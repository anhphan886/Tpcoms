var objQueue = {
    addQueue: function () {
        $.ajax({
            url: laroute.route('ticket.queue.add.popup'),
            method: 'POST',
            dataType: 'JSON',
            data: {},
            success: function (res) {
                if (!res.error) {
                    $('#popup-queue').html(res.data);
                    $('#popup-queue').find('#modal-issue-group-add').modal();
                }
            }
        })
    },
    save: function (is_quit = 0) {
        let form = $('#form-submit-queue');
        $.getJSON(laroute.route('ticket.validation'), function (json) {
            form.validate({
                rules: {
                    queue_name: {
                        required: true,
                        maxlength: 255
                    },
                    description: {
                        maxlength: 255
                    },
                    email_address: {
                        required: true
                    },
                    email_password: {
                        required: true
                    },

                },
                messages: {
                    queue_name: {
                        required: json.queue.queue_name_required,
                        maxlength: json.queue.queue_name_max,
                    },
                    description: {
                        maxlength: json.queue.des_max,
                    },
                    email_address: {
                        required: json.queue.email_address_required
                    },
                    email_password: {
                        required: json.queue.email_password_required
                    },

                }
            });

            if (form.valid()) {
                // ($('#ticket_queue_id').length) ? laroute.route('ticket.queue.update') :
                let url = ($('#ticket_queue_id').length) ? laroute.route('ticket.queue.update') : laroute.route('ticket.queue.store');
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                if (is_quit === 0) {
                                    if ($('#ticket_queue_id').length) {
                                        window.location.reload();
                                    } else {
                                        window.location.href = laroute.route('ticket.queue.create');
                                    }
                                } else {
                                    window.location.href = laroute.route('ticket.queue.index');
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
        })
    },
    editQueue: function (id) {
        $.ajax({
            url: laroute.route('ticket.queue.edit.popup'),
            method: 'POST',
            dataType: 'JSON',
            data: {id:id},
            success: function (res) {
                if (!res.error) {
                    $('#popup-queue').html(res.data);
                    $('#popup-queue').find('#modal-ticket-queue').modal();
                }
            }
        })
    },

    submitEditQueue: function(){
        let form = $('#form-submit-edit');

        $.ajax({
            url: laroute.route('ticket.queue.update'),
            method: 'POST',
            dataType: 'JSON',
            data: form.serialize(),
            success: function (res) {
                if (!res.error) {
                    swal.fire(res.message, "", "success").then(function () {
                        window.location.reload();
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
                title: json.queue.TITLE_POPUP,
                html: json.queue.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.queue.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: json.queue.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        //Đường dẫn route
                        url: laroute.route('ticket.queue.destroy'),
                        //Method route
                        method: 'POST',
                        //Data truyền qua để controller bắt.
                        data: {
                            ticket_queue_id: id
                        },
                        //Sau khi thành công thì làm gì
                        success: function (res) {
                            //Làm gì đó ....
                            if (res.error == 0) {
                                swal.fire(res.message, "", "success").then(function () {
                                    location.reload();
                                });
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
