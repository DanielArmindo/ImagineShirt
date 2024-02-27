<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ImagineShirt</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/imgs/theme/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/custom.css') }}">
    @livewireStyles
</head>

<body>
    <div>
        <main class="main">
            <div class="card">
                <div class="card-body mx-4">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="logo logo-width-1 d-block d-lg-none me-3">
                                        <a href="/"><img src="{{ asset('/assets/imgs/logo/logo2.png') }}" alt="logo"></a>
                                    </div>

                                </div>
                            </div>


                        <div class="col-md-6">
                            <p class="my-5 mx-5" style="font-size: 20px;">
                                @if (isset($status))
                                    @switch($status)
                                        @case('closed')
                                            Your order has been placed.
                                            @break
                                        @case('paid')
                                            Your order has been paid.
                                            @break
                                        @case('canceled')
                                            Your order has been revoked.
                                            @break

                                    @endswitch
                                @else
                                    Your order has been received and is now being processed.
                                @endif
                                Your order details are shown below for your reference:
                                </p>
                        </div>
                        <div class="col-md-12 d-flex justify-content-between">
                            <div>
                                <p style="font-size: 15px;">Name: {{ $nome }}</p>
                                <p style="font-size: 15px;">Nif: {{ $nif }}</p>
                            </div>
                            <p style="font-size: 15px;">Data: {{ $data }}</p>
                        </div>




                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <p>Image</p>
                                    </th>
                                    <th>
                                        <p>Product</p>
                                    </th>
                                    <th>
                                        <p>Price</p>
                                    </th>
                                    <th>
                                        <p>Quantity</p>
                                    </th>
                                    <th>
                                        <p>Total</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @isset($order_items)

                                    @foreach ($order_items as $item)
                                        <tr>
                                            <td class="image product-thumbnail"><img src="{{ $images[$loop->index] }}"
                                                    alt="Sem Imagem Disponivel"></td>
                                            <td>{{ $item->tshirt_imageRef->name }}</td>
                                            <td>{{ $item->unit_price }}€</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->sub_total }}€</td>
                                        </tr>
                                    @endforeach

                                @else

                                    @foreach ($carrinho as $item)
                                        <tr>
                                            <td class="image product-thumbnail"><img src="{{ $item->options->image_url }}"
                                                    alt="Sem Imagem Disponivel"></td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->price }}€</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->subtotal }}€</td>
                                        </tr>
                                    @endforeach

                                @endisset


                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">Total</td>
                                    <td>{{ $total }}€</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <p class="text-end"style="font-size: 15px;">Payment Type: {{ $payment }}</p>
                </div>
            </div>

    </div>
    </main>


    <script src="{{ asset('/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/jquery-ui.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
    <!-- Template  JS -->
    <script src="{{ asset('/assets/js/main.js?v=3.3') }}"></script>
    <script src="{{ asset('/assets/js/shop.js?v=3.3') }}"></script>
    @vite('resources/js/app.js')
    @livewireScripts
    @stack('scripts')
</body>

</html>
