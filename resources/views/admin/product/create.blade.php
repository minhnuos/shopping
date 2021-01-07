@extends('admin_layout')



@section('js')
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
        CKEDITOR.replace('editor1', options);
        CKEDITOR.replace('editor2', options);
    </script>
@endsection

@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm sản phẩm
                </header>
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if ($message) {
                    echo '<span class="alert-error"> ' . $message . '</span>';
                    \Illuminate\Support\Facades\Session::forget('message');
                }
                ?>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="post" action="{{route('store.product')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input type="text" name="name" class="form-control" placeholder="Tên sản phẩm">
                            </div>
                            <div class="form-group">
                                <label>Giá sản phẩm</label>
                                <input type="text" name="price" class="form-control" placeholder="Giá sản phẩm">
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh sản phẩm</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Mô tả sản phẩm</label>
                                <textarea id="editor2" style="resize: none" rows="5" class="form-control" name="desc"
                                          placeholder="Mô tả sản phẩm"> </textarea>
                            </div>
                            <div class="form-group">
                                <label>Nội dung sản phẩm</label>
                                <textarea id="editor1" style="resize: none" rows="5" class="form-control" name="contents"
                                          placeholder="Nội dung sản phẩm"> </textarea>
                            </div>
                            <div class="form-group">
                                <label>Hiển thị</label>
                                <select name="status" class="form-control input-sm m-bot15">
                                    <option value="1">Hiện</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Danh mục sản phẩm</label>
                                <select name="category_id" class="form-control input-sm m-bot15">
                                    @foreach($categoryProducts as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Thương hiệu</label>
                                <select name="brand_id" class="form-control input-sm m-bot15">
                                    @foreach($brandProducts as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Thêm sản phẩm</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
@endsection
