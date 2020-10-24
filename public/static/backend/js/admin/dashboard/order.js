"use strict";
// Class definition

var KTAppOrderDatatable = function () {
    // variables
    var datatable;
    var heading;

    var setHeading = function (arrHeading) {
        heading = arrHeading;
    };
    // init
    var init = function () {
        $('.kt-selectpicker').selectpicker();
        datatable = $('#datatable_list_order').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'POST',
                        headers: {},
                        url: laroute.route('admin.dashboard.list-order'),
                        map: function(raw) {
                            // sample data mapping
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },

                pageSize: 5,
                serverPaging:!0,
                serverFiltering:!0,
                serverSorting:0
            },

            // layout definition
            layout: {
                theme: "default",
                class: "",
                scroll: true,
                height: "auto",
                footer: 0
            },

            // column sorting
            sortable:!0,
            toolbar: {
                placement:["bottom"], items: {
                    pagination: {
                        pageSizeSelect: [5, 10],
                        items: {
                            info: 'Displaying {{start}} - {{end}} of {{total}} records'
                        }
                    }
                }
            },
            translate: {
                toolbar: {
                    pagination: {
                        items: {
                            info: 'Hiển thị {{start}} - {{end}} của {{total}}'
                        }
                    }
                },
                records: {
                    noRecords: "Không có dữ liệu"
                }
            },
            search: {
                input: $('#search_order'),
                delay: 100,
            },

            // columns definition
            columns: [
                {
                    field: '',
                    title: '#',
                    sortable: false, // disable sort for this column
                    width: 40,
                    selector: false,
                    textAlign: 'center',
                    template: function (row, index, datatable) {
                        return (index + 1 + (datatable.getCurrentPage()) * datatable.getPageSize()) - datatable.getPageSize();
                    }

                },
                {
                    field: 'order_code',
                    title: heading.order_code,
                    sortable: false,
                    template: function (row) {
                        let link = laroute.route('product.order.detail', {id: row.order_code});
                        return '<a href="' + link +'" class="m-link m--font-bolder">'+row.order_code+'</a>';
                    }
                },
                {
                    field: 'is_adjust',
                    title: 'Loại',
                    sortable: false,
                    template: function (row) {
                        if (row.is_adjust == 1) {
                            return '<span>' + 'Điều chỉnh' + '</span>';
                        } else {
                            return '<span>' + 'Mới' + '</span>';
                        }
                    }
                },
                {
                    field: 'customer_name',
                    title: heading.customer,
                    sortable: false,
                },
                {
                    field: 'created_at',
                    title: 'Ngày khởi tạo',
                    sortable: false,
                    template: function (row) {
                        let d = new Date(row.created_at);
                        let day = d.getDate();
                        let month = d.getMonth() + 1;
                        let year = d.getFullYear();
                        var time = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                        if (day < 10) {
                            day = "0" + day;
                        }
                        if (month < 10) {
                            month = "0" + month;
                        }
                        let date = day + "/" + month + "/" + year + ' ' + time;
                        return '<span>' + date + '</span>';
                    }
                },
                {
                    field: 'voucher_code',
                    title: 'Mã giảm giá',
                    sortable: false,
                },
                {
                    field: 'amount',
                    title: heading.amount,
                    sortable: false,
                    textAlign: 'right',
                    template: function (row) {
                        return '<span class="m--font-bolder">' + parseInt(row.amount).toLocaleString() + '</span>';
                    }
                },
                {
                    field: 'order_status_id',
                    title: heading.status,
                    filterable: false, // disable or enablePOP filtering
                    textAlign: 'right',
                    sortable: false,
                    template: function (t) {
                        var lang = $('#language').val();
                        if (lang == 'vi') {
                            var a = {
                                    "1": {
                                        title: t.order_status_name_vi, class: " m-badge--primary btn-new kt-padding-10",
                                    },
                                    "2": {
                                        title: t.order_status_name_vi, class: " m-badge--info btn-accepted kt-padding-10",
                                    },
                                    "3": {
                                        title: t.order_status_name_vi,
                                        class: " m-badge--warning btn-waiting-payment kt-padding-10",
                                    },
                                    "4": {
                                        title: t.order_status_name_vi,
                                        class: " m-badge--success btn-finished kt-padding-10",
                                    },
                                    "5": {
                                        title: t.order_status_name_vi,
                                        class: " m-badge--danger btn-cancelled kt-padding-10",
                                    },
                                    "6": {
                                        title: t.order_status_name_vi,
                                        class: " m-badge--success btn-finished kt-padding-10",
                                    },
                                    "7": {
                                            title: t.order_status_name_vi,
                                            class: " m-badge--success btn-finished kt-padding-10",
                                        },
                                    }
                            ;
                            return '<span class="m-badge ' + a[t.order_status_id].class + ' m-badge--wide">' + a[t.order_status_id].title + "</span>"
                        } else {
                            var a = {
                                    "1": {
                                        title: t.order_status_name_en, class: " m-badge--primary btn-new kt-padding-10",
                                    },
                                    "2": {
                                        title: t.order_status_name_en, class: " m-badge--info btn-accepted kt-padding-10",
                                    },
                                    "3": {
                                        title: t.order_status_name_en,
                                        class: " m-badge--warning btn-waiting-payment kt-padding-10",
                                    },
                                    "4": {
                                        title: t.order_status_name_en,
                                        class: " m-badge--success btn-finished kt-padding-10",
                                    },
                                    "5": {
                                        title: t.order_status_name_en,
                                        class: " m-badge--danger btn-cancelled kt-padding-10",
                                    },
                                    "6": {
                                        title: t.order_status_name_en,
                                        class: " m-badge--danger btn-finished kt-padding-10",
                                    },
                                    "7": {
                                        title: t.order_status_name_en,
                                        class: " m-badge--danger btn-finished kt-padding-10",
                                    }
                                }
                            ;
                            return '<span class="m-badge ' + a[t.order_status_id].class + ' m-badge--wide">' + a[t.order_status_id].title + "</span>"
                        }

                    }
                }
            ]
        });
    };

    return {
        // public functions
        init: function () {
            init();
        },
        setHeading: function (arrHeading) {
            setHeading(arrHeading);
        }
    };
}();

// On document ready

KTUtil.ready(function () {
    KTAppOrderDatatable.init();
    $('#search_order').keypress(function () {
        $.ajaxSetup({ global: false });
    });
});

