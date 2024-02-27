<?php

namespace App\Http\Livewire\Admin;

use Exception;
use App\Models\color;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Http\Controllers\HelperFunctions;
use Illuminate\Support\Facades\Storage;

class ColorsComponent extends Component
{
    public function render(Request $request)
    {
        $orders_selected = 0;
        $msg = '';
        $msg2 = '';
        $msg3 = '';
        $update_color = '';
        $cor = null;
        $code = -1;

        if ($request->has('show_orders')) {
            $orders_selected = $request->show_orders;
        }

        if ($request->has('msg')) {
            $msg = $request->msg;
        }
        if ($request->has('msg2')) {
            $msg2 = $request->msg2;
        }
        if ($request->has('msg3')) {
            $msg3 = $request->msg3;
        }

        $cores = color::get();
        $tshirts = HelperFunctions::get_tshirts($cores);

        if ($request->has('upcolor')) {
            $update_color = $request->upcolor;
            $update_color = explode('.jpg',$update_color);
            $update_color = $update_color[0];

            $cor = color::where('code',$update_color)->get()->first();
            if ($cor == null) {
                $code = -1;
            }else{
                $code = $cor->code;
            }

        }

        return view('livewire.admin.colors-component',[
            'tshirts' => $tshirts, 'cores' => $cores, 'orders_selected'=>$orders_selected,
             'msg'=>$msg,'msg2'=>$msg2, 'msg3'=>$msg3,
            'cor'=>$cor,'code'=>$code
        ]);
    }

    public function delete_color($color){
        $color = explode('.jpg',$color);
        $color = $color[0];

        $value = color::where('code',$color)->get()->first();

        if ($value->count()==0) {
            return redirect()->route('admin.colors',['show_orders'=>1,'msg'=>'Não se efetuou a eliminação da cor']);
        }

        $value->delete();

        return redirect()->route('admin.colors',['show_orders'=>1,'msg'=>'Eliminação Efetuada']);
    }

    public function add_color(Request $request){

        $request->validate([
            'name_color' => 'required|string|max:100']);

        $color = new color();

        try {
            $hex = bin2hex($request->name_color);
            if (!$request->file('file_photo')->isValid()) {
                throw new Exception();
            }
            $request->file_photo->storeAs('public/tshirt_base',$hex.".jpg");
            $color->code = $hex;
            $color->name = $request->name_color;
            $color->save();
        } catch (\Throwable $th) {
            return redirect()->route('admin.colors',['show_orders'=>2,'msg2'=>'Erro na criação tente novamente mais tarde!']);
        }

        return redirect()->route('admin.colors',['show_orders'=>2,'msg2'=>'Criação de cor efetuada!']);

    }

    public function edit_color(Request $request, $color){


        $color = color::where('code',$color)->get();

        if ($color->count() ==0) {
            return redirect()->route('admin.colors',['msg3'=>'Nao selecionou uma cor para alterar']);
        }

        $color= $color->first();
        $update = false;
        $valor = $color->code;

        $request->validate(['name_color' => 'nullable|string|max:100',]);

        try {

            if ($request->name_color != null) {
                $color->name = $request->name_color;
                $hex = bin2hex($request->name_color);
                $update =true;
            }

            if ($request->hasFile('file_photo')) {
                $file_name = $update == true ? $hex.".jpg" : $valor.'.jpg';
                $file_code = $update == true ? $hex : $valor;

                $request->file_photo->storeAs('public/tshirt_base',$file_name);

                $url = 'public/tshirt_base/'.$color->code.'.jpg';
                Storage::delete($url);

                $color->code = $file_code;
                $update =true;
            }

            if (!$update) {
                return redirect()->route('admin.colors',['msg3'=> 'Sem nenhuma alteração']);
            }
            $color->update();
        } catch (\Throwable $th) {
            return redirect()->route('admin.colors',['msg3'=> 'Erro ao alterar a cor']);
        }

        return redirect()->route('admin.colors',['msg3'=> 'Alteracao feita com sucesso']);
    }
}
