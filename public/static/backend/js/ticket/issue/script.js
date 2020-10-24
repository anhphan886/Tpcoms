jQuery.validator.setDefaults({
    debug: true,
    success: "valid",
});
var objIssue = {
    create: function () {
        $('#btn-issue-create').click(function (e) {
            e.preventDefault()
            $.ajax({
                url: laroute.route('ticket.issue.create'),
                method: 'GET',
                success: function (res) {
                    $('#popup-modal').html(res).find('#modal-issue-add').modal()
                }
            })
        })
    },
    save: function (is_quit = 0) {
        var form = $('#form-issue-submit');
        $.getJSON(laroute.route('ticket.validation'), function (json) {
            form.validate({
                rules: {
                    issue_name_vi: {
                        required: true
                    },
                    issue_name_en: {
                        required: true
                    },
                    portal_ticket_issue_group_id: {
                        required: true
                    },
                    portal_ticket_issue_level_id: {
                        required: true
                    },
                    queue_id: {
                        required: true,
                        min: 1
                    },
                    process_time: {
                        required: true,
                        min: 1,
                        validateNumber: true
                    },
                    crictical_time2: {
                        required: true,
                        min: 1,
                        validateNumber: true
                    },
                    crictical_time3: {
                        required: true,
                        min: 1,
                        validateNumber: true
                    },
                    crictical_time4: {
                        required: true,
                        min: 1,
                        validateNumber: true
                    },

                },
                messages: {
                    issue_name_vi: {
                        required: json.issue.issue_name_vi_required
                    },
                    issue_name_en: {
                        required: json.issue.issue_name_en_required
                    },
                    portal_ticket_issue_group_id: {
                        required: json.issue.portal_ticket_issue_group_id_required
                    },
                    portal_ticket_issue_level_id: {
                        required: json.issue.portal_ticket_issue_level_id_required
                    },
                    queue_id: {
                        required: json.issue.queue_id_required
                    },
                    process_time: {
                        required: json.issue.process_time_required,
                        min: "Vui lòng nhập giá trị lớn hơn hoặc bằng 1"
                    },
                    crictical_time2: {
                        required: json.issue.crictical_time2_required,
                        min: "Vui lòng nhập giá trị lớn hơn hoặc bằng 1"
                    },
                    crictical_time3: {
                        required: json.issue.crictical_time3_required,
                        min: "Vui lòng nhập giá trị lớn hơn hoặc bằng 1"
                    },
                    crictical_time4: {
                        required: json.issue.crictical_time4_required,
                        min: "Vui lòng nhập giá trị lớn hơn hoặc bằng 1"
                    }
                }
            });

            if (form.valid()) {
                let url = ($('#portal_ticket_issue_id').length) ? laroute.route('ticket.issue.update') : laroute.route('ticket.issue.store')
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
                                        window.location.href = laroute.route('ticket.issue.add');
                                    }
                                } else {
                                    window.location.href = laroute.route('ticket.issue.index');
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

        $.validator.addMethod("validateNumber", function (value, element) {
            return this.optional(element) || /^\d+$/.test(value);
        }, "Vui lòng chỉ nhập số");
    },

    remove: function (id) {
        $.getJSON(laroute.route('ticket.validation'), function (json) {
            Swal.fire({
                title: json.issue.TITLE_POPUP,
                html: json.issue.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.issue.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: json.issue.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        //Đường dẫn route
                        url: laroute.route('ticket.issue.destroy'),
                        //Method route
                        method: 'POST',
                        //Data truyền qua để controller bắt.
                        data: {
                            portal_ticket_issue_id: id
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
    },


};
// $(document).ready(function () {
//    $("#form-issue-submit").validate({
//        rules: {
//            process_time: {
//                validateNumber: true
//            },
//            crictical_time1: {
//                validateNumber: true
//            },
//            crictical_time2: {
//                validateNumber: true
//            },
//            crictical_time3: {
//                validateNumber: true
//            },
//        },
//        messages: {
//            process_time: {
//                required: "Vui lòng nhập thời gian xử lý"
//            },
//            crictical_time1: {
//                required: "Vui lòng nhập thời gian xử lý mức 1"
//            },
//            crictical_time2: {
//                required: "Vui lòng nhập thời gian xử lý mức 2"
//            },
//            crictical_time3: {
//                required: " Vui lòng nhập thời gian xử lý mức 3"
//            }
//        }
//    });
//     $.validator.addMethod("validateNumber", function (value, element) {
//         return this.optional(element) || /^\d+$/.test(value);
//     }, "Vui lòng chỉ nhập số và có giá trị lớn hơn 0");
// });

// $("#form-issue-submit").validate({
//    rules: {
//         process_time: {
//             min: 1
//        },
//        crictical_time1: {
//            min: 1
//        },
//        crictical_time2: {
//            min: 1
//        },
//        crictical_time3: {
//            min: 1
//        },
//    },
//     messages: {
//         process_time: {
//             min: "Vui lòng nhập giá trị lớn hơn hoặc bằng 1"
//         },
//         crictical_time1: {
//             min: "Vui lòng nhập giá trị lớn hơn hoặc bằng 1"
//         },
//         crictical_time2: {
//             min: "Vui lòng nhập giá trị lớn hơn hoặc bằng 1"
//         },
//         crictical_time3: {
//             min: "Vui lòng nhập giá trị lớn hơn hoặc bằng 1"
//         }
//     }
// });
