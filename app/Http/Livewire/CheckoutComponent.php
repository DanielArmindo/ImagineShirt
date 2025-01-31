<?php

namespace App\Http\Livewire;

use App\Http\Controllers\HelperFunctions;
use Cart;
use App\Models\color;
use App\Models\order;
use Livewire\Component;
use App\Models\customer;
use App\Models\order_item;
use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;

class CheckoutComponent extends Component
{

    public function render(Request $request)
    {
        $msg = '';
        if ($request->has('mensage')) {
            $msg = $request->mensage;
        }

        $user = customer::where('id',$request->user()->id)->first();
        return view('livewire.checkout-component',['user'=>$user,'msg'=>$msg]);
    }

    public function proceed_checkout(CheckoutRequest $request,customer $user)
    {

        if ($request->payment_option == "PAYPAL") {
            $request->validate(['ref' => 'email']);
        }else{
            $request->validate(['ref' => 'digits:16']);
        }

        if (Cart::count() == 0) {
            return redirect()->route('shop.checkout',['mensage'=>'Sem itens no carrinho']);
        }

        $notes = $request->has('notes')? $request->notes: null;

        // Verify/update customer data
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
            $user->save();
        }

        //=================Put cart itens in order tables
        //Create order item
        $order = new order();

        try {
            $order->status = "pending";
            $order->customer_id = $user->id;

            date_default_timezone_set("Europe/Lisbon");
            $order->date = date("Y-m-d");

            $order->total_price = Cart::total();
            if ($notes  != null) {
                $order->notes = $notes ;
            }
            $order->nif = $user->nif;
            $order->address = $user->address;
            $order->payment_type = $user->default_payment_type;
            $order->payment_ref = $user->default_payment_ref;


            //Export pdf and save it
            $temp_id = $order->id;
            $name_pdf = HelperFunctions::export_to_PDF($temp_id,$user->userRef->name,$user->nif,$user->default_payment_type);
            $order->receipt_url = $name_pdf; //Ficheiro para o pdf
            $order->save();

        } catch (\Throwable $th) {
            return redirect()->route('shop.checkout',['mensage'=>'Error to do order (order)']);
        }


        $items = array();
        // put itens from cart to order_items table
        foreach (Cart::content() as $product){

            try {
                $order_item = new order_item();

                $color = $product->options->color;
                $id_color = color::where('name',$color)->pluck('code')->first();
                $total =$product->price*$product->qty;

                $order_item->order_id = $order->id;
                $order_item->tshirt_image_id = $product->id;
                $order_item->color_code = $id_color;
                $order_item->size = $product->options->size;
                $order_item->qty = $product->qty;
                $order_item->unit_price = $product->price;
                $order_item->sub_total = $total;

                $order_item->save();

                array_push($items,$order_item);

            } catch (\Throwable $th) {
                foreach ($items as $value) {
                    $value->delete();
                }
                $order->delete();
                return redirect()->route('shop.checkout',['mensage'=>'Error to do order']);
            }

        }

        //=================End Put cart itens in order tables

        Cart::destroy();

        Mail::to($request->user())->send(new OrderShipped($order));
        //Depois enviar para as view com as suas orders
        return redirect()->route('shop.checkout',['mensage'=>'Order placed']);
    }
}
