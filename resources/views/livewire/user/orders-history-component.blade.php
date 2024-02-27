
<div class = "col-md-12 justify-content-center p-5 ">
    <h3>Order Information</h3>
    <div class="card-body ">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>PDF</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>#{{$orders->id}}</td>
                        <td>{{$orders->date}}</td>
                        <td>{{$orders->status}}</td>
                        <td>{{$orders->total_price}}€</td>
                        <td><a href="{{route('download.pdf',['order'=>$orders])}}" class="btn-small d-block">Download</a></td>
                    </tr>


                </tbody>
            </table>
        </div>
    </div>
</div>
<div class = "col-md-12 justify-content-center px-5">
<h3 >Items</h3>
    <div class="card-body ">
    <div class="table-responsive">
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Price</th>

                </tr>
            </thead>

            <tbody>
                @foreach ($orders->orderitemRef as $item)
                <tr>

                    <td>{{$item->tshirt_imageRef->name}}</td>
                    <td><img width="100px" height="100px" src="{{$images[$loop->index]}}"  /></td>
                    <td>{{$item->qty}}</td>
                    <td>{{$item->colorRef->name}}</td>
                    <td>{{$item->size}}</td>
                    <td>{{$item->sub_total}}€</td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
</div>


