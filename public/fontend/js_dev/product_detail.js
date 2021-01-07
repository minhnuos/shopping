$(document).ready(function(){
    var element = {
        buttonCart: $('.cart'),
        inputQuantity: $('#quantity'),
    }
    element.buttonCart.click(function () {
        let url = $(this).data('url');
        let product_id = $(this).data('product_id');
        Swal.fire({
            title: 'Bạn có muốn thêm sản phẩm vào giỏ hàng?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Có'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        quantity: element.inputQuantity.val(),
                        product_id: product_id
                    },
                    statusCode: {
                        200: function () {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Thêm giỏ hàng thành công',
                                showConfirmButton: false,
                                timer: 1000
                            })
                        },
                        500: function () {

                        },
                        400: function () {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Sản phẩm đã hết hàng',
                                showConfirmButton: false,
                                timer: 1000
                            })
                        }
                    }
                });
            }
        })

    });
});
