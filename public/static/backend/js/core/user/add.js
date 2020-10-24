var autoGeneratePassword = 0;
var isActive = 1;
var isChangePass = 1;
var Add = {
    submitAdd: function (action) {
        // console.log(123); return false;
        $.validator.addMethod("validatePassword", function (value, element) {
            return this.optional(element) || /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/i.test(value);
        });
        $('#form-adds').validate({
            rules: {
                full_name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 20,
                    validatePassword: true,
                },
                password_confirm: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                full_name: {
                    required: PLEASE_ENTER_NAME
                },
                email: {
                    required: PLEASE_ENTER_EMAIL,
                    email: PLEASE_ENTER_EMAIL_FORMAT,
                },
                password: {
                    required: PLEASE_ENTER_PASSWORD,
                    minlength: PASSWORD_LENGTH,
                    maxlength: PASSWORD_LENGTH,
                    validatePassword: VALIDATE_PASSWORD
                },
                password_confirm: {
                    required: PLEASE_ENTER_CONFIRM_PASSWORD,
                    equalTo: FAIL_CONFIRM_PASSWORD,
                }
            },
            submitHandler: function () {
                var arrayRoleGroup = [];
                $("input[name='group_child_id[]']").each(function () {
                    var val = $(this).val();
                    arrayRoleGroup.push(val);
                });

                $.ajax({
                    url: laroute.route('core.user.store'),
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        full_name: $('#full_name').val(),
                        is_actived: $('#is_actived').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                        default_menu: $('#default_menu').val(),
                        arrayRoleGroup: arrayRoleGroup,
                        isActive: isActive
                    }, success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.data, "", "success").then(function (result) {
                                if (result.dismiss == 'esc' || result.dismiss == 'backdrop') {
                                    if (action==0){
                                        window.location.href = laroute.route('core.user.index');
                                    } else {
                                        location.reload();
                                    }

                                }
                                if (result.value == true) {
                                    if (action==0){
                                        window.location.href = laroute.route('core.user.index');
                                    } else {
                                        location.reload();
                                    }
                                }
                            });
                        } else {
                            swal.fire(res.data, "", "error");
                        }
                    },
                    error: function (res) {
                        if (res.responseJSON != undefined) {
                            var mess_error = '';
                            $.map(res.responseJSON.errors, function (a) {
                                mess_error = mess_error.concat(a + '<br/>');
                            });
                            swal.fire('Thêm thất bại', mess_error, "error");
                        }
                    }
                });
            }
        });
    },
    autoGeneratePassword: function (o) {
        if ($(o).is(':checked')) {
            $('.append-password').empty();
            var tpl = $('#tpl-auto-password').html();
            $('.append-password').append(tpl)
            var password = Math.random()                        // Generate random number, eg: 0.123456
                .toString(36)           // Convert  to base-36 : "0.4fzyo82mvyr"
                .slice(-8);// Cut off last 8 characters : "yo82mvyr"
            $('#password').val(password);
            autoGeneratePassword = 1;
        } else {
            $('#password').val('');
            $('.append-password').empty();
            var tpl = $('#tpl-not-auto-password').html();
            $('.append-password').append(tpl);
            autoGeneratePassword = 0;
        }
    },
    createPasswordNew: function () {
        var is_activated = 0;
        if ($('#is_activateds').is(":checked")) {
            is_activated = 1;
        } else {
            is_activated = 0;
        }
        $.validator.addMethod("validatePassword", function (value, element) {
            return this.optional(element) || /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/i.test(value);
        });
        if (autoGeneratePassword == 0) {
            $('#form-reset-password').validate({
                rules: {
                    password2: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        validatePassword: true,
                    },
                    // confirm_password2: {
                    //     required: true,
                    //     equalTo: "#password2"
                    // }
                },
                messages: {
                    password2: {
                        required: 'Vui lòng nhập mật khẩu',
                        minlength: 'Mật khẩu phải từ 8 - 20 ký tự',
                        maxlength: 'Mật khẩu phải từ 8 - 20 ký tự',
                        validatePassword:"Hãy nhập password từ 8 đến 20 ký tự bao gồm chữ cái, số và ký tự đặc biệt"
                    },
                    // confirm_password2: {
                    //     required: 'Vui lòng xác nhận mật khẩu',
                    //     equalTo: "Vui lòng nhập lại xác nhận mật khẩu "
                    // }
                },
                submitHandler: function () {
                    $.ajax({
                        url: laroute.route('core.user.update-password'),
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            userId: $('#hidden-password').val(),
                            is_activated: isChangePass,
                            password: $('#password2').val()
                        },
                        success: function (res) {
                            if (res.error == false) {
                                // swal.fire('Đổi mật khẩu thành công!', "", "success")
                                $('#kt_modal_reset_password').modal('hide');
                                $('#modal-reset-password-success').html(res.item);
                                $('#kt_modal_reset_password_success').modal();
                            } else {
                                swal.fire(res.data, "", "error");
                            }
                        }
                    });
                }
            });
        } else {
            var form = $('#form-reset-password');
            form.validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        validatePassword: true,
                    },
                },
                messages: {
                    password: {
                        required: 'Vui lòng nhập mật khẩu',
                        minlength: 'Mật khẩu phải từ 8 - 20 ký tự',
                        maxlength: 'Mật khẩu phải từ 8 - 20 ký tự',
                        validatePassword:"Hãy nhập password từ 8 đến 20 ký tự bao gồm chữ cái, số và ký tự đặc biệt"
                    },
                }, submitHandler: function () {
                    $.ajax({
                        url: laroute.route('core.user.update-password'),
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            userId: $('#hidden-password').val(),
                            is_activated: isChangePass,
                            password: $('#password').val()
                        },
                        success: function (res) {
                            if (res.error == false) {
                                // swal.fire('Đổi mật khẩu thành công!', "", "success");
                                $('#kt_modal_reset_password').modal('hide');
                                $('#modal-reset-password-success').html(res.item);
                                $('#kt_modal_reset_password_success').modal();
                            } else {
                                swal.fire(res.data, "", "error");
                            }
                        }
                    });
                }
            });
        }
    },

    copyToClipboard: function () {
        /* Get the text field */
        var copyText = document.getElementById("password-label");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");

    },
    selectGroupChild: function (group_id = 0) {
        var listChild = [];
        $('#table-admin-group-child tbody').find('.group-child-item input:hidden').each(function () {
            var t = $(this);
            listChild.push(t.val());
        });
        $.ajax({
            url: laroute.route('core.user.get-list-child'),
            method: 'POST',
            data: {
                group_id_list: listChild,
                group_id: group_id
            },
            success: function (res) {
                $('#kt_modal_list_group_child').find('#popup-list-group-child').html(res);
                $('#kt_modal_list_group_child').modal();
            }
        });
    },
    selectAllGroup: function (o) {
        if ($(o).is(':checked')) {
            // Iterate each checkbox
            $('#table-popup-group-child input:checkbox').each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $('#table-popup-group-child input:checkbox').each(function () {
                $(this).prop('checked', false);
            });
        }
    },
    addGroupChild: function () {
        var collection = [];
        $('#table-popup-group-child tr td').each(function () {
            var thisTableTr = $(this);
            thisTableTr.find('input:checkbox').each(function () {
                var thisCheckbox = $(this);
                if (thisCheckbox.prop('checked') === true) {
                    collection.push($(this).val());
                }
            });
        });
        $.ajax({
            url: laroute.route('core.user.add-collection-list-child'),
            method: 'POST',
            data: {
                collection: collection
            },
            success: function (res) {
                $('#row-btn-add').before(res);
                $('#kt_modal_list_group_child').find('#popup-list-group-child').html();
                $('#kt_modal_list_group_child').modal('hide');
            }
        });
    },
    removeRowGroupChild: function (t) {
        if($(t).val()==1){
            $(t).parentsUntil('tbody').remove();
        }
    },
    change_status: function (id, obj) {
        var is_actived = 0;
        if ($(obj).is(':checked')) {
            is_actived = 1;
        };

        $.ajax({
            url: laroute.route('core.user.change-status'),
            dataType:'JSON',
            method:'POST',
            data:{
                id:id,
                is_actived:is_actived
            },
            success:function (res) {
                if (res.error == false) {
                    swal.fire('Thay đổi trạng thái thành công', "", "success")
                }
            }
        })
    },
    changeIsActive: function (t) {
        if ($(t).is(':checked')) {
            isActive = 1;
        } else {
            isActive = 0;
        }
    },
    isChangePass:function (t) {
        if ($($(t)).is(':checked')) {
            isChangePass = 1;
        }else {
            isChangePass = 0;
        }
    },
    reload: function () {
        location.reload();
    },
    show_password: function (inputId) {
        if ($(inputId).prop('type') == 'password') {
            $(inputId).prop('type', 'text');
        } else {
            $(inputId).prop('type', 'password');
        }
    },
};

