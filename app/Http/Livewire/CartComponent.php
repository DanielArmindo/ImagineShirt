<?php

namespace App\Http\Livewire;

use Cart;
use App\Models\price;
use Livewire\Component;

class CartComponent extends Component
{
    public function increaseQuantity($rowId)
    {

        $prices = price::all()->first();
        $product = Cart::get($rowId);
        $value = $product->price;
        $qty = $product->qty + 1;
        if($qty == $prices->qty_discount )
        {
            if($value == $prices->unit_price_catalog)
            {
                $value = $prices->unit_price_catalog_discount;
            }else
            {
                $value = $prices->unit_price_own_discount;
            }

        }
        Cart::update($rowId, ['qty' => $qty,'price' => $value]);


        $this->emitTo('cart-icon-component', 'refreshComponent');
    }
    public function decreaseQuantity($rowId)
    {
        $prices = price::all()->first();
        $product = Cart::get($rowId);
        $value = $product->price;

        $qty = $product->qty - 1;
        if($qty == ($prices->qty_discount-1) )
        {
            if($value == $prices->unit_price_catalog_discount)
            {
                $value = $prices->unit_price_catalog;
            }else
            {
                $value = $prices->unit_price_own;
            }

        }

        Cart::update($rowId, ['qty' => $qty,'price' => $value]);
        $this->emitTo('cart-icon-component', 'refreshComponent');
    }
    public function destroy($rowId)
    {
        Cart::remove($rowId);
        session()->flash('success_message', 'Item has been removed');
    }
    public function destroyAll()
    {
        Cart::destroy();
        session()->flash('success_message', 'All items has been removed');
    }
    public function render()
    {

        return view('livewire.cart-component');
    }
}
