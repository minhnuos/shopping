@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin khách hàng
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$order->customer->name}}</td>
                        <td>{{$order->customer->phone}}</td>
                        <td>{{$order->customer->address}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-7 text-right text-center-xs">

                    </div>
                </div>
            </footer>
        </div>
    </div>
    <br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin vận chuyển
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Tên người vận chuyển</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($order->shipping))
                        <tr>
                            <td>{{$order->shipping->name}}</td>
                            <td>{{$order->shipping->phone}}</td>
                            <td>{{$order->shipping->address}}</td>
                        </tr>
                    @else
                        <tr>
                            <td></td>
                            <td><h2>Chưa có người vận chuyển</h2></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><h3>chọn người ship hàng</h3></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <form action="{{route('choose.shipping.shipping')}}" method="post" >
                                    @csrf
                                    <div class="form-group">
                                        <select name="shipping_id" id="" class="form-control">
                                            @foreach($shipping as $item)
                                                <option value="{{$item->id}}" >{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" name="order_id" value="{{$order->id}}" class="btn btn-primary"> Chọn </button>
                                </form>
                            </td>
                            <td></td>
                        </tr>

                    @endif
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-7 text-right text-center-xs">

                    </div>
                </div>
            </footer>
        </div>
    </div>
    <br><br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Chi tiết sản phẩm đơn hàng
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng tiền</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orderDetail as $item)
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>
                            <td>{{$item->product->name}}</td>
                            <td><img src="{{$item->product->image}}" alt="" style="width: 50px; height: 50px"></td>
                            <td>{{$item->quantity}}</td>
                            <td>{{number_format($item->product->price)}}</td>
                            <td>{{number_format($item->product->price*$item->quantity)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-7 text-right text-center-xs">

                    </div>
                </div>
            </footer>
        </div>
    </div>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-12 text-left text-center-xs" style="float: right;text-align: right;" >
                        <table style="float: right !important;width: 300px;">
                            <tr>
                                <td>Phí vận chuyển</td>
                                <td>:</td>
                                <td>+ {{number_format($order->fee_ship)}}</td>
                            </tr> <tr>
                                <td>Giảm giá</td>
                                <td>:</td>
                                <td>@if($discount == 0) 0 @else - {{number_format($discount)}} @endif</td>
                            </tr>
                            <tr>
                                <td>Thành tiền </td>
                                <td>:</td>
                                <td>{{number_format((int) str_replace(',','',$order->total) + $order->fee_ship -$discount)  }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-12 text-center">
                        <a href="{{route('order.print.bill',['order_id' => $order->id])}}" style="width: 200px;" target="_blank" class="btn btn-compose">Xuất hóa đơn</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
