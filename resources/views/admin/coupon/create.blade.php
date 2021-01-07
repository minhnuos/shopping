@extends('admin_layout')

@section('js')

@endsection
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm mã giảm giá
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="post" action="{{route('store.coupon')}}">
                            @csrf
                            <div class="form-group">
                                <label >Tên mã giảm giá</label>
                                <input type="text" name="name" class="form-control" placeholder="Tên mã giảm giá">
                            </div>
                            <div class="form-group">
                                <label>Mã giảm giá</label>
                                <input type="text" name="code" class="form-control" placeholder="Tên thương hiệu">
                            </div>
                            <div class="form-group">
                                <label>Số lượng</label>
                                <input type="text" name="qty" class="form-control" placeholder="Tên thương hiệu">
                            </div>
                            <div class="form-group">
                                <label>lượng giảm giá</label>
                                <input type="text" name="number" class="form-control" placeholder="Tên thương hiệu">
                            </div>
                            <div class="form-group">
                                <label>Thời gian hết hạn</label>
                                <input type="text" name="time" class="form-control" placeholder="Tên thương hiệu">
                            </div>

                            <div class="form-group">
                                <label >Hình thức giảm giá</label>
                                <select name="addition" class="form-control input-sm m-bot15">
                                    <option value="1">giảm theo phầm trăm</option>
                                    <option value="2">Giảm theo tiền</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Thêm mã giảm giá</button>
                        </form>
                    </div>

                </div>
            </section>
        </div>
@endsection
