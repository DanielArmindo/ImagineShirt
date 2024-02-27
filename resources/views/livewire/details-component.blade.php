       <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow">Home</a>
                    <span></span> Shop
                    <span></span> {{$product->name}}
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
                                        <h2 class="title-detail">{{$product->name}}</h2>
                                        <div class="product-detail-rating">
                                            <div class="pro-details-brand">
                                                <span> Categoria:
                                                    @if ($product->categorieRef == null)
                                                    <a href="{{route('product.category',['name'=>'null'])}}">
                                                    Sem Categoria
                                                    @else
                                                    <a href="{{route('product.category',['name'=>$product->categorieRef->name])}}">
                                                    {{$product->categorieRef->name}}
                                                    @endif
                                                </a></span>
                                            </div>
                                        </div>
                                        <div class="clearfix product-price-cover">
                                            <div class="product-price primary-color float-left">
                                                <ins><span class="text-brand">{{$prices->unit_price_catalog}} €</span></ins>

                                            </div>
                                        </div>
                                        <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                        <div class="short-desc mb-30">
                                            <p>{{$product->description}}</p>
                                        </div>


                                        <form action="{{route('product.details',['product'=>$product])}}" method="get">
                                            <h4 class="mr-20">Size:</h4>
                                            <div class="form-group">
                                                <div class="custom_select">
                                                    <input type="text" name="base" value="{{$base}}" readonly style="display: none">
                                                    <select class="form-control select-active" name="size" onchange="this.form.submit()">
                                                        <option {{ $size == 'S' ? 'selected' : '' }} value="S">S</option>
                                                        <option {{ $size == 'M' ? 'selected' : '' }} value="M">M</option>
                                                        <option {{ $size == 'L' ? 'selected' : '' }} value="L">L</option>
                                                        <option {{ $size == 'XS' ? 'selected' : '' }} value="XS">XS</option>
                                                        <option {{ $size == 'XL' ? 'selected' : '' }} value="XL">XL</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                        <div class="detail-extralink">

                                            <div class="product-extra-link2">
                                                <button type="button" class="button button-add-to-cart" wire:click.prevent="store({{$product->id}},'{{"$product->name"}}','{{"1"}}','{{"$prices->unit_price_catalog"}}','{{"$base"}}','{{"$size"}}','{{"$images[0]"}}')">Add to cart</button>

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
                                                <li><a class="text-dark" href="{{route('product.details',['product'=>$product,'base'=>$url,'size'=>$size])}}"><img src="{{$image}}" alt=""></a></li>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!--Fim Seleção da tshirt-->

                            <div class="tab-style3">
                                <ul class="nav nav-tabs text-uppercase">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description">Packaging & Delivery</a>
                                    </li>
                                </ul>
                                <div class="tab-content shop_info_tab entry-main-content">
                                    <div class="tab-pane fade show active" id="Description">
                                        <div class="">

                                            <h4 class="mt-30">Packaging & Delivery</h4>
                                            <hr class="wp-block-separator is-style-wide">
                                            <p>Envio Rápido e Confiável para as suas Camisolas</p>
                                            <p>Na nossa loja de camisolas, queremos garantir que você receba suas peças de forma rápida e segura. Por isso, trabalhamos com serviços de envio confiáveis para entregar os seus pedidos em tempo hábil.</p>
                                            <p>Assim que seu pedido for confirmado, nossa equipe dedicada começa a preparar suas camisolas para envio. Cuidamos de cada detalhe, desde a embalagem cuidadosa até a etiquetagem correta, para que suas camisolas cheguem em perfeitas condições.</p>
                                            <p>Oferecemos diferentes opções de envio para atender às suas necessidades e preferências. Você pode escolher entre o envio expresso, que garante uma entrega mais rápida, ou o envio padrão, que oferece um prazo de entrega mais flexível.</p>
                                            <p>Para garantir transparência e rastreamento, fornecemos um código de rastreamento assim que seu pedido for despachado. Com esse código, você poderá acompanhar a trajetória das suas camisolas até a sua porta. Dessa forma, você terá total controle sobre o status da entrega.</p>
                                            <p>Estamos comprometidos em oferecer um excelente atendimento ao cliente em relação ao envio. Caso tenha alguma dúvida sobre o processo de envio ou precise de assistência, nossa equipe de suporte estará pronta para ajudar. Basta entrar em contato conosco por meio dos canais de comunicação disponíveis no nosso site.</p>
                                            <p>Valorizamos a satisfação dos nossos clientes, e é por isso que nos esforçamos para tornar o processo de envio simples, eficiente e confiável. Conte conosco para entregar suas camisolas de maneira segura e no prazo. Seu conforto e satisfação são a nossa prioridade.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-60">
                                <div class="col-12">
                                    <h3 class="section-title style-1 mb-30">Related products</h3>
                                </div>
                                <div class="col-12">
                                    <div class="row related-products">

                                        @foreach ($rproducts  as $rproduct )
                                            <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                                <div class="product-cart-wrap small hover-up">
                                                    <div class="product-content-wrap">
                                                        <a href="{{route('product.details',['product'=>$rproduct])}}" tabindex="0">
                                                        <img class="default-img" src="{{$images[($loop->index)+1]}}" alt="Sem Imagem Disponivel">
                                                        </a>
                                                        <h2><a href="{{route('product.details',['product'=>$rproduct])}}" tabindex="0">{{$rproduct->name}}</a></h2>
                                                        <div class="product-price">
                                                            <span>{{$prices->unit_price_catalog}}€</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                            <div class="product-cart-wrap small hover-up">
                                                <div class="product-img-action-wrap">
                                                    <div class="product-img product-img-zoom">
                                                        <a href="product-details.html" tabindex="0">
                                                            <img class="default-img" src="assets/imgs/shop/product-3-1.jpg" alt="">
                                                            <img class="hover-img" src="assets/imgs/shop/product-4-2.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="product-action-1">
                                                        <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-search"></i></a>
                                                        <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="wishlist.php" tabindex="0"><i class="fi-rs-heart"></i></a>
                                                        <a aria-label="Compare" class="action-btn small hover-up" href="compare.php" tabindex="0"><i class="fi-rs-shuffle"></i></a>
                                                    </div>
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        <span class="sale">-12%</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                            <div class="product-cart-wrap small hover-up">
                                                <div class="product-img-action-wrap">
                                                    <div class="product-img product-img-zoom">
                                                        <a href="product-details.html" tabindex="0">
                                                            <img class="default-img" src="assets/imgs/shop/product-4-1.jpg" alt="">
                                                            <img class="hover-img" src="assets/imgs/shop/product-4-2.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="product-action-1">
                                                        <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-search"></i></a>
                                                        <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="wishlist.php" tabindex="0"><i class="fi-rs-heart"></i></a>
                                                        <a aria-label="Compare" class="action-btn small hover-up" href="compare.php" tabindex="0"><i class="fi-rs-shuffle"></i></a>
                                                    </div>
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        <span class="new">New</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                            <div class="product-cart-wrap small hover-up mb-0">
                                                <div class="product-img-action-wrap">
                                                    <div class="product-img product-img-zoom">
                                                        <a href="product-details.html" tabindex="0">
                                                            <img class="default-img" src="assets/imgs/shop/product-5-1.jpg" alt="">
                                                            <img class="hover-img" src="assets/imgs/shop/product-3-2.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="product-action-1">
                                                        <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-search"></i></a>
                                                        <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="wishlist.php" tabindex="0"><i class="fi-rs-heart"></i></a>
                                                        <a aria-label="Compare" class="action-btn small hover-up" href="compare.php" tabindex="0"><i class="fi-rs-shuffle"></i></a>
                                                    </div>
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        <span class="hot">Hot</span>
                                                    </div>
                                                </div>

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
