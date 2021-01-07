@extends('admin_layout')



@section('js')
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>

        CKEDITOR.replace('editor1');
    </script>
@endsection

@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm Slider
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="post" action="{{route('store.slider')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên slider</label>
                                <input type="text" name="name" class="form-control" placeholder="Tên slider">
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh sản phẩm</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Mô tả sản phẩm</label>
                                <textarea id="editor1" style="resize: none" rows="5" class="form-control" name="desc"
                                          placeholder="Mô tả sản phẩm"> </textarea>
                            </div>
                            <div class="form-group">
                                <label>Hiển thị</label>
                                <select name="status" class="form-control input-sm m-bot15">
                                    <option value="1">Hiện</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Thêm Slider</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
@endsection
