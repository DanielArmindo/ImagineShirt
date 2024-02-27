<style>
    .form-group {
  margin-bottom: 0;
}
</style>
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow">Home</a>
                <span></span> Shop
                <span></span> Custom Tshirt
            </div>
        </div>
    </div>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-gallery">
                                    <!-- MAIN SLIDES -->
                                    <div class="product-image-slider">
                                        <img src="{{$images[0]}}" alt="Sem Produto para Visualizar">
                                    </div>
                                    <!-- THUMBNAILS -->
                                </div>
                                <!-- End Gallery -->
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info">
                                    <h2 class="title-detail">Custom Tshirt</h2>

                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            <ins><span class="text-brand">{{$prices->unit_price_own}} €</span></ins>

                                        </div>
                                    </div>
                                    <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                    <div class="short-desc mb-30">
                                        <p>Custom your tshirt with size and custom image</p>
                                    </div>


                                    <form action="{{route('custom.product')}}" method="get">
                                        <h4 style="display: inline-flex;margin-right:15px">Size:</h4>
                                        <div class="form-group" style="display: inline-flex">
                                            <div class="custom_select">
                                                <input type="text" name="background" value="{{$background}}" readonly style="display: none">
                                                <input type="text" name="base" value="{{$base}}" readonly style="display: none">
                                                <select class="form-control select-active" name="size" onchange="this.form.submit()" style="width: 120px;">
                                                    <option {{ $size == 'S' ? 'selected' : '' }} value="S">S</option>
                                                    <option {{ $size == 'M' ? 'selected' : '' }} value="M">M</option>
                                                    <option {{ $size == 'L' ? 'selected' : '' }} value="L">L</option>
                                                    <option {{ $size == 'XS' ? 'selected' : '' }} value="XS">XS</option>
                                                    <option {{ $size == 'XL' ? 'selected' : '' }} value="XL">XL</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="bt-1 border-color-1 mt-30 mb-30">
                                        <div class="mb-3">
                                            <form action="{{route('custom.photo')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <label for="formFile" class="form-label">Upload your custom image to preview (image must be as png an size less than 4M)</label>
                                                <input class="form-control" type="file" name="photo_upload" id="formFile" accept="image/png" onchange="form.submit()">
                                            </form>
                                            @error('photo_upload')
                                                {{$message}}
                                            @enderror

                                            @if ($msg != '')
                                                <br>
                                                <h4 style="color: darkgoldenrod">{{$msg}}</h4>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="detail-extralink">
                                    <a href="{{route('custom.product',['base'=>$base,'size'=>$size,'background'=>2])}}" type="button" class="btn btn-sm btn-outline-primary">White Background</a>
                                    <a href="{{route('custom.product',['base'=>$base,'size'=>$size,'background'=>1])}}" type="button" class="btn btn-sm btn-outline-primary">Black Background</a>

                                    <div class="product-extra-link2">
                                        <button type="button" class="button button-add-to-cart"
                                        wire:click.prevent="store({{$code_tshirt}},'{{"1"}}','{{"$prices->unit_price_own"}}','{{"$base"}}','{{"$size"}}','{{"$images[0]"}}','{{"$background"}}')">
                                        Add to cart</button>
                                    </div>

                                    </div>
                                </div>
                                <!-- Detail Info -->
                            </div>
                        </div>

                        <!--Seleção da tshirt-->
                        <section class="section-padding">
                            <div class="container">
                                <h3 class="section-title mb-20 wow fadeIn animated"><span>Select color of tshirt</span> </h3>
                                <div class="carausel-6-columns-cover position-relative wow fadeIn animated">
                                    <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-3-arrows"></div>
                                    <div class="carausel-6-columns text-center" id="carausel-6-columns-3">
                                        @foreach ($tshirts as $tshirt)
                                            @foreach ($tshirt as $image => $url)
                                            <li><a class="text-dark" href="{{route('custom.product',['base'=>$url])}}"><img src="{{$image}}" alt=""></a></li>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!--Fim Seleção da tshirt-->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
