jQuery(document).ready(function () {
    $.validator.addMethod('validatePhone', function (value, element ) {
        return this.optional(element) || /0[0-9\s.-]{9,12}/.test(value);
    }, "Vui lòng nhập đúng định dạng số điện thoại");

    $.validator.addMethod("validatePassword", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])[0-9a-zA-Z!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{8,}$/i.test(value);
    });
    // const account_type = $('#account_type').val();
    // if ( account_type != '') {
    //     $('#account_type-error').text('');
    // };
    $('#form-add').validate({
        rules: {
            account_name: {
                required: true,
                maxlength: 255,
            },
            account_type: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 20,
                validatePassword: true,
            },
            password_confirm: {
                required: true,
                equalTo: "#password",
            },
            account_phone: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 11,
                validatePhone: true,
            },
            account_id_num: {
                required: true,
                minlength: 8,
                maxlength: 12,

            },
            address: {
                required: true,
                maxlength: 255,
            },
            province_id: {
                required: true,
            }
        },
        messages: {
            account_name: {
                required: 'Vui lòng nhập tên',
                maxlength: 'Tên quá dài, chỉ được nhập tối  đá 255 ký tự'
            },
            account_type: {
                required: 'Vui lòng chọn loại tài khoản'
            },
            email: {
                required: 'Vui lòng nhập email',
                email: 'Vui lòng nhập đúng định dạng email',
            },
            password: {
                required: 'Vui lòng nhập mật khẩu',
                minlength: 'Mật khẩu quá ngắn,  mật khẩu phải có ít nhất 8 ký tự',
                maxlength: 'Mật khẩu quá dài, mật khẩu chỉ được tối đa 20 ký tự',
                validatePassword: 'Vui lòng nhập đúng định dạng mật khẩu, mật khẩu phải từ 8 đến 20 ký tự bao gồm cả chử và số'
            },
            password_confirm: {
                required: 'Vui lòng nhập xác nhận mật khẩu',
                equalTo:   'Mật khẩu xác nhận không chính xác, vui lòng nhập lại'
            },
            account_phone: {
                required: 'Vui lòng nhập số điện thoại',
                minlength: 'Số điện thoại phải có ít nhất 10 số',
                maxlength: 'Số điện thoại tối đa chỉ được 11 số',
                number: 'Số điện thoại chỉ được nhập số',
            },
            account_id_num: {
                required: 'Vui lòng nhập sô Hộ chiếu hoặc sô CMND',
                minlength: 'Hộ chiêu hoặc chứng minh nhân dân phải có ít nhất 8 ký tự',
                maxlength: 'Hộ chiêu hoặc chứng minh nhân dân chỉ được nhập tối đa 12 ký tự',
            },
            address: {
                required: 'Vui lòng nhập địa chỉ',
                maxlength: 'Địa chỉ quá dài, địa chỉ không được nhập quá 255 ký tự',
            },
            province_id: {
                required: 'Vui lòng chọn Tỉnh/Thành phố',
            }
        }
    });
});

var createChildAccount = {
    createChildAccount: function (is_quit = 0) {
        $.validator.addMethod('validatePhone', function (value, element ) {
            return this.optional(element) || /0[0-9\s.-]{9,12}/.test(value);
        }, "Vui lòng nhập đúng định dạng số điện thoại");

        $.validator.addMethod("validatePassword", function (value, element) {
            return this.optional(element) || /^(?=.*\d)(?=.*[a-z])[0-9a-zA-Z!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{8,}$/i.test(value);
        });

        $('#form-add').validate({
            rules: {
                account_name: {
                    required: true,
                    maxlength: 255,
                },
                account_type: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 20,
                    validatePassword: true,
                },
                password_confirm: {
                    required: true,
                    equalTo: "#password",
                },
                account_phone: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 11,
                    validatePhone: true,
                },
                account_id_num: {
                    required: true,
                    minlength: 8,
                    maxlength: 12,

                },
                address: {
                    required: true,
                    maxlength: 255,
                },
                province_id: {
                    required: true,
                }
            },
            messages: {
                account_name: {
                    required: 'Vui lòng nhập tên',
                    maxlength: 'Tên quá dài, chỉ được nhập tối  đá 255 ký tự'
                },
                account_type: {
                    required: 'Vui lòng chọn loại tài khoản'
                },
                email: {
                    required: 'Vui lòng nhập email',
                    email: 'Vui lòng nhập đúng định dạng email',
                },
                password: {
                    required: 'Vui lòng nhập mật khẩu',
                    minlength: 'Mật khẩu quá ngắn,  mật khẩu phải có ít nhất 8 ký tự',
                    maxlength: 'Mật khẩu quá dài, mật khẩu chỉ được tối đa 20 ký tự',
                    validatePassword: 'Vui lòng nhập đúng định dạng mật khẩu, mật khẩu phải từ 8 đến 20 ký tự bao gồm cả chử và số'
                },
                password_confirm: {
                    required: 'Vui lòng nhập xác nhận mật khẩu',
                    equalTo:   'Mật khẩu xác nhận không chính xác, vui lòng nhập lại'
                },
                account_phone: {
                    required: 'Vui lòng nhập số điện thoại',
                    minlength: 'Số điện thoại phải có ít nhất 10 số',
                    maxlength: 'Số điện thoại tối đa chỉ được 11 số',
                    number: 'Số điện thoại chỉ được nhập dố'
                },
                account_id_num: {
                    required: 'Vui lòng nhập số Hộ chiếu hoặc số CMND',
                    minlength: 'Hộ chiêu hoặc chứng minh nhân dân phải có ít nhất 8 ký tự',
                    maxlength: 'Hộ chiêu hoặc chứng minh nhân dân chỉ được nhập tối đa 12 ký tự',
                },
                address: {
                    required: 'Vui lòng nhập địa chỉ',
                    maxlength: 'Địa chỉ quá dài, địa chỉ không được nhập quá 255 ký tự',
                },
                province_id: {
                    required: 'Vui lòng chọn Tỉnh/Thành phố',
                }
            }
        });
        if ($('#form-add').valid()) {
            let form = $('#form-add');
            $.ajax({
                url: laroute.route('product.customer.create-childAccount'),
                method: "POST",
                dataType: "JSON",
                data: form.serialize(),
                success: function (res) {
                    if (!res.error) {
                        swal.fire(res.message, "", "success").then(function () {
                            if (is_quit === 0) {
                                if ($('#customer_account_id').length) {
                                    window.location.reload();
                                } else {
                                    window.location.href = laroute.route('product.customer.add-childAccount',{id: $('#customer_id').val()} );
                                }
                            } else {
                                window.location.href = laroute.route('product.customer.detail',{id: $('#customer_id').val()} );
                            }
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
    }
};
jQuery(document).ready(function () {
    $('.--select2').select2();
});
