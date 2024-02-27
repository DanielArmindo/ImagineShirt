<x-app-layout>
    <style>
        .custom_price{
            font-weight: bold;
            color: #F15412;
        }
    </style>
    <main class="main mb-50 mt-50">
        <div class="container">

            <div class="mt-15 mb-30 text-center">
                @if($errors->any())
                    {{ implode('', $errors->all(':message')) }}<br>
                @endif
                <h4 style="color:darkgoldenrod">{{$msg}}</h4>
            </div>

            <div class="row">
                <div class="col">
                    <h2>Unit Price in Catalog</h2>
                    <p class="mt-15">Each unit costs <span class="custom_price">{{$precos->unit_price_catalog}}€</span></p>
                    <p>When arrive at <span class="custom_price">{{$precos->qty_discount}}</span> units each unit costs <span class="custom_price">{{$precos->unit_price_catalog_discount}}€</span></p>
                    <div class="d-flex">
                        <form action="{{route('admin.change.prices')}}" method="post" style="width: 100%;margin-top:10px">
                            @csrf
                            @method('PUT')
                            <input type="number" name="operation" value="1" readonly style="display: none">
                            <div class="col-10" style="display: inline-flex"><span class="col-2" style="margin-top:10px">New Price:</span>
                                <input name="new_price" type="number" step="0.01" min="0.01"><span style="margin-top:10px">€</span></div>
                                <br><br>
                            <div class="col-10" style="display: inline-flex"><span class="col-4" style="margin-top:7px">Price when discounted:</span>
                                <input name="discount_price" type="number" step="0.01" min="0.01"><span style="margin-top:10px">€</span></div>
                                <br>
                              <button class="btn-sm" type="submit">Save</button>
                        </form>
                    </div>
                </div>
                <div class="col">
                    <h2>Unit Price in Custom Tshirts</h2>
                    <p class="mt-15">Each unit costs <span class="custom_price">{{$precos->unit_price_own}}€</span></p>
                    <p>When arrive at <span class="custom_price">{{$precos->qty_discount}}</span> units each unit costs <span class="custom_price">{{$precos->unit_price_own_discount}}€</span></p>
                    <form action="{{route('admin.change.prices')}}" method="post" style="width: 100%;margin-top:10px">
                        @csrf
                        @method('PUT')
                        <input type="number" name="operation" value="2" readonly style="display: none">
                        <div class="col-10" style="display: inline-flex"><span class="col-3"  style="margin-top:10px">New Price:</span>
                            <input name="new_price" type="number" step="0.01" min="0.01"><span style="margin-top:10px">€</span></div>
                            <br><br>
                        <div class="col-10" style="display: inline-flex"><span class="col-4"  style="margin-top:7px">Price when discounted:</span>
                            <input name="discount_price" type="number" step="0.01" min="0.01"><span style="margin-top:10px">€</span></div>
                            <br>
                        <button class="btn-sm" type="submit">Save</button>
                    </form>
                </div>
            </div>

            <div class="row text-center mt-50">
                <h2>Change Quantity for discount:</h2>
                <form action="{{route('admin.change.prices')}}" method="post" style="margin-top:10px">
                    @csrf
                    @method('PUT')
                    <input type="number" name="operation" value="3" readonly style="display: none">
                    <input class="col-4" name="quantity" type="number" value="{{$precos->qty_discount}}">
                    <button class="btn-sm" type="submit">Save</button>
                </form>
            </div>




        </div>
    </main>
</x-app-layout>
