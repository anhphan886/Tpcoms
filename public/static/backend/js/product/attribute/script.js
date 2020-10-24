$('.ss-select-2').select2();
var attribute = {
    save: function (type) {
        var form = $('#form-submit');
        $.getJSON(laroute.route('product.validation'), function (json) {
            form.validate({
                rules: {
                    product_attribute_group_id: {
                        required: true
                    },
                    product_attribute_name_vi: {
                        required: true,
                        maxlength:255
                    },
                    product_attribute_name_en: {
                        required: true,
                        maxlength:255
                    },
                    unit_name: {
                        required: true
                    },
                    price_day: {
                        required: true
                    },
                    price_month: {
                        required: true
                    },
                    price_year: {
                        required: true
                    },
                    description: {
                        maxlength:255
                    }
                },
                messages: {
                    product_attribute_group_id: {
                        required: json.attribute.enter_category
                    },
                    product_attribute_name_vi: {
                        required: json.attribute.enter_name_vi,
                        maxlength: json.product.maxlength,
                    },
                    product_attribute_name_en: {
                        required: json.attribute.enter_name_en,
                        maxlength: json.product.maxlength
                    },
                    unit_name: {
                        required: json.attribute.enter_unit
                    },
                    price_day: {
                        required: json.attribute.enter_price_day
                    },
                    price_month: {
                        required: json.attribute.enter_price_month
                    },
                    price_year: {
                        required: json.attribute.enter_price_year
                    },
                    description: {
                        maxlength: json.product.maxlength,
                    },
                }
            });
            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.product-attribute.store'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.product-attribute');
                            });
                        }
                    },
                    error: function (res) {
                        var mess_error = '';
                        jQuery.each(res.responseJSON.errors, function (key, val) {
                            mess_error = mess_error.concat(val + '<br/>');
                        });
                        swal.fire(mess_error, "", "error");
                    }
                });
            }
        });
    },
    remove: function (id) {
        $.getJSON(laroute.route('product.validation'), function (json) {
            Swal.fire({
                title: json.attribute.TITLE_POPUP,
                html: json.attribute.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.attribute.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: json.attribute.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: laroute.route('product.product-attribute.destroy'),
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function (res) {
                            if (res.error === 0) {
                                swal.fire(res.message, "", "success").then(function () {
                                    location.reload();
                                });
                            } else {
                                swal.fire("Lỗi!", res.message, "error");
                            }
                        }
                    });
                }
            });
        });
    },
    edit: function () {
        var form = $('#form-submit');
        $.getJSON(laroute.route('product.validation'), function (json) {
            form.validate({
                rules: {
                    product_attribute_group_id: {
                        required: true
                    },
                    product_attribute_name_vi: {
                        required: true,
                        maxlength:255
                    },
                    product_attribute_name_en: {
                        required: true,
                        maxlength:255
                    },
                    unit_name: {
                        required: true
                    },
                    price_day: {
                        required: true
                    },
                    price_month: {
                        required: true
                    },
                    price_year: {
                        required: true
                    },
                    description: {
                        maxlength:255
                    }
                },
                messages: {
                    product_attribute_group_id: {
                        required: json.attribute.enter_category
                    },
                    product_attribute_name_vi: {
                        required: json.attribute.enter_name_vi,
                        maxlength: json.product.maxlength,
                    },
                    product_attribute_name_en: {
                        required: json.attribute.enter_name_en,
                        maxlength: json.product.maxlength,
                    },
                    unit_name: {
                        required: json.attribute.enter_unit
                    },
                    price_day: {
                        required: json.attribute.enter_price_day
                    },
                    price_month: {
                        required: json.attribute.enter_price_month
                    },
                    price_year: {
                        required: json.attribute.enter_price_year
                    },
                    description: {
                        maxlength: json.product.maxlength,
                    },
                }
            });
            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.product-attribute.update'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.product-attribute');
                            });
                        }
                    },
                    error: function (res) {
                        var mess_error = '';
                        jQuery.each(res.responseJSON.errors, function (key, val) {
                            mess_error = mess_error.concat(val + '<br/>');
                        });
                        swal.fire(mess_error, "", "error");
                    }
                });
            }
        });
    },
};
