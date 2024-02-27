<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Models\order;
use Livewire\Component;
use App\Models\order_item;
use App\Models\tshirt_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CheckoutRequest;
use App\Models\customer;
use Illuminate\Support\Facades\Storage;

class UserDashboardComponent extends Component


{
    public function render(Request $request)
    {
        $orders_selected = 0;
        $type_search = '';
        $search= '';

        if ($request->has('show_orders')) {
            $orders_selected = 1;
        }

        $orders=order::where('customer_id',Auth::user()->id);

        if ($request->has('search') and $request->search != '' and $request->has('type_search')) {
            $type_search = $request->type_search;
            $search= $request->search;

            switch ($type_search) {
                case 'ID':
                    $orders = $orders->where('id',$search)->paginate(12);
                    break;

                case 'DATE':
                    $orders = $orders->where('date','like',$search)->paginate(12);
                    break;
            }

        }else{
            $orders= $orders->paginate(12);
        }


        $user = $request->user();

        return view('livewire.user.user-dashboard-component',
        ['user'=>$user,'orders'=>$orders, 'orders_selected'=>$orders_selected,
        'type_search'=>$type_search, 'search'=>$search ]);
    }

    public function showitems($id)
    {
        $order=order::find($id);
        $orderitems=order_item::where('order_id',$id)->get();
        return view('livewire.user.user-dashboard-component',['order'=>$order],['orderitems'=>$orderitems]);
    }

    public function update_photo(Request $request, User $user) :RedirectResponse
    {
        if (Auth::user()->id!=$user->id) {
            session()->flush();
            return redirect()->route('login');
        }

        // Photo update
        if ($request->hasFile('file_photo')) {

            if ($user->url_foto != null) {
                Storage::delete('public/photos/' . $user->photo_url);
            }

            $path = $request->file_photo->store('public/photos');

            $user->photo_url = basename($path);
            $user->save();
        }

        return redirect()->route('user.dashboard');
    }

    // Page for custom tshirts from user
    public function index_custom(Request $request){

        $name = $request->user()->name;
        $images = array();

        $tshirts = tshirt_image::where('customer_id',$request->user()->id)->get();

        if ($tshirts->count() != 0) {
            foreach ($tshirts as $tshirt) {
                $base = 'fafafa.jpg';
                $url = $tshirt->image_url;
                $back = json_decode($tshirt->extra_info,true);
                try {
                    $back = intval($back['background']);
                } catch (\Throwable $th) {
                    $back = 1;
                }

                $camisola = route('merge_imageb64',['background'=>$back,'tshirt'=>$base,'estampa'=>$url]);
                array_push($images,$camisola);
            }
        }

        return view('livewire.user.custom-tshirts-component',
        ['name'=> $name, 'images' => $images, 'products' => $tshirts]);
    }

    public function add_custom_tshirt(Request $request,tshirt_image $tshirt){

        if ($tshirt->customer_id != $request->user()->id) {
            session()->flush();
            return redirect()->route('home.index');
        }

        session()->forget('order');
        session()->put('order', $tshirt->id);
        return redirect()->route('custom.product');
    }

    public function del_custom_tshirt(Request $request,tshirt_image $tshirt){

        if ($tshirt->customer_id != $request->user()->id) {
            session()->flush();
            return redirect()->route('home.index');
        }

        if ($tshirt->order_itemRef->count() !=0) {
            return redirect()->route('user.custom.tshirts');
        }

        $tshirt->delete();
        session()->forget('order');
        return redirect()->route('user.custom.tshirts');
    }

    //Update user address
    public function update_address(CheckoutRequest $request,$id){

        if ($request->payment_option == "PAYPAL") {
            $request->validate(['ref' => 'email']);
        }else{
            $request->validate(['ref' => 'digits:16']);
        }

        $user = customer::find($id);
        $save = false;

        if ($user->address != $request->address) {
            $user->address = $request->address;
            $save = true;
        }
        if ($user->nif != $request->nif) {
            $user->nif = $request->nif;
            $save = true;
        }
        if ($user->default_payment_type != $request->payment_option) {
            $user->default_payment_type = $request->payment_option;
            $save = true;
        }
        if ($user->default_payment_ref != $request->ref) {
            $user->default_payment_ref = $request->ref;
            $save = true;
        }

        if ($save) {
            try {
                $user->save();
            } catch (\Throwable $th) {
                return redirect()->route('profile.edit',)->with('status', 'address-not-updated');
            }

        }

        if ($save == false) {
            return redirect()->route('profile.edit',)->with('status', 'address-not-updated');
        }

        return redirect()->route('profile.edit',)->with('status', 'address-updated');
    }
}
