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
        // $('#choose_day').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        // $('#time').val('1').trigger('change');
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
            "firstDay": 1
        },
        ranges: {
            'To day': [moment(), moment()],
            'Yesterday': [moment().subtract(1, "days"), moment().subtract(1, "days")],
            "Last 7 days": [moment().subtract(6, "days"), moment()],
            "Last 30 days": [moment().subtract(29, "days"), moment()],
            "This month": [moment().startOf("month"), moment().endOf("month")],
            "Last month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
        }
    }, function (start, end, label) {
        $('#choose_day').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }).on('apply.daterangepicker', function(ev, picker) {
        $('#choose_day').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        // $('#time').val('1').trigger('change');
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
            data: {province_id: $(t).val()},
            success: function (res) {
                $('.district').empty();
                $.getJSON(laroute.route('product.validation'), function (json) {
                    $('.district').append('<option value="">' + json.order.choose_province + '</option>');
                    var valH = $('#hidden_district_id').val();
                    if ($(t).val() != '') {
                        $.each(res, function (key, value) {
                            if (valH != 0 && key == valH) {
                                $('.district').append('<option selected value="' + key + '">' + value + '</option>');
                            } else {
                                $('.district').append('<option value="' + key + '">' + value + '</option>');
                            }
                        });
                    } else {
                        $('.district').empty();
                        $('.district').append('<option value="">' + json.order.choose_province + '</option>');
                    }
                });

            }
        });
    },
    upload: function (id, input) {
        $.getJSON(laroute.route('product.validation'), function (json) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var file_data = $(input).prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                form_data.append('id', id);

                $('#input-pdf').val(file_data.name);
                $.ajax({
                    url: laroute.route("product.customer.upload"),
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        swal.close();
                        if (res.error == 0) {
                            swal.fire(json.contract.upload_success, "", "success").then(function () {
                                location.reload();
                            });
                        } else {
                            swal.fire(json.contract.error, "", "error");
                        }
                    },
                    error: function (res) {
                        swal.fire(json.contract.error, "", "error");
                    }
                });
            }
        });
    },

};
 var customer = {
     changeStatus: function(email, obj) {
         var is_active = 0;
         if ($(obj).is(':checked')) {
             is_active = 1;
         };

         $.ajax({
             url: laroute.route('product.customer.change-status-customer'),
             dataType:'JSON',
             method:'POST',
             data:{
                 email:email,
                 is_active:is_active
             },
             success:function (res) {
                 if (res.error == false) {
                     swal.fire('Thay đổi trạng thái thành công', "", "success")
                 }
             }
         })
     },
 };
$(document).ready(function () {
    if ($('.select_province').val() != '' && $('.district').val() == '') {
        order.changeProvince('.select_province');
    }
});
