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
        CKEDITOR.replace('my-editor', options);
    </script>
@endsection
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm danh mục sản phẩm
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
                        <form role="form" method="post" action="{{route('store.category.product')}}">
                            @csrf
                            <div class="form-group">
                                <label >Tên danh mục</label>
                                <input type="text" name="name" class="form-control" placeholder="Tên danh mục">
                            </div>
                            <div class="form-group">
                                <label >Mô tả danh mục</label>
                                <textarea style="resize: none" rows="5" class="form-control" id="my-editor" name="desc" placeholder="Mô tả danh mục"> </textarea>
                            </div>
                            <div class="form-group">
                                <label >Hiển thị</label>
                                <select name="status" class="form-control input-sm m-bot15">
                                    <option value="1">Hiện</option>
                                    <option value="0">Ẩn</option>

                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Thêm danh mục</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
@endsection
