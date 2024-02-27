<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>ImagineShirt</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="shortcut icon" type="image/x-icon" href="/assets/imgs/logo/logo1.png">
    <link rel="stylesheet" href="{{ asset('/assets/css/main.css')}}">
    <link rel="stylesheet" href="{{ asset('/assets/css/custom.css')}}">
@livewireStyles
</head>

<body>
    <header class="header-area header-style-1 header-height-2">
        <div class="header-top header-top-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4">

                    </div>
                    <div class="col-xl-6 col-lg-4">

                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info header-info-right">
                            @auth
                            <ul>
                                <li><i class="fi-rs-user"></i>{{ Auth::user()->name }} /
                                    <form method="POST" action="{{route('logout')}}">
                                        @csrf
                                        <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                    </form>
                                </li>
                            </ul>
                            @else
                            <ul>
                                <li><i class="fi-rs-key"></i><a href="{{route('login')}}">Log In </a>  / <a href="{{route('register')}}">Sign Up</a></li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="/"><img src="/assets/imgs/logo/logo2.png" alt="logo"></a>
                    </div>
                    <div class="header-right">
                       @livewire('header-search-component')
                        <div class="header-action-right">
                            <div class="header-action-2">

                                @livewire('cart-icon-component')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="/"><img src="/assets/imgs/logo/logo2.png" alt="logo"></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">

                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                            <nav>
                                <ul>
                                    <li><a class="active" href="{{route('home.index')}}">Home </a></li>
                                    <li><a href="{{route('about')}}">About</a></li>
                                    <li><a href="{{route('shop')}}">Shop</a></li>
                                    <li><a href="{{route('contact')}}">Contact</a></li>

                                        @auth
                                           @if(Auth::user()->user_type == "A")
                                                <!--Admin-->
                                                <li><a href="#">My Account<i class="fi-rs-angle-down"></i></a>
                                                <ul class="sub-menu">
                                                    <li><a href="{{route('admin.dashboard')}}">Info Accounts</a></li>
                                                    <li><a href="{{route('admin.order')}}">Manage Orders</a></li>
                                                    <li><a href="{{route('admin.colors')}}">Manage Base Colors Tshirts</a></li>
                                                    <li><a href="{{route('admin.categories')}}">Manage Categories</a></li>
                                                    <li><a href="{{route('admin.images')}}">Manage Images</a></li>
                                                    <li><a href="{{route('admin.prices')}}">Change Prices Company</a></li>
                                                    <li><a href="{{route('admin.statistics')}}">Statistics</a></li>
                                                </ul>
                                            @elseif(Auth::user()->user_type == "E")
                                                <!--Funcionario-->
                                                <li><a href="#">My Account<i class="fi-rs-angle-down"></i></a>
                                                <ul class="sub-menu">
                                                    <li><a href="{{route('employee.dashboard')}}">Manage Orders</a>
                                                    <li><a href="{{route('employee.change.password')}}">Change Passoword</a></li>
                                                </ul>

                                            @elseif(Auth::user()->user_type == "C")
                                                <!--User-->

                                                 <li><a href="#">Custom Tshirt<i class="fi-rs-angle-down"></i></a>
                                                    <ul class="sub-menu">
                                                        <li><a href="{{route('custom.product')}}">Custom Tshirt</a>
                                                        <li><a href="{{route('user.custom.tshirts')}}">My Custom Tshirts</a></li>
                                                    </ul>
                                                <li><a href="#">My Account<i class="fi-rs-angle-down"></i></a>
                                                <ul class="sub-menu">
                                                    <li><a href="{{route('user.dashboard')}}">Dashboard</a></li>
                                                    <li><a href="{{route('profile.edit')}}">Account Details</a></li>

                                                </ul>
                                            @endif
                                        @endif
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>


                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">

                            <div class="header-action-icon-2">
                                @livewire('cart-icon-component')
                            </div>
                            <div class="header-action-icon-2 d-block d-lg-none">
                                <div class="burger-icon burger-icon-white">
                                    <span class="burger-icon-top"></span>
                                    <span class="burger-icon-mid"></span>
                                    <span class="burger-icon-bottom"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="index.html"><img src="/assets/imgs/logo/logo2.png" alt="logo"></a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>

            <!-- mobile menu start -->
            <div class="mobile-header-content-area">
                @livewire('header-search-component')
                <div class="mobile-menu-wrap mobile-header-border">
                    <nav>
                        <ul class="mobile-menu">
                            <li class="menu-item-has-children"><span class="menu-expand"></span><a href="/">Home</a></li>
                            <li class="menu-item-has-children"><span class="menu-expand"></span><a href="{{route('shop')}}">Shop</a></li>
                            <li class="menu-item-has-children"><span class="menu-expand"></span><a href="{{route('about')}}">About</a></li>
                            <li class="menu-item-has-children"><span class="menu-expand"></span><a href="{{route('contact')}}">Contact</a></li>
                            @auth
                                @if(Auth::user()->user_type == "A")
                                <li class="menu-item-has-children"><span class="menu-expand"></span><a>My Account</a>
                                    <ul class="dropdown">
                                        <li><a href="{{route('admin.dashboard')}}">Info Accounts</a></li>
                                        <li><a href="{{route('admin.order')}}">Manage Orders</a></li>
                                        <li><a href="{{route('admin.colors')}}">Manage Base Colors Tshirts</a></li>
                                        <li><a href="{{route('admin.categories')}}">Manage Categories</a></li>
                                        <li><a href="{{route('admin.images')}}">Manage Images</a></li>
                                        <li><a href="{{route('admin.prices')}}">Change Prices Company</a></li>
                                        <li><a href="{{route('admin.statistics')}}">Statistics</a></li>
                                    </ul>
                                </li>

                                @elseif(Auth::user()->user_type == "E")

                                    <li class="menu-item-has-children"><span class="menu-expand"></span><a>My Account</a>
                                        <ul class="dropdown">
                                            <li><a href="{{route('employee.dashboard')}}">Manage Orders</a>
                                            <li><a href="{{route('employee.change.password')}}">Change Password</a></li>
                                        </ul>
                                    </li>

                                @elseif(Auth::user()->user_type == "C")
                                <li><a href="{{route('custom.product')}}">Custom Tshirt</a>
                                <li class="menu-item-has-children"><span class="menu-expand"></span><a>My Account</a>
                                    <ul class="dropdown">
                                        <li><a href="{{route('user.dashboard')}}">Dashboard</a></li>
                                        <li><a href="{{route('profile.edit')}}">Account Details</a></li>
                                        <li><a href="{{route('user.custom.tshirts')}}">My Custom Tshirts</a></li>
                                    </ul>
                                </li>
                                @endif
                            @endauth
                        </ul>
                    </nav>
                </div>

                <div class="mobile-header-info-wrap mobile-header-border">
                    <div class="single-mobile-header-info">
                        @auth
                            <a>{{Auth::user()->name}}</a>
                        </div>
                        <div class="single-mobile-header-info">
                            <form method="POST" action="{{route('logout')}}">
                            @csrf
                                <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();">Log Out </a>
                            </form>
                        </div>

                        @else
                        <a href="{{route('login')}}">Log In </a>
                        </div>
                        <div class="single-mobile-header-info">
                            <a href="{{route('register')}}">Sign Up</a>
                        </div>
                        @endauth

                </div>
            </div>
            <!-- mobile menu end -->

        </div>
    </div>

    {{$slot}}

    <footer class="main">
        <section class="newsletter p-10  wow fadeIn animated">

        </section>
        <section class="section-padding footer-mid">
            <div class="container pt-15 pb-20">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="widget-about font-md mb-md-5 mb-lg-0">
                            <div class="logo logo-width-1 wow fadeIn animated">
                                <a href="/"><img src="/assets/imgs/logo/logo2.png" alt="logo"></a>
                            </div>
                            <h5 class="mt-20 mb-10 fw-600 text-grey-4 wow fadeIn animated">Contact</h5>
                            <p class="wow fadeIn animated">
                                <strong>Address: </strong>Rua dos Santos 112 3º Esq. Leiria
                            </p>
                            <p class="wow fadeIn animated">
                                <strong>Phone: </strong>962 211 079
                            </p>
                            <p class="wow fadeIn animated">
                                <strong>Email: </strong>imagine@shirt.pt
                            </p>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 text-center">
                        <h5 class="widget-title wow fadeIn animated">About</h5>
                        <ul class="footer-list wow fadeIn animated mb-sm-5 mb-md-0">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Delivery Information</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms &amp; Conditions</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4 mob-center">
                            <div class="col-md-0 col-lg-0 mt-md-0 mt-lg-0 float-end">
                                <p class="mb-20 wow fadeIn animated">Secured Payment Gateways</p>
                                <img class="wow fadeIn animated" src="/assets/imgs/theme/payment-method.png" alt="">
                            </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="container pb-20 wow fadeIn animated mob-center">
            <div class="row">
                <div class="col-12 mb-20">
                    <div class="footer-bottom"></div>
                </div>
                <div class="col-lg-6">

                </div>
                <div class="col-lg-6">
                    <p class="text-lg-end text-start font-sm text-muted mb-0">
                        &copy; <strong class="text-brand">ImagineShirt</strong> All rights reserved
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Vendor JS-->
<script src="{{ asset('/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ asset('/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
<script src="{{ asset('/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/slick.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/wow.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/jquery-ui.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/magnific-popup.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/select2.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/waypoints.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/counterup.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/images-loaded.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/isotope.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/scrollup.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/jquery.vticker-min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/jquery.elevatezoom.js') }}"></script>


<!-- Template  JS -->
<script src="{{ asset('/assets/js/main.js?v=3.3') }}"></script>
<script src="{{ asset('/assets/js/shop.js?v=3.3') }}"></script>
    @vite('resources/js/app.js')
@livewireScripts
@stack('scripts')
</body>

</html>
