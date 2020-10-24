var objIssueGroup = {
    create: function () {
        $('#btn-issue-group-create').click(function (e) {
            e.preventDefault()
            $.ajax({
                url: laroute.route('ticket.issue-group.create'),
                method: 'GET',
                success: function (res) {
                    $('#popup-modal').html(res).find('#modal-issue-group-add').modal()
                }
            })
        })
    },
    save: function (is_quit = 0) {
        var form = $('#form-issue-group-submit');
        $.getJSON(laroute.route('ticket.validation'), function (json) {
            form.validate({
                rules: {
                    issue_group_name_vi: {
                        required: true
                    },
                    issue_group_name_en: {
                        required: true
                    }
                },
                messages: {
                    issue_group_name_vi: {
                        required: json.issue_group.issue_group_name_vi_required
                    },
                    issue_group_name_en: {
                        required: json.issue_group.issue_group_name_en_required
                    }
                }
            });

            if (form.valid()) {
                let url = ($('#portal_ticket_issue_group_id').length) ? laroute.route('ticket.issue-group.update') : laroute.route('ticket.issue-group.store')
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (!res.error) {
                            swal.fire(res.message, "", "success").then(function () {
                                if (is_quit === 0) {
                                    if ($('#portal_ticket_issue_group_id').length) {
                                        window.location.reload();
                                    } else {
                                        window.location.href = laroute.route('ticket.issue-group.add');
                                    }
                                } else {
                                    window.location.href = laroute.route('ticket.issue-group.index');
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
    },

    edit: function () {
        let form = $('#form-submit-edit');
        $.ajax({
            url: laroute.route('ticket.issue-group.update'),
            method: 'POST',
            dataType: 'JSON',
            data: form.serialize(),
            success: function (res) {
                if (!res.error) {
                    swal.fire(res.message, "", "success").then(function () {
                        window.location.href = laroute.route('ticket.issue-group.index');
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
    },
    remove: function (id) {
        $.getJSON(laroute.route('ticket.validation'), function (json) {
            Swal.fire({
                title: json.issue_group.TITLE_POPUP,
                html: json.issue_group.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.issue_group.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: json.issue_group.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel",
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        //Đường dẫn route
                        url: laroute.route('ticket.issue-group.destroy'),
                        //Method route
                        method: 'POST',
                        //Data truyền qua để controller bắt.
                        data: {
                            ticket_issue_group_id: id
                        },
                        //Sau khi thành công thì làm gì
                        success: function (res) {
                            //Làm gì đó ....
                            if (res.error == 0) {
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
