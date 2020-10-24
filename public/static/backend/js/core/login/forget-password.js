var login = $('#kt_login');
var displayForgotForm = function () {
    login.removeClass('kt-login--signin');
    login.removeClass('kt-login--signup');

    login.addClass('kt-login--forgot');
    //login.find('.kt-login--forgot').animateClass('flipInX animated');
    KTUtil.animateClass(login.find('.kt-login__forgot')[0], 'flipInX animated');

};
var forgetPassword = {
    changePassword: function (token) {
        $.validator.addMethod("validatePassword", function (value, element) {
            // return this.optional(element) || /^(?=.*\d)(?=.*[a-z])[0-9a-zA-Z]{8,}$/i.test(value);
            return this.optional(element) || /^(?=.*\d)(?=.*[a-z])[0-9a-zA-Z!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{8,}$/i.test(value);
        });
        var form = $('#form-reset');

        form.validate({
            rules: {
                new_password: {
                    required: true,
                    minlength: 8,
                    maxlength: 20,
                    validatePassword: true,
                },
                confirm_new_password: {
                    required: true,
                    equalTo: '#new_password',
                },
            },
            messages: {
                new_password: {
                    required: 'Hãy nhập mật khẩu mới',
                    minlength: 'Tối thiểu 8 ký tự',
                    maxlength: 'Tối đa 20 kí tự',
                    validatePassword: 'Hãy nhập password từ 8 đến 20 ký tự bao gồm chữ và số'
                },
                confirm_new_password: {
                    equalTo: 'Mật khẩu nhập lại cần trùng với mật khẩu mới',
                    required: 'Vui lòng nhập xác nhận mật khẩu'
                },
            },
        });
        if (form.valid()) {
            $.ajax({
                url: laroute.route('user.forget-password.submit-reset-password'),
                method: "POST",
                data: {
                    token: token,
                    password: $('#new_password').val()
                },
                success: function (res) {
                    if (res.error == false) {
                        swal.fire('Đặt lại mật khẩu mới thành công!', "", "success").then(function (result) {
                            if (result.dismiss == 'esc' || result.dismiss == 'backdrop') {
                                window.location.href = laroute.route('user.forget-password.forget-password-success');
                            }
                            if (result.value == true) {
                                window.location.href = laroute.route('user.forget-password.forget-password-success');
                            }
                        });
                    } else {
                        swal.fire('Đặt lại mật khẩu thất bại', "", "error");
                    }
                    $('#swal2-title').css("font-family", 'Segoe UI');
                }
            });
        }
    },
    forgetPassword: function () {
        $('.remove-class').remove();
        displayForgotForm();
    },
    getPassword: function () {
        var form = $('#form-send-email');

        form.validate({
            rules: {
                email_reset: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email_reset: {
                    required: 'Vui lòng nhập email',
                    email: 'Email sai định dạng'
                }
            }
        });
        if (form.valid()) {
            $('#submit-forget').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            $.ajax({
                url: laroute.route('user.forget-password.send-email-reset-password'),
                dataType: 'JSON',
                method: 'POST',
                data: {
                    email_reset: $('#email_reset').val(),
                },
                success: function (res) {
                    $('#submit-forget').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    $('#submit-forget').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                    if (res.error == false) {
                        $('.error-email-reset').text('');
                        swal.fire('Gửi mail thành công. Vui lòng kiểm tra lại email', "", "success");
                    } else {
                        $('.error-email-reset').text('Email không đúng hoặc chưa có trong hệ thống');
                    }
                }
            });
        }
    },
    goToLogin: function () {
        window.location.href = laroute.route('login');
    },
    reset: function () {
        $('.error-email-reset').text('');
    }
};

$(document).ready(function () {
    $('#submit-forget').click(function () {

    });
});