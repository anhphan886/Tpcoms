$('.receipt').mask('00', {reverse: true});

var config = {
    putValue : function(name, value){
        $(`[name=${name}]`).val(value);
    },
    save: function () {
        var configRemindReceipt = [];
        var flag = true;
        let list_param = [];
        $.each($('.all-config'), (key, val)=>{list_param[val.name]= val.value})
        $('.receipt').each(function () {
            let val = $(this).val();
            if (val != '') {
                configRemindReceipt.push(val);
            }
        });
        if (configRemindReceipt.length == 0) {
            flag = false;
            swal.fire('Vui lòng thêm thời gian nhắc trước hạn thanh toán phiếu thu!', "", "error");
        }
        if (flag == true) {
            $.ajax({
                url: laroute.route('admin.config.update'),
                method: "POST",
                data: {
                    configRemindReceipt: configRemindReceipt,
                    ...list_param
                },
                success: function (res) {
                    if (res.error == false) {
                        swal.fire('Chỉnh sửa thành công!', "", "success").then(function () {
                            location.reload();
                        });
                    } else {
                        if (res.error == 1) {
                            swal.fire('Thời gian nhắc trước hạn thanh toán phiếu thu trùng nhau!', "", "error").then(function () {
                            });
                        } else if (res.error == 2) {
                            swal.fire('Thời gian nhắc trước hạn thanh toán phiếu thu phải lớn hơn 0 !', "", "error").then(function () {
                            });
                        } else {
                            swal.fire('Chỉnh sửa thất bại!', "", "error").then(function () {
                            });
                        }
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
    },
    addInputConfigRemindReceipt: function () {
        let tpl = $('#tpl-input-config-receipt').html();
        $('#dev-input-config').append(tpl);
        $('.receipt').mask('00', {reverse: true});
    },
    removeInput: function (th) {
        $(th).closest('.form-group').remove();
    }
};
