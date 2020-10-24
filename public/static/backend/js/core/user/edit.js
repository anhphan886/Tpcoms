var iat = 0;
var Edit = {
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
        if ($(t).val()==1){
            $(t).parentsUntil('tbody').remove();
        }
    },
    submitEdit: function (id) {
        var isActive = 0;
        if ($($('#is_actived')).is(':checked')) {
            isActive = 1;
        }


        $('#form-edit').validate({
            rules: {
                full_name: {
                    required: true
                },
                password_confirm: {
                    equalTo: "#password"
                }
            },
            messages: {
                full_name: {
                    required: PLEASE_ENTER_NAME
                },
                password_confirm: {
                    equalTo: PLEASE_ENTER_CONFIRM_PASSWORD
                }
            },
            submitHandler: function () {
                var arrayRoleGroup = [];
                $("input[name='group_child_id[]']").each(function () {
                    var val = $(this).val();
                    arrayRoleGroup.push(val);
                });

                $.ajax({
                    url: laroute.route('core.user.update'),
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        id: id,
                        full_name: $('#full_name').val(),
                        is_actived: isActive,
                        default_menu: $('#default_menu').val(),
                        password: $('#password').val(),
                        arrayRoleGroup: arrayRoleGroup
                    }, success: function (res) {
                        if (res.error == false) {
                            swal.fire("Chỉnh sửa thành công", "", "success").then(function (result) {
                                if (result.dismiss == 'esc' || result.dismiss == 'backdrop') {
                                    window.location.href = laroute.route('core.user.index');
                                }
                                if (result.value == true) {
                                    window.location.href = laroute.route('core.user.index');
                                }
                            });
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
};
