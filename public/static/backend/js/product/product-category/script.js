$('.ss-select-2').select2();
var productCategory = {
    save: function (type) {
        var form = $('#form-submit');
        $.getJSON(laroute.route('product.validation'), function (json) {
            form.validate({
                rules: {
                    category_name_vi: {
                        required: true,
                        maxlength:255
                    },
                    category_name_en: {
                        required: true,
                        maxlength:255
                    }
                },
                messages: {
                    category_name_vi: {
                        required: json.product_category.enter_name_vi,
                        maxlength: json.product.maxlength,
                    },
                    category_name_en: {
                        required: json.product_category.enter_name_en,
                        maxlength: json.product.maxlength,
                    }
                }
            });
            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.product-category.store'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.product-category');
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
                title: json.product_category.TITLE_POPUP,
                html: json.product_category.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.product_category.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: json.product_category.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: laroute.route('product.product-category.destroy'),
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
                    category_name_vi: {
                        required: true,
                        maxlength:255
                    },
                    category_name_en: {
                        required: true,
                        maxlength:255
                    },
                },
                messages: {
                    category_name_vi: {
                        required: json.product_category.enter_name_vi,
                        maxlength: json.product.maxlength,
                    },
                    category_name_en: {
                        required: json.product_category.enter_name_en,
                        maxlength: json.product.maxlength,
                    }
                }
            });
            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.product-category.update'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.product-category');
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
