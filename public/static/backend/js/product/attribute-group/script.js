$('.ss-select-2').select2();
var attributeGroup = {
    save: function (type) {
        var form = $('#form-submit');
        $.getJSON(laroute.route('product.validation'), function (json) {
            form.validate({
                rules: {
                    product_attribute_group_name_vi: {
                        required: true,
                        maxlength:255
                    },
                    product_attribute_group_name_en: {
                        required: true,
                        maxlength:255
                    },
                    positions: {
                        required: true,
                        digits:true
                    }
                },
                messages: {
                    product_attribute_group_name_vi: {
                        required: json.attribute_group.enter_name_vi,
                        maxlength: json.product.maxlength,
                    },
                    product_attribute_group_name_en: {
                        required: json.attribute_group.enter_name_en,
                        maxlength: json.product.maxlength,
                    },
                    positions: {
                        required: json.attribute_group.enter_positions,
                        digits: json.attribute_group.enter_positions_number,
                    }
                }
            });
            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.product-attribute-group.store'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.product-attribute-group');
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
                title: json.attribute_group.TITLE_POPUP,
                html: json.attribute_group.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.attribute_group.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: json.attribute_group.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: laroute.route('product.product-attribute-group.destroy'),
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
                    product_attribute_group_name_vi: {
                        required: true,
                        maxlength:255
                    },
                    product_attribute_group_name_en: {
                        required: true,
                        maxlength:255
                    },
                    positions: {
                        required: true,
                        digits:true
                    }
                },
                messages: {
                    product_attribute_group_name_vi: {
                        required: json.attribute_group.enter_name_vi,
                        maxlength: json.product.maxlength,
                    },
                    product_attribute_group_name_en: {
                        required: json.attribute_group.enter_name_en,
                        maxlength: json.product.maxlength,
                    },
                    positions: {
                        required: json.attribute_group.enter_positions,
                        digits: json.attribute_group.enter_positions_number,
                    }
                }
            });
            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.product-attribute-group.update'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.product-attribute-group');
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
    showSoldTogether: function (t) {
        if ($(t).is(':checked')) {
            $('.quantity_attribute').show();
        } else {
            $('.quantity_attribute').hide();
        }
    }
};
