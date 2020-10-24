$('.ss-select-2').select2();
var segment = {
    save: function (is_quit = 0) {
        var form = $('#form-submit');
        $.getJSON(laroute.route('product.validation'), function (json) {
            form.validate({
                rules: {
                    name_vi: {
                        required: true,
                        maxlength:255,
                        // validateName: true,
                    },
                    name_en: {
                        required: true,
                        maxlength:255,
                        // validateName: true,
                    },
                },
                messages: {
                    name_vi: {
                        required: json.segment.enter_name_vi,
                        maxlength: json.segment.name_vi_maxlength,
                    },
                    name_en: {
                        required: json.segment.enter_name_en,
                        maxlength: json.segment.name_en_maxlength,
                    },
                }
            });
            if (form.valid()) {

                let url = ($('#id').length) ? laroute.route('product.segment.update') : laroute.route('product.segment.store');
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                if (is_quit === 0) {
                                    if ($('#id').length) {
                                        window.location.reload();
                                    } else {
                                        window.location.href = laroute.route('product.segment.create');
                                    }
                                } else {
                                    window.location.href = laroute.route('product.segment');
                                }
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
        // $.validator.addMethod("validateName", function (value, element) {
        //     return this.optional(element) || /^[a-zA-Z]+$/.test(value);
        // }, "Vui lòng chỉ nhập tên lĩnh vực không chứa chữ số và kí tự đặc biệt");
    },
    remove: function (id) {
        $.getJSON(laroute.route('product.validation'), function (json) {
            Swal.fire({
                title: json.segment.TITLE_POPUP,
                html: json.segment.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.segment.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: json.segment.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: laroute.route('product.segment.destroy'),
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
                    name: {
                        required: true,
                        maxlength:255
                    },
                },
                messages: {
                    name: {
                        required: json.segment.enter_name_vi,
                        maxlength: json.product.maxlength,
                    },
                }
            });
            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.segment.update'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.segment');
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
