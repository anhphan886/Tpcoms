$('#province_id').select2();
$('#district_id').select2();
$('#order_status_id').select2();
$('#product_id').select2();
$('#staff_id').select2();
$('.ss-select-2').select2();

if ($('#language').val() == 'vi') {
    $("#choose_day").daterangepicker({
        autoUpdateInput: false,
        autoApply: true,
        showCustomRangeLabel: true,
        buttonClasses: "m-btn btn",
        applyClass: "btn-primary",
        cancelClass: "btn-danger",
        maxDate: moment().endOf("day"),
        startDate: moment().startOf("day"),
        endDate: moment().add(1, 'days'),
        locale: {
            customRangeLabel: "Tùy chọn ngày",
            format: 'DD/MM/YYYY',
            "applyLabel": "Đồng ý",
            "cancelLabel": "Thoát",
            daysOfWeek: [
                "CN",
                "T2",
                "T3",
                "T4",
                "T5",
                "T6",
                "T7"
            ],
            "monthNames": [
                "Tháng 1 năm",
                "Tháng 2 năm",
                "Tháng 3 năm",
                "Tháng 4 năm",
                "Tháng 5 năm",
                "Tháng 6 năm",
                "Tháng 7 năm",
                "Tháng 8 năm",
                "Tháng 9 năm",
                "Tháng 10 năm",
                "Tháng 11 năm",
                "Tháng 12 năm"
            ],
            "firstDay": 1
        },
        ranges: {
            'Hôm nay': [moment(), moment()],
            'Hôm qua': [moment().subtract(1, "days"), moment().subtract(1, "days")],
            "7 ngày trước": [moment().subtract(6, "days"), moment()],
            "30 ngày trước": [moment().subtract(29, "days"), moment()],
            "Trong tháng": [moment().startOf("month"), moment().endOf("month")],
            "Tháng trước": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
        }
    }, function (start, end, label) {

    }).on('apply.daterangepicker', function(ev, picker) {
        $('#choose_day').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        $('#time').val('1').trigger('change');
    });
} else {
    $("#choose_day").daterangepicker({
        autoUpdateInput: false,
        autoApply: true,
        showCustomRangeLabel: true,
        buttonClasses: "m-btn btn",
        applyClass: "btn-primary",
        cancelClass: "btn-danger",
        maxDate: moment().endOf("day"),
        startDate: moment().startOf("day"),
        endDate: moment().add(1, 'days'),
        locale: {
            format: 'DD/MM/YYYY',
            "firstDay": 1,

        },
        ranges: {
            'To day': [moment(), moment()],
            'Yesterday': [moment().subtract(1, "days"), moment().subtract(1, "days")],
            "Last 7 days": [moment().subtract(6, "days"), moment()],
            "Last 30 days": [moment().subtract(29, "days"), moment()],
            "This month": [moment().startOf("month"), moment().endOf("month")],
            "Last month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
        },
    }, function (start, end, label) {
    }).on('apply.daterangepicker', function(ev, picker) {
        $('#choose_day').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
}

var order = {
    removeInput: function (t) {
        $(t).val('');
    },
    changeProvince: function (t) {
        $.ajax({
            url: laroute.route('product.order.get-district'),
            method: "POST",
            // data: {province_id: $(t).val()},
            data: {province_id: $('#province_id').val()},
            success: function (res) {
                $('#district_id').empty();
                $.getJSON(laroute.route('product.validation'), function (json) {
                    $('#district_id').append('<option value="">' + json.order.choose_province + '</option>');
                    if ($(t).val() != '') {
                        var valH = $('#hidden_district_id').val();
                        $.each(res, function (key, value) {
                            if (valH != 0 && key == valH) {
                                $('#district_id').append('<option selected value="' + key + '">' + value + '</option>');
                            } else {
                                $('#district_id').append('<option value="' + key + '">' + value + '</option>');
                            }
                        })
                    } else {
                        $('#district_id').empty();
                        $('#district_id').append('<option value="">' + json.order.choose_province + '</option>');
                    }
                });

            }
        });
    },
    selecttrial: (e) => {
        $('#trialDate').hide();
        $('#paidDate').hide();
        $('#submitConfirm').prop("disabled", false);
        if (e.value === "trial") {
            $('#trialDate').show();
        } else if(e.value === "prepaid") {
            $('#paidDate').show();
            $('#paidDate>input').val(window.curQuantity);
        }
    },
    confirmApproveOrder: () => {
        let addedValue = { option: $('input[name=approveOption]:checked').val() };
        if (addedValue.option === "trial" || addedValue.option === "prepaid") {
            let date = $(addedValue.option === "trial"?'#trialDate>input':'#paidDate>input').val();
            let dateNum = Number(date.replace(/\s/g,''));
            if (isNaN(dateNum) || dateNum < 0) {
                swal.fire(
                    '',
                    'Thời gian không hợp lệ',
                    'warning'
                );
                $(addedValue.option === "trial"?'#trialDate>input':'#paidDate>input').css('border', 'solid 1px red');
                return;
            } else {
                if(!(date.replace(/\s/g,'') === '')){
                    addedValue['value'] = dateNum;
                }
            }
        }
        swal.fire({
            title: "Bạn có muốn duyệt đơn hàng?",
            buttonsStyling: false,
            showCloseButton: true,
            type: "danger",
            confirmButtonText: "Đồng ý",
            confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",
            showCancelButton: true,
            cancelButtonText: "Hủy",
            cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
        }).then(function (result) {
            if (result.value) {
                $.post(laroute.route('product.order.approveOrder'), { ...addedValue, order_id: window.currentModalOrderId }, function (res) {
                    if (!res.error) {
                        swal.fire(res.message, "", "success").then(function () {
                            window.location.reload();
                        });
                    } else {
                        swal.fire(res.message, "", "error");
                    }
                }, 'JSON');
            }

        });
    },
    approveOrder: function (orderId, quantity, isAdjust) {
        if(isAdjust == 1){
            swal.fire({
                title: "Bạn có muốn duyệt đơn hàng điều chỉnh này?",
                buttonsStyling: false,
                showCloseButton: true,
                type: "danger",
                confirmButtonText: "Duyệt đơn hàng",
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",
                showCancelButton: true,
                cancelButtonText: "Hủy đơn hàng",
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                console.log(result);
                if (result.value) {
                    $.post(laroute.route('product.order.approveAdjustOrder'), { order_id: orderId, type : 'confirm' }, function (res) {
                        if (!res.error) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.reload();
                            });
                        } else {
                            swal.fire(res.message, "", "error");
                        }
                    }, 'JSON');
                }
                if(result.dismiss == 'cancel'){
                    $.post(laroute.route('product.order.approveAdjustOrder'), { order_id: orderId , type : 'cancel' }, function (res) {
                        if (!res.error) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.reload();
                            });
                        } else {
                            swal.fire(res.message, "", "error");
                        }
                    }, 'JSON');
                }

            });
            return;
        }
        window.currentModalOrderId = orderId;
        window.curQuantity = quantity;
        $('#approveModal').modal('show');
        $('#submitConfirm').prop("disabled", true);
        return;
    },

    payOrder: function (orderId) {
        swal.fire({
            title: "Bạn có muốn tạo thanh toán đơn hàng?",
            buttonsStyling: false,
            showCloseButton: true,
            type: "danger",
            confirmButtonText: "Đồng ý",
            confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",
            showCancelButton: true,
            cancelButtonText: "Hủy",
            cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
        }).then(function (result) {
            if (result.value) {
                $.post(laroute.route('product.order.payOrder'), { order_id: orderId }, function (res) {
                    if (!res.error) {
                        swal.fire(res.message, "", "success").then(function () {
                            window.location.reload();
                        });
                    } else {
                        swal.fire(res.message, "", "error");
                    }
                }, 'JSON');
            }

        });
    },
};
$('#approveModal').on('hidden.bs.modal', function (e) {
    $('#trialDate>input').val('');
    $('#trialDate').hide();
    $('#paidDate>input').val('');
    $('#paidDate').hide();

    $(this).find("input[type=checkbox], input[type=radio]")
        .prop("checked",false);
        $('#trialDate>input').css('border', '');
        $('#paidDate>input').css('border', '');

});
$(document).ready(function () {
    if ($('.select_province').val() != '' && $('.district').val() == '') {
        order.changeProvince('.select_province');
    }
});
