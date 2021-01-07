@extends('layout')
@section('js')
    <script src="{{asset('fontend/js_dev/product_detail.js')}}"></script>

@endsection
@section('content')
    <div class="product-details"><!--product-details-->
        <div class="col-sm-5">
            <div class="view-product">
                <img class="image_detail" src="{{$product->image}}" alt=""/>
                <h3>ZOOM</h3>
            </div>
            <div id="similar-product" class="carousel slide" data-ride="carousel">

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <a href=""><img src="{{asset('/fontend/images/product-details/similar1.jpg')}}" alt=""></a>
                        <a href=""><img src="{{asset('/fontend/images/product-details/similar2.jpg')}}" alt=""></a>
                        <a href=""><img src="{{asset('/fontend/images/product-details/similar3.jpg')}}" alt=""></a>
                    </div>
                    <div class="item">
                        <a href=""><img src="{{asset('/fontend/images/product-details/similar1.jpg')}}" alt=""></a>
                        <a href=""><img src="{{asset('/fontend/images/product-details/similar2.jpg')}}" alt=""></a>
                        <a href=""><img src="{{asset('/fontend/images/product-details/similar3.jpg')}}" alt=""></a>
                    </div>
                    <div class="item">
                        <a href=""><img src="{{asset('/fontend/images/product-details/similar1.jpg')}}" alt=""></a>
                        <a href=""><img src="{{asset('/fontend/images/product-details/similar2.jpg')}}" alt=""></a>
                        <a href=""><img src="{{asset('/fontend/images/product-details/similar3.jpg')}}" alt=""></a>
                    </div>

                </div>

                <!-- Controls -->
                <a class="left item-control" href="#similar-product" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right item-control" href="#similar-product" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>

        </div>
        <div class="col-sm-7">
            <div class="product-information"><!--/product-information-->
                <img src="{{asset('fontend/images/product-details/new.jpg')}}" class="newarrival" alt=""/>
                <h2>{{$product->name}}</h2>
                <p>Mã ID: {{$product->id}}</p>
{{--                <img src="{{asset('fontend/images/product-details/rating.png')}}" alt=""/>--}}
                <span>
									<span>{{number_format($product->price)}}</span>


                                @if($product->quantity == 0)
                        <marquee style="text-shadow: 2px 2px 2px;font-size: 30px;color: #FE980F;">Sản phẩm tạm hết hàng</marquee>
                                @else

									<input type="number" id="quantity" value="1" min="1"/>


                                <button data-url="{{route('add.cart')}}" data-product_id="{{$product->id}}" type="button"
                                class="btn btn-fefault cart">
										<i class="fa fa-shopping-cart"></i>
										Thêm giỏ hàng
                                </button>

                                @endif
                </span>

                <p><b>Tình trạng:</b> Còn <span style=" color: #FE980F; font-size: 20px;">{{$product->quantity}}</span> sản phẩm</p>
                <p><b>Điều kiện:</b> Mới 100%</p>
                <p><b>Thương hiệu:</b> {{$product->brand->name}}</p>
                <p><b>Danh mục:</b> {{$product->category->name}}</p>
                <a href=""><img src="{{asset('fontend/images/product-details/share.png')}}" class="share img-responsive"
                                alt=""/></a>
            </div><!--/product-information-->
        </div>
    </div><!--/product-details-->

    <div class="category-tab shop-details-tab"><!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#details" data-toggle="tab">Mô tả</a></li>
                <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>
                <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="details">
                <p>{!! $product->desc !!}</p>
            </div>

            <div class="tab-pane fade" id="companyprofile">
                <p>{!! $product->content !!}</p>
            </div>
            <div class="tab-pane fade " id="reviews">
                <div class="col-sm-12">
                    <ul>
                        <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                        <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                        <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                    </ul>
                    <p><b>Write Your Review</b></p>
                    <form action="#">
										<span>
											<input type="text" placeholder="Your Name"/>
											<input type="email" placeholder="Email Address"/>
										</span>
                        <textarea name=""></textarea>
                        <b>Rating: </b> <img src="{{asset('fontend/images/product-details/rating.png')}}" alt=""/>
                        <button type="button" class="btn btn-default pull-right">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div><!--/category-tab-->

    <div class="recommended_items"><!--recommended_items-->
        <h2 class="title text-center">Sản phẩm gợi ý</h2>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    @foreach($recommentProduct as $item)
                        <a href="{{route('detail.product',['slug' => $item->slug])}}">
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img class="image_recomment" src="{{$item->image}}" alt=""/>
                                            <h2>{{number_format($item->price)}}</h2>
                                            <p>{{$item->name}}</p>
                                            <a href="#" class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div><!--/recommended_items-->
@endsection
