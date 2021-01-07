@extends('layout')


@section('js')
    <script src="{{asset('fontend/js_dev/cart_index.js')}}"></script>
@endsection
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="">Trang chủ</a></li>
                    <li class="active">Giỏ hàng của bạn</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Tên sản phẩm</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng tiền</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cart as $item)
                        <tr>
                            <td class="cart_product">
                                <img style="width: 50px;height: 50px;" src="{{$item->options->image}}" alt="">
                            </td>
                            <td class="cart_description">
                                <h4><a href="">{{$item->name}}</a></h4>
                                <p>Mã ID: {{$item->id}}</p>
                            </td>
                            <td class="cart_price">
                                <p>{{number_format($item->price)}}</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <a class="cart_quantity_up" href=""
                                       data-url="{{route('update.cart', ['rowId' => $item->rowId])}}"> + </a>
                                    <input class="cart_quantity_input" type="type" name="quantity"
                                           value="{{$item->qty}}"
                                           autocomplete="off" size="2">
                                    <a class="cart_quantity_down" href=""
                                       data-url="{{route('update.cart', ['rowId' => $item->rowId])}}"> - </a>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">{{number_format($item->price*$item->qty)}}</p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete"
                                   data-url="{{route('delete.cart',['rowId' => $item->rowId])}}" href=""><i
                                        class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->


    <section id="do_action">
        <div class="container">
            @if(count($cart) >0)
                <div class="row">
                    <div class="col-sm-6">
                        <div class="total_area">
                            <ul>
                                <li>Tổng <span id="subtotal">{{Cart::subtotal()}}</span></li>
                                <li>Thuế <span id="tax">{{Cart::tax()}}</span></li>
                                <li>Phí vận chuyển <span>0</span></li>
                                <li>Thành tiền <span id="total">{{Cart::total()}}</span></li>
                            </ul>
                            <a
                                class="btn btn-default check_out"
                                data-checklogin="{{route('user.statuslogin')}}"
                                data-login="{{route('user.login')}}"
                                data-checkout="{{route('checkout.index')}}"
                                href="">
                                Thanh toán
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="" style="text-align: center;">
                    <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/assets/50ae7a4bf7cca69985b40dfea02eddb3.png" alt="">
                    <p style="text-align: center; font-size: 30px;color: #0083C9;font-weight: bold;">Giỏ hàng rỗng</p>
                </div><!--/register-req-->
            @endif
        </div>
    </section><!--/#do_action-->

@endsection