var list = {
    action: function (o) {
        var t = $(o);
        var userId = t.parents('td').find('.id-my-user').val();

        if (t.val() == 'reset_password') {
            $.ajax({
                url: laroute.route('core.user.show-reset-password'),
                method: 'POST',
                data: {
                    user_id: userId
                },
                success: function (res) {
                    $('#kt_modal_reset_password').find('.modal-body .kt-scroll').html(res);
                    $('#kt_modal_reset_password').modal();
                    $('#hidden-password').val(userId);
                }
            });
        } else if (t.val() == 'edit_user') {
            javascript:location.href = laroute.route('core.user.edit',{id:userId});
        } else if (t.val() == 'delete_user') {
            swal.fire({
                title: "Bạn có muốn xóa tài khoản không?",
                buttonsStyling: false,
                showCloseButton: true,
                html: "Khi tài khoản bị xóa, tài khoản đó sẽ không thể khôi phục lại được." +
                "<br>" +
                "Bạn có chắc chắn muốn xóa tài khoản này không?",
                type: "danger",

                confirmButtonText: "Đồng ý xóa",
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: "Không xóa",
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                if (result.value) {
                    javascript:location.href = laroute.route('core.user.destroy',{id:userId});
                }
            });
        }
    },
    remove: function (id) {
        swal.fire({
            title: "Bạn có muốn xóa tài khoản không?",
            buttonsStyling: false,
            showCloseButton: true,
            html: "Khi tài khoản bị xóa, tài khoản đó sẽ không thể khôi phục lại được." +
            "<br>" +
            "Bạn có chắc chắn muốn xóa tài khoản này không?",
            type: "danger",

            confirmButtonText: "Đồng ý xóa",
            confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

            showCancelButton: true,
            cancelButtonText: "Không xóa",
            cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
        }).then(function (result) {
            if (result.value) {
                javascript:location.href = laroute.route('core.user.destroy', {id: id});
            }
        });
    },
    resetPass: function (id) {
        $.ajax({
            url: laroute.route('core.user.show-reset-password'),
            method: 'POST',
            data: {
                user_id: id
            },
            success: function (res) {
                $('#kt_modal_reset_password').find('.modal-body .kt-scroll').html(res);
                $('#kt_modal_reset_password').modal();
                $('#hidden-password').val(id);
            }
        });
    },
    onlyReset: function(userId){
        $.ajax({
            url: laroute.route('core.user.show-reset-password'),
            method: 'POST',
            data: {
                user_id: userId
            },
            success: function (res) {
                $('#kt_modal_reset_password').find('.modal-body .kt-scroll').html(res);
                $('#kt_modal_reset_password').modal();
                $('#hidden-password').val(userId);
            }
        });
    },

    show_password: function (inputId) {
        if ($(inputId).prop('type') == 'password') {
            $(inputId).prop('type', 'text');
        } else {
            $(inputId).prop('type', 'password');
        }
    },
};
jQuery(document).ready(function () {
    $('.--select2').select2();
});
//
