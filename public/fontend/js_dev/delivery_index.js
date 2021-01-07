$(document).ready(function () {
    var element = {
        choose : $('.choose'),
        district: $('#district'),
        province: $('#province'),
        subDistrict: $('#sub_district'),
        addDelivery : $('#add-delivery'),
        feeShip : $('#fee-ship'),
        selectDelivery: $('#select-delivery'),
    }
    element.choose.on('change', function () {
        var action = $(this).attr('id');
        var id = $(this).val();
        var url = $(this).data('url');
        if(action == 'province' || action == 'district') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    action: action,
                    id: id
                },
                statusCode: {
                   200: function (data) {
                       if(action == 'province') {
                           element.district.html(data.html);
                       } else {
                           element.subDistrict.html(data.html);
                       }
                   },
                   500: function () {

                   }
                }
            })
        }

    });
    var selectDelivery = () => {
        $.ajax({
            url: element.addDelivery.data('select'),
            type: 'get',
            statusCode: {
                200: function (data) {
                    element.selectDelivery.html(data.data);
                }
            }
        });
    }

    element.addDelivery.click( function () {
        var url = $(this).data('url');
        if(element.province.val()  && element.district.val() && element.feeShip.val()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    province_id: element.province.val(),
                    district_id: element.district.val(),
                    subDistrict_id: element.subDistrict.val(),
                    feeShip: element.feeShip.val()
                },
                statusCode: {
                    200: function (data) {
                        selectDelivery();
                    },
                    500: function () {

                    }
                }
            });
        } else {
            alert('vui lòng nhập thêm thông tin');
        }
    });
});
