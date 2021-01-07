@extends('layout')


@section('js')
    <script src="{{asset('fontend/js_dev/checkout_index.js')}}"></script>
@endsection
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Trang chủ</a></li>
                    <li class="active">Thanh toán</li>
                </ol>
            </div><!--/breadcrums-->
            <div class="register-req">
                <p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
            </div><!--/register-req-->

            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="register-req">
                            <p>xem lại thông tin sản phẩm</p>
                        </div>
                        @if(count($cart) > 0)
                            <div class="table-responsive cart_info">
                                <table class="table table-condensed">
                                    <thead>
                                    <tr class="cart_menu">
                                        <td class="image">Hình ảnh</td>
                                        <td class="price">Giá</td>
                                        <td class="quantity">Số lượng</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cart as $item)
                                        <tr>
                                            <td class="cart_product">
                                                <img style="width: 50px;height: 50px;" src="{{$item->options->image}}"
                                                     alt="">
                                            </td>
                                            <td class="cart_price">
                                                <p>{{number_format($item->price)}}</p>
                                            </td>
                                            <td class="cart_quantity">
                                                <div class="cart_quantity_button">
                                                    <p>{{$item->qty}}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="check-coupon input-group-addon">
                                <input class="form-control" id="coupon-code" type="text" placeholder="nhập mã giảm giá">
                                <button class="btn btn-primary @if(empty($discountRate)) active @else unactive @endif"
                                        data-url="{{route('check.coupon.coupon')}}"
                                        id="check-coupon">Sử dụng
                                </button>
                                <button class="btn btn-primary @if(!empty($discountRate)) active @else unactive @endif"
                                        data-url="{{route('delete.coupon.coupon')}}"
                                        id="delete-coupon">Hủy mã giảm giá
                                </button>
                            </div>
                            <div class="total_area">
                                <ul>
                                    <li>Tổng <span id="subtotal">{{Cart::subtotal()}}</span></li>
                                    <li>Giảm giá
                                        <span id="tax">
                                            @if(!empty($discountRate))
                                                - {{number_format($discountRate)}}
                                            @else
                                                0
                                            @endif
                                        </span>
                                    </li>
                                    <li>Phí vận chuyển <span id="fee-ship">@if($ship > 0) + {{number_format($ship)}} @else 0 @endif </span></li>
                                    <li>Thành tiền <span
                                            id="total">{{number_format((int) str_replace(',', '',Cart::total()) - $discountRate + $ship)}}</span>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/assets/50ae7a4bf7cca69985b40dfea02eddb3.png" alt="">
                        @endif
                    </div>
                    <div class="col-sm-6 ">
                        <div class="bill-to">
                            <p>Làm ơn điền đầy đủ thông tin nếu đây là lần đầu tiên bạn mua hàng</p>

                            <div class="form-one">
                                <form>
                                    @csrf
                                    <input type="text" name="name" class="name" placeholder="Họ tên"
                                           value="@if($customer){{$customer->name}} @endif">
                                    <input type="text" name="email" class="email" placeholder="Email"
                                           value="@if($customer){{$customer->email}}@endif">
                                    <input type="text" name="address" class="address" placeholder="Địa chỉ chi tiết"
                                           value="@if($customer){{$customer->address}}@endif">
                                    <input type="text" name="phone" class="phone" placeholder="số điện thoại"
                                           value="@if($customer){{$customer->phone}}@endif">
                                    {{--                                    <div class="order-message">--}}
                                    {{--                                        <p>Ghi chú đơn hàng</p>--}}
                                    <textarea name="note" placeholder="ghi chú đơn hàng của bạn"
                                              rows="4" class="note"></textarea>
                                    {{--                                    </div>--}}

                                    <div class="form-group">
                                        <label>Tỉnh thành phố</label>
                                        <select name="province" data-url="{{route('get.delivery.feeship')}}"
                                                id="province" class="form-control input-sm m-bot15 choose">
                                            <option value="">--chọn tỉnh thành phố--</option>
                                            @foreach($provinces as $item)
                                                @if($customer)
                                                    @if($item->id == $customer->province_id)
                                                        <option selected value="{{$item->id}}">{{$item->name}}</option>
                                                    @else
                                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                                    @endif
                                                @else
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Quận huyện</label>
                                        <select name="district" data-url="{{route('get.delivery.feeship')}}"
                                                id="district" class="form-control input-sm m-bot15 choose">
                                            <option value="">--chọn quận huyện--</option>
                                            @if($customer)

                                                @if($province)
                                                    @foreach($province->districts as $item)

                                                        @if($customer->district_id == $item->id)
                                                            <option selected
                                                                    value="{{$item->id}}">{{$item->name}}</option>
                                                        @else
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Xã phường</label>
                                        <select name="sub_district" id="sub_district" data-url="{{route('get.delivery.feeship')}}"
                                                class="form-control input-sm m-bot15 choose">
                                            <option value="">--chọn xã phường--</option>
                                            @if($customer)
                                                @if($district)
                                                    @foreach($district->subDistricts as $item)

                                                        @if($customer->sub_district_id == $item->id)
                                                            <option selected
                                                                    value="{{$item->id}}">{{$item->name}}</option>
                                                        @else
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                    <div class="payment-options">
                                        @foreach($payment as $item)
                                            @if($item->id === 1)
                                                <div>
                                                    <label>
                                                        <input type="radio" class="payment" name="payment"
                                                               value="{{$item->id}}"
                                                               checked="checked"> {{$item->method}}
                                                    </label>
                                                </div>
                                            @else
                                                <div>
                                                    <label>
                                                        <input type="radio" class="payment" name="payment"
                                                               value="{{$item->id}}"
                                                        > {{$item->method}}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach

                                    </div>
                                    <a type="submit" class="btn btn-primary submit_checkout"
                                       data-url="{{route('checkout.store')}}"> Mua hàng</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <!--/#cart_items-->

@endsection
