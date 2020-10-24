$('.ss-select-2').select2();
var contract = {
    action: function (id, type) {
        $.getJSON(laroute.route('product.validation'), function (json) {
            var jsonTitle = '';
            var jsonSuccess = '';

            if(type == 'cancel') {
                jsonTitle = json.contract.title_popup_cancel;
                jsonSuccess = json.contract.cancel_success;
            } else {
                jsonTitle = json.contract.title_popup_approve;
                jsonSuccess = json.contract.approve_success;
            }
            Swal.fire({
                title: jsonTitle,
                html: json.contract.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.contract.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: json.contract.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: laroute.route('product.contract.action'),
                        method: 'POST',
                        data: {
                            id: id,
                            type: type,
                        },
                        success: function (res) {
                            if (res.error === 0) {
                                swal.fire(jsonSuccess, "", "success").then(function () {
                                    location.reload();
                                });
                            } else {
                                swal.fire(json.contract.error, "", "error");
                            }
                        }
                    });
                }
            });
        });
    },
    upload: function (id, input) {
        $.getJSON(laroute.route('product.validation'), function (json) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var file_data = $(input).prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                form_data.append('id', id);

                $('#input-pdf').val(file_data.name);
                $.ajax({
                    url: laroute.route("product.contract.upload"),
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        swal.close();
                        if (res.error == 0) {
                            swal.fire(json.contract.upload_success, "", "success").then(function () {
                                location.reload();
                            });
                        } else {
                            swal.fire(json.contract.error, "", "error");
                        }
                    },
                    error: function (res) {
                        swal.fire(json.contract.error, "", "error");
                    }
                });
            }
        });
    },
    annexUpload: function (id, input) {
        $.getJSON(laroute.route('product.validation'), function (json) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var file_data = $(input).prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                form_data.append('id', id);

                $('#input-pdf').val(file_data.name);
                $.ajax({
                    url: laroute.route("product.annex.upload"),
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        swal.close();
                        if (res.error == 0) {
                            swal.fire(json.contract.upload_success, "", "success").then(function () {
                                location.reload();
                            });
                        } else {
                            swal.fire(json.contract.error, "", "error");
                        }
                    },
                    error: function (res) {
                        swal.fire(json.contract.error, "", "error");
                    }
                });
            }
        });
    },

    save: function () {
        var form = $('#form-submit');
        $.getJSON(laroute.route('product.validation'), function () {
            form.validate({
                rules: {
                    time_contract: {
                        number: true,
                        validateNumber: true
                    },
                },
                messages: {
                    time_contract: {
                        number: 'Vui lòng chỉ nhập số',
                    },
                }
            });

            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.contract.update'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (!res.error) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.contract');
                            });
                        } else {
                            swal.fire(res.message, "", "error");
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

        $.validator.addMethod("validateNumber", function (value, element) {
            return this.optional(element) || /^\d+$/.test(value);
        }, "Vui lòng chỉ nhập số");
    },
};
