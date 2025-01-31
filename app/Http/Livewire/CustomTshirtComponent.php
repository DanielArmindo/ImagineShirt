<?php

namespace App\Http\Livewire;

use Cart;
use App\Models\color;
use App\Models\price;
use Livewire\Component;
use App\Models\tshirt_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\HelperFunctions;

class CustomTshirtComponent extends Component
{

    public function render(Request $request)
    {
        //verificar se o user tem tshirt custumizavel e mostrar
        $product = new tshirt_image();
        $base = 'fafafa.jpg';
        $flag = 2;
        $prices = price::all()->first();
        $size = 'M';
        $msg = '';
        $code_tshirt = -1;

        if ($request->has('base')) {
            $base = $request->base;
        }

        if ($request->has('size')) {
            $size = $request->size;
        }

        if ($request->has('background') && $request->background != 2) {
            $flag = $request->background;
        }

        if ($request->has('msg')) {
            $msg = $request->msg;
        }

        $images = array();

        if (session()->has('order')) {
            $code_tshirt = session('order');
            $tshirt_url = tshirt_image::where('id', $code_tshirt)->pluck('image_url')->first();
            $camisola = route('merge_imageb64', ['background' => $flag, 'tshirt' => $base, 'estampa' => $tshirt_url]);
            array_push($images, $camisola);
        } else {
            array_push($images, asset('/storage/tshirt_base/' . $base));
        }

        $cores = color::get("code");
        $tshirts = HelperFunctions::get_tshirts($cores);

        return view(
            'livewire.custom-tshirt-component',
            [
                'product' => $product,
                'prices' => $prices,
                'base' => $base,
                'images' => $images,
                'tshirts' => $tshirts,
                'size' => $size,
                'msg' => $msg,
                'background' => $flag,
                'code_tshirt' => $code_tshirt
            ]
        );
    }

    public function store(Request $request)
    {
        $product_id = $request->product_id;
        $product_qnt = $request->product_qnt;
        $product_price = $request->product_price;
        $color = $request->color;
        $size = $request->size;
        $image_url = $request->image_url;
        $background = $request->background;

        if ($product_id == -1) {
            return redirect()->route('custom.product', ['msg' => 'Error submitting to cart (No image selected)']);
        }

        try {
            $tshirt = tshirt_image::where('id', $product_id)->where('customer_id', $request->user()->id)->first();
            $values = array("background" => $background);
            $values = json_encode($values);

            $tshirt->extra_info =  $values;
            $tshirt->save();
        } catch (\Throwable $th) {
            return redirect()->route('custom.product', ['msg' => 'Error submitting to cart']);
        }

        $product_name = "Custom Tshirt";

        $color = explode(".", $color);
        $color_name = color::where('code', $color[0])->pluck('name')->first();

        Cart::add($product_id, $product_name, $product_qnt, $product_price, ['color' => $color_name, 'size' => $size, 'image_url' => $image_url])->associate('App\Models\tshirt_image');
        session()->flash('success_message', 'Item added in Cart');
        session()->forget('order');
        return redirect()->route('shop.cart');
    }

    public function upload_photo(Request $request)
    {
        $request->validate(['photo_upload' => 'required|mimes:png|max:4096']);

        $id = null;

        // Caso já tenha inserido uma
        if (session()->has('order')) {

            $tshirt = tshirt_image::where('id', session('order'))->where('customer_id', $request->user()->id)->first();

            if ($tshirt->order_itemRef->count() == 0) {
                try {
                    $path = Storage::delete('tshirt_images_private/' . $tshirt->image_url);

                    $path = Storage::putFile('tshirt_images_private', $request->photo_upload);
                    $path = explode('/', $path);
                    $tshirt->image_url = $path[array_key_last($path)];
                    $tshirt->save();
                } catch (\Throwable $th) {
                    return redirect()->route('custom.product', ['msg' => 'Error To Upload Photo']);
                }

                return redirect()->route('custom.product');
            }
        }

        try {
            $path = Storage::putFile('tshirt_images_private', $request->photo_upload);

            $path = explode('/', $path);

            $tshirt_image = new tshirt_image();
            $tshirt_image->customer_id = $request->user()->id;
            $tshirt_image->name = 'Custom Tshirt';
            $tshirt_image->image_url = $path[array_key_last($path)];

            $tshirt_image->save();

            $id = $tshirt_image->id;
        } catch (\Throwable $th) {
            return redirect()->route('custom.product', ['msg' => 'Error To Upload Photo']);
        }

        session()->forget('order');
        session()->put('order', $id);

        return redirect()->route('custom.product');
    }
}
