<div class="header-action-icon-2">
    <a class="mini-cart-icon" href="{{route('shop.cart')}}">
        <img alt="Surfside Media" src="/assets/imgs/theme/icons/icon-cart.svg">
        @if(Cart::count() > 0)
            <span class="pro-count blue">{{ Cart::count() }}</span>
        @endif
    </a>
    <div class="cart-dropdown-wrap cart-dropdown-hm2">
        <ul>
            @foreach(Cart::content() as $item)
            <li>
                <div class="shopping-cart-img">
                    <img alt="{{$item->name}}" src="{{$item->options->image_url}}">
                </div>
                <div class="shopping-cart-title">
                    <h4>
                    @if ($item->name == "Custom Tshirt")
                        <a href="{{route('custom.product')}}">
                    @else
                        <a href="{{route('product.details',['product'=>$item->id])}}">
                    @endif
                    {{substr($item->name,0,20)}}</a></h4>
                    <h4><span style="color: darkorange; font-weight:bold">{{$item->qty}} × </span>{{$item->price}}€</h4>
                </div>

            </li>
            @endforeach

        </ul>
        <div class="shopping-cart-footer">
            <div class="shopping-cart-total">
                <h4>Total <span>{{Cart::total()}}€</span></h4>
            </div>
            <div class="shopping-cart-button">
                <a href="{{route('shop.cart')}}" class="outline">View cart</a>
                <a href="{{route('shop.checkout')}}">Checkout</a>
            </div>
        </div>
    </div>
</div>
