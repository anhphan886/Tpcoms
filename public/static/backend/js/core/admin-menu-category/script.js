var adminMenuCategory = {
    init: function () {
        $('#perpage').change(function () {
            adminMenuCategory.filter();
        });
    },
    filter: function () {
        $('#form-filter').submit();
    },
    sort: function (o, col) {
        var sort = $(o).data('sort');
        switch (col) {
            case 'menu_category_name':
                $("#sort_menu_category_name").val(sort);
                $('#sort_menu_category_position').val(null);
                break;
            case 'menu_category_position':
                $("#sort_menu_category_name").val(null);
                $('#sort_menu_category_position').val(sort);
                break;
        }
        adminMenuCategory.filter();
    },
    inputFiler: function () {
        $('.input-filter').show();
    },
    save: function (is_quit = 0) {
        var form = $('#form-submit');
        $.getJSON(laroute.route('core.validation'), function (json) {
            form.validate({
                rules: {
                    menu_category_name: {
                        required: true,
                        maxlength: 250
                    },
                    menu_category_position: {
                        number: true,
                        required: true,
                        max: 1000000,
                        min: 1
                    }
                },
                messages: {
                    menu_category_name: {
                        required: json.admin_menu_category.PLEASE_ENTER_NAME,
                        maxlength: json.admin_menu_category.MAX_LENGTH_250
                    },
                    menu_category_position: {
                        number: json.admin_menu_category.ONLY_NUMBER,
                        required: json.admin_menu_category.PLEASE_ENTER_POSITION,
                        max: json.admin_menu_category.MAX_NUMBER,
                        min: json.admin_menu_category.MIN_NUMBER
                    }
                }
            });

            if (form.valid()) {
                var url = ($('#menu_category_id').length) ? laroute.route('core.admin-menu-category.update') : laroute.route('core.admin-menu-category.store');
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (!res.error) {
                            if (is_quit === 0) {
                                if ($('#menu_category_id').length) {
                                    swal.fire(res.message, "", "success").then(function () {
                                        window.location.reload();
                                    });
                                } else {
                                    swal.fire(res.message, "", "success").then(function () {
                                        window.location.href = laroute.route('core.admin-menu-category.create');
                                    });
                                }
                            } else {
                                swal.fire(res.message, "", "success").then(function () {
                                    window.location.href = laroute.route('core.admin-menu-category.index');
                                });
                            }
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
    remove: function (id) {
        $.getJSON(laroute.route('core.validation'), function (json) {
            Swal.fire({
                title: json.admin_menu_category.TITLE_POPUP,
                html: json.admin_menu_category.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.admin_menu_category.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: json.admin_menu_category.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: laroute.route('core.admin-menu-category.destroy'),
                        method: 'POST',
                        data: {
                            menu_category_id: id
                        },
                        success: function (data) {
                            if (data.error === 0) {
                                location.reload();
                            } else {
                                swal.fire("Lỗi!", res.message, "error");
                            }
                        }
                    });
                }
            });
        });
    }
};
adminMenuCategory.init();
