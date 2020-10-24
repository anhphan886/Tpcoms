var voucher = {
    change_status: function (id, obj) {
        var is_actived = 0;
        if ($(obj).is(':checked')) {
            is_actived = 1;
        };

        $.ajax({
            url: laroute.route('product.voucher.change-status'),
            dataType:'JSON',
            method:'POST',
            data:{
                id:id,
                is_actived:is_actived
            },
            success:function (res) {
                if (res.error == false) {
                    swal.fire('Thay đổi trạng thái thành công', "", "success")
                }
            }
        })
    },
    editVoucher : function () {
        var form = $('#edit-voucher');
        $.validator.addMethod("code", function (value, element) {
            return this.optional(element) || /^(?=.*[a-zA-Z0-9])[a-zA-Z0-9?]*$/i.test(value);
        });
        $.getJSON(laroute.route('product.validation'), function (json) {
            form.validate({
                rules: {
                    code: {
                        required: true,
                        code: true,
                        maxlength:25
                    },
                    type:{
                        required: true,
                    },
                    cash: {
                        required: true,
                        maxlength:11
                    },
                    percent: {
                        required: true,
                        maxlength:11
                    },
                    // quota: {
                    //     required: true,
                    //     maxlength:11
                    // },
                    expired_date: {
                        required: true,
                    },
                    required_price: {
                        required: true,
                    },
                },
                messages: {
                    code: {
                        required: json.voucher.enter_code,
                        code: json.voucher.code_code,
                        maxlength: json.voucher.max_code,
                    },
                    type: {
                        required:json.voucher.enter_type,
                    },
                    cash: {
                        required: json.voucher.enter_cash_percent,
                        maxlength: json.voucher.max_cash_percent,
                    },
                    percent: {
                        required: json.voucher.enter_cash_percent,
                        maxlength: json.voucher.max_cash_percent,
                    },
                    // quota: {
                    //     required: json.voucher.enter_quota,
                    //     maxlength: json.voucher.max_quota,
                    // },
                    expired_date: {
                        required: json.voucher.enter_expire_date,
                    },
                    required_price: {
                        required: json.voucher.enter_required_price,
                    },
                }
            });
            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.voucher.editPost'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: $('#edit-voucher').serialize(),
                    success: function (res) {
                        console.log(res);
                        if (res.message.error == false) {
                            swal.fire(res.message.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.voucher');
                            });
                        } else{
                            swal.fire("Lỗi", "", "error").then(function () {
                            });
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
    save: function () {
        $.validator.addMethod("code", function (value, element) {
            return this.optional(element) || /^(?=.*[a-zA-Z0-9])[a-zA-Z0-9?]*$/i.test(value);
        });
        var form = $('#save-voucher');
        $.getJSON(laroute.route('product.validation'), function (json) {
            form.validate({
                rules: {
                    code: {
                        required: true,
                        code: true,
                        maxlength:25
                    },
                    type:{
                        required: true,
                    },
                    cash: {
                        required: true,
                        maxlength:11
                    },
                    percent: {
                        required: true,
                        maxlength:11
                    },
                    // quota: {
                    //     required: true,
                    //     maxlength:11
                    // },
                    expired_date: {
                        required: true,
                    },
                    required_price: {
                        required: true,
                    },
                },
                messages: {
                    code: {
                        required: json.voucher.enter_code,
                        code: json.voucher.code_code,
                        maxlength: json.voucher.max_code,
                    },
                    type: {
                        required:json.voucher.enter_type,
                    },
                    cash: {
                        required: json.voucher.enter_cash_percent,
                        maxlength: json.voucher.max_cash_percent,
                    },
                    percent: {
                        required: json.voucher.enter_cash_percent,
                        maxlength: json.voucher.max_cash_percent,
                    },
                    // quota: {
                    //     required: json.voucher.enter_quota,
                    //     maxlength: json.voucher.max_quota,
                    // },
                    expired_date: {
                        required: json.voucher.enter_expire_date,
                    },
                    required_price: {
                        required: json.voucher.enter_required_price,
                    },
                }
            });
            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.voucher.store'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: $('#save-voucher').serialize(),
                    success: function (res) {
                        console.log(res);
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.voucher');
                            });
                        } else{
                            swal.fire(res.message, "", "error").then(function () {
                            });
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
        $.getJSON(laroute.route('product.validation'), function (json) {
            Swal.fire({
                title: json.voucher.TITLE_POPUP,
                html: json.voucher.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.voucher.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: json.voucher.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: laroute.route('product.voucher.destroy'),
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function (res) {
                            if (res.error === 0) {
                                swal.fire(res.message, "", "success").then(function () {
                                    location.reload();
                                })
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
$("input[name='type']").change(function () {
    window.selectedType = this.value;
    $('#cash_percent').val('');
    if(this.value === 'sale_percent'){
        $('#cash_percent').attr('name', 'percent');
        $('#max_price').prop("disabled", false);
        $('#value-voucher').text('Giá trị giảm (%)')
    }else if(this.value === 'sale_cash'){
        $('#cash_percent').attr('name', 'cash');
        $('#max_price').prop("disabled", true);
        $('#value-voucher').text('Giá trị giảm (VNĐ)')
    }
});
window.priceConvert = (price)=>{
    try{
        let priceFloat = parseFloat(price);
        if(typeof(priceFloat) === 'number' && !isNaN(priceFloat)){
            x = priceFloat;
            return (parseInt(x)+'').split('').map((v,i)=>{return (i+1-(''+parseInt(x)).length%3)%3 === 0&& i!=(parseInt(x)+'').length-1? v+',': v}).join('')+((x+'').split('.').length===1?'':'.'+(x+'').split('.')[1]);
        }else {
            return '';
        }
    }catch{
        return '';
    }
};
$('#cash_percent').keyup((e)=>{
    let val = $('#cash_percent').val().split(',').join('');
    if(!window.selectedType){
        window.selectedType = 'sale_cash';
    }
    if(window.selectedType === 'sale_percent'){
        if(isNaN(Number(val)) || val.indexOf('.') !== -1 || (Number(val) <1 || Number(val) > 100)){
            $('#cash_percent').val('');
            return;
        }
    }else if(window.selectedType === 'sale_cash'){
        if(val.length > 11 || val.indexOf('.') !== -1 || isNaN(Number(val)) || (Number(val) <1)){
            $('#cash_percent').val('');
            return;
        }
        $('#cash_percent').val(priceConvert(val));
    }
});
$('#quota').keyup((e)=>{
    let val = $('#quota').val().split(',').join('');
    if(val.length > 11 || val.indexOf('.') !== -1 || isNaN(Number(val)) || (Number(val) <1)){
        $('#quota').val('');
        return;
    }
    $('#quota').val(priceConvert(val));
});
$('#max_price').keyup((e)=>{
    let val = $('#max_price').val().split(',').join('');
    if(val.length > 11 || isNaN(Number(val))){
        $('#max_price').val('');
        return;
    }
    $('#max_price').val(priceConvert(val));
});
// $('#cash_percent').bind("cut copy paste",function(e) {
//     e.preventDefault();
// });
$('#required_price').keyup((e)=>{
    let val = $('#required_price').val().split(',').join('');
    if(val.length > 11 || isNaN(Number(val))){
        $('#required_price').val('');
        return;
    }
    $('#required_price').val(priceConvert(val));
});

$(".date-picker-expire").datepicker({
    format: "dd/mm/yyyy",
    startDate: '+1d',
    language: 'vi',
});



var arrows;
if (KTUtil.isRTL()) {
    arrows = {
        leftArrow: '<i class="la la-angle-right"></i>',
        rightArrow: '<i class="la la-angle-left"></i>'
    }
} else {
    arrows = {
        leftArrow: '<i class="la la-angle-left"></i>',
        rightArrow: '<i class="la la-angle-right"></i>'
    }
}
// minimum setup
$('#expired_date').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    orientation: "bottom left",
    templates: arrows,
});
