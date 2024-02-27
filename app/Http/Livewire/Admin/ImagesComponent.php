<?php

namespace App\Http\Livewire\Admin;


use Exception;
use Livewire\Component;
use App\Models\tshirt_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class ImagesComponent extends Component
{
    public function render(Request $request)
    {
        $orders_selected = 0;
        $msg1= $msg2=$msg3 = '';

        $image = null;
        $code = -1;

        if ($request->has('show_orders')) {
            $orders_selected =$request->show_orders;
        }

        if ($request->has('msg1')) {
            $msg1 = $request->msg1;
        }
        if ($request->has('msg2')) {
            $msg2 = $request->msg2;
        }
        if ($request->has('msg3')) {
            $msg3 = $request->msg3;
        }

        if ($request->has('show_orders')) {
            $orders_selected = $request->show_orders;
        }

        if ($request->has('upImage')) {
            $image = tshirt_image::whereNull('customer_id')->where('id',$request->upImage)->get()->first();
            $code = $image->id;
        }


        $products = tshirt_image::whereNull('customer_id')->paginate(9);

        $images = array();

        foreach ($products as $product) {
            $camisola = route('merge_tshirt',['tshirt'=>'fafafa.jpg','estampa'=>$product->image_url]);
            array_push($images,$camisola);
        }

        return view('livewire.admin.images-component',[
            'images' => $images, 'orders_selected'=>$orders_selected,'products'=>$products,
            'msg1'=>$msg1,'msg2'=>$msg2,'msg3'=>$msg3, 'code'=>$code,'image'=>$image
        ]);
    }

    public function del_image(tshirt_image $image){
        $image->delete();
        return redirect()->route('admin.images',['show_orders'=>1,'msg2'=>'Eliminado com Sucesso']);
    }

    public function new_image(Request $request){
        $request->validate([
            'name' => 'required|string|max:100',
            'desc' => 'required|string'
        ]);

        $image = new tshirt_image();

        try {
            if (!$request->file('ficheiro')->isValid()) {
                throw new Exception();
            }

            $path= $request->ficheiro->store('public/tshirt_images');

            $image->image_url = basename($path);
            $image->name = $request->name;
            $image->description = $request->desc;
            $image->save();

        } catch (\Throwable $th) {
            return redirect()->route('admin.images',['show_orders'=>2,'msg3'=>'Erro na criação tente novamente mais tarde!']);
        }

        return redirect()->route('admin.images',['show_orders'=>2,'msg3'=>'Criação da imagem efetuada!']);
    }

    public function edit_image(Request $request,$image){

        $image = tshirt_image::where('id',$image)->get();

        if ($image->count() ==0) {
            return redirect()->route('admin.images',['msg1'=>'Nao selecionou uma imagem para alterar']);
        }

        $image= $image->first();
        $update = false;

        $request->validate(['name' => 'nullable|string|max:100',
         'desc'=>'nullable|string|max:100'
        ]);

        try {

            if ($request->name != null and $image->name != $request->name) {
                $image->name = $request->name;
                $update =true;
            }

            if ($request->desc != null and $image->description != $request->desc) {
                $image->description = $request->desc;
                $update =true;
            }

            if ($request->hasFile('ficheiro')) {
                $path= $request->ficheiro->store('public/tshirt_images');

                $image->image_url = basename($path);

                $url = 'public/tshirt_base/'.$image->image_url;
                Storage::delete($url);
                $update =true;
            }

            if (!$update) {
                return redirect()->route('admin.images',['msg1'=> 'Sem nenhuma alteração']);
            }

            $image->update();
        } catch (\Throwable $th) {
            return redirect()->route('admin.images',['msg1'=> 'Erro ao alterar a cor']);
        }

        return redirect()->route('admin.images',['msg1'=> 'Alteracao feita com sucesso']);
    }
}
