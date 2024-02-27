<?php

namespace App\Http\Livewire;

use Cart;
use App\Models\price;
use Livewire\Component;
use App\Models\categorie;
use App\Models\tshirt_image;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    use WithPagination;
    public $name;

    public function mount($name)
    {
        $this->name = $name;
    }

    public function render(Request $request)
    {
        $pageSize = 12;
        $orderBy = "Default  Sorting";
        $prices = price::all()->first();

        if ($request->has('pageSize')) {
            $pageSize = $request->pageSize;
        }

        if ($request->has('orderBy')) {
            $orderBy = $request->orderBy;
        }

        if ($this->name=="null") {
            if($orderBy == 'Sort By Newness'){
                $products = tshirt_image::whereNull('customer_id')->where('category_id',null)->orderBy('created_at','DESC')->paginate($pageSize);
            }
            else{
                $products = tshirt_image::whereNull('customer_id')->where('category_id',null)->paginate($pageSize);
            }
            $categoty_name = "Sem Categoria";
        }else{
            $category = categorie::where('name',$this->name)->first();
            $category_id = $category->id;
            $categoty_name = $category->name;

            if($orderBy == 'Sort By Newness'){
                $products = tshirt_image::whereNull('customer_id')->where('category_id',$category_id)->orderBy('created_at','DESC')->paginate($pageSize);
            }
            else{
                $products = tshirt_image::whereNull('customer_id')->where('category_id',$category_id)->paginate($pageSize);
            }

        }

        $images = array();

        foreach ($products as $product) {
            $camisola = route('merge_tshirt',['tshirt'=>'fafafa.jpg','estampa'=>$product->image_url]);
            array_push($images,$camisola);
        }

        $page_url = 'product.category';

        $page_url = array();

        array_push($page_url,route('product.category',['name'=>$this->name,'pageSize'=>12,'orderBy'=>$orderBy]));
        array_push($page_url,route('product.category',['name'=>$this->name,'pageSize'=>15,'orderBy'=>$orderBy]));
        array_push($page_url,route('product.category',['name'=>$this->name,'pageSize'=>24,'orderBy'=>$orderBy]));
        array_push($page_url,route('product.category',['name'=>$this->name,'pageSize'=>30,'orderBy'=>$orderBy]));
        array_push($page_url,route('product.category',['name'=>$this->name,'pageSize'=>$pageSize]));
        array_push($page_url,route('product.category',['name'=>$this->name,'pageSize'=>$pageSize,'orderBy'=>'Sort By Newness']));

        $categories = categorie::orderBy('name','ASC')->get();

        return view('livewire.shop-component', ['pageSize' => $pageSize , 'orderBy' => $orderBy, 'page_url' => $page_url,
        'products' => $products,'categories' => $categories,'categoty_name' => $categoty_name,'images' => $images,'prices' => $prices]);
    }
}
