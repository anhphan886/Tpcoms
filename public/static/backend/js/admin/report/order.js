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

        report.orderChartColumn();

        $('#choose_day').change(function () {
            report.orderChartColumn();
        });
    },
    orderChartColumn: function () {
        var choose_day = $('#choose_day').val();
        $.ajax({
            url: laroute.route('admin.report.get-order-by-status'),
            method: "POST",
            data: {choose_day: choose_day},
            dataType: "JSON",
            success: function (res) {
                report.chartGrowthByBranch(res.chart);
                report.chartPie('pie-chart-status', res.pie_chart_status);
            }
        });
    },
    chartGrowthByBranch: function (dataValue) {
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "none",
            "dataProvider": dataValue,
            "valueAxes": [{
                "gridColor": "#FFFFFF",
                "gridAlpha": 0.2,
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
                "title": "Trạng thái",
            },
        });
    },
    chartPie: function (div_id, dataValue) {
        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable(dataValue);

            var options = {
                title: '',
                pieHole: 0.4,
                legend: {position: 'bottom'},
                chartArea: {left: 0, top: 7, right: 0, width: '50%', height: '75%'},
                colors: ['#08c900', '#0e58c9', '#00bac9', '#ff0000', '#FF6600', '#FF33FF', '#6600FF', '#333333', '#00FFFF'],
                enableInteractivity: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById(div_id));
            chart.draw(data, options);
        }
    }
};

report.init();
