<?php

namespace App\Http\Livewire;

use Cart;
use App\Models\price;
use Livewire\Component;
use App\Models\categorie;
use App\Models\tshirt_image;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class SearchComponent extends Component
{
    use WithPagination;

    public $q;
    public $search_term;

    public function mount()
    {
        $this->fill(request()->only('q'));
        $this->search_term = '%'.$this->q.'%';
    }

    public function store($product_id,$product_name){
        Cart::add($product_id,$product_name,1,100)->associate('App\Models\tshirt_image');
        session()->flash('success_message','Item added in Cart');
        return redirect()->route('shop.cart');
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

        if($orderBy == 'Sort By Newness')
        $products = tshirt_image::whereNull('customer_id')->where('name','like',$this->search_term)->orderBy('created_at','DESC')->paginate($pageSize);
        else
        $products = tshirt_image::whereNull('customer_id')->where('name','like',$this->search_term)->paginate($pageSize);

        $images = array();

        foreach ($products as $product) {
            $camisola = route('merge_tshirt',['tshirt'=>'fafafa.jpg','estampa'=>$product->image_url]);
            array_push($images,$camisola);
        }

        $page_url = array();

        array_push($page_url,route('shop',['pageSize'=>12,'orderBy'=>$orderBy]));
        array_push($page_url,route('shop',['pageSize'=>15,'orderBy'=>$orderBy]));
        array_push($page_url,route('shop',['pageSize'=>24,'orderBy'=>$orderBy]));
        array_push($page_url,route('shop',['pageSize'=>30,'orderBy'=>$orderBy]));
        array_push($page_url,route('shop',['pageSize'=>$pageSize]));
        array_push($page_url,route('shop',['pageSize'=>$pageSize,'orderBy'=>'Sort By Newness']));

        $categories = categorie::orderBy('name','ASC')->get();

        return view('livewire.shop-component', ['pageSize' => $pageSize , 'orderBy' => $orderBy, 'page_url' => $page_url,
        'products' => $products,'categories' => $categories,'images' => $images,'prices' => $prices]);
    }
}
