$(document).ready(function () {
    var element = {
        submitCheckout: $('.submit_checkout'),
        name: $('.name'),
        email: $('.email'),
        address: $('.address'),
        phone: $('.phone'),
        checked: $('input:checked'),
        note: $('.note'),
        payment: $('.payment'),
        checkCoupon: $('#check-coupon'),
        deleteCoupon: $('#delete-coupon'),
        coupon: $('#tax'),
        total: $('#total'),
        inputCoupon: $('#coupon-code'),
        choose: $('.choose'),
        district: $('#district'),
        province: $('#province'),
        subDistrict: $('#sub_district'),
        feeShip : $('#fee-ship'),
    }
    // đặt hàng
    var value = {
        payment: element.checked.val()
    }

    element.payment.click(function () {
        payment = $(this).val();
    });

    element.submitCheckout.click(function (event) {
        event.preventDefault();
        url = $(this).data('url');
        Swal.fire({
            title: 'Bạn chắc chắn muốn mua hàng?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Có'
        }).then((result) => {
            if (result.isConfirmed) {
                if (value.payment &&
                    element.name.val() &&
                    element.email.val() &&
                    element.address.val() &&
                    element.phone.val() &&
                    element.note.val() &&
                    element.province.val() &&
                    element.district.val()
                ) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: {
                            payment: value.payment,
                            name: element.name.val(),
                            email: element.email.val(),
                            address: element.address.val(),
                            phone: element.phone.val(),
                            note: element.note.val(),
                            province_id: element.province.val(),
                            district_id: element.district.val(),
                            sub_district_id: element.subDistrict.val(),

                        },
                        statusCode: {
                            200: function (data) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Mua hàng thàng công',
                                    showConfirmButton: false,
                                    timer: 1000
                                })
                            },
                            409: function (data) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: 'Giỏ hàng đang trống!',
                                    showConfirmButton: false,
                                    timer: 1000
                                })
                            },
                            500: function () {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Mua hàng thất bại',
                                    showConfirmButton: false,
                                    timer: 1000
                                })
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Vui lòng điền đẩy đủ thông tin',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }

            }
        })
    });


    // check mã giảm giá
    var updateTotal = (coupon, total) => {
        element.coupon.text(coupon);
        element.total.text(total);
    }
    var updateFeeShipAndTotal = (feeship, total) => {
        element.feeShip.text(feeship);
        element.total.text(total);
    }
    element.checkCoupon.click(function () {
        console.log(1);
        couponCode = $(this).prev().val();
        url = $(this).data('url');
        if (couponCode == '') {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Vui lòng nhập mã giảm giá để sử dụng',
                showConfirmButton: false,
                timer: 1000
            })
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                data: {
                    codeCoupon: couponCode
                },
                url: url,
                statusCode: {
                    200: function (data) {
                        updateTotal(data.discountRate, data.total);
                        element.checkCoupon.addClass('unactive');
                        element.checkCoupon.removeClass('active');
                        element.deleteCoupon.addClass('active');
                        element.deleteCoupon.removeClass('unactive');
                    },
                    500: function () {

                    },
                    408: function () {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: 'mã giảm giá hết hạn sử dụng',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    409: function () {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'mã giảm giá không tồn tại',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            });
        }
    })
    element.deleteCoupon.click(function () {
        var url = $(this).data('url');
        Swal.fire({
            title: 'bạn có chắc chắc muốn hủy mã giảm giá?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'get',
                    statusCode: {
                        200: function (data) {
                            updateTotal(data.discountRate, data.total);
                            element.checkCoupon.removeClass('unactive');
                            element.checkCoupon.addClass('active');
                            element.deleteCoupon.addClass('unactive');
                            element.deleteCoupon.removeClass('active');
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Hủy thành công',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        },
                        500: function () {

                        }
                    }
                })

            }
        })
    })


    // lấy ra địa chỉ
    element.choose.on('change', function () {
        var action = $(this).attr('id');
        var id = $(this).val();
        var url = $(this).data('url');
        var province = element.province.val();
        var district = element.district.val();
        var subDistrict = element.subDistrict.val();
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
                id: id,
                province_id : province,
                district_id : district,
                subDistrict_id : subDistrict,
            },
            statusCode: {
                200: function (data) {
                    if (action == 'province') {
                        element.district.html(data.html);
                    } else if (action == 'district') {
                        element.subDistrict.html(data.html);
                    }
                    if(data.fee_ship == 0) {
                        updateFeeShipAndTotal('Free',data.total);
                    } else {
                        updateFeeShipAndTotal(` + ${data.fee_ship}`,data.total);
                    }
                },
                500: function () {

                }
            }
        })


    });
});






