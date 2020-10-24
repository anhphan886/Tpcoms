var adminAction = {
    start: function () {
        adminAction.selectAll();
        adminAction.init();
    },
    init: function () {
        $('#perpage').change(function () {
            adminAction.filter();
        });
    },
    filter: function () {
        $('#form-filter').submit();
    },
    sort: function (o, col) {
        var sort = $(o).data('sort');
        switch (col) {
            case 'action_name':
                $("#sort_action_name").val(sort);
                $("#sort_description").val(null);
                $('#sort_action_name_default').val(null);
                $('#sort_action_group_name').val(null);
                break;
            case 'description':
                $("#sort_action_name").val(null);
                $("#sort_description").val(sort);
                $('#sort_action_name_default').val(null);
                $('#sort_action_group_name').val(null);
                break;
            case 'action_name_default':
                $("#sort_action_name").val(null);
                $("#sort_description").val(null);
                $('#sort_action_name_default').val(sort);
                $('#sort_action_group_name').val(null);
                break;
            case 'action_group_name':
                $("#sort_action_name").val(null);
                $("#sort_description").val(null);
                $('#sort_action_name_default').val(null);
                $('#sort_action_group_name').val(sort);
                break;
        }
        adminAction.filter();
    },
    inputFiler: function () {
        $('.input-filter').show();
    },
    selectAll: function () {
        $('#select-all').click(function (event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function () {
                    this.checked = false;
                });
            }
        });
        $(document).on('click', '#select-all-group', function () {
            if (this.checked) {
                // Iterate each checkbox
                $('#table-popup-group input:checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $('#table-popup-group input:checkbox').each(function () {
                    this.checked = false;
                });
            }
        });
    },
    saveInfo: function () {
        var form = $('#form-submit');
        $.getJSON(laroute.route('core.validation'), function (json) {
            form.validate({
                rules: {
                    action_name: {
                        required: true
                    }
                },
                messages: {
                    action_name: {
                        required: json.admin_action.PLEASE_ENTER_NAME
                    }
                }
            });

            if (form.valid()) {
                $.ajax({
                    url: laroute.route('core.admin-action.update'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (!res.error) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('core.admin-action.index');
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
    showPopupAdminGroup: function () {
        var listChild = [];
        $('#table-admin-group tbody').find('.group-item input:hidden').each(function () {
            var t = $(this);
            listChild.push(t.val());
        });
        $.ajax({
            url: laroute.route('core.admin-action.get-list-group'),
            method: 'POST',
            data: {
                group_id_list: listChild
            },
            success: function (res) {
                $('#kt_modal_list_group').find('#popup-list-group').html(res);
                $('#kt_modal_list_group').modal();
            }
        });
    },
    addGroupFromPopup: function () {
        var collection = [];
        $('#table-popup-group tr td').each(function () {
            var thisTableTr = $(this);
            thisTableTr.find('input:checkbox').each(function () {
                var thisCheckbox = $(this);
                if (thisCheckbox.prop('checked') === true) {
                    collection.push($(this).val());
                }
            });
        });
        $.ajax({
            url: laroute.route('core.admin-action.add-collection-list-group'),
            method: 'POST',
            data: {
                collection: collection,
            },
            success: function (res) {
                $('#row-btn-add').before(res);
                $('#kt_modal_list_group').find('#popup-list-group').html();
                $('#kt_modal_list_group').modal('hide');
            }
        });
    },
    removeRow: function (t) {
        if ($(t).val() == 1) {
            $(t).parentsUntil('tbody').remove();
        }
    }
};
