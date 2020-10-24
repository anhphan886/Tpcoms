$('.ss--select2').select2();
if ($('#language').val() == 'vi') {
    $("#choose_day").daterangepicker({
        autoUpdateInput: true,
        autoApply: true,
        showCustomRangeLabel: true,
        buttonClasses: "m-btn btn",
        applyClass: "btn-primary",
        cancelClass: "btn-danger",
        maxDate: moment().endOf("day"),
        startDate: moment().subtract(6, "days"),
        endDate: moment().startOf("day"),
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

    }).on('apply.daterangepicker', function (ev, picker) {
        $('#choose_day').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $("#choose_day_order").daterangepicker({
        autoUpdateInput: true,
        autoApply: true,
        showCustomRangeLabel: true,
        buttonClasses: "m-btn btn",
        applyClass: "btn-primary",
        cancelClass: "btn-danger",
        maxDate: moment().endOf("day"),
        startDate: moment().subtract(6, "days"),
        endDate: moment().startOf("day"),
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

    }).on('apply.daterangepicker', function (ev, picker) {
        $('#choose_day_order').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
} else {
    $("#choose_day").daterangepicker({
        autoUpdateInput: true,
        autoApply: true,
        showCustomRangeLabel: true,
        buttonClasses: "m-btn btn",
        applyClass: "btn-primary",
        cancelClass: "btn-danger",
        maxDate: moment().endOf("day"),
        startDate: moment().subtract(6, "days"),
        endDate: moment().startOf("day"),
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
    }).on('apply.daterangepicker', function (ev, picker) {
        $('#choose_day').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $("#choose_day_order").daterangepicker({
        autoUpdateInput: true,
        autoApply: true,
        showCustomRangeLabel: true,
        buttonClasses: "m-btn btn",
        applyClass: "btn-primary",
        cancelClass: "btn-danger",
        maxDate: moment().endOf("day"),
        startDate: moment().subtract(6, "days"),
        endDate: moment().startOf("day"),
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
    }).on('apply.daterangepicker', function (ev, picker) {
        $('#choose_day_order').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
}
var chart = {
    init: function() {
        var month = $('#m_month').val();
        var year = $('#m_year').val();
        chart.orderChart('', year);
        chart.topServiceChart();
        chart.orderByStatusChart();
        $('#choose_day').change(function () {
            chart.topServiceChart();
        });
        $('#choose_day_order').change(function () {
            chart.orderByStatusChart();
        });
    },
    orderChart:function(month, year){
        let title = 'Tháng';
        if (month != '') {
            title = 'Ngày';
        }
        $.ajax({
            url: laroute.route('admin.dashboard.get-order-by-month-year'),
            method: "POST",
            data: {month:month,year: year},
            success: function (res) {
                AmCharts.makeChart("m_orders", {
                    "type": "serial",
                    "theme": "light",
                    "marginLeft": 30,
                    "marginRight": 8,
                    "marginTop": 10,
                    "marginBottom": 26,
                    "creditsPosition": 0,
                    "balloon": {
                        "adjustBorderColor": false,
                        "horizontalPadding": 10,
                        "verticalPadding": 8,
                        "color": "#ffffff"
                    },
                    "dataProvider": res,
                    "valueAxes": [{
                        "axisAlpha": 0,
                        "position": "left",
                        "title": "Số lượng",
                        "integersOnly" : true,

                    }],
                    "startDuration": 1,
                    "graphs": [{
                        "alphaField": "alpha",
                        "balloonText": "<span style='font-size:12px;'><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                        "fillAlphas": 1,
                        "title": "Tháng",
                        "type": "column",
                        "valueField": "order",
                        "dashLengthField": "dashLengthColumn",
                    }],
                    "categoryField": "month",
                    "categoryAxis": {
                        "gridPosition": "start",
                        "axisAlpha": 0,
                        "tickLength": 0,
                        "title": title,
                    }
                });
            }
        });
    },
    topServiceChart: function () {
        var choose_day = $('#choose_day').val();
        $.ajax({
            url: laroute.route('admin.dashboard.get-top-service'),
            method: "POST",
            data: {choose_day: choose_day},
            success: function (res) {
                AmCharts.makeChart("m_top_service", {
                    "theme": "light",
                    "type": "serial",
                    "dataProvider":res ,
                    "valueAxes": [{
                        "id": "distanceAxis",
                        "amount": " VNĐ",
                        "position": "left",
                    },
                        {
                            "id": "durationAxis",
                            "axisAlpha": 0,
                            "gridAlpha": 0,
                            // "inside": true,
                            "position": "right"
                        }],
                    "startDuration": 1,
                    "graphs": [{
                        "balloonText": "Số lượng: <b>[[value]]</b>",
                        "fillAlphas": 0.9,
                        "lineAlpha": 0.2,
                        "type": "column",
                        "valueField": "used",
                        "valueAxis": "durationAxis"
                    }, {
                        "balloonText": "Tổng tiền: <b>[[value]] VNĐ</b>  ",
                        "fillAlphas": 0.9,
                        "lineAlpha": 0.2,
                        "type": "column",
                        "clustered": false,
                        "columnWidth": 0.5,
                        "valueField": "amount",
                        "valueAxis": "distanceAxis"
                    }],
                    "rotate": true,
                    "plotAreaFillAlphas": 0.1,
                    "categoryField": "name",
                    "categoryAxis": {
                        "gridPosition": "start"
                    }

                });
            }
        });
    },
    filterDateTime: function () {
        var month = $('#m_month').val();
        var year = $('#m_year').val();
        chart.orderChart(month, year);
    },
    orderByStatusChart:function(){
        var choose_day = $('#choose_day_order').val();
        $.ajax({
            url: laroute.route('admin.dashboard.get-order-by-status'),
            method: "POST",
            data: {choose_day: choose_day},
            success: function (res) {
                AmCharts.makeChart("m_order_by_status", {
                    "type": "serial",
                    "addClassNames": false,
                    "theme": "light",
                    "marginLeft": 30,
                    "marginRight": 8,
                    "marginTop": 10,
                    "marginBottom": 26,
                    "creditsPosition": 0,
                    "balloon": {
                        "adjustBorderColor": false,
                        "horizontalPadding": 10,
                        "verticalPadding": 8,
                        "color": "#ffffff"
                    },
                    "dataProvider": res,
                    "valueAxes": [{
                        "axisAlpha": 0,
                        "position": "left",
                        "title": "Số lượng",
                        "integersOnly" : true,
                    }],
                    "startDuration": 1,
                    "graphs": [{
                        "alphaField": "alpha",
                        "balloonText": "<span style='font-size:12px;'>[[category]]<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                        "fillAlphas": 1,
                        "title": "Quantity",
                        "type": "column",
                        "valueField": "quantity",
                        "dashLengthField": "dashLengthColumn",
                        "colorField": "color"
                    }],
                    "categoryField": "status",
                    "categoryAxis": {
                        "gridPosition": "start",
                        "axisAlpha": 0,
                        "tickLength": 0,
                        "title": "Trạng thái",
                    }
                });
            }
        });
    },
    scroll: function (o, tab) {
        $('html,body').animate({
            scrollTop: $(o).offset().top - 140
        }, 1200);
        if (tab == 'customer') {
            $('.tab_order').removeClass('active');
            $('.div_tab_order').removeClass('active');
            $('.tab_customer').addClass('active');
            $('.div_tab_customer').addClass('active');
        }
        if (tab == 'order') {
            $('.tab_customer').removeClass('active');
            $('.div_tab_customer').removeClass('active');
            $('.tab_order').addClass('active');
            $('.div_tab_order').addClass('active');
        }
        if (tab == 'receipt') {
            $('.tab_invoice').removeClass('active');
            $('.div_tab_invoice').removeClass('active');
            $('.tab_receipt').addClass('active');
            $('.div_tab_receipt').addClass('active');
        }
        if (tab == 'invoice') {
            $('.tab_receipt').removeClass('active');
            $('.div_tab_receipt').removeClass('active');
            $('.tab_invoice').addClass('active');
            $('.div_tab_invoice').addClass('active');
        }
    },
    redirectTicket: function () {
        window.location.href = laroute.route('ticket.index');
    }
};
chart.init();