<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;

use Livewire\Component;
use App\Models\customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\price;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AdminDashboardComponent extends Component
{

    public function render(Request $request)
    {

        $admins= User::where('user_type','A');
        $employees = User::where('user_type','E');
        $clients = User::where('user_type','C');
        $users_deleted = User::onlyTrashed();

        $user_type_view = $request->query('user_type_view') !== null ? $request->query('user_type_view') : 1;

        $msg1 = $msg2 = $msg3 = $msg4 = '';

        if(session()->has('type_search')){
            switch (session()->get('type_search')) {
                case 'admins':
                    $admins = $admins->where('name','like','%'.session()->get('search_bar').'%');
                    $user_type_view = $request->session()->has('redirect_part') ? 1 : $user_type_view;
                    $msg1 = session()->get('search_bar');
                    break;

                case 'employees':
                    $employees = $employees->where('name','like','%'.session()->get('search_bar').'%');
                    $user_type_view = $request->session()->has('redirect_part') ? 2 : $user_type_view;
                    $msg2 = session()->get('search_bar');
                    break;

                case 'clients':
                    $clients = $clients->where('name','like','%'.session()->get('search_bar').'%');
                    $user_type_view = $request->session()->has('redirect_part') ? 3 : $user_type_view;
                    $msg3 = session()->get('search_bar');
                    break;

                case 'revoked':
                    $users_deleted = $users_deleted->where('name','like','%'.session()->get('search_bar').'%');
                    $user_type_view = $request->session()->has('redirect_part') ? 4 : $user_type_view;
                    $msg4 = session()->get('search_bar');
                    break;
            }
        }

        if ($request->session()->has('clear')) {
            $user_type_view =$request->session()->get('clear');
        }

        $admins= $admins->paginate(12);
        $employees = $employees->paginate(12);
        $clients = $clients->paginate(12);
        $users_deleted = $users_deleted->paginate(12);

        return view('livewire.admin.admin-dashboard-component',
        ['admins'=>$admins,'employees'=>$employees, 'clients'=>$clients, 'user_type_view' => $user_type_view,
        'users_deleted'=>$users_deleted,
        'msg1'=>$msg1,'msg2'=>$msg2,'msg3'=>$msg3,'msg4'=>$msg4]);
    }

    public function create(): View
    {
        $newUser = new User();

        return view('livewire.admin.create-user',
        ['user'=>$newUser]);
    }

    public function store(UserRequest $request) :RedirectResponse
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($request->validated());

        //update user with photo
        if ($request->hasFile('file_photo')) {
            $path = $request->file_photo->store('public/photos');

            $user->photo_url = basename($path);
            $user->save();
        }

        return redirect()->route('admin.dashboard');
    }

    public function edit(User $admin)
    {
        if($admin->user_type != "A" and $admin->user_type != "E"){
            session()->flush();
            return redirect()->route('home.index');
        }

        return view('livewire.admin.update-user',
        ['user'=>$admin]);
    }

    public function update(UserRequest $request, User $admin) :RedirectResponse
    {
        $admin->update($request->validated());

        // Photo update
        if ($request->hasFile('file_photo')) {

            if ($admin->url_foto != null) {
                Storage::delete('public/photos/' . $admin->photo_url);
            }

            $path = $request->file_photo->store('public/photos');

            $admin->photo_url = basename($path);
            $admin->save();
        }

        return redirect()->route('admin.dashboard');
    }

    //Update user account to blocked or unlocked
    public function block_change(Request $request, User $admin)
    {
        if (!$request->has('flag') || ($request->flag< 1 || $request->flag> 2)) {
            session()->flush();
            return redirect()->route('home.index');
        }

        if (($admin->blocked == 1 and $request->flag == 1) || ($admin->blocked == 0 and $request->flag == 2)) {
            return redirect()->route('admin.dashboard');
        }

        if ($request->flag == 1) {
            //Bloqueia
            $admin->update(['blocked'=>1]);
        }
        else{
            //Desbloqueia
            $admin->update(['blocked'=>0]);
        }

        return redirect()->route('admin.dashboard');
    }

    public function destroy(User $admin):RedirectResponse
    {
        if ($admin->user_type == "A" or $admin->user_type == "E") {
            //softw
            $admin->update(['blocked'=>1]);
            $admin->delete();

            return redirect()->route('admin.dashboard');
        }else{
            //softdelete
            $admin->update(['blocked'=>1]);
            $admin->customerRef->delete();
            $admin->delete();
            return redirect()->route('admin.dashboard');
        }
    }

    public function search(Request $request)
    {
        $valid = array('admins','employees','clients','revoked');

        if (!$request->has('type_search') || !in_array($request->type_search,$valid)) {
            session()->flush();
            return redirect()->route('home.index');
        }

        if(empty($request->search_name)){
            $request->session()->forget('type_search');
            $request->session()->forget('search_bar');

            switch ($request->type_search) {
                case 'admins':
                    $value = 1;
                    break;

                case 'employees':
                    $value = 2;
                    break;

                case 'clients':
                    $value = 3;
                    break;

                case 'revoked':
                    $value = 4;
                    break;
            }

            return redirect()->route('admin.dashboard')->with('clear',$value);
        }

        session()->put('type_search', $request->type_search);
        session()->put('search_bar', $request->search_name);

        return redirect()->route('admin.dashboard')->with('redirect_part',true);
    }

    public function undo_deleted(Request $request){
        $user = User::onlyTrashed()->where('id',$request->user)->first();

        if ($user->user_type == 'C') {
            customer::onlyTrashed()->find($user->id)->restore();
        }

        $user->restore();
        $user->update(['blocked' => 0]);
        return redirect()->back();
    }

    public function undo_all_deleted(){
        User::onlyTrashed()->restore();
        customer::onlyTrashed()->restore();
        return redirect()->back();
    }

    //Alteração dos preços na loja
    public function index_prices(Request $request){
        $precos = price::first();
        $msg = '';

        if ($request->has('msg')) {
            $msg = $request->msg;
        }

        return view('livewire.admin.prices-component',['precos'=>$precos,'msg'=>$msg]);
    }

    public function change_prices(Request $request){
        if (!$request->has('operation') || $request->operation > 3 || $request->operation < 1) {
            return redirect()->route('admin.prices',['msg'=>'Erro Na Alteração']);
        }

        $prices = price::first();

        switch($request->operation){
            case 1:
                $request->validate(['new_price' => 'nullable|min:0,01', 'discount_price' => 'nullable|min:0,01']);

                $update = false;
                if ($request->new_price != $prices->unit_price_catalog and $request->new_price != null) {
                    $prices->unit_price_catalog=$request->new_price;
                    $update = true;
                }
                if ($request->discount_price != $prices->unit_price_catalog_discount and $request->discount_price!=null) {
                    $prices->unit_price_catalog_discount=$request->discount_price;
                    $update = true;
                }

                if ($update == false) {
                    return redirect()->route('admin.prices',['msg'=>'Quantidade permanece a mesma']);
                }
                break;

            case 2:
                $request->validate(['new_price' => 'nullable|min:0,01', 'discount_price' => 'nullable|min:0,01']);

                $update = false;
                if ($request->new_price != $prices->unit_price_own and $request->new_price != null) {
                    $prices->unit_price_own=$request->new_price;
                    $update = true;
                }
                if ($request->discount_price != $prices->unit_price_own_discount and $request->discount_price!=null) {
                    $prices->unit_price_own_discount=$request->discount_price;
                    $update = true;
                }

                if ($update == false) {
                    return redirect()->route('admin.prices',['msg'=>'Quantidade permanece a mesma']);
                }
                break;

            case 3:
                $request->validate(['quantity' => 'required|min:1']);
                if ($request->quantity == $prices->qty_discount) {
                    return redirect()->route('admin.prices',['msg'=>'Quantidade permanece a mesma']);
                }
                $prices->qty_discount = $request->quantity;
                $prices->update();
                return redirect()->route('admin.prices',['msg'=>'Alteração Efetuada com Sucesso']);
                break;
        }

        $prices->update();

        return redirect()->route('admin.prices',['msg'=>'Alteração Efetuada com Sucesso']);

    }
}
