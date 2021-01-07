@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê sản phẩm
            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message) {
                echo '<span class="alert-error"> '. $message . '</span>';
                \Illuminate\Support\Facades\Session::forget('message');
            }
            ?>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
                    </div>
                </div>
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
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Hình ảnh</th>
                        <th>Danh mục</th>
                        <th>Thương hiệu</th>
                        <th>Hiển thị</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $item)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->price}}</td>
                            <th>{{$item->quantity}}</th>
                            <td><img src="{{$item->image}}" alt="none" style="width: 50px; height: 50px;"></td>
                            <td>{{$item->category->name}}</td>
                            <td>{{$item->brand->name}}</td>
                            <td><span class="text-ellipsis">
                                    @if($item->status == 0)
                                        <a href="{{route('unactive.product',['id' => $item->id])}}" ><span class="fa-thumbs-up fa fa-thumbs-styling"></span></a>
                                    @else
                                        <a href="{{route('active.product',['id' => $item->id])}}"><span class="fa-thumbs-down fa fa-thumbs-styling"></span></a>
                                    @endif
                                </span></td>
                            <td>
                                <a href="{{route('edit.product',['id' => $item->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <a onclick="return confirm('bạn có chắc muốn xóa?')" href="{{route('delete.product',['id' => $item->id])}}" class="active" ui-toggle-class="">
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
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                           {{$products->links()}}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
