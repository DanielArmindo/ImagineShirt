    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow">Home</a>

                    <span></span> Checkout
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <form method="post" action="{{route('shop.proceed_checkout',['user'=>$user])}}">
                    @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-25">
                            <h4>Billing Details</h4>
                        </div>

                        <div class="form-group">
                            <input type="text" name="address" required placeholder="Address *" value="{{$user->address != null ? $user->address : ''}}">
                        </div>
                        <div class="form-group">
                            <input required type="text" name="nif" placeholder="Nif" value="{{$user->nif != null ? $user->nif : ''}}">
                        </div>

                        <div class="form-group">
                            <input type="text" name="notes" placeholder="Notes about the order">
                        </div>

                        <div class="mb-25">
                            <h4>Payments</h4>
                        </div>
                        <div class="form-group">
                            <input required type="text" name="ref" placeholder="Referency payment" value="{{$user->default_payment_ref != null ? $user->default_payment_ref : ''}}">
                        </div>

                        <div class="payment_option">
                            <div class="custome-radio">
                                <input class="form-check-input" {{$user->default_payment_type == 'VISA' ? 'checked' : ''}} required type="radio" name="payment_option" value="VISA" id="exampleRadios3">
                                <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse" data-target="#cashOnDelivery" aria-controls="cashOnDelivery">VISA</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" {{$user->default_payment_type == 'MC' ? 'checked' : ''}} required type="radio" name="payment_option" value="MC" id="exampleRadios4">
                                <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse" data-target="#cardPayment" aria-controls="cardPayment">Master Card</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" {{$user->default_payment_type == 'PAYPAL' ? 'checked' : ''}} required type="radio" name="payment_option" value="PAYPAL" id="exampleRadios5">
                                <label class="form-check-label" for="exampleRadios5" data-bs-toggle="collapse" data-target="#paypal" aria-controls="paypal">Paypal</label>
                            </div>
                        </div>
                        @if($errors->any())
                            {{ implode('', $errors->all(':message')) }}<br>
                        @endif
                        @if($msg != '')
                            <br><h4 style="color:darkgoldenrod">{{$msg}}</h4>
                        @endif
                    </div>


                    <div class="col-md-6">
                        <div class="order_review">
                            <div class="mb-20">
                                <h4>Your Orders</h4>
                            </div>
                            <div class="table-responsive order_table text-center">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (Cart::content() as $item )
                                        <tr>
                                            <td class="image product-thumbnail"><img src="{{$item->options->image_url}}" alt="Sem Imagem Disponivel"></td>
                                            <td>
                                                <h5>
                                                @if ($item->name == "Custom Tshirt")
                                                    <a href="{{route('custom.product')}}">
                                                @else
                                                    <a href="{{route('product.details',['product'=>$item->id])}}">
                                                @endif
                                                {{$item->name}}</a></h5> <span class="product-qty">x {{$item->qty}}</span>
                                            </td>
                                            <td>{{$item->qty*$item->price}}€</td>
                                        </tr>
                                        @endforeach


                                        <tr>
                                            <th>Shipping</th>
                                            <td colspan="2"><em>Free Shipping</em></td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td colspan="2" class="product-subtotal"><span class="font-xl text-brand fw-900">{{Cart::total()}}€</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                            <button type="submit" class="btn btn-fill-out btn-block mt-30">Place Order</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </section>
    </main>
