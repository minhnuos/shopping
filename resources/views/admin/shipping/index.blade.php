@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thêm người vận chuyển
            </div>
            <div class="row w3-res-tb">
                <form action="{{route('store.shipping')}}" method="post">
                    @csrf
                    <div class="form-group col-md-4">
                        <label>Tên người vận chuyển</label>
                        <input type="text" name="name" class="form-control" placeholder="Nhập tên người vận chuyển">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="form-group col-md-5">
                        <label>Địa chỉ</label>
                        <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ">
                    </div>
                    <div class="form-group col-md-12 ">
                        <input type="submit" class="btn btn-primary" value="Thêm">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê Shipping
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
                        <th>Tên người vận chuyển</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($shipping as $item)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                            </td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->address}}</td>
                            <td>
                                <a href="{{route('detail.order',['id' => $item->id])}}" class="active"
                                   ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <a onclick="return confirm('bạn có chắc muốn xóa?')" href="" class="active"
                                   ui-toggle-class="">
                                    <i class="fa fa-times text-danger text"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">


                    <div class="col-sm-7 text-right text-center-xs">
                        {{$shipping->links()}}
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
