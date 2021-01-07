@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cật nhật danh mục sản phẩm
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
                        <form role="form" method="post" action="{{route('update.category.product',['id' => $category_product->id])}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label >Tên danh mục</label>
                                <input type="text" name="name" class="form-control" placeholder="Tên danh mục" value="{{$category_product->name}}">
                            </div>
                            <div class="form-group">
                                <label >Mô tả danh mục</label>
                                <textarea style="resize: none" rows="5" class="form-control" name="desc" placeholder="Mô tả danh mục"> {{$category_product->desc}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-info">Sửa danh mục</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
@endsection
