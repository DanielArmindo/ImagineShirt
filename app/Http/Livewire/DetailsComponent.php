<?php

namespace App\Http\Livewire;

use Cart;
use App\Models\color;
use App\Models\price;
use Livewire\Component;
use App\Models\tshirt_image;
use Illuminate\Http\Request;
use App\Http\Controllers\HelperFunctions;

class DetailsComponent extends Component
{
    public $id_tshirt;

    public function mount($product)
    {
        $this->id_tshirt = $product;
    }

    public function store($product_id,$product_name,$product_price,$product_qnt,$color,$size,$image_url){
        $color = explode(".", $color);
        $colordb = color::where('code',$color[0])->first();

        Cart::add($product_id,$product_name,$product_price,$product_qnt,['color'=>$colordb->name,'size'=>$size,'image_url'=>$image_url])->associate('App\Models\tshirt_image');
        session()->flash('success_message','Item added in Cart');
        return redirect()->route('shop.cart');
    }

    public function render(Request $request)
    {
        $base = 'fafafa.jpg';
        $prices = price::all()->first();
        $size = 'M';

        $product = tshirt_image::where('id', $this->id_tshirt)->first();
        $rproducts = tshirt_image::where('category_id', $product->category_id)->inRandomOrder()->limit(4)->get();

        if ($request->has('base')) {
            $base = $request->base;
        }

        if ($request->has('size')) {
            $size = $request->size;
        }

        $images = array();

        array_push($images,route('merge_tshirt',['tshirt'=>$base,'estampa'=>$product->image_url]));

        foreach ($rproducts as $rproduct) {
            $camisola = route('merge_tshirt',['tshirt'=>$base,'estampa'=>$rproduct->image_url]);
            array_push($images,$camisola);
        }

        $cores = color::get("code");
        $tshirts = HelperFunctions::get_tshirts($cores);


        return view('livewire.details-component', ['prices'=>$prices,'product' => $product, 'rproducts' => $rproducts,
        'images'=>$images, 'tshirts' => $tshirts, 'base'=>$base, 'size'=>$size]);
    }
}
