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

    $document.on('blur', '.comma-format', function () {
        // Format and place back into text
        $(this).val(formatNumber($(this).val()));
    });
}

$(function () {
    //this formats the number if it was typed in manually -- the spin code is in the modified bootstrap-touchspin script
    initCommas();
});
var product_id = 0;
var attribute_result;
var service_detail;
var detail_attribute = [];
var orderAdjust = {
    init: function () {
        $('.--select2').select2();
        $('#customer_service_id').trigger('change');
        orderAdjust.loadInfoAfterAdjust();
    },
    _initModal: function () {
        $('.kt-money').mask('000,000,000,000', {reverse: true});

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
    getServices: function (t) {
        orderAdjust.reset();
        const customer_id = $(t).val();

        if (customer_id !== '') {
            $.ajax({
                url: laroute.route('ticket.get-list-service-by-customer'),
                method: 'POST',
                dataType: 'JSON',
                data: {
                    customer_id: customer_id
                },
                success: function (res) {
                    if (!res.error) {
                        $('#customer_service_id').empty();
                        $('#customer_service_id').append(`<option value="">----- Chọn dịch vụ -----</option>`);
                        if (!res.data) {
                            return;
                        }
                        res.data.forEach(item => {
                            if (item.type == 'real') {
                                $('#customer_service_id').append(`<option value="${item.customer_service_id}">${item.product_name_vi}</option>`)
                            }
                        })
                    }
                }
            });
        } else {
            $('#customer_service_id').empty()
            $('#customer_service_id').append(`<option value="">----- Chọn dịch vụ -----</option>`)
        }
    },
    getDetailService: function (t) {
        var customer_service_id = $(t).val();
        $.ajax({
            url: laroute.route('product.order.get-detail-service'),
            method: 'POST',
            dataType: 'JSON',
            data: {
                customer_service_id: customer_service_id
            },
            async: false,
            success: function (res) {
                if (!res.error) {
                    detail_attribute = res.detailAttribute;
                    product_id = res.serviceDetail.product_id;
                    orderAdjust.reset();
                    let tplInfoService = $('#tpl-info-service').html();
                    let content = '';

                    let detailAttribute = res.detailAttribute;
                    $.each(detailAttribute, function (key, value) {
                        let el = '';
                        el = value.product_attribute_name_vi + ' ' + value.value + ' ' + value.unit_name + '<br>';
                        content += el;
                    });

                    if (content != null && content != '') {
                        let type = res.serviceDetail.payment_type;
                        let payment_type = 'Dùng thử';
                        if (type == 'postpaid') {
                            payment_type = 'Thanh toán sau';
                        } else if (type == 'prepaid') {
                            payment_type = 'Thanh toán trước';
                        } else {
                            payment_type = 'Dùng nhiêu trả nhiêu';
                        }
                        tplInfoService = tplInfoService.replace(/{service_content}/g, content);
                        tplInfoService = tplInfoService.replace(/{payment_type}/g, payment_type);
                        tplInfoService = tplInfoService.replace(/{quantity}/g, res.serviceDetail.quantity + ' Tháng');
                        tplInfoService = tplInfoService.replace(/{price}/g, orderAdjust.formatMoney(res.serviceDetail.price));
                        tplInfoService = tplInfoService.replace(/{amount}/g, orderAdjust.formatMoney(res.serviceDetail.amount));
                        $('#info_service > tbody').append(tplInfoService);
                    }
                }
            }
        });
    },
    adjust: function () {
        if (product_id != 0) {
            $.ajax({
                url: laroute.route('product.order.load-popup-create-order-adjust'),
                method: 'POST',
                dataType: 'JSON',
                data: {
                    product_id: product_id,
                    detail_attribute: detail_attribute,
                },
                success: function (res) {
                    $('#form-create-order').html(res.data);
                    $('#form-create-order').find('#create-order').modal();
                    $('.ss--select2').select2();
                }
            });
        } else {
            swal.fire('Vui lòng chọn dịch vụ', "", "error");
        }

    },
    update: function () {
        if (product_id != 0) {
            var data = {
                customer_service_id: $('#customer_service_id').val(),
                form_data: $('#form-product').serializeArray()
            };
            $.ajax({
                url: laroute.route('product.order.adjust-service'),
                method: 'POST',
                dataType: 'JSON',
                data: data,
                success: function (res) {
                    if (res.error == false) {
                        detail_attribute = [];
                        attribute_result = res.data_service.attribute_result;
                        service_detail = res.data_service.service_detail;
                        detail_attribute = res.data_service.attribute_result;
                        $('#info_service_after').empty();
                        $('#info_service_after').append(res.data);
                        $('#create-order').modal('hide');
                        $('.product_name_vi_table').text($('.product_name_vi').text());
                        let total = $('#total_hidden').val();
                        let vat = total * 0.1;
                        $('.total').text(orderAdjust.formatMoney(total) + ' VNĐ');
                        $('.vat').text(orderAdjust.formatMoney(vat) + ' VNĐ');
                        $('.amount').text( orderAdjust.formatMoney(parseInt(total) + parseInt(vat)) + ' VNĐ');
                    } else {
                        swal.fire('Dịch vụ không có thay đổi!', "", "error");
                    }
                }
            });
        } else {
            swal.fire('Vui lòng chọn dịch vụ', "", "error");
        }
    },
    save: function () {
        $.ajax({
            url: laroute.route('product.order.submit-create-order-adjust'),
            method: 'POST',
            dataType: 'JSON',
            data: {
                attribute_result: attribute_result,
                service_detail: service_detail,
                order_code: $('#order_code').val(),
                form_data: $('#form-submit').serializeArray(),
                total: $('#total_hidden').val()
            },
            success: function (res) {
                if (res.error == false) {
                    swal.fire(res.message, "", "success").then(function () {
                        window.location.href = laroute.route('product.order');
                    });
                } else {
                    swal.fire(res.message, "", "error");
                }
            }
        });
    },
    reset: function () {
        $('#info_service > tbody').empty();
        $('#info_service_after').empty();
        attribute_result = null;
        service_detail = null;
        $('.total').text('0 VNĐ');
        $('.vat').text('0 VNĐ');
        $('.amount').text('0 VNĐ');
    },
    loadInfoAfterAdjust: function () {
        $.ajax({
            url: laroute.route('product.order.get-package-order-adjust'),
            method: 'POST',
            dataType: 'JSON',
            data: {order_code: $('#order_code').val()},
            success: function (res) {
                if (res.error == false) {
                    attribute_result = res.data_service.attribute_result;
                    service_detail = res.data_service.service_detail;
                    detail_attribute = res.data_service.attribute_result;
                    $('#info_service_after').empty();
                    $('#info_service_after').append(res.data);

                    $('.product_name_vi_table').text(res.data_service.service_detail.product_name_vi);
                    let total = $('#total_hidden').val();

                    let vat = total * 0.1;
                    $('.total').text(orderAdjust.formatMoney(total) + ' VNĐ');
                    $('.vat').text(orderAdjust.formatMoney(vat) + ' VNĐ');
                    $('.amount').text(orderAdjust.formatMoney(parseInt(total) + parseInt(vat)) + ' VNĐ');
                } else {
                    swal.fire('Dịch vụ không có thay đổi!', "", "error");
                }
            }
        });
    },
    formatMoney: function (x) {
        return isNaN(x) ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
};
orderAdjust.init();