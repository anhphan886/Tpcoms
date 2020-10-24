
    $("#choose_day").daterangepicker({
        autoUpdateInput: false,
        autoApply: true,
        showCustomRangeLabel: true,
        buttonClasses: "m-btn btn",
        applyClass: "btn-primary",
        cancelClass: "btn-danger",
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

