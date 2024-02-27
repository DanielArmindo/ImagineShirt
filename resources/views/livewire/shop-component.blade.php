
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span> Shop
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="shop-product-fillter">
                            <div class="totall-product">
                                <p> We found <strong class="text-brand">{{$products->total()}}</strong> items for you!</p>
                            </div>
                            <div class="sort-by-product-area">
                                <div class="sort-by-cover mr-10">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps"></i>Show:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span> {{$pageSize}} <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="{{$pageSize==12 ? 'active': ''}}" href="{{$page_url[0]}}">12</a></li>
                                            <li><a class="{{$pageSize==15 ? 'active': ''}}" href="{{$page_url[1]}}">15</a></li>
                                            <li><a class="{{$pageSize==24 ? 'active': ''}}" href="{{$page_url[2]}}">24</a></li>
                                            <li><a class="{{$pageSize==30 ? 'active': ''}}" href="{{$page_url[3]}}">30</a></li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="sort-by-cover">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span> {{$orderBy}} <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="{{$orderBy=='Default Sorting' ? 'active': ''}}" href="{{$page_url[4]}}">Default Sorting</a></li>

                                            <li><a class="{{$orderBy=='Sort By Newness' ? 'active': ''}}" href="{{$page_url[5]}}">Sort By Newness</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row product-grid-3">
                            @foreach ($products as $product)
                            <div class="col-lg-4 col-md-4 col-6 col-sm-6">
                                <div class="product-cart-wrap mb-30">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="{{route('product.details',['product'=>$product])}}" class="text-center">
                                                <img class="default-img" src="
                                                {{$images[$loop->index]}}
                                                " alt="Sem foto Disponivel">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="#">
                                                @if ($product->categorieRef == null)
                                                Sem Categoria
                                                @else
                                                {{$product->categorieRef->name}}
                                                @endif
                                        </div>
                                        <h2><a href="{{route('product.details',['product'=>$product])}}">{{$product->name}}</a></h2>


                                        <div class="product-action-1 show">
                                            <a aria-label="View Tshirt" class="action-btn hover-up" href="{{route('product.details',['product'=>$product])}}"><i class="fi-rs-eye"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                        <!--pagination-->
                        <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                            <nav aria-label="Page navigation example">
                                {{$products->appends(['pageSize'=>$pageSize,'orderBy'=>$orderBy])->links("pagination::bootstrap-5");}}
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-3 primary-sidebar sticky-sidebar">
                        <div class="row">
                            <div class="col-lg-12 col-mg-6"></div>
                            <div class="col-lg-12 col-mg-6"></div>
                        </div>
                        <div class="widget-category mb-30">
                            <h5 class="section-title style-1 mb-30 wow fadeIn animated">Category</h5>
                            <ul class="categories">
                                <li><a href="{{route('shop')}}">Todos</a></li>
                                <li><a href="{{route('product.category',['name'=>'null'])}}">Sem Categoria</a></li>
                                @foreach ($categories as $category )
                                <li><a href="{{route('product.category',['name'=>$category->name])}}">{{$category->name}}</a></li>

                                @endforeach

                            </ul>
                        </div>

                        <!-- Product sidebar Widget -->


                    </div>
                </div>
            </div>
        </section>
    </main>
