var changePassword = {
    save: function () {
        var form = $('#form-submit');
        $.getJSON(laroute.route('core.validation'), function (json) {
            form.validate({
                rules: {
                    old_password: {
                        required: true,
                        maxlength: 20,
                    },
                    new_password: {
                        required: true,
                        maxlength: 20,
                        minlength: 8,
                    },
                    password_confirm: {
                        required: true,
                        equalTo: "#new_password"
                    },
                },
                messages: {
                    old_password: {
                        required: json.change_password.enter_old_password,
                        maxlength: json.change_password.length_password
                    },
                    new_password: {
                        required: json.change_password.enter_new_password,
                        maxlength: json.change_password.length_password,
                        minlength: json.change_password.length_password
                    },
                    password_confirm: {
                        required: json.change_password.enter_password_confirm,
                        equalTo: json.change_password.error_password_confirm
                    },
                }
            });

            if (form.valid()) {
                $.ajax({
                    url: laroute.route('admin.submit-change-password'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.history.back();
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
    },
};