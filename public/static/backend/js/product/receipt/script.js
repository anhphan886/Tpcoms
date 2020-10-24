$(document).ready(function () {
    $('.ss-select-2').select2();
    $('#amount').mask('000,000,000,000', { reverse: true });

});

var receipt = {
    cancel: function (id) {
        $.getJSON(laroute.route('product.validation'), function (json) {
            Swal.fire({
                title: json.receipt.TITLE_POPUP,
                html: json.receipt.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.receipt.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: json.receipt.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: laroute.route('product.receipt.cancel'),
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function (res) {
                            if (res.error === 0) {
                                location.reload();
                            } else {
                                swal.fire("Lỗi!", res.message, "error");
                            }
                        }
                    });
                }
            });
        });
    },
    clickUpload: function () {
        $(".label_getFileImage").trigger("click");
    },
    uploadAvatar: function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#div-image').empty();
                var tpl = $('#image-tpl').html();
                tpl = tpl.replace(/{link}/g, e.target.result);
                $('#div-image').append(tpl);
            };
            reader.readAsDataURL(input.files[0]);
            var file_data = $('#getFileImage').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);
            var fsize = input.files[0].size;
            var img = new Image();

            if (Math.round(fsize / 1024) <= 10240) {
                $('.error_img').text('');
                $.ajax({
                    url: laroute.route("product.product.uploads-image"),
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        if (res != 'error') {
                            $('#image-avatar').val(res);
                        }
                    }
                });
            }
        }
    },
    save: function () {
        Swal.fire({
            title: 'Thanh toán hóa đơn',
            text: 'Bạn có muốn thanh toán hóa đơn này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff8830',
            cancelButtonColor: '#6c7293',
            confirmButtonText: 'Thanh toán',
            cancelButtonText: 'Bỏ qua'
        }).then((result) => {
            if (result.value) {
                var form = $('#form-submit');
                $.getJSON(laroute.route('product.validation'), function (json) {
                    form.validate({
                        rules: {
                            receipt_by: {
                                required: true
                            },
                            payer: {
                                required: true,
                                maxlength: 255
                            },
                            payment_type: {
                                required: true
                            },
                            amount: {
                                required: true,
                            },
                            // image_avatar: {
                            //     required: true,
                            // },
                        },
                        messages: {
                            receipt_by: {
                                required: json.receipt.enter_staff
                            },
                            payer: {
                                required: json.receipt.enter_payer,
                                maxlength: json.product.maxlength,
                            },
                            payment_type: {
                                required: json.receipt.enter_payment_type
                            },
                            amount: {
                                required: json.receipt.enter_amount_money,
                            },
                            // image_avatar: {
                            //     required: json.receipt.image_avatar,
                            // },
                        }
                    });

                    if (form.valid()) {
                        $.ajax({
                            url: laroute.route('product.receipt.submit-payment-receipt'),
                            method: "POST",
                            data: form.serialize(),
                            success: function (res) {
                                if (res.error == false) {
                                    swal.fire(res.message, "", "success").then(function () {
                                        window.location.href = laroute.route('product.receipt');
                                    });
                                } else {
                                    swal.fire(res.message, "", "error").then(function () {

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
            }
        })

    },

    save2: function () {
        Swal.fire({
            title: 'Thanh toán hóa đơn',
            text: 'Bạn có muốn thanh toán hóa đơn này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff8830',
            cancelButtonColor: '#6c7293',
            confirmButtonText: 'Thanh toán',
            cancelButtonText: 'Bỏ qua'
        }).then((result) => {
            if (result.value) {
                var form = $('#form-submit');
                $.getJSON(laroute.route('product.validation'), function (json) {
                    form.validate({
                        rules: {
                            receipt_by: {
                                required: true
                            },
                            payer: {
                                required: true,
                                maxlength: 255
                            },
                            payment_type: {
                                required: true
                            },
                            amount: {
                                required: true,
                            },
                            // image_avatar: {
                            //     required: true,
                            // },
                        },
                        messages: {
                            receipt_by: {
                                required: json.receipt.enter_staff
                            },
                            payer: {
                                required: json.receipt.enter_payer,
                                maxlength: json.product.maxlength,
                            },
                            payment_type: {
                                required: json.receipt.enter_payment_type
                            },
                            amount: {
                                required: json.receipt.enter_amount_money,
                            },
                            // image_avatar: {
                            //     required: json.receipt.image_avatar,
                            // },
                        }
                    });

                    if (form.valid()) {
                        $.ajax({
                            url: laroute.route('product.receipt.submit-payment-receipt'),
                            method: "POST",
                            data: form.serialize(),
                            success: function (res) {
                                swal.fire(res.message, "", "success").then(function () {
                                    window.location.href = laroute.route('product.invoice');
                                });
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

            }
        })
    },

    saveDBreceipt: function () {
        var form = $('#form-submit');
        $.getJSON(laroute.route('product.validation'), function (json) {
            form.validate({
                rules: {
                    receipt_by: {
                        required: true
                    },
                    payer: {
                        required: true,
                        maxlength: 255
                    },
                    payment_type: {
                        required: true
                    },
                    amount: {
                        required: true,
                    },
                    // image_avatar: {
                    //     required: true,
                    // },
                },
                messages: {
                    receipt_by: {
                        required: json.receipt.enter_staff
                    },
                    payer: {
                        required: json.receipt.enter_payer,
                        maxlength: json.product.maxlength,
                    },
                    payment_type: {
                        required: json.receipt.enter_payment_type
                    },
                    amount: {
                        required: json.receipt.enter_amount_money,
                    },
                    // image_avatar: {
                    //     required: json.receipt.image_avatar,
                    // },
                }
            });

            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.receipt.submit-payment-receipt'),
                    method: "POST",
                    data: form.serialize(),
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.debt-receipt');
                            });
                        } else {
                            swal.fire(res.message, "", "error").then(function () {

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
    submitButton: function () {
        var form = $('#form-edit-receipt');
        form.validate({
            rules: {
                pay_expired: {
                    required: true,
                },
            },
            messages: {
                pay_expired: {
                    required: 'Vui lòng chọn hạn thanh toán'
                }
            }
        });
        if (form.valid()) {

            $.ajax({
                url: laroute.route('product.receipt.editReceipt'),
                method: "POST",
                dataType: "JSON",
                data: form.serialize(),
                success: function (res) {
                    if (res.error == false) {
                        swal.fire(res.message, "", "success").then(function () {
                            window.location.href = laroute.route('product.receipt');
                        });
                    } else {
                        swal.fire(res.message, "", "error");
                    }
                    // alert('123123');
                },
                error: function (res) {
                    var mess_error = '';
                    jQuery.each(res.responseJSON.error, function (key, val) {
                        mess_error = mess_error.concat(val + '<br/>');
                    });
                    swal.fire(mess_error, "", "error");
                }
            });
        }
    },
    submitButtonEdit: function () {
        var form = $('#form-edit-receipt');
        form.validate({
            rules: {
                pay_expired: {
                    required: true,
                },
            },
            messages: {
                pay_expired: {
                    required: 'Vui lòng chọn hạn thanh toán'
                }
            }
        });
        if (form.valid()) {
            $.ajax({
                url: laroute.route('product.receipt.editDebtReceipt'),
                method: "POST",
                dataType: "JSON",
                data: form.serialize(),
                success: function (res) {
                    if (res.error == false) {
                        swal.fire(res.message, "", "success").then(function () {
                            window.location.href = laroute.route('product.debt-receipt');
                        });
                    } else {
                        swal.fire(res.message, "", "error");
                    }
                    // alert('123123');
                },
                error: function (res) {
                    var mess_error = '';
                    jQuery.each(res.responseJSON.error, function (key, val) {
                        mess_error = mess_error.concat(val + '<br/>');
                    });
                    swal.fire(mess_error, "", "error");
                }
            });
        }
    },
};

