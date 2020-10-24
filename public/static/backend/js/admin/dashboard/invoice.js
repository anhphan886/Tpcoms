"use strict";
// Class definition

var KTAppInvoiceDatatable = function () {
    // variables
    var datatable;
    // init
    var init = function () {
        $('.kt-selectpicker').selectpicker();
        datatable = $('#datatable_list_invoice').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'POST',
                        headers: {},
                        url: laroute.route('admin.dashboard.list-invoice'),
                        map: function (raw) {
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
                serverPaging: !0,
                serverFiltering: !0,
                serverSorting: 0
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
            sortable: !0,
            toolbar: {
                placement: ["bottom"], items: {
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
                input: $('#search_invoice'),
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
                    field: 'invoice_no',
                    title: 'Mã hoá đơn',
                    sortable: false,
                    template: function (row) {
                        let link = laroute.route('product.invoice.show', {id: row.invoice_no});
                        return '<a href="' + link + '" class="m-link m--font-bolder">' + row.invoice_no + '</a>';
                    }
                },
                {
                    field: 'invoice_number',
                    title: 'Mã chứng từ',
                    sortable: false,
                },
                {
                    field: 'customer_name',
                    title: 'Tên khách hàng',
                    sortable: false,
                },
                {
                    field: 'status',
                    title: 'Trạng thái đơn hàng',
                    filterable: false, // disable or enablePOP filtering
                    textAlign: 'center',
                    sortable: false,
                    template: function (t) {
                        var a = {
                                "new": {
                                    title: 'Chưa xuất',
                                    class: " m-badge--primary kt-padding-10 color-green",
                                },
                                "finish": {
                                    title: 'Đã xuất',
                                    class: " m-badge--info kt-padding-10 color-brown",
                                },
                                "cancel": {
                                    title: 'Đã hủy',
                                    class: " m-badge--warning kt-padding-10 color-red",
                                },
                            }
                        ;
                        return '<span class="m-badge ' + a[t.status].class + ' m-badge--wide">' + a[t.status].title + "</span>"

                    }
                },
                {
                    field: 'receipt_status',
                    title: 'Trạng thái phiếu thu',
                    filterable: false, // disable or enablePOP filtering
                    textAlign: 'center',
                    sortable: false,
                    template: function (t) {
                        var a = {
                                "paid": {
                                    title: 'Đã thanh toán',
                                    class: " m-badge--primary kt-padding-10 color-green",
                                },
                                "unpaid": {
                                    title: 'Chưa thanh toán',
                                    class: " m-badge--info kt-padding-10 color-red",
                                },
                                "refund": {
                                    title: 'Hoàn tiền',
                                    class: " m-badge--warning kt-padding-10 color-yellow",
                                },
                                "part-paid": {
                                    title: 'Còn nợ',
                                    class: " m-badge--warning kt-padding-10 text-warning",
                                },
                                "cancel": {
                                    title: 'Hủy',
                                    class: " m-badge--warning kt-padding-10 color-brown",
                                },
                            };

                        return '<span class="m-badge ' + a[t.receipt_status].class + ' m-badge--wide">' + a[t.receipt_status].title + "</span>"

                    }
                },
                {
                    field: 'amount',
                    title: 'Thành tiền (VNĐ)',
                    textAlign: 'right',
                    template: function (row) {
                        return '<span class="m--font-bolder">' + parseInt(row.amount).toLocaleString() + '</span>';
                    }
                },
                {
                    field: 'create_full_name',
                    title: 'Người xuất hoá đơn',
                    sortable: false,
                },
                {
                    field: 'invoice_at',
                    title: 'Ngày xuất',
                    sortable: false,
                    template: function (row) {
                        let date = '';
                        if(row.invoice_at != null) {
                            let d = new Date(row.invoice_at);
                            let day = d.getDate();
                            let month = d.getMonth() + 1;
                            let year = d.getFullYear();
                            if (day < 10) {
                                day = "0" + day;
                            }
                            if (month < 10) {
                                month = "0" + month;
                            }
                            date = day + "/" + month + "/" + year;
                        }
                        return '<span>' + date + '</span>';
                    }
                },
            ]
        });
    };

    return {
        // public functions
        init: function () {
            init();
        },
    };
}();

// On document ready

KTUtil.ready(function () {
    KTAppInvoiceDatatable.init();
    $('#search_invoice').keypress(function () {
        $.ajaxSetup({global: false});
    });
});

