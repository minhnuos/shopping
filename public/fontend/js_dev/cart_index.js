$(document).ready(function(){
    var element = {
        cartDelete: $('.cart_quantity_delete'),
        cartTotal: $('#total'),
        cartTax: $('#tax'),
        cartSubTotal: $('#subtotal'),
        cartQuantityUp : $('.cart_quantity_up'),
        cartQuantityDown : $('.cart_quantity_down'),
        checkOut: $('.check_out'),
    }
    var updateCartTotal = (total, tax, subtotal) => {
        element.cartTotal.text(total);
        element.cartTax.text(tax);
        element.cartSubTotal.text(subtotal);
    }
    var callAjaxUpdateCart = (url,qty, elementTotal,elementQty) => {
        $.ajax({
            type: 'get',
            url: url,
            data: {
                qty: qty,
            },
            statusCode: {
                200: function (data) {
                    updateCartTotal(data.total,data.tax,data.subtotal);
                    elementTotal.text(data.totalCartItem);
                    elementQty.val(qty);
                },
                500: function () {

                },
                400: function (data) {
                    let message = 'Số lượng hàng trong kho chỉ còn ' + --qty + ' sản phẩm';
                    console.log(message);
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: message,
                        showConfirmButton: false,
                        timer: 1000
                    })
                }

            }
        });

    }
    element.cartDelete.click(function (event) {
        event.preventDefault();
        var url = $(this).data('url');
        var that = $(this);
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa sản phẩm khỏi giỏ hàng?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Có'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'get',
                    url: url,
                    statusCode: {
                        200: function (data) {
                            that.parent().parent().remove();
                            updateCartTotal(data.total,data.tax,data.subtotal);
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Xóa thành công',
                                showConfirmButton: false,
                                timer: 1000
                            })
                        },
                        500: function () {

                        }
                    }
                });
            }
        })
    });
    element.cartQuantityUp.click(function (event) {
        event.preventDefault();
        var url = $(this).data('url');
        var elementQty = $(this).next();
        var qty = Number(elementQty.val()) + 1;
        var elementTotal = $(this).parent().parent().next().children(0);
        callAjaxUpdateCart(url,qty,elementTotal,elementQty);

    });
    element.cartQuantityDown.click(function (event) {
        event.preventDefault();
        var url = $(this).data('url');
        var elementQty = $(this).prev();
        var qty = Number(elementQty.val()) - 1;
        var elementTotal = $(this).parent().parent().next().children(0);
        qty >= 1 ?
            callAjaxUpdateCart(url,qty,elementTotal,elementQty) :
            Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'sản phẩm đã ở mức tối thiểu',
            showConfirmButton: false,
            timer: 1000
        });
    });
    element.checkOut.click(function (event) {
        event.preventDefault()
        var urlChecklogin = $(this).data('checklogin');
        var urlLogin = $(this).data('login');
        var urlchechout = $(this).data('checkout');
        $.ajax({
            type: 'get',
            url: urlChecklogin,
            statusCode: {
                200: function (data) {
                    if(!data.status) {
                        location.replace(urlLogin);
                    } else {
                        location.replace(urlchechout);
                    }
                }
            }
        });
    });
});
