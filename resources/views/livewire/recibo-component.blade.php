<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ImagineShirt</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ public_path('/assets/imgs/theme/favicon.ico') }}">
    <link rel="stylesheet" href="{{ public_path('/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ public_path('/assets/css/custom.css') }}">
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
                                        <a href="/"><img src="{{ public_path('/assets/imgs/logo/logo2.png') }}" alt="logo"></a>
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
                                            <td class="image product-thumbnail"><img src="data:image/png;base64,{{ $images[$loop->index] }}"
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
                                            <td class="image product-thumbnail"><img src="data:image/png;base64,{{ $images[$loop->index] }}"
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

</body>
</html>
