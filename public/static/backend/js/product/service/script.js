
var objService = {

    save: function () {
        var form = $('#form-service-submit');
        $.getJSON(laroute.route('product.validation'), function (json) {
            form.validate({
                rules: {
                    service_content: {
                        required: false
                    },
                },
                messages: {
                    service_content: {
                        required: json.service.service_content_required,
                    },
                }
            });

            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.service.update'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (!res.error) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = document.referrer;
                                // location.reload();
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
    cancel_service : (id)=>{
        Swal.fire({
            title: json.title,
            text: json.text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff8830',
            cancelButtonColor: '#6c7293',
            confirmButtonText: json.confirm_button_text,
            cancelButtonText : json.cancel_button_text
          }).then((result) => {
            if (result.value) {
                $.ajax({
                    url : laroute.route('product.service.update'),
                    method : 'POST',
                    data : {
                        customer_service_id : id,
                        status : 'cancel'

                    },
                    success : (e)=>{
                        if(e.error == 1){
                            Swal.fire(
                                json.cancel_fail,
                                '',
                                'error'
                              )
                        }else{
                            Swal.fire(
                                json.cancel_success,
                                '',
                                'success'
                              ).then(()=>{
                                  location.reload();
                              })
                        }
                    }
                });
            }
          })
    },

    resume_service : (id)=>{
        Swal.fire({
            title: 'Phục hồi dịch vụ',
            text: 'Bạn có muốn phục hồi dịch vụ này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff8830',
            cancelButtonColor: '#6c7293',
            confirmButtonText: 'Phục hồi',
            cancelButtonText : 'Bỏ qua'
          }).then((result) => {
            if (result.value) {
                $.ajax({
                    url : laroute.route('product.service.resume'),
                    method : 'POST',
                    data : {
                        customer_service_id : id
                    },
                    success : (e)=>{
                        if(e.error == 1){
                            Swal.fire(
                                'Phục hồi thất bại',
                                '',
                                'error'
                              )
                        }else{
                            Swal.fire(
                                'Phục hồi thành công',
                                '',
                                'success'
                              ).then(()=>{
                                  location.reload();
                              })

                        }

                    }
                });
            }
          })
    },
    // extends_service :  (id, type, payment_type)=>{
    //     console.log(payment_type);
    //     window.currentService = id;
    //     if(payment_type === 'trial'){
    //         $('#approveModal').modal('show');
    //         return;
    //     }
    //     Swal.fire({
    //         title: json.extends_title,
    //         input: 'text',
    //         text: json.extends_text,
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#ff8830',
    //         cancelButtonColor: '#6c7293',
    //         confirmButtonText: json.extends_confirm_button_text,
    //         cancelButtonText : json.extends_cancel_button_text,
    //         showLoaderOnConfirm: true,
    //         preConfirm: (month) => {
    //           },
    //           allowOutsideClick: () => !Swal.isLoading()
    //         }).then((e) => {
    //         if (e.value || !e.dismiss) {
    //             let month = e.value;
    //             if(isNaN(Number(month)) || month.indexOf('.') != -1 || month == '' || Number(month) <= 0){
    //                 Swal.fire(
    //                     json.extends_month_invalid,
    //                     '',
    //                     'error'
    //                 )
    //             }else{
    //                 objService.call_extends(id, month);
    //             }
    //         }
    //     })
    // },
    // select_type_order : (e)=>{
    //     if(e.value === 'prepaid'){
    //         $('#prepaidMonth').show();
    //         $('#prepaidMonth>input').val('');
    //     }else{
    //         $('#prepaidMonth').hide();
    //     }
    // },
    // extends_service_id : ()=>{
    //     let type = $('[name="typeOrder"]:checked').val();
    //     let month = $('#prepaidMonth>input').val();
    //     if(type === 'prepaid'){
    //         if(isNaN(Number(month)) || month.indexOf('.') != -1 || month == '' || Number(month) <= 0){
    //             Swal.fire(
    //                 json.extends_month_invalid,
    //                 '',
    //                 'error'
    //             )
    //             return;
    //         }
    //     }
    //     let customer_service_id = window.currentService;
    //     objService.call_extends(customer_service_id, month, type);
    // },
    open_model_extends: (id, type, payment_type)=>{
        $('#approveModal').modal('show');
        $('#customer_service_id').val(id);
        $('#type').val(type);
        $('#payment_type').val(payment_type);
        $('#month').val('');
        $('#month-error').hide();
        $('#month').removeClass('is-invalid');
    },

    call_extends : function() {
        let  form = $('#form-extends');
        $.getJSON(laroute.route('product.validation'), function () {
            form.validate({
                rules: {
                    month: {
                        required: true,
                        number: true,
                        digits: true,
                        min: 1,
                    },
                },
                messages: {
                    month: {
                        required: 'Vui lòng nhập số tháng muốn gia hạn',
                        number: 'Vui lòng chỉ nhập số',
                        digits: 'Vui lòng nhập số tháng cần gia hạn là số nguyên dương',
                        min: 'Vui lòng  nhập số có giá trị nhỏ nhất là 1',
                    },
                }
            });
            if (form.valid()) {
                $.ajax({
                    url : laroute.route('product.service.extends'),
                    method : 'POST',
                    data: form.serialize(),
                    success: function (res) {
                        if (!res.error) {
                            swal.fire(res.message, "", "success").then(function () {
                                location.reload();
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

    vm_action : (type = 'none')=>{
        switch(type){
            case 'delete':
                break;
            case 'power_on':
                break;
            case 'power_off':
                break;
            case 'reboot':
                break;
            case 'shutdown':
                break;
            case 'suspend':
                break;
        }
    },

    stop_payment: (id)=>{
        $('#customer_service_id').val(id);
        $('#stop_payment').modal('show');
    },

    payment: function () {
        let  form = $('#form-stop-payment');
        $.getJSON(laroute.route('product.validation'), function () {
            form.validate({
                rules: {
                    stop_payment_at: {
                        required: true
                    },
                },
                messages: {
                    stop_payment_at: {
                        required: 'Vui lòng chọn ngày tạm dừng thanh toán dịch vụ',
                    },
                }
            });
            if (form.valid()) {
                $.ajax({
                    url : laroute.route('product.service.stopPayment'),
                    method : 'POST',
                    data: {
                        customer_service_id: $('#customer_service_id').val(),
                        stop_payment_at: $('#stop_payment_at').val(),
                    },
                    success: function (res) {
                        if (!res.error) {
                            swal.fire(res.message, "", "success").then(function () {
                                location.reload();
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

$(document).ready(function () {
    $('.ss-select-2').select2();
});
