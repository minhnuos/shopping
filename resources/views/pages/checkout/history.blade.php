@extends('layout')

@section('css')
    <link href="{{asset('fontend/css/history.css')}}" rel="stylesheet">
@endsection
@section('js')
    <script src="{{asset('fontend/js_dev/cart_index.js')}}"></script>
    <script>
        function openPage(pageName,elmnt) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "";
            }
            document.getElementById(pageName).style.display = "block";
            elmnt.style.backgroundColor = '#A4A4A4';
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>
@endsection
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="">Trang chủ</a></li>
                    <li class="active">Lịch sử mua hàng</li>
                </ol>
            </div>
        </div>
    </section> <!--/#cart_items-->
    <div class="history">
        <button class="tablink" onclick="openPage('Home', this)" id="defaultOpen">Chờ xác nhận</button>
        <button class="tablink" onclick="openPage('News', this)" >Đang giao</button>
        <button class="tablink" onclick="openPage('Contact', this)" >Giao thành công</button>
        <button class="tablink" onclick="openPage('About', this)">Đã hủy</button>
    </div>

    <section class="content-history">
        <div id="Home" class="tabcontent">
           <ul>
               @foreach($orders as $item)
                   @foreach($item as $order)
                       @if($order->status == 0)
                           <li class="item-history">
                               <p>Thời gian đặt hàng : {{date('H:i:s d-m-Y',strtotime($order->created_at))}} </p>
                               <hr/>
                                <div>
                                    <table>
                                        @foreach($order->orderDetail as $orderDetail)
                                            <tr>
                                                <td><img style="width: 75px;height: 75px;" src="{{$orderDetail->product->image}}" alt=""></td>
                                                <td> {{$orderDetail->product->name}} <br> x {{$orderDetail->quantity}} </td>
                                                <td>{{number_format($orderDetail->product->price)}} vnđ</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="info-option-history">

                                    <p>Giảm giá : @if($order->valueCoupon() == 0)
                                            0
                                        @else
                                            - {{number_format($order->valueCoupon())}}
                                        @endif vnđ</p>
                                    <p>Phí vận chuyển : + {{number_format($order->fee_ship)}} vnđ</p>
                                    <p>Thành tiền: {{number_format((int)str_replace(',', '', $order->total) + $order->fee_ship - $order->valueCoupon())}} vnđ</p>
                                    <button class="btn btn-info">Hủy đơn hàng</button>
                                </div>
                           </li>
                           <hr/>
                       @endif

                    @endforeach
               @endforeach
           </ul>
        </div>

        <div id="News" class="tabcontent">
            <ul>
                @foreach($orders as $item)
                    @foreach($item as $order)
                        @if($order->status == 1)
                            <li class="item-history">
                                <p>Thời gian đặt hàng : {{date('H:i:s d-m-Y',strtotime($order->created_at))}} </p>
                                <hr/>
                                <div>
                                    <table>
                                        @foreach($order->orderDetail as $orderDetail)
                                            <tr>
                                                <td><img style="width: 75px;height: 75px;" src="{{$orderDetail->product->image}}" alt=""></td>
                                                <td> {{$orderDetail->product->name}} <br> x {{$orderDetail->quantity}} </td>
                                                <td>{{number_format($orderDetail->product->price)}} vnđ</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="info-option-history">

                                    <p>Giảm giá : @if($order->valueCoupon() == 0)
                                            0
                                        @else
                                            - {{number_format($order->valueCoupon())}}
                                        @endif vnđ</p>
                                    <p>Phí vận chuyển : + {{number_format($order->fee_ship)}} vnđ</p>
                                    <p>Thành tiền: {{number_format((int)str_replace(',', '', $order->total) + $order->fee_ship - $order->valueCoupon())}} vnđ</p>

                                </div>
                            </li>
                            <hr/>
                        @endif

                    @endforeach
                @endforeach
            </ul>
        </div>

        <div id="Contact" class="tabcontent">
            <ul>
                @foreach($orders as $item)
                    @foreach($item as $order)
                        @if($order->status == 2)
                            <li class="item-history">
                                <p>Thời gian đặt hàng : {{date('H:i:s d-m-Y',strtotime($order->created_at))}} </p>
                                <hr/>
                                <div>
                                    <table>
                                        @foreach($order->orderDetail as $orderDetail)
                                            <tr>
                                                <td><img style="width: 75px;height: 75px;" src="{{$orderDetail->product->image}}" alt=""></td>
                                                <td> {{$orderDetail->product->name}} <br> x {{$orderDetail->quantity}} </td>
                                                <td>{{number_format($orderDetail->product->price)}} vnđ</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="info-option-history">

                                    <p>Giảm giá : @if($order->valueCoupon() == 0)
                                            0
                                        @else
                                            - {{number_format($order->valueCoupon())}}
                                        @endif vnđ</p>
                                    <p>Phí vận chuyển : + {{number_format($order->fee_ship)}} vnđ</p>
                                    <p>Thành tiền: {{number_format((int)str_replace(',', '', $order->total) + $order->fee_ship - $order->valueCoupon())}} vnđ</p>

                                </div>
                            </li>
                            <hr/>
                        @endif

                    @endforeach
                @endforeach
            </ul>
        </div>
        <div id="About" class="tabcontent">
            <ul>
                @foreach($orders as $item)
                    @foreach($item as $order)
                        @if($order->status == 3)
                            <li class="item-history">
                                <p>Thời gian đặt hàng : {{date('H:i:s d-m-Y',strtotime($order->created_at))}} </p>
                                <hr/>
                                <div>
                                    <table>
                                        @foreach($order->orderDetail as $orderDetail)
                                            <tr>
                                                <td><img style="width: 75px;height: 75px;" src="{{$orderDetail->product->image}}" alt=""></td>
                                                <td> {{$orderDetail->product->name}} <br> x {{$orderDetail->quantity}} </td>
                                                <td>{{number_format($orderDetail->product->price)}} vnđ</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="info-option-history">

                                    <p>Giảm giá : @if($order->valueCoupon() == 0)
                                            0
                                        @else
                                            - {{number_format($order->valueCoupon())}}
                                        @endif vnđ</p>
                                    <p>Phí vận chuyển : + {{number_format($order->fee_ship)}} vnđ</p>
                                    <p>Thành tiền: {{number_format((int)str_replace(',', '', $order->total) + $order->fee_ship - $order->valueCoupon())}} vnđ</p>

                                </div>
                            </li>
                            <hr/>
                        @endif

                    @endforeach
                @endforeach
            </ul>
        </div>
    </section>


@endsection

