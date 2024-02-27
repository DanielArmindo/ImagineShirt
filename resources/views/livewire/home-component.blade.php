<main class="main">
<br>
    <section class="section-padding">
        <div class="container wow fadeIn animated">
            <h3 class="section-title text-center mb-20"><span>Tshirts</span> Categorias</h3>
            <div class="carausel-6-columns-cover position-relative">
                <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-2-arrows"></div>
                <div class="carausel-6-columns carausel-arrow-center" id="carausel-6-columns-2">
                    <div class="product-cart-wrap small hover-up">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="{{route('shop')}}">
                                    <img class="default-img" src="{{$camisolas[0]}}" alt="">

                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Ver Catágolo" class="action-btn hover-up" href="{{route('shop')}}"  data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>

                            </div>


                        </div>
                        <div class="product-content-wrap">
                            <h2><a href="{{route('shop')}}">Tshirt Estampa</a></h2>
                            <h2>{{$prices->unit_price_catalog }}€</h2>

                        </div>
                    </div>
                    <!--End product-cart-wrap-2-->
                    <div class="product-cart-wrap small hover-up">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="{{route('custom.product')}}">
                                    <img class="default-img" src="{{$camisolas[1]}}" alt="">

                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Costumizar" class="action-btn hover-up" href="{{route('custom.product')}}"  data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>

                            </div>

                        </div>
                        <div class="product-content-wrap">
                            <h2><a href="{{route('custom.product')}}">Tshirt Costumizável</a></h2>
                            <h2>{{$prices->unit_price_own }}€</h2>

                        </div>
                    </div>
                    <!--End product-cart-wrap-2-->



                </div>
            </div>
        </div>
    </section>
<br>
<br>
    @if (!Auth::check())
        <h4 class="section-title mb-20 wow fadeIn animated text-center"><span>Login to your account to customize own tshirt</span> </h4>
    @endif

    <section class="section-padding">
        <div class="container">
            <h3 class="section-title mb-20 wow fadeIn animated"><span>Categories</span> </h3>
            <div class="carausel-6-columns-cover position-relative wow fadeIn animated">
                <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-3-arrows"></div>
                <div class="carausel-6-columns text-center" id="carausel-6-columns-3">
                    @foreach ($categories as $category )

                    <li><a class="text-dark" href="{{route('product.category',['name'=>$category->name])}}">{{$category->name}}</a></li>

                    @endforeach

                </div>
            </div>
        </div>
    </section>
    <br>
    <br>

    </main>
