@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cật nhật sản phẩm
                </header>
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if($message) {
                    echo '<span class="alert-error"> '. $message . '</span>';
                    \Illuminate\Support\Facades\Session::forget('message');
                }
                ?>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="post" action="{{route('update.product',['id' => $product->id])}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label >Tên sản phẩm</label>
                                <input type="text" name="name" class="form-control" placeholder="Tên sản phẩm" value="{{$product->name}}">
                            </div>
                            <div class="form-group">
                                <label>Giá sản phẩm</label>
                                <input type="text" name="price" class="form-control" placeholder="Tên sản phẩm"
                                       value="{{$product->price}}">
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh sản phẩm</label>
                                <input type="file" name="image" class="form-control" placeholder="Tên sản phẩm">
                                <img src="{{$product->image}}" alt="none"  style="width: 100px; height: 100px;">

                            </div>
                            <div class="form-group">
                                <label >Mô tả sản phẩm</label>
                                <textarea style="resize: none" rows="5" class="form-control" name="desc" placeholder="Mô tả thương hiệu"> {{$product->desc}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Nội dung sản phẩm</label>
                                <textarea style="resize: none" rows="5" class="form-control" name="contents"
                                          placeholder="Mô tả thương hiệu"> {{$product->desc}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Danh mục sản phẩm</label>
                                <select name="category_id" class="form-control input-sm m-bot15">
                                    @foreach($categoryProducts as $item)
                                        @if($product->category->id == $item->id)
                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                        @else
                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Thương hiệu</label>
                                <select name="brand_id" class="form-control input-sm m-bot15">
                                    @foreach($brandProducts as $item)
                                        @if($product->brand->id == $item->id)
                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                        @else
                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Sửa sản phẩm</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
@endsection
