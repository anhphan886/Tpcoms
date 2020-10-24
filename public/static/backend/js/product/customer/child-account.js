"use strict";
var autoGeneratePassword = 0;
var isActive = 1;
jQuery(document).ready(function () {
    $('.--select2').select2();
});

$(document).ready(function () {
   $("#form-edit").validate({
       rules: {
           account_name: {
               required: true,
               maxlength: 255,
           },
           account_phone: {
               required: true,
               number:  true,
               minlength: 10,
               maxlength: 11,
               validatePhone: true,
           },
           address: {
               required: true,
               maxlength: 255
           }
       },

       messages: {
           account_name: {
               required:   'Vui lòng nhập tên tài khoản',
               maxlength: 'Tên tài khoản quá dài, vui lòng nhập không quá 255 ký tự',
           },
           account_phone: {
               required: 'Vui lòng nhập số điện thoại',
               number: 'Số điện thoại chỉ được nhập số',
               minlength: 'số điện thoại phải có ít nhất 10 số',
               maxlength: 'Số điện thoại chỉ được nhập tối đa 11 số',
           },
           address: {
               required: 'Vui lòng nhập địa chỉ',
               maxlength: 'Địa chỉ được nhập tối đa 255 ký tự'
           },
       },
   });
    $.validator.addMethod('validatePhone', function (value, element ) {
        return this.optional(element) || /0[0-9\s.-]{9,12}/.test(value);
    }, "Vui lòng nhập đúng định dạng số điện thoại");
});
// reset password
var resetPass ={
    onlyReset: function (customer_account_id) {

        $.ajax({
           url: laroute.route('product.customer.show-reset-password'),
            method: 'POST',
            data: {
                customer_account_id: customer_account_id
            },
            success: function (res) {
                $('#kt_modal_reset_password').find('.modal-body .kt-scroll').html(res);
                $('#kt_modal_reset_password').modal();
                $('#hidden-password').val(customer_account_id);
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

    copyToClipboard: function () {
        /* Get the text field */
        var copyText = document.getElementById("password-label");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");

    },
};

///
///
var Add = {
    //// event onchange status
    change_status: function(id, obj) {
        console.log($(obj));
        var is_actived = 0;
        if ($(obj).is(':checked')) {
            is_actived = 1;
        };

        $.ajax({
            url: laroute.route('product.customer.change-status'),
            dataType: 'JSON',
            method: 'POST',
            data: {
                id: id,
                is_actived: is_actived
            },
            success: function(res) {
                if (res.error == false) {
                    swal.fire('Thay đổi trạng thái thành công', "", "success")
                }
            }
        })
    },

    changeIsActive: function(t) {
        if ($(t).is(':checked')) {
            isActive = 1;
        } else {
            isActive = 0;
        }
    },

    ///
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
    ////
    createPasswordNew: function () {
        // var is_activated = 0;
        // // if ($('#is_activateds').is(":checked")) {
        // //     is_activated = 1;
        // // } else {
        // //     is_activated = 0;
        // // }
        $.validator.addMethod("validatePassword", function (value, element) {
            return this.optional(element) || /^(?=.*\d)(?=.*[a-z])[0-9a-zA-Z!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{8,}$/i.test(value);
        });
        if (autoGeneratePassword == 0) {
            $('#form-reset-password').validate({
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
                        minlength: 'Mật khẩu phải có ít nhất 8 ký tự',
                        maxlength: 'Mật khẩu chỉ được tối đa 20 ký tự',
                        validatePassword: 'Mật khẩu phải từ 8 đến 20 ký tự bao gồm chử và số',
                    },
                },
            });
            if ($('#form-reset-password').valid()) {
                $.ajax({
                    url: laroute.route('product.customer.edit-reset-password'),
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        customer_account_id: $('#hidden-password').val(),
                        // is_activated: isChangePass,
                        password: $('#password').val()
                    },
                    success: function (res) {
                        // alert(JSON.parse(res));
                        if (res.error == false) {
                            // swal.fire('Đổi mật khẩu thành công!', "", "success");
                            $('#kt_modal_reset_password').modal('hide');
                            $('#modal-reset-password-success').html(res.detail);
                            $('#kt_modal_reset_password_success').modal();
                            swal.fire('Đổi mật khẩu thành công!', "", "success");
                        } else {
                            swal.fire(res.data, "", "error");
                        }
                    }
                });
            }
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
                        minlength: 'Mật khẩu phải có ít nhất 8 ký tự',
                        maxlength: 'Mật khẩu chỉ được tối đa 20 ký tự',
                        validatePassword:'Mật khẩu phải từ 8 đến 20 ký tự bao gồm chử và số',
                    },
                }
            });
            if ($('#form-reset-password').valid()) {
                $.ajax({
                    url: laroute.route('product.customer.edit-reset-password'),
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        customer_account_id: $('#hidden-password').val(),
                        // is_activated: isChangePass,
                        password: $('#password').val()
                    },
                    success: function (res) {
                        // alert(JSON.parse(res));
                        if (res.error == false) {
                            // swal.fire('Đổi mật khẩu thành công!', "", "success");
                            $('#kt_modal_reset_password').modal('hide');
                            $('#modal-reset-password-success').html(res.detail);
                            $('#kt_modal_reset_password_success').modal();
                            swal.fire('Đổi mật khẩu thành công!', "", "success");
                        } else {
                            swal.fire(res.data, "", "error");
                        }
                    }
                });
            }
        }
    },
    ///
    editChildAccuont: function (is_quit = 0) {
        $('#form-edit').validate({
           rules: {
               account_name: {
                   required: true,
                   maxlength: 255,
               },
               account_phone: {
                   required: true,
                   number:  true,
                   minlength: 10,
                   maxlength: 11,
                   validatePhone: true,
               },
               address: {
                   required: true,
                   maxlength: 255
               }
           },

            messages: {
                account_name: {
                    required:   'Vui lòng nhập tên tài khoản',
                    maxlength: 'Tên tài khoản quá dài, vui lòng nhập không quá 255 ký tự',
                },
                account_phone: {
                    required: 'Vui lòng nhập số điện thoại',
                    number: 'Số điện thoại chỉ được nhập số',
                    minlength: 'số điện thoại phải có ít nhất 10 số',
                    maxlength: 'Số điện thoại chỉ được nhập tối đa 11 số',
                },
                address: {
                    required: 'Vui lòng nhập địa chỉ',
                    maxlength: 'Địa chỉ được nhập tối đa 255 ký tự'
                },
            },
        });

        if ($('#form-edit').valid()){
            let url = laroute.route('product.customer.edit-childAccount');
            let form = $('#form-edit');
            $.ajax({
                url: url,
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
                                    window.location.href = laroute.route('product.customer.show-childAccount',{id: $('#customer_account_id').val()} );
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
        $.validator.addMethod('validatePhone', function (value, element ) {
            return this.optional(element) || /0[0-9\s.-]{9,12}/.test(value);
        }, "Vui lòng nhập đúng định dạng số điện thoại");

    }
};

var KTappChildAccountDatabase = function () {

    var datatable;
    var heading;

    var setHeading = function (arrHeading) {
        heading = arrHeading;
    };

    var init = function () {
        $('#datatable_list_childAccount').selectpicker();
        datatable = $('#datatable_list_childAccount').KTDatatable({
            data: {
                type: 'remote',
                source: {
                      read : {
                          method: 'POST',
                          headers: {},
                          url: laroute.route('product.customer.list-childAccount'),
                          params: {
                              customer_id: $('#customer_id_hidden').val(),
                              customer_email: $('#customer_email').val(),
                          },
                          map: function (raw) {
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                          },
                      },
                },
                pageSize: 10,
                serverPaging: !0,
                serverFiltering:!0,
                serverSorting: 0,
            },
            layout: {
              theme: "default",
                class: "table table-striped",
              scroll: true,
              height: "auto",
              footer: 0,
            },
            sortable:!0,
            toolbar: {
                placement:["bottom"], items: {
                    pagination: {
                        pageSizeSelect: [5, 10]
                    }
                }
            },
            translate: {
                toolbar: {
                    pagination: {
                        items: {
                            info: 'Hiển thị {{start}} - {{end}} của {{total}}'
                        },
                    }
                },
                records: {
                    noRecords: "Không có dữ liệu"
                }
            },
            search: {
                input: $('#search_childAccount'),
                delay: 100,
            },

            columns: [
                {
                    field: '',
                    title: '#',
                    sortable: false,
                    width: 40,
                    selector: false,
                    textAlign: 'center',
                    template: function (row, index, datatable) {
                        return (index  + 1 + (datatable.getCurrentPage()) * datatable.getPageSize()) - datatable.getPageSize();
                    }
                },
                {
                    field: 'account_email',
                    title: 'Email',
                    sortable: false,
                    template: function (row) {
                        return '<span class="m--font-bolder">' + row.account_email + '</span>';
                    }
                },
                {
                    field: 'account_name',
                    title: 'Họ và tên',
                    sortable: false,
                    template: function (row) {
                        return '<span class="m--font-bolder">' + row.account_name + '</span>';
                    }
                },
                {
                    field: 'account_type',
                    title: 'Loại tài khoản',
                    sortable: false,
                    template: function (row) {
                        if (row.account_type == "techical") {
                            return '<span class="m--font-bolder">' + 'Kỹ thuật' + '</span>';
                        } else {
                            return '<span class="m--font-bolder">' + 'Kế toán' + '</span>';
                        }
                    }
                },
                {
                    field: 'is_active',
                    title: 'Trạng thái',
                    sortable: false,
                    template: function (row) {
                        if (row.is_active == 1) {
                            return '<span class="kt-switch kt-switch--success">'
                                        +'<label>'
                                            + '<input type="checkbox" onchange="Add.change_status('+row.customer_account_id+', this)" checked="checked"  name="">'
                                            + '<span></span>'
                                        +'</label>'
                                   + '</span>';
                        }
                        else {
                            return '<span class="kt-switch kt-switch--success">'
                                        +'<label>'
                                            + '<input type="checkbox" onchange="Add.change_status('+row.customer_account_id+', this)" name="">'
                                            + '<span></span>'
                                        +'</label>'
                                    + '</span>';
                        }
                    }
                },
                {
                    field: 'customer_account_id',
                    title: 'Hành Động',
                    sortable: false,
                    template: function (row) {
                        let link = laroute.route('product.customer.show-childAccount', {id: row.customer_account_id});
                        return '<div class="dropdown nt-fix-btn">'
                                    +'<button class="btn btn-label-brand dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                        +'Hành động'
                                    +'</button>'
                                    +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
                                        +'<a class="dropdown-item" href="'+link+'">'
                                            +'<i class="la la-edit">'
                                                +'<span class="kh-df-font-size">Chỉnh sửa</span> '
                                            +'</i>'
                                        +'</a>'
                                    +'</div>'
                                + '</div>'
                    }
                },
            ]
        });
    };

    return {
        init: function () {
            init();
        },
        setHeading: function (arrHeading) {
            setHeading(arrHeading);
        },
    }
}();

KTUtil.ready(function () {
    KTappChildAccountDatabase.init();
    $('#search_childAccount').keypress(function () {
        $.ajaxSetup({ global: false });
    });
});
