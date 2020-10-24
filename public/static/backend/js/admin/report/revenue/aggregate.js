var report = {
    init: function () {
        $('#year').select2();
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

        report.chartColumn();

        $('#choose_day').change(function () {
            $('#year').val('').trigger('change');
            report.chartColumn();
        });
        $('#year').change(function () {
            // $('#choose_day').val('');
            report.chartColumn();
        });
    },
    chartColumn: function () {
        var choose_day = $('#choose_day').val();
        var year = $('#year').val();
        var type = 'year';
        if (year == '') {
            type = 'month';
        }

        $.ajax({
            url: laroute.route('admin.report.aggregate-chart'),
            method: "POST",
            data: {
                choose_day: choose_day,
                year: year,
            },
            dataType: "JSON",
            success: function (res) {
                $('.total_money').text(formatNumber(res.totalMoney));
                $('.total_paid').text(formatNumber(res.totalPaid));
                $('.total_unpaid').text(formatNumber(res.totalUnpaid));
                report.chart(res.chart, type);
            }
        });
    },
    chart: function (data, type) {
        let title = 'Tháng';
        if (type != 'year') {
            title = 'Ngày';
        }
        var chart = AmCharts.makeChart("container", {
            "type": "serial",
            "theme": "none",
            "legend": {
                "horizontalGap": 10,
                "maxColumns": 1,
                "position": "right",
                "useGraphSettings": true,
                "markerSize": 10
            },
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
            // "dataProvider": [{
            //     "year": 2003,
            //     "paid": 2.5,
            //     "unpaid": 2.5,
            // }, {
            //     "year": 2004,
            //     "paid": 2.6,
            //     "unpaid": 2.7,
            // }, {
            //     "year": 2005,
            //     "paid": 2.8,
            //     "unpaid": 2.9,
            // }],

            "dataProvider": data,
            "valueAxes": [{
                "stackType": "regular",
                "axisAlpha": 0,
                "position": "left",
                "title": "Tổng tiền",
            }],
            "graphs": [{
                "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                "fillAlphas": 0.8,
                "labelText": "[[value]]",
                "lineAlpha": 0.3,
                "title": "Đã thanh toán",
                "type": "column",
                "fillColors": "#5578eb",
                "valueField": "paid",
                "colorField": "color1"
            }, {
                "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                "fillAlphas": 0.8,
                "labelText": "[[value]]",
                "lineAlpha": 0.3,
                "title": "Chưa thanh toán",
                "type": "column",
                "fillColors": "#ffc107",
                "valueField": "unpaid",
                "colorField": "color2"
            },
                {
                    "balloonText": "<b>[[title]]</b><br><span style='font-size:34px'>[[category]]: <b>[[value]]</b></span>",
                    "fillAlphas": 0.8,
                    "labelText": "[[value]]",
                    "lineAlpha": 0.3,
                    "title": "",
                    "type": "column",
                    "valueField": "null",
                    "color": "#fff",
                    "bulletBorderColor": "#fff",
                    "bulletColor": "#fff",
                    "balloonColor": "#fff",
                    "fillColors": "#fff",
                    "legendColor": "#fff",
                },],
            "categoryField": "year",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "gridAlpha": 0,
                "position": "left",
                "title": title,
            },
            "export": {
                "enabled": false
            }

        });
    },
};

//Hàm định dạng tiền.
function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}

report.init();
