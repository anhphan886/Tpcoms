var report = {
    init: function () {
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
            report.chartColumn();
        });
    },
    chartColumn: function () {
        var choose_day = $('#choose_day').val();
        $.ajax({
            url: laroute.route('admin.report.receipt-chart'),
            method: "POST",
            data: {choose_day: choose_day},
            dataType: "JSON",
            success: function (res) {
                report.chart(res.chart);
                report.chartPie('pie-chart-status', res.pie_chart_status);
                report.chartPie('pie-chart-payment-type', res.pie_chart_payment_type);
            }
        });
    },
    chart: function (dataValue) {
        AmCharts.makeChart("chartdiv", {
            // "chart": {
            //     "numberFormatter": {
            //         "numberFormat": "#a"
            //     }
            // },
            "usePrefixes": true,
            "prefixesOfBigNumbers": [
                {"number":1e+3,"prefix":" Nghìn"},
                {"number":1e+6,"prefix":" Triệu"},
                {"number":1e+9,"prefix":" Tỉ"},
                {"number":1e+12,"prefix":" Nghìn tỉ"},
            ],
            "theme": "light",
            "type": "serial",
            "dataProvider": dataValue,
            "valueAxes": [{
                "id": "distanceAxis",
                "position": "left",
                "title": "Số tiền (VNĐ)",
                "prefixesOfBigNumbers": [{number:1e+3,prefix:"k"},{number:1e+6,prefix:"M"},{number:1e+9,prefix:"G"},{number:1e+12,prefix:"T"},{number:1e+15,prefix:"P"},{number:1e+18,prefix:"E"},{number:1e+21,prefix:"Z"},{number:1e+24,prefix:"Y"}],
            },
                {
                    "id": "durationAxis",
                    "axisAlpha": 0,
                    "gridAlpha": 0,
                    "position": "right",
                    "title": "Số lượng",
                }],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "Số lượng: <b>[[value]]</b>",
                "fillAlphas": 0.9,
                "lineAlpha": 0.2,
                "type": "column",
                "valueField": "quantity",
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
            "plotAreaFillAlphas": 0.1,
            "categoryField": "status",
            "categoryAxis": {
                // "gridPosition": "start",
                "gridPosition": "start",
                "gridAlpha": 0,
                "tickPosition": "start",
                "tickLength": 0,
                "title": "Trạng thái",
            }

        });
    },
    chartPie: function (div_id, dataValue) {
        // var dataValue = [
        //     ['Task', 'Hours'],
        //     ['A', 10],
        //     ['B', 20],
        //     ['C', 30],
        // ];
        var arrayColor = ['#00B050', '#ED7D31', "#34bfa3",  "#4fc4ca", '#1F85DE', '#FF0066', '#E72ACF', '#FA58F4', '#FF0040', '#81DAF5', '#9A2EFE'];
        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        //Random màu cho biểu đồ tỷ lệ.
        var colors = arrayColor.sort(func);
        function func() {
            return 0.5 - Math.random();
        }
        function drawChart() {
            var data = google.visualization.arrayToDataTable(dataValue);

            var options = {
                title: '',
                pieHole: 0.4,
                legend: {position: 'bottom'},
                chartArea: {left: 0, top: 7, right: 0, width: '50%', height: '75%'},
                colors: colors,
                enableInteractivity: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById(div_id));
            chart.draw(data, options);
        }
    }
};

report.init();
