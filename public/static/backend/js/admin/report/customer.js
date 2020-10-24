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
            url: laroute.route('admin.report.customer-chart'),
            method: "POST",
            data: {choose_day: choose_day},
            dataType: "JSON",
            success: function (res) {
                report.chart(res.chart);
                report.chartPie('pie-chart-customer-type', res.pie_chart_customer_type);
                report.chartPie('pie-chart-customer-status', res.pie_chart_customer_status);
            }
        });
    },
    chart: function (dataValue) {
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        // var dataValue = [
        //         ["day", "TỔNG SỐ KH", "CÁ NHÂN", "DOANH NGHIỆP"],
        //         ["22/12", 0, 0, 0],
        //         ["23/12", 0, 0, 0],
        //         ["24/12", 0, 0, 0],
        //         ["25/12", 7, 0, 0],
        //         ["26/12", 0, 0, 0],
        //         ["27/12", 1, 0, 1],
        //         ["28/12", 0, 0, 10],
        //
        //     ];

        function drawChart() {
            var data = google.visualization.arrayToDataTable(
                dataValue
            );

            var options = {
                title: 'Số khách hàng',
                titleTextStyle: {
                    color: "#454545",
                    fontSize: 13,
                    bold: true
                },
                legend: {
                    position: 'right',
                    textStyle: {
                        color: '#454545',
                        fontSize: 13,
                        bold: true
                    }
                },
                titlePosition: 'out',
                hAxis: {title: '', titleTextStyle: {color: '#333', fontSize: 12}},
                vAxis: {
                    minValue: 0,
                    format: '0',
                    min: 0
                },
                colors: ['#4fc4cb', '#0098d1', '#f26d7e', '#f8ba05'],
                height: "450px",
                width: "80%",
                chartArea: {
                    height: "450px",
                    width: "80%",
                    left: 30
                }
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chartdiv'));
            chart.draw(data, options);
        }
    },
    chartPie: function (div_id, dataValue) {
        // var dataValue = [
        //     ['Task', 'Hours'],
        //     ['A', 10],
        //     ['B', 20],
        //     ['C', 30],
        // ];
        var arrayColor = [];
        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        if (div_id == 'pie-chart-customer-type') {
            arrayColor = ['#FF8000', '#DF01D7'];
        } else {
            arrayColor = ['#04B404', '#04B4AE'];
        }

        function drawChart() {
            var data = google.visualization.arrayToDataTable(dataValue);

            var options = {
                title: '',
                pieHole: 0.4,
                legend: {position: 'bottom'},
                chartArea: {left: 0, top: 7, right: 0, width: '50%', height: '75%'},
                colors: arrayColor,
                enableInteractivity: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById(div_id));
            chart.draw(data, options);
        }
    }
};

report.init();
