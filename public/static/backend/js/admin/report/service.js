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
            url: laroute.route('admin.report.service-chart'),
            method: "POST",
            data: {choose_day: choose_day},
            dataType: "JSON",
            success: function (res) {
                report.chart(res.chart);
                report.chartPie('pie-chart-type', res.pie_chart_type);
                report.chartPie('pie-chart-pay', res.pie_chart_pay);
                report.chartPie('pie-chart-status', res.pie_chart_status);
            }
        });
    },
    chart: function (dataValue) {
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "none",
            "dataProvider": dataValue,
            "valueAxes": [{
                "gridColor": "#FFFFFF",
                "gridAlpha": 0.1,
                "dashLength": 0,
                "title": "Số lượng",
                "integersOnly" : true
            }],
            "gridAboveGraphs": true,
            "startDuration": 1,
            "graphs": [{
                "balloonText": "[[category]]: <b>[[value]]</b>",
                "fillAlphas": 0.8,
                "lineAlpha": 0.1,
                "type": "column",
                "valueField": "visits",
                "colorField": "color"
            }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "country",
            "categoryAxis": {
                "gridPosition": "start",
                "gridAlpha": 0,
                "tickPosition": "start",
                "tickLength": 0,
                "title": "Dịch vụ",
            },
            "yAxis": {
                "title": {
                    "text": 'Số tiền (VNĐ)'
                },
                "min": 0
            },
        });
    },
    chartPie: function (div_id, dataValue) {
        var arrayColor = ['#00B050', '#ED7D31', "#34bfa3",  "#4fc4ca", '#1F85DE', '#FF0066', '#6600FF', '#E72ACF', '#FA58F4', '#FF0040', '#81DAF5', '#9A2EFE'];
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
