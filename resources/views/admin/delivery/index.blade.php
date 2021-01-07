@extends('admin_layout')


@section('js')
    <script src="{{asset('fontend/js_dev/delivery_index.js')}}"></script>
@endsection
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm phí vận chuyển theo khu vực
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="post" action="{{route('store.category.product')}}">
                            @csrf
                            <div class="form-group">
                                <label>Tỉnh thành phố</label>
                                <select name="province" data-url="{{route('get.delivery.delivery')}}" id="province" class="form-control input-sm m-bot15 choose">
                                    <option value="">--chọn tỉnh thành phố--</option>
                                    @foreach($provinces as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Quận huyện</label>
                                <select name="district" data-url="{{route('get.delivery.delivery')}}" id="district" class="form-control input-sm m-bot15 choose">
                                    <option value="">--chọn quận huyện--</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Xã phường</label>
                                <select name="sub_district" id="sub_district" class="form-control input-sm m-bot15 choose">
                                    <option value="">--chọn xã phường--</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Phí vận chuyển</label>
                                <input type="text" id="fee-ship" placeholder="phí vận chuyển" name="fee_ship" class="form-control">
                            </div>
                            <button type="button" class="btn btn-info" data-select="{{route('select.delivery')}}" data-url="{{route('store.delivery')}}" id="add-delivery">Thêm phí vận chuyển</button>
                        </form>
                    </div>

                </div>
                <div id="select-delivery">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Tên Thành phố</th>
                                <th>Tên quận huyện</th>
                                <th>Tên xã phường</th>
                                <th>Phí ship</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($feeShips as $item)
                                    <tr>
                                        <th>{{$item->proivince->name}}</th>
                                        <th>{{$item->district->name}}</th>
                                        <th>
                                            @if($item->subDistrict)
                                                {{$item->subDistrict->name}}
                                            @else
                                                null
                                                @endif
                                        </th>
                                        <th>{{number_format($item->feeship)}}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-agile-info">
                        <div class="panel panel-default">
                            <footer class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-7 text-right text-center-xs">
                                        {{$feeShips->links()}}
                                    </div>
                                </div>
                            </footer>
                        </div>
                    </div>
                </div>
            </section>

        </div>

    </div>
@endsection
