var adminMenu = {
    init: function () {
        $('.select2').select2({
            'width': '100%'
        });
        adminMenu.selectAll();
        $('#perpage').change(function () {
            adminMenu.filter();
        });
    },
    filter: function () {
        $('#form-filter').submit();
    },
    sort: function (o, col) {
        var sort = $(o).data('sort');
        switch (col) {
            case 'menu_name':
                $("#sort_menu_name").val(sort);
                $("#sort_menu_position").val(null);
                $("#sort_menu_category_name").val(null);
                break;
            case 'menu_category_name':
                $("#sort_menu_name").val(null);
                $("#sort_menu_position").val(null);
                $("#sort_menu_category_name").val(sort);
                break;
            case 'menu_position':
                $("#sort_menu_name").val(null);
                $("#sort_menu_position").val(sort);
                $("#sort_menu_category_name").val(null);
                break;
        }
        adminMenu.filter();
    },
    inputFiler: function () {
        $('.input-filter').show();
    },
    selectAll: function () {
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
    showPopupAdminGroup: function () {
        var listChild = [];
        $('#table-admin-group tbody').find('.group-item input:hidden').each(function () {
            var t = $(this);
            listChild.push(t.val());
        });
        $.ajax({
            url: laroute.route('core.admin-menu.get-list-group'),
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
    addGroup: function () {
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
            url: laroute.route('core.admin-menu.add-collection-list'),
            method: 'POST',
            data: {
                collection: collection
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
    },
    removeMenu: function (menu_id) {
        $.getJSON(laroute.route('core.validation'), function (json) {
            Swal.fire({
                title: json.admin_menu.TITLE_POPUP,
                html: json.admin_menu.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.admin_menu.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes ",

                showCancelButton: true,
                cancelButtonText: json.admin_menu.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel "
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: laroute.route('core.admin-menu.destroy'),
                        method: 'POST',
                        data: {
                            menu_id: menu_id
                        },
                        success: function (data) {
                            if (data.error === 0) {
                                location.reload();
                            } else {
                                swal("Lỗi!", data.message, "error");
                            }
                        }
                    });
                }
            });
        });
    },
    save: function (is_quit = 0) {
        var form = $('#form-submit');
        $.getJSON(laroute.route('core.validation'), function (json) {
            form.validate({
                rules: {
                    menu_name: {
                        required: true,
                        maxlength: 250
                    },
                    menu_position: {
                        required: true,
                        number: true,
                        max: 1000000,
                        min: 1
                    }
                },
                messages: {
                    menu_name: {
                        required: json.admin_menu.PLEASE_ENTER_NAME,
                        maxlength: json.admin_menu.MAX_LENGTH_250
                    },
                    menu_position: {
                        required: json.admin_menu.PLEASE_ENTER_POSITION,
                        number: json.admin_menu.ONLY_NUMBER,
                        max: json.admin_menu.MAX_NUMBER,
                        min: json.admin_menu.MIN_NUMBER
                    }
                }
            });

            if (form.valid()) {
                var url = ($('#menu_id').length) ? laroute.route('core.admin-menu.update') : laroute.route('core.admin-menu.store')
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (!res.error) {
                            swal.fire(res.message, "", "success").then(function () {
                                if (is_quit === 0) {
                                    if ($('#menu_id').length) {
                                        window.location.reload();
                                    } else {
                                        window.location.href = laroute.route('core.admin-menu.create');
                                    }
                                } else {
                                    window.location.href = laroute.route('core.admin-menu.index');
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
        });
    }
};
adminMenu.init();
