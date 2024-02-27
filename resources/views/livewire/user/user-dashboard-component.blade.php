<style>
    .custom_select .select2-container--default .select2-selection--single {
        width: 160px;
        padding-right: 50px;
    }
</style>
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{route('home.index')}}" rel="nofollow">Home</a>
                <span></span> My Account
            </div>
        </div>
    </div>
    <section class="pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-menu">
                                <ul class="nav flex-column" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link
                                        @if ($orders_selected == 0)
                                            active
                                        @endif
                                        " id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link
                                        @if ($orders_selected == 1)
                                            active
                                        @endif
                                        " id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                    </li>

                                    <li class="nav-item">
                                        <form method="POST" action="{{route('logout')}}">
                                            @csrf
                                            <a class="nav-link" href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content dashboard-content">
                                <div class="tab-pane fade
                                @if ($orders_selected == 0)
                                active show
                                @endif
                                " id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">

                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">{{$user->name}} </h5>
                                        </div>
                                        <div class="card-body">
                                            <p>From your account dashboard. you can easily check &amp; view your <a href="{{route('user.dashboard',['show_orders'])}}">orders</a> and <a href="{{route('profile.edit')}}">edit your password and account details.</a></p>
                                        </div>
                                    </div>

                                    <div class="card" style="margin-top: 15px">
                                        <form action="{{route('profile.update.photo', ['user' =>$user])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                        <div class="card-header">
                                            <h5>Perfil Image</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img alt="Sem Imagem" id="perfil_photo" height="100px" width="100px" src="{{asset('/storage/photos/'.$user->photo_url)}}" alt="">
                                                </div>

                                                <div class="col-lg-9 align-self-center mb-lg-0 mb-4">
                                                    <h3 class="font-heading mb-40">
                                                        Change perfil image
                                                    </h3>
                                                    <input type="file" name="file_photo" accept="image/png, image/jpeg" onchange="readURL(this);">
                                                    <input type="submit" class="btn btn-fill-out btn-block mt-30" value="Change Photo">
                                                </div>

                                            </div>
                                        </div>
                                        </form>
                                    </div>


                                </div>
                                <div class="tab-pane fade
                                @if ($orders_selected == 1)
                                active show
                                @endif
                                " id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Your Orders</h5>
                                        </div>
                                        <div class="card-body">

                                            <div class="search-style-1">
                                                <form action="{{route('user.dashboard')}}" method="GET" style="width: 100%;">
                                                    <div class="container" style="display:inline-flex">
                                                        <input type="number" name="show_orders" value="1" style="display: none">
                                                        <input class="col-9" type="text" placeholder="Search for Clients..." name="search" value="{{$search}}">
                                                        <input class="col-3" style="padding: inherit;" type="submit" value="Search">
                                                    </div>

                                                    <div class="container">
                                                        <div class="custom_select mt-3 mb-3 justify-content-center" style="display:inline-flex">
                                                            <h5 style="padding-top: 14px;padding-right: 15px;">Search Type:</h5>
                                                            <select class="form-control select-active" name="type_search">
                                                                <option {{$type_search == "ID" ? 'selected' : ''}} value="ID">Number Order</option>
                                                                <option {{$type_search == "DATE" ? 'selected' : ''}} value="DATE">Date</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>

                                            @if ($orders->count() != 0)
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Order</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Total</th>

                                                                <th>Products</th>
                                                                <th>PDF</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach($orders as $order)
                                                            <tr>
                                                                <td>{{$order->id}}</td>
                                                                <td>{{$order->date}}</td>
                                                                <td>{{$order->status}}</td>
                                                                <td>{{$order->total_price}}€</td>

                                                                <td>
                                                                    <a href="{{route('user.order',['order'=>$order])}}" class="btn-small d-block">View</a>

                                                                <td>
                                                                    <a href="{{route('show.pdf', ['order' => $order])}}">View</a>
                                                                    <a href="{{route('download.pdf',['order'=>$order])}}" class="btn-small d-block">Download</a>
                                                                </td>
                                                            </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!--pagination-->
                                                <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                                                    <nav aria-label="Page navigation example">
                                                        {{$orders->appends(['show_orders'=>0,'type_search'=>$type_search,'search'=>$search])->links("pagination::bootstrap-5");}}
                                                    </nav>
                                                </div>
                                            @else
                                                <h4 class="text-center mb-3 mt-3" style="color:darkorange">Without Orders</h4>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#perfil_photo')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
