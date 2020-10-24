var login = {
    ktLogin: $('#kt_login'),
    init: function () {
        login.handleFormSwitch();
    },
    submit: function (o) {
        var form = $('#form-login');
        var btn = $('#kt_login_signin_submit');
        $.getJSON(laroute.route('core.validation'), function (json) {
            form.validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    email: {
                        required: json.login.email_required,
                        email: json.shared.email
                    },
                    password: {
                        required: json.login.password_required
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            $.ajax({
                url: '',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    email: $('#email').val(),
                    password: $('#password').val()
                },
                success: function (response) {
                    if (response.error) {
                        // similate 2s delay
                        setTimeout(function () {
                            btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                            login.showErrorMsg(form, 'danger', response.message);
                        }, 1000);
                    } else {
                        window.location = response.url;
                    }
                }
            });
        });
    },
    handleFormSwitch: function () {
        $('#kt_login_forgot').click(function (e) {
            e.preventDefault();
            login.displayForgotForm();
            document.title = 'Quên mật khẩu';
        });

        $('#kt_login_forgot_cancel').click(function (e) {
            e.preventDefault();
            login.displaySignInForm();
            document.title = 'Đăng nhập hệ thống';
        });

        $('#kt_login_signup').click(function (e) {
            e.preventDefault();
            login.displaySignUpForm();
        });

        $('#kt_login_signup_cancel').click(function (e) {
            e.preventDefault();
            login.displaySignInForm();
        });
    },
    displaySignInForm: function () {
        login.ktLogin.removeClass('kt-login--forgot');
        login.ktLogin.removeClass('kt-login--signup');

        login.ktLogin.addClass('kt-login--signin');
        KTUtil.animateClass(login.ktLogin.find('.kt-login__signin')[0], 'flipInX animated');
        //login.find('.kt-login__signin').animateClass('flipInX animated');
    },
    displayForgotForm: function () {
        login.ktLogin.removeClass('kt-login--signin');
        login.ktLogin.removeClass('kt-login--signup');

        login.ktLogin.addClass('kt-login--forgot');
        //login.find('.kt-login--forgot').animateClass('flipInX animated');
        KTUtil.animateClass(login.ktLogin.find('.kt-login__forgot')[0], 'flipInX animated');

    },
    showErrorMsg: function (form, type, msg) {
        var alert = $('<div class="kt-alert kt-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
            <span></span>\
        </div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        //alert.animateClass('fadeIn animated');
        KTUtil.animateClass(alert[0], 'fadeIn animated');
        alert.find('span').html(msg);
    },

};
login.init();

var forgetPass = {
    init: function () {
        var form = $('#form-reset');

        $('.error-email-reset').text('');
        form.validate({
            rules: {
                email_reset: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email_reset: {
                    required: 'Hãy nhập email',
                    email: 'Email không hợp lệ'
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
                        swal.fire('Gửi email thành công. Vui lòng kiểm tra lại email', "", "success");
                    } else {
                        $('.error-email-reset').text('Email không tồn tại');
                    }
                    $('#swal2-title').css("font-family", 'Segoe UI');
                }
            });
        } else {
            return false;
        }

    },
    reset: function () {
        $('.error-email-reset').text('');
    }
};
