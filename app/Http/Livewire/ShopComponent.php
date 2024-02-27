<?php

namespace App\Http\Livewire;

use Cart;
use Livewire\Component;
use App\Models\categorie;
use App\Models\color;
use App\Models\tshirt_image;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\price;
use App\Models\User;

class ShopComponent extends Component
{
    use WithPagination;


    public function store($product_id,$product_name,$product_price,$product_qnt){
        Cart::add($product_id,$product_name,$product_price,$product_qnt)->associate('App\Models\tshirt_image');
        session()->flash('success_message','Item added in Cart');
        return redirect()->route('shop.cart');
    }

    public function render(Request $request)
    {
       // User::onlyTrashed()->restore();
       //color::onlyTrashed()->restore();

        $pageSize = 12;
        $prices = price::all()->first();
        $orderBy = "Default  Sorting";

        if ($request->has('pageSize')) {
            $pageSize = $request->pageSize;
        }

        if ($request->has('orderBy')) {
            $orderBy = $request->orderBy;
        }

        if($orderBy == 'Sort By Newness')
        $products = tshirt_image::whereNull('customer_id')->orderBy('created_at','DESC')->paginate($pageSize);
        else
        $products = tshirt_image::whereNull('customer_id')->paginate($pageSize);

        $images = array();

        foreach ($products as $product) {
            $camisola = route('merge_tshirt',['tshirt'=>'fafafa.jpg','estampa'=>$product->image_url]);
            array_push($images,$camisola);
        }

        $categories = categorie::orderBy('name','ASC')->get();

        $page_url = array();

        array_push($page_url,route('shop',['pageSize'=>12,'orderBy'=>$orderBy]));
        array_push($page_url,route('shop',['pageSize'=>15,'orderBy'=>$orderBy]));
        array_push($page_url,route('shop',['pageSize'=>24,'orderBy'=>$orderBy]));
        array_push($page_url,route('shop',['pageSize'=>30,'orderBy'=>$orderBy]));
        array_push($page_url,route('shop',['pageSize'=>$pageSize]));
        array_push($page_url,route('shop',['pageSize'=>$pageSize,'orderBy'=>'Sort By Newness']));

        return view('livewire.shop-component',
        ['pageSize' => $pageSize , 'orderBy' => $orderBy, 'page_url' => $page_url,
        'products' => $products,'categories' => $categories,'images' => $images,'prices' => $prices]);
    }
}
