"use strict";
// Class definition

var KTAppReceiptDatatable = function () {
    // variables
    var datatable;

    // init
    var init = function () {
        $('.kt-selectpicker').selectpicker();
        datatable = $('#datatable_list_receipt').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'POST',
                        headers: {},
                        url: laroute.route('admin.dashboard.list-receipt'),
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
                input: $('#search_receipt'),
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
                    field: 'receipt_no',
                    title: 'Mã phiếu thu',
                    sortable: false,
                    template: function (row) {
                        let link = laroute.route('product.receipt.show', {code: row.receipt_no});
                        return '<a href="' + link + '" class="m-link m--font-bolder">' + row.receipt_no + '</a>';
                    }
                },
                {
                    field: 'customer_name',
                    title: 'Khách hàng',
                    sortable: false,
                },
                {
                    field: 'receipt_content',
                    title: 'Nội dung phiếu thu',
                    sortable: false,
                },
                {
                    field: 'created_at',
                    title: 'Ngày xuất phiếu thu',
                    sortable: false,
                    template: function (row) {
                        console.log(row)
                        let d = new Date(row.created_at);
                        let day = d.getDate();
                        let month = d.getMonth() + 1;
                        let year = d.getFullYear();
                        if (day < 10) {
                            day = "0" + day;
                        }
                        if (month < 10) {
                            month = "0" + month;
                        }
                        let date = day + "/" + month + "/" + year;
                        return '<span>' + date + '</span>';
                    }
                },
                {
                    field: 'amount',
                    title: 'Tổng tiền(VNĐ)',
                    textAlign: 'right',
                    template: function (row) {
                        let amount = parseInt(row.amount);
                        let vat = parseInt(row.vat);
                        return '<span class="m--font-bolder">' + parseInt(amount+vat).toLocaleString() + '</span>';
                    }
                },
                {
                    field: 'debt',
                    title: 'Còn nợ',
                    textAlign: 'right',
                    template: function (row) {
                        return '<span class="m--font-bolder">' + parseInt(row.debt).toLocaleString() + '</span>';
                    }
                },
                {
                    field: 'pay_expired',
                    title: 'Hạn thanh toán',
                    sortable: false,
                    template: function (row) {
                        let d = new Date(row.pay_expired);
                        let day = d.getDate();
                        let month = d.getMonth() + 1;
                        let year = d.getFullYear();
                        if (day < 10) {
                            day = "0" + day;
                        }
                        if (month < 10) {
                            month = "0" + month;
                        }
                        let date = day + "/" + month + "/" + year;
                        return '<span>' + date + '</span>';
                    }
                },
                {
                    field: 'status',
                    title: 'Trạng thái',
                    filterable: false, // disable or enablePOP filtering
                    textAlign: 'center',
                    sortable: false,
                    template: function (t) {
                        var a = {
                                "unpaid": {
                                    title: 'Chưa thanh toán',
                                    class: " m-badge--primary kt-padding-10 color-red",
                                },
                                "paid": {
                                    title: 'Đã thanh toán',
                                    class: " m-badge--info kt-padding-10 color-green",
                                },
                                "part-paid": {
                                    title: 'Còn nợ',
                                    class: " m-badge--warning kt-padding-10 text-warning",
                                },
                                "refund": {
                                    title: 'Hoàn tiền',
                                    class: " m-badge--success kt-padding-10 color-yellow",
                                },
                                "cancel": {
                                    title: 'Hủy',
                                    class: " m-badge--danger kt-padding-10 color-brown",
                                },
                            }
                        ;
                        return '<span class="m-badge ' + a[t.status].class + ' m-badge--wide">' + a[t.status].title + "</span>"

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
    };
}();

// On document ready

KTUtil.ready(function () {
    KTAppReceiptDatatable.init();
    $('#search_receipt').keypress(function () {
        $.ajaxSetup({global: false});
    });
});

var exportTab = {
    tab_receipt:function () {
        $('#search_receipt').keyup(function () {
            $.ajaxSetup({global: true});
        });
        $('#search_receipt').trigger('keyup');
        $('#search_receipt').keyup(function () {
            $.ajaxSetup({global: false});
        });
    },
    tab_invoice:function () {
        $('#search_invoice').keyup(function () {
            $.ajaxSetup({global: true});
        });
        $('#search_invoice').trigger('keyup');
        $('#search_invoice').keyup(function () {
            $.ajaxSetup({global: false});
        });
    },
};

