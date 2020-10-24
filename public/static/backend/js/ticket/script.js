var objTicket = {
    currentLang: 'vi',
    init: function (currentLang) {
        objTicket.currentLang = currentLang;
        $('#customer_service_id').change(function(){
            let serviceId = this.value;
            if(serviceId !== ''){
                $.ajax({
                    method : 'POST',
                    url : laroute.route('product.service.detail'),
                    data :  { customer_service_id : serviceId},
                    success : (e)=>{
                        if(e){
                            if(e.service_content){
                                $('#info-service').css('display', 'block');
                                $('#info-service').text(e.service_content);
                                return;
                            }
                        }
                        $('#info-service').css('display', 'none');
                    }
                })
            }
        });
        $('#customer_service_id').change(function(){
            let serviceId = this.value;
            if(serviceId !== ''){
                $.ajax({
                    method : 'POST',
                    url : laroute.route('product.service.attribute'),
                    data :  { customer_service_id : serviceId},
                    success : (e)=>{
                        if(e){
                            $('#attribute-service').css('display', 'block');
                            var data ="";
                            jQuery.each(e, function(index, value){
                                data = data + value.product_attribute_name_vi + " : " + parseInt(value.value) + value.unit_name +"\n";
                            });
                            $('#attribute-service').text(data);
                            return;
                        }
                        $('#attribute-service').css('display', 'none');
                    }
                })
            }
        });
        $('#customer_service_id').trigger('change');
        $('#date_issue').datetimepicker({
            todayHighlight: true,
            autoclose: true,
            pickerPosition: 'top-left',
            format: 'dd/mm/yyyy hh:ii:ss'
        })
        $('#date_estimated').datetimepicker({
            todayHighlight: true,
            autoclose: true,
            pickerPosition: 'top-left',
            format: 'dd/mm/yyyy hh:ii:ss'
        })
        $('.select-2').select2()
        $('#queue_process_id').change(function () {
            objTicket.filter()
        })
        // $('#comment_content').summernote({
        //     placeholder: '',
        //     tabsize: 2,
        //     height: 300,
        //     toolbar: [
        //         ['style', ['style']],
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['fontname', ['fontname', 'fontsize']],
        //         ['color', ['color']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //         ['table', ['table']],
        //         // ['insert', ['link', 'picture', 'video']],
        //         ['view', ['fullscreen', 'codeview', 'help']],
        //     ],
        //     callbacks: {
        //         onImageUpload: function(files) {
        //             for(let i=0; i < files.length; i++) {
        //                 $.upload(files[i]);
        //             }
        //         }
        //     }
        // });
        $.upload = function (file) {
            let out = new FormData();
            out.append('upload_file', file, file.name);

            $.ajax({
                method: 'POST',
                url: laroute.route('ticket.upload-img'),
                contentType: false,
                cache: false,
                processData: false,
                data: out,
                success: function (img) {
                    // var image = $('<img>').attr('src', '/uploads/image/' + img['file']);
                    $('#comment_content').summernote('insertImage', img.file.public_path);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        };
    },
    filter: function () {
        $('#form-filter').submit()
    },
    getIssueGroup: function () {
        $('#ticket_issue_group_id').change(function () {
            const ticket_issue_group_id = $(this).val();
            if(ticket_issue_group_id != '') {
                $('#ticket_issue_group_id-error').text('');
            }
            $.ajax({
                url: laroute.route('ticket.get-list-issue'),
                method: 'POST',
                dataType: 'JSON',
                data: {
                    ticket_issue_group_id: ticket_issue_group_id
                },
                success: function (res) {
                    if (!res.error && res.data !== null) {
                        $('#issue_id').empty()
                        let placeholder = (objTicket.currentLang == "vi") ? 'Chọn vấn đề' : 'Select issue'
                        $('#issue_id').append(`
                            <option value="">${placeholder}</option>
                            `)
                        res.data.forEach((item) => {
                            let issue_name = (objTicket.currentLang == "vi") ? item.issue_name_vi : item.issue_name_en
                            $('#issue_id').append(`
                            <option value="${item.portal_ticket_issue_id}">${issue_name}</option>
                            `)
                        })
                    }
                }
            })
        })
    },
    selectQueueByIssue: function () {
        $('#issue_id').change(function() {
            const ticket_issue_id = $(this).val()
            if(issue_id != '') {
                $('#issue_id-error').text('');
            }

            $.ajax({
                url: laroute.route('ticket.select-queue'),
                method: 'POST',
                dataType: 'JSON',
                data: {
                    ticket_issue_id: ticket_issue_id
                },
                success: function (res) {
                    if (!res.error && res.data !== null) {
                        $('#queue_process_id').val(res.data.queue_id).change()
                        $('#issue_level').val(res.data.issue_level_value)
                        objTicket.getStaffByQueue($('#queue_process_id').val())
                    }
                }
            })
        })
    },
    changeQueue: function () {
        $('#queue_process_id').change(function () {
            const queueId = $(this).val()
            if(queue_process_id != '') {
                $('#queue_process_id-error').text('');
            }
            objTicket.getStaffByQueue(queueId)
        })
    },
    getInfoCustomer: function () {
        $('#customer_id').change(function () {
            const customer_id = $(this).val();
            if (customer_id !== '') {
                $.ajax({
                    url: laroute.route('ticket.get-info-customer'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        customer_id
                    },
                    success: function (res) {
                        if (!res.error && res.data !== null) {
                            let content = `
                        <p>${res.data.customer_no} - ${res.data.customer_name}</p><p>${res.data.customer_phone}</p>
                        `;
                            $('#info-customer').html(content);
                            $('#info-customer').show();
                            $('#customer_id-error').text('');
                        }
                    }
                })
            } else {
                $('#info-customer').html();
                $('#info-customer').hide();
            }
        })
    },
    getServices: function () {
        $('#customer_id').change(function () {
            const customer_id = $(this).val();
            if (customer_id !== '') {
                $.ajax({
                    url: laroute.route('ticket.get-list-service-by-customer'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        customer_id: customer_id
                    },
                    success: function (res) {
                        if (!res.error) {
                            $('#customer_service_id').empty()
                            let placeholder = (objTicket.currentLang == "vi") ? 'Chọn dịch vụ' : 'Select service'
                            $('#customer_service_id').append(`<option value="">${placeholder}</option>`)
                            if(!res.data) { return ;}
                            res.data.forEach(item => {
                                let service_name = (objTicket.currentLang == "vi") ? item.product_name_vi : item.product_name_en
                                $('#customer_service_id').append(`<option value="${item.customer_service_id}">${service_name}</option>`)
                            })
                        }
                    }
                })
            } else {
                $('#customer_service_id').empty()
                let placeholder = (objTicket.currentLang == "vi") ? 'Chọn dịch vụ' : 'Select service'
                $('#customer_service_id').append(`<option value="">${placeholder}</option>`)
            }
        })
    },
    getStaffByQueue: function (queueId) {
        $.ajax({
            url: laroute.route('ticket.get-staff-by-queue'),
            method: 'POST',
            dataType: 'JSON',
            data: {
                queue_id: queueId
            },
            success: function (res) {
                if (!res.error) {
                    $('#operate_by').empty()
                    $('#process_by_list').empty()
                    let placeholder = (objTicket.currentLang == "vi") ? 'Chọn nhân viên' : 'Select staff'
                    $('#operate_by').append(`
                            <option value="">${placeholder}</option>
                            `)
                    if(!res.data){return;}
                    if (res.data.operator) {
                        res.data.operator.forEach((item) => {
                            $('#operate_by').append(`
                            <option value="${item.id}">${item.full_name}</option>
                            `)
                        })
                    }
                    if (res.data.processor) {
                        res.data.processor.forEach((item) => {
                            $('#process_by_list').append(`
                            <option value="${item.id}">${item.full_name}</option>
                            `)
                        })
                    }
                }
            }
        })
    },
    checkDateEstimated: function () {
        $('#date_estimated').change(function () {
            var dateEstimated = $(this).val();
            var dateIssue = $('#date_issue').val();
            if (dateEstimated !== '') {
                var result = objTicket.convertDateToInt(dateEstimated) - objTicket.convertDateToInt(dateIssue);
                console.log(result)
                if (result <= 0) {
                    swal.fire("Cảnh báo!", 'Thời gian dự kiến phải lớn thời gian phát sinh sự cố!', "warning");
                }
                $('#checkEstimated').val(result);
            } else {
                $('#checkEstimated').val(1);
            }
        });
    },
    convertDateToInt: function (strDate) {
        const newDate = strDate.replace(/\//g, '-').split("-").reverse().join("-")
        const date = new Date(newDate)
        const year = date.getFullYear() + ''
        const month = (date.getMonth() + 1).toString()
        const formatedMonth = (month.length === 1) ? ("0" + month) : month
        const day = date.getDate().toString()
        const formatedDay = (day.length === 1) ? ("0" + day) : day
        const hour = date.getHours().toString()
        const formatedHour = (hour.length === 1) ? ("0" + hour) : hour
        const minute = date.getMinutes().toString()
        const formatedMinute = (minute.length === 1) ? ("0" + minute) : minute
        const second = date.getSeconds().toString()
        const formatedSecond = (second.length === 1) ? ("0" + second) : second
        var result = year + "-" + formatedMonth + "-" + formatedDay + " " + formatedHour + ':' + formatedMinute + ':' + formatedSecond;
        return new Date(result).getTime();
    },
    uploadImage: function (input) {
        if (input.files && input.files[0]) {
            var file_data = $('#getFileUpload').prop('files')[0]
            var form_data = new FormData();
            form_data.append('upload_file', file_data)
            var fsize = input.files[0].size
            var fileInput = input
            var file = fileInput.files && fileInput.files[0]
            var img = new Image()

            if (Math.round(fsize / 1024) <= 2048) {
                var reader = new FileReader()
                var imageAvatar = $('#station_category_icon')
                reader.onload = function (e) {
                    $('#upload-file-image').empty()
                    var tpl = $('#upload-file-tpl').html()
                    tpl = tpl.replace(/{link}/g, e.target.result)
                    $('#upload-file-image').append(tpl)

                };
                reader.readAsDataURL(input.files[0]);
                $('.error_img').text('');
                $.ajax({
                    url: laroute.route("ticket.upload-img"),
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        if (res.success == 1) {
                            $('#upload_file').val(res.file.file_name);
                        }
                    }
                });
            } else {
                $.getJSON(laroute.route('ticket.validation'), function (json) {
                    Swal.fire(json.ticket.size_too_large, "", 'error');
                });
            }
        }
    },
    postComment: function () {
        let form = $('#frm-comment')
        form.validate({
            rules: {
                comment_content: {
                    required: true,
                },
            },
            messages: {
                comment_content: {
                    required: 'Bạn chưa nhập nội dung bình luận'
                },
            }
        });
        if (form.valid()) {
            let senddata = form.serialize()
            $.ajax({
                url: laroute.route('ticket.post-comment'),
                method: 'POST',
                data: senddata + '&ticket_id=' + $('#ticket_id').val(),
                success: function (res) {
                    if (!res.error) {
                        swal.fire(res.message, '', 'success').then(function () {
                            window.location.reload()
                        });
                    }
                    else {
                        swal.fire(res.message, '', 'error')
                    }
                }
            })
        }
    },
    save: function (is_quit = 0) {
        var form = $('#form-submit')

        $.getJSON(laroute.route('ticket.validation'), function (json) {
            form.validate({
                rules: {
                    issue_id: {
                        required: true,
                    },
                    ticket_issue_group_id:{
                      required: true
                    },
                    ticket_title: {
                        required: true,
                        maxlength: 100
                    },
                    queue_process_id: {
                        required: true
                    },
                    date_issue: {
                        required: true
                    },
                    date_estimated: {
                        required: true
                    },
                    customer_id: {
                        required: true,
                    },
                    // customer_service_id: {
                    //     required: true
                    // }
                },
                messages: {
                    issue_id: {
                        required: json.ticket.issue_id_required,
                    },
                    ticket_issue_group_id: {
                      required: json.ticket.ticket_issue_group_id_required,
                    },
                    ticket_title: {
                        required: json.ticket.ticket_title_required,
                        maxlength: json.ticket.ticket_title_max
                    },
                    queue_process_id: {
                        required: json.ticket.queue_process_id_required
                    },
                    date_issue: {
                        required: json.ticket.date_issue_required
                    },
                    date_estimated: {
                        required: json.ticket.date_estimated_required
                    },
                    customer_id: {
                        required: json.ticket.customer_id_required,
                    },
                    // customer_service_id: {
                    //     required: json.ticket.customer_service_id_required,
                    // }
                }
            });

            if (form.valid()) {
                let url = ($('#ticket_id').length) ? laroute.route('ticket.update') : laroute.route('ticket.store')
                // let check = $('#checkEstimated').val()
                    $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'JSON',
                        data: form.serialize(),
                        success: function (res) {
                            if (!res.error) {
                                swal.fire(res.message, '', 'success').then(function () {
                                    if (is_quit === 0) {
                                        if ($('#ticket_id').length) {
                                            window.location.reload();
                                        } else {
                                            window.location.href = laroute.route('ticket.create');
                                        }
                                    } else {
                                        window.location.href = laroute.route('ticket.index');
                                    }
                                });
                            } else {
                                swal.fire(res.message, '', 'error')
                            }
                        },
                        error: function (res) {
                            var mess_error = '';
                            jQuery.each(res.responseJSON.errors, function (key, val) {
                                mess_error = mess_error.concat(val + '<br/>');
                            });
                            swal.fire(mess_error, '', 'error')
                        }
                    });
            }
        })
    },
    save2: function () {
        var form = $('#form-submit')

        $.getJSON(laroute.route('ticket.validation'), function (json) {
            form.validate({
                rules: {
                    issue_id: {
                        required: true,
                    },
                    ticket_issue_group_id:{
                        required: true
                    },
                    ticket_title: {
                        required: true,
                        maxlength: 100
                    },
                    queue_process_id: {
                        required: true
                    },
                    date_issue: {
                        required: true
                    },
                    date_estimated: {
                        required: true
                    },
                    customer_account_id: {
                        required: true,
                    },
                    // customer_service_id: {
                    //     required: true
                    // }
                },
                messages: {
                    issue_id: {
                        required: json.ticket.issue_id_required,
                    },
                    ticket_issue_group_id: {
                        required: json.ticket.ticket_issue_group_id_required,
                    },
                    ticket_title: {
                        required: json.ticket.ticket_title_required,
                        maxlength: json.ticket.ticket_title_max
                    },
                    queue_process_id: {
                        required: json.ticket.queue_process_id_required
                    },
                    date_issue: {
                        required: json.ticket.date_issue_required
                    },
                    date_estimated: {
                        required: json.ticket.date_estimated_required
                    },
                    customer_account_id: {
                        required: json.ticket.customer_account_id_required,
                    },
                    // customer_service_id: {
                    //     required: json.ticket.customer_service_id_required,
                    // }
                }
            });

            if (form.valid()) {
                let url = ($('#ticket_id').length) ? laroute.route('ticket.update') : laroute.route('ticket.store');
                // let check = $('#checkEstimated').val()
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (!res.error) {
                            swal.fire(res.message, '', 'success').then(function () {
                                    window.location.href = laroute.route('product.order');
                            });
                        } else {
                            swal.fire(res.message, '', 'error')
                        }
                    },
                    error: function (res) {
                        var mess_error = '';
                        jQuery.each(res.responseJSON.errors, function (key, val) {
                            mess_error = mess_error.concat(val + '<br/>');
                        });
                        swal.fire(mess_error, '', 'error')
                    }
                });
            }
        })
    },


};
