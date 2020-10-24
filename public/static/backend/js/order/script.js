$('.ss--select2').select2();
function formatNumber(nStr) {
    //check for blank, use jquery trim for ie8 compat
    if ("" === $.trim(nStr)) {
        return 0;
    }

    // Check if it is a number
    if (!$.isNumeric(nStr)) {
        return nStr;
    }

    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function initCommas() {
    // Cache document for better performance
    var $document = $(document);

    $document.on('blur', '.comma-format', function() {
        // Format and place back into text
        $(this).val(formatNumber($(this).val()));
    });
}

$(function () {
    //this formats the number if it was typed in manually -- the spin code is in the modified bootstrap-touchspin script
    initCommas();
});

var orderItem = {
    sessionId : 0,
    _initModal : function(){
        $('.kt-money').mask('000,000,000,000', {reverse: true});
        $('.number-only').ForceNumericOnly();
        $('.kt_touchspin').TouchSpin({
            forcestepdivisibility: 'round',
            replacementval: 0,
            buttondown_class: 'btn btn-secondary',
            buttonup_class: 'btn btn-secondary',
            verticalbuttons: true,
            verticalup: '<i class="la la-angle-up"></i>',
            verticaldown: '<i class="la la-angle-down"></i>'
        });

        $('.--select2').select2();

        initCommas();
    },

    loadPopup : function (id = null) {
        var data = {
            id : id,
            sessionId : orderItem.sessionId
        };
        $.post(laroute.route('product.order.load-popup-create-order'), data, function(res){
            $('#form-create-order').html(res.data);
            $('#form-create-order').find('#create-order').modal();
            $('.ss--select2').select2();
        }, 'JSON')
    },

    loadProduct :function (id, obj) {
        $('.item-product').removeClass('active');
        $(obj).addClass('active');
        var data = {
            id : id,
            sessionId : orderItem.sessionId
        };
        $.post(laroute.route('product.order.load-product'), data, function(res){
            $('#list-product').html(res.data);
            orderItem._initModal();
            $('.ss--select2').select2();
        }, 'JSON')
    },

    addCart : function () {

        var data = $('#form-product').serializeArray();

        $.post(laroute.route('product.order.add-cart'), data, function(res){
            $('#create-order').modal('hide');
            swal.fire(res.message, "", "success").then(function () {
            });
            orderItem.loadCart();
        }, 'JSON');
    },

    deleteCart : function (key) {
        var data = {
            key : key,
            sessionId : orderItem.sessionId
        };
        swal.fire({
            title: "Bạn có muốn xóa đơn hàng?",
            buttonsStyling: false,
            showCloseButton: true,
            confirmButtonText: "Đồng ý",
            confirmButtonClass: "btn btn-sm btn-default btn-bold",
            showCancelButton: true,
            cancelButtonText: "Hủy",
            cancelButtonClass: "btn btn-sm btn-bold btn-brand"
        }).then(function (result) {
            if (result.value) {
                $.post(laroute.route('product.order.delete-cart'), data, function(res){
                    swal.fire(res.message, "", "success").then(function () {
                    });
                    orderItem.loadCart();
                }, 'JSON');
            }
        });
    },

    loadCart : function () {
        var data = {
            sessionId : orderItem.sessionId
        };
        data.sessionId = orderItem.sessionId;
        $.post(laroute.route('product.order.load-cart'), data, function(res){
            $('#load-cart').html(res.data);
            orderItem._initModal();
        }, 'JSON');
    },

    updateMonth : function (key, obj) {
        var data = {
            sessionId : orderItem.sessionId,
            key : key,
            month : $(obj).val()
        };
        $.post(laroute.route('product.order.update-month'), data, function(res){
            orderItem.loadCart();
            orderItem._initModal();
        }, 'JSON');
    },

    loadPromotion : function () {
        var data = {
            sessionId : orderItem.sessionId
        };
        $.post(laroute.route('product.order.load-promotion'), data, function(res){
            $('#popup-promotion').html(res.data);
            $('#popup-promotion').find('#kt_promotion').modal();
            orderItem._initModal();
        }, 'JSON');
    },

    changePromotion : function(obj){
        var type = $("input[name='cash_type']:checked").val();
        $('.value_type').hide();
        if(type == 'percent'){
            $('.value_percent').show();
        } else {
            $('.value_money').show();
        }
    },

    addPromotion : function () {
        $.validator.addMethod("validatePassword", function (value, element) {
            return this.optional(element) || /^(?=.*[a-zA-Z0-9])[a-zA-Z0-9?]*$/i.test(value);
        });
        $('#form-promotion').validate({
            rules: {
                voucher_code: {
                    maxlength: 25,
                    validatePassword: true,
                }
            },
            messages: {
                voucher_code: {
                    maxlength: 'Mã khuyến mãi tối đa 25 ký tự',
                    validatePassword: 'Mã khuyến mãi gồm chữ hoặc số'
                },
            },
        });

        if ($('#form-promotion').valid()){
            var data = $('#form-promotion').serializeArray();
            data.sessionId = orderItem.sessionId;
            $.post(laroute.route('product.order.add-promotion'), $('#form-promotion').serializeArray(), function(res){
                $('#kt_promotion').modal('hide');
                if(!res.error){
                    swal.fire(res.message, "", "success").then(function () {
                    });
                    orderItem.loadCart();
                } else {
                    swal.fire(res.message, "", "error").then(function () {
                        $('#voucher_code').val('');
                    });
                }

            }, 'JSON');
        }

    },

    doOrder : function (order_id = null) {
        swal.fire({
            title: order_id ? "Bạn có muốn cập nhật đơn hàng?" :"Bạn có muốn đặt hàng?",
            buttonsStyling: false,
            showCloseButton: true,
            type: "danger",
            confirmButtonText: "Đồng ý",
            confirmButtonClass: "btn btn-sm btn-bold btn-brand",
            showCancelButton: true,
            cancelButtonText: "Hủy",
            cancelButtonClass: "btn btn-sm btn-default btn-bold"
        }).then(function (result) {
            if (result.value) {
                var data = {
                    sessionId : orderItem.sessionId,
                    source : $('#source').val(),
                    customer_id : $('#customer_id').val(),
                    staff_id : $('#staff_id').val(),
                    order_id : order_id,
                    voucher_code : $('#voucher_code').val(),
                    order_status_id : $('#order_status_id').val(),
                    order_content : $('#order_content').val()
                };
                $.post(laroute.route('product.order.do-order'), data, function(res){
                    if(!res.error){
                        swal.fire(res.message, "", "success").then(function () {
                            window.location.href = laroute.route('product.order');
                        });
                    } else {
                        swal.fire(res.message, "", "error").then(function () {
                            $('#voucher_code').val('');
                        });
                    }

                }, 'JSON');
            }
        });
    }
};
jQuery.fn.ForceNumericOnly =
    function () {
        return this.each(function () {
            $(this).keydown(function (e) {
                var key = e.charCode || e.keyCode || 0;
                // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
                // home, end, period, and numpad decimal
                return (
                    key == 8 ||
                    key == 9 ||
                    key == 13 ||
                    key == 46 ||
                    key == 110 ||
                    key == 190 ||
                    (key >= 35 && key <= 40) ||
                    (key >= 48 && key <= 57) ||
                    (key >= 96 && key <= 105));
            });
        });
    };


