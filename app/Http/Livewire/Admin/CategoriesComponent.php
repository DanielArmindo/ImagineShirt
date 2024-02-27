<?php

namespace App\Http\Livewire\Admin;

use App\Models\color;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Http\Controllers\HelperFunctions;
use App\Models\categorie;

class CategoriesComponent extends Component
{
    public function render(Request $request)
    {
        $orders_selected = 0;
        $msg1= $msg2=$msg3 = '';

        $upcat = -1;
        $name_cat ='';

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

        if ($request->has('change_category')) {
            $category = categorie::where('id',$request->change_category)->first();
            $upcat = $category->id;
            $name_cat =$category->name;
        }

        $categories = categorie::get();
        $cores = color::get();
        $tshirts = HelperFunctions::get_tshirts($cores);

        return view('livewire.admin.categories-component',[
            'categories' => $categories,'tshirts'=>$tshirts ,
            'orders_selected'=>$orders_selected, 'upcat'=>$upcat,'name'=>$name_cat,
            'msg1'=>$msg1,'msg2'=>$msg2,'msg3'=>$msg3
        ]);
    }

    public function delete_category(categorie $category){
        $category->delete();
        return redirect()->route('admin.categories',['show_orders'=>1,'msg2'=>'Eliminado com Sucesso']);
    }

    public function new_category(Request $request){
        $request->validate(['name' => 'required|string|max:100']);
        try {
            $category = new categorie();
            $category->name= $request->name;
            $category->save();
        } catch (\Throwable $th) {
            return redirect()->route('admin.categories',['show_orders'=>2,'msg3'=>'Erro na Criação']);
        }

        return redirect()->route('admin.categories',['show_orders'=>2,'msg3'=>'Categoria criada com sucesso']);
    }

    public function update_category(Request $request,$id){
        $category = categorie::where('id',$id)->get();

        if ($category->count() ==0) {
            return redirect()->route('admin.categories',['msg1'=>'Nao selecionou uma categoria']);
        }

        $category= $category->first();

        $request->validate(['name' => 'required|string|max:100']);

        if ($request->name == $category->name) {
            return redirect()->route('admin.categories',['msg1'=>'Dados permanecem os mesmos']);
        }

        $category->name = $request->name;
        $category->update();

        return redirect()->route('admin.categories',['msg1'=>'Categoria Alterada com Sucesso']);

    }


}
