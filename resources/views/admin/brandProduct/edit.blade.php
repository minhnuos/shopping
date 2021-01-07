@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cật nhật thương hiệu sản phẩm
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
                        <form role="form" method="post" action="{{route('update.brand.product',['id' => $brand_product->id])}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label >Tên thương hiệu</label>
                                <input type="text" name="name" class="form-control" placeholder="Tên thương hiệu" value="{{$brand_product->name}}">
                            </div>
                            <div class="form-group">
                                <label >Mô tả thương hiệu</label>
                                <textarea style="resize: none" rows="5" class="form-control" name="desc" placeholder="Mô tả thương hiệu"> {{$brand_product->desc}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-info">Sửa thương hiệu</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
@endsection
