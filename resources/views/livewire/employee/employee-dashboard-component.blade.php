<style>
    input {
        height: 30px;
        line-height: normal;
    }
    .btn,.btn-sm{
        line-height: 0%;
    }
    .btn.btn-sm{
        line-height: 0;
    }

    /*Pagination Style*/
    [aria-current] .page-link {
        color: #F15412;
    }

    .page-item.active .page-link{
        background-color: #F15412;
        border-color: #F15412;
    }

    [rel='prev'], [rel='next'] {
        color: #F15412;
    }

    [rel='prev']:hover, [rel='next']:hover {
        color: white;
        background-color: #F15412;
    }

    .pagination > li :not([rel='prev'],[rel='next'],[aria-current] .page-link) {
        color: #F15412;
    }
</style>
<section class="pt-100 pb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 m-auto">
                <div class="row">
                    <div class="tab-content dashboard-content">
                        <div class="tab-pane fade active show">
                            <div class="tab-pane fade active show" id="order" role="tabpanel"
                                aria-labelledby="clients-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Change order status</h5>
                                    </div>
                                    <!--Listagem Orders-->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="search-style-1" style="margin-bottom: 20px">
                                                <form action="{{route('employee.dashboard')}}" method="GET" style="width: 100%">

                                                    <input style="width: 80%" type="text"
                                                        placeholder="Search for Order..." name="search_term"
                                                        value="{{$msg}}">
                                                    <input class="improviso btn-buscar-top"
                                                        style="display: inline-block;width:19%;padding:0" type="submit"
                                                        value="Search">
                                                </form>
                                            </div>


                                            @if ($orders->count() == 0)
                                                <h4 class="p-3 text-center">Without Orders Found</h4>
                                            @else
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Order</th>
                                                            <th>Date</th>

                                                            <th>Total</th>
                                                            <th>Notes</th>
                                                            <th>Nif</th>
                                                            <th>Address</th>
                                                            <th>Customer Id</th>
                                                            <th>Name Customer</th>
                                                            <th>Payment Type</th>
                                                            <th>Payment Ref</th>
                                                            <th>Status</th>
                                                            <th>Change To</th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                        @foreach ($orders as $order)
                                                            <tr>
                                                                <td>#{{ $order->id }}</td>
                                                                <td>{{ $order->date }}</td>

                                                                <td>{{ $order->total_price }}€</td>
                                                                <td>{{ $order->notes }}</td>
                                                                <td>{{ $order->nif }}</td>
                                                                <td>{{ $order->address }}</td>
                                                                <td>{{ $order->customer_id }}</td>
                                                                <td>{{ $order->customerRef->userRef->name }}</td>
                                                                <td>{{ $order->payment_type }}</td>
                                                                <td>{{ $order->payment_ref }}</td>
                                                                <td style="color: #F15412;font-weight:bold">{{ $order->status }}</td>
                                                                <td>

                                                                        @if($order->status=="pending")
                                                                            <form action="{{route('employee.changeStatus')}}" method="post" style="display:inline-block">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <input type="text" name="status" value="paid" readonly style="display:none">
                                                                                <input type="number" name="order_id" value="{{$order->id}}" readonly style="display:none">
                                                                                <input type="submit" class="btn btn-sm" value="Paid" style="display: inline-flex">
                                                                            </form>
                                                                        @endif

                                                                        @if($order->status=="paid")
                                                                            <form action="{{route('employee.changeStatus')}}" method="post" style="display:inline-block">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="text" name="status" value="closed" readonly style="display:none">
                                                                            <input type="number" name="order_id" value="{{$order->id}}" readonly style="display:none">
                                                                            <input type="submit" class="btn btn-sm" value="Closed" style="display: inline-flex">
                                                                            </form>
                                                                        @endif



                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                            </div>
                                            @endif
                                        <!--Paginação das orders que tem status pending ou paid-->
                                        <br>
                                        @if (!($orders->count() == 0))
                                            {{ $orders->links('pagination::bootstrap-5') }}
                                        @endif
                                    </div>
                                    <!--Fim Listagem Clientes-->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
