<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="token" content="{{ csrf_token() }}" id="token">
    <title>Home | E-Shopper</title>
    <link href="{{asset('fontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('fontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('fontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('fontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('fontend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('fontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('fontend/css/responsive.css')}}" rel="stylesheet">

    @yield('css')
<!--[if lt IE 9]>
    <script src="{{asset('fontend/js/html5shiv.js')}}"></script>
    <script src="{{asset('fontend/respond.min.js')}}"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{asset('fontend/images/ico/favicon.ico')}}">{{('')}}
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{asset('fontend/images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="{{asset('fontend/images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="{{asset('fontend/images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('fontend/images/ico/apple-touch-icon-57-precomposed.png')}}">
</head><!--/head-->

<body>
<header id="header"><!--header-->
{{--    <div class="header_top"><!--header_top-->--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-sm-6">--}}
{{--                    <div class="contactinfo">--}}
{{--                        <ul class="nav nav-pills">--}}
{{--                            <li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>--}}
{{--                            <li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6">--}}
{{--                    <div class="social-icons pull-right">--}}
{{--                        <ul class="nav navbar-nav">--}}
{{--                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>--}}
{{--                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>--}}
{{--                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>--}}
{{--                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>--}}
{{--                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div><!--/header_top-->--}}
    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="{{route('index')}}"><i class="fa fa-home"></i> Trang chủ</a></li>
                            <li><a href="#"><i class="fa fa-book"></i>Tin tức</a></li>
                            <li><a href="#"><i class="fa fa-phone-square"></i> Liên hệ</a></li>
                            <li><a href="#"><i class="fa fa-star"></i> Yêu thích</a></li>
                            <li><a href="{{route('checkout.index')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                            <li><a href="{{route('index.cart')}}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                            @if(Auth::check())
                                <li class="dropdown">
                                    <a href=""><i class="fa fa-user"></i> {{Auth::user()->name}}</a>
                                    <div class="dropdown-content" style="left:0;">
                                        <a href="#">Thông tin cá nhân</a>
                                        <a href="{{route('checkout.history')}}">Lịch sử mua hàng</a>
                                        <a href="{{route('user.logout')}}">Đăng xuất</a>
                                    </div>
                                </li>

                            @else
                                <li><a href="{{route('user.login')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div><!--/header-bottom-->
    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="logo pull-left">
                        <a href="{{route('index')}}"><img src="{{asset('fontend/images/home/logo.png')}}" alt=""/></a>
                    </div>
{{--                    <div class="btn-group pull-right">--}}
{{--                        <div class="btn-group">--}}
{{--                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">--}}
{{--                                USA--}}
{{--                                <span class="caret"></span>--}}
{{--                            </button>--}}
{{--                            --}}
{{--                        </div>--}}

{{--                        <div class="btn-group">--}}
{{--                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">--}}
{{--                                DOLLAR--}}
{{--                                <span class="caret"></span>--}}
{{--                            </button>--}}
{{--                            <ul class="dropdown-menu">--}}
{{--                                <li><a href="#">Canadian Dollar</a></li>--}}
{{--                                <li><a href="#">Pound</a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="col-sm-10">
                    <form class="form-search">
                        <input id="search" type="text" placeholder="Nhập tên sản phẩm"/>
                        <input id="submit" type="submit" value="Tìm kiếm" />
                    </form>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->


</header><!--/header-->

<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($sliders as $key => $item)
                            <li data-target="#slider-carousel" data-slide-to="{{$key}}" class="@if($key == 0) active @endif"></li>
                        @endforeach

                    </ol>

                    <div class="carousel-inner">
                        @foreach($sliders as $key => $item)
                        <div class="item @if($key == 0) active @endif">

                            <div class="col-sm-12">
                                <img src="{{$item->image}}" style="height: 300px;width: 100%;" class="girl img-responsive"
                                     alt=""/>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section><!--/slider-->

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Danh mục sản phẩm</h2>
                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                        @foreach($categoryProducts as $item)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="{{route('category.product',['slug' => $item->slug])}}">{{$item->name}}</a></h4>
                                </div>
                            </div>
                        @endforeach

                    </div><!--/category-products-->

                    <div class="brands_products"><!--brands_products-->
                        <h2>Thương hiệu sản phẩm</h2>
                        @foreach($brandProducts as $item)
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="{{route('brand.product',['slug' => $item->slug])}}"> <span class="pull-right">({{count($item->product)}})</span>{{$item->name}}</a></li>
                                </ul>
                            </div>
                        @endforeach

                    </div><!--/brands_products-->

                    <div class="price-range"><!--price-range-->
                        <h2>Tìm kiếm theo giá</h2>
                        <div class="well text-center">
                            <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600"
                                   data-slider-step="5" data-slider-value="[0,600]" id="sl2"><br/>
                            <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
                        </div>
                    </div><!--/price-range-->

                    <div class="shipping text-center"><!--shipping-->
                        <img src="{{asset('fontend/images/home/shipping.jpg')}}" alt=""/>
                    </div><!--/shipping-->

                </div>
            </div>

            <div class="col-sm-9 padding-right">
                @yield('content')

            </div>
        </div>
    </div>
</section>

<footer id="footer"><!--Footer-->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="companyinfo">
                        <h2><span>e</span>-shopper</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="{{asset('fontend/images/home/iframe1.png')}}" alt=""/>
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="{{asset('fontend/images/home/iframe2.png')}}" alt=""/>
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="{{asset('fontend/images/home/iframe3.png')}}" alt=""/>
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="{{asset('fontend/images/home/iframe4.png')}}" alt=""/>
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="address">
                        <img src="{{asset('fontend/images/home/map.png')}}" alt=""/>
                        <p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Service</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Online Help</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Change Location</a></li>
                            <li><a href="#">FAQ’s</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Quock Shop</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">T-Shirt</a></li>
                            <li><a href="#">Mens</a></li>
                            <li><a href="#">Womens</a></li>
                            <li><a href="#">Gift Cards</a></li>
                            <li><a href="#">Shoes</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Policies</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Terms of Use</a></li>
                            <li><a href="#">Privecy Policy</a></li>
                            <li><a href="#">Refund Policy</a></li>
                            <li><a href="#">Billing System</a></li>
                            <li><a href="#">Ticket System</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>About Shopper</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Company Information</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Store Location</a></li>
                            <li><a href="#">Affillate Program</a></li>
                            <li><a href="#">Copyright</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <h2>About Shopper</h2>
                        <form action="#" class="searchform">
                            <input type="text" placeholder="Your email address"/>
                            <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i>
                            </button>
                            <p>Get the most recent updates from <br/>our site and be updated your self...</p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
                <p class="pull-right">Designed by <span><a target="_blank"
                                                           href="http://www.themeum.com">Themeum</a></span></p>
            </div>
        </div>
    </div>

</footer><!--/Footer-->


<script src="{{asset('fontend/js/jquery.js')}}"></script>
<script src="{{asset('fontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('fontend/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{asset('fontend/js/price-range.js')}}"></script>
<script src="{{asset('fontend/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{asset('fontend/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@yield('js')
</body>
</html>
