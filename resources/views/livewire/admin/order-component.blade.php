<style>
    input {
        height: 30px;
        line-height: normal;
    }

    .btn,
    .btn-sm {
        line-height: 0%;
    }

    .btn.btn-sm {
        line-height: 0;
    }

    /*Pagination Style*/
    [aria-current] .page-link {
        color: #F15412;
    }

    .page-item.active .page-link {
        background-color: #F15412;
        border-color: #F15412;
    }

    [rel='prev'],
    [rel='next'] {
        color: #F15412;
    }

    [rel='prev']:hover,
    [rel='next']:hover {
        color: white;
        background-color: #F15412;
    }

    .pagination>li :not([rel='prev'], [rel='next'], [aria-current] .page-link) {
        color: #090909;
    }

    @media only screen and (max-width: 1270px){
        .ajuste{
            width: 90px;
        }
    }
    @media only screen and (min-width: 1271px){
        .ajuste{
            width: 90px;
        }
    }
    .custom_select .select2-container--default .select2-selection--single {
        padding-right: 40px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding: unset;
    }

    .link-vd:hover{
        text-decoration: underline #F15412
    }
</style>
<div class="col-lg-11 p-5 m-auto" id="order" role="tabpanel" aria-labelledby="admins-tab">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Change order status
                @if (session()->has('order_message'))
                - <span style="color: #F15412">{{session('order_message')}}</span>
                @endif
            </h5>
        </div>
        <!--Listagem Orders-->
        <div class="card-body">
            <div class="row">

                <div class="search-style-1" style="margin-bottom: 20px">
                    <form action="{{ route('admin.order') }}" method="GET" style="width:100%;display: inline-flex">

                        <div class="row col-6 justify-content-center">
                                <input class="col-sm-4" style="width: 80%" type="text" placeholder="Search for ..." name="search_term" value="{{ $search }}">
                                <input class="btn-buscar-top col-sm-2 ajuste" type="submit" value="Search">
                        </div>


                        <div class="row col-6">
                            <div class="form-group col-6 text-center">
                                <div class="custom_select">
                                    <select class="form-control select-active" name="type_search">
                                        <option {{$type_search == "ID" ? 'selected' : ''}} value="ID">Number Order</option>
                                        <option {{$type_search == "DATE" ? 'selected' : ''}} value="DATE">Date</option>
                                        <option {{$type_search == "CUSTM_ID" ? 'selected' : ''}} value="CUSTM_ID">Customer ID</option>
                                    </select>
                                </div>
                                <h5>Type of Search</h5>
                            </div>

                            <div class="form-group col-6 text-center" >
                                <div class="custom_select">
                                    <select class="form-control select-active" name="type_sort">
                                        <option {{$type_sort == "DEF" ? 'selected' : ''}} value="DEF">Default</option>
                                        <option {{$type_sort == "DATE_ASC" ? 'selected' : ''}} value="DATE_ASC">Date ASC</option>
                                        <option {{$type_sort == "DATE_DESC" ? 'selected' : ''}} value="DATE_DESC">Date DESC</option>
                                        <option {{$type_sort == "STATUS_ASC" ? 'selected' : ''}} value="STATUS_ASC">Status ASC</option>
                                        <option {{$type_sort == "STATUS_DESC" ? 'selected' : ''}} value="STATUS_DESC">Status DESC</option>
                                        <option {{$type_sort == "TOTAL_ASC" ? 'selected' : ''}} value="TOTAL_ASC">Total ASC</option>
                                        <option {{$type_sort == "TOTAL_DESC" ? 'selected' : ''}} value="TOTAL_DESC">Total DESC</option>
                                    </select>
                                </div>
                                <h5>Sorting</h5>
                            </div>
                        </div>
                    </form>
                </div>
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
                                <th>PDF</th>
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
                                        <form action="{{ route('admin.changeStatus') }}" method="post"
                                            style="display:inline-block;padding:5px;">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="status" value="paid" readonly
                                                style="display:none">
                                            <input type="number" name="order_id" value="{{ $order->id }}" readonly
                                                style="display:none">
                                            <input type="submit" class="btn btn-sm" value="Paid"
                                                style="display: inline-flex">
                                        </form>
                                        <form action="{{ route('admin.changeStatus') }}" method="post"
                                            style="display:inline-block;padding:5px;">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="status" value="closed" readonly
                                                style="display:none">
                                            <input type="number" name="order_id" value="{{ $order->id }}" readonly
                                                style="display:none">
                                            <input type="submit" class="btn btn-sm" value="Closed"
                                                style="display: inline-flex">
                                        </form>
                                        <form action="{{ route('admin.changeStatus') }}" method="post"
                                            style="display:inline-block;padding:5px;">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="status" value="canceled" readonly
                                                style="display:none">
                                            <input type="number" name="order_id" value="{{ $order->id }}" readonly
                                                style="display:none">
                                            <input type="submit" class="btn btn-sm" value="Canceled"
                                                style="display: inline-flex">
                                        </form>

                                    <td>
                                        <a href="{{ route('admin.show.pdf', ['order' => $order]) }}" class="link-vd">View</a>
                                        <a href="{{ route('admin.download.pdf', ['order' => $order]) }}" class="link-vd">Download</a>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <br>
                @if (!($orders->count() == 0))
                    {{ $orders->appends(['type_search'=>$type_search,'type_sort'=>$type_sort,'search_term'=>$search])->links('pagination::bootstrap-5') }}
                @endif
        </div>
        @endif
        <!--Paginação das orders que tem status pending ou paid-->

    </div>
    <!--Fim Listagem Clientes-->
</div>
</div>
