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
    // if(!res.data){return;},
    var init = function () {
        $('#datatable_list_order').selectpicker();
        datatable = $('#datatable_list_order').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'POST',
                        headers: {},
                        url: laroute.route('product.customer.list-order'),
                        params: {
                            customer_id: $('#customer_id_hidden').val()
                        },
                        map: function (raw) {
                            // console.log(1, raw);
                            // sample data mapping
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },
                pageSize: !5,
                serverPaging: !0,
                serverFiltering: !0,
                serverSorting: 0
            },

            // layout definition
            layout: {
                theme: "default",
                class: "table table-striped",
                scroll: true,
                height: "auto",
                footer: 0
            },

            // column sorting
            sortable: !0,
            toolbar: {
                placement: ["bottom"], items: {
                    pagination: {
                        pageSizeSelect: [5, 10]
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
                    title: 'Mã đơn hàng',
                    sortable: false,
                    template: function (row) {
                        return '<a class="m-link m--font-bolder">' + row.order_code + '</a>';
                    }
                },
                {
                    field: 'total',
                    title: 'Tổng tiền',
                    sortable: false,
                    template: function (row) {
                        return '<span class="m--font-bolder">' + parseInt(row.total).toLocaleString() + ' VNĐ</span>';
                    }
                },
                {
                    field: 'discount',
                    title: 'Tiền giảm',
                    sortable: false,
                    template: function (row) {
                        if (row.discount != null && row.discount != null) {
                            return '<span class="m--font-bolder">' + parseInt(row.discount).toLocaleString() + ' VNĐ </span>';
                        } else {
                            return '<span>' + '0' + ' ' + 'VNĐ </span>';
                        }
                    }
                },
                {
                    field: 'vat',
                    title: 'VAT',
                    sortable: false,
                    template: function (row) {
                        return '<span class="m--font-bolder">' + parseInt(row.vat).toLocaleString() + ' VNĐ</span>';
                    }
                },
                {
                    field: 'amount',
                    title: 'Tổng tiền thanh toán',
                    sortable: false,
                    template: function (row) {
                        return '<span class="m--font-bolder">' + parseInt(row.amount).toLocaleString() + ' VNĐ</span>';
                    }
                },
                {
                    field: 'voucher_code',
                    title: 'Mã voucher',
                    sortable: false,
                    template: function (row) {
                        let voucher_code = '';
                        if (row.voucher_code == '') {
                            voucher_code = '';
                        } else if (row.voucher_code == row.voucher_code) {
                            voucher_code = row.voucher_code;
                        }
                        return voucher_code;
                    }
                },
                {
                    field: 'order_status_name_vi',
                    title: 'Trạng thái',
                    filterable: false, // disable or enablePOP filtering
                    textAlign: 'center',
                    sortable: false,
                    template: function (t) {
                        var a = {
                                "1": {
                                    title: t.order_status_name_vi,
                                    // class: " m-badge--primary btn-new kt-padding-10",
                                },
                                "2": {
                                    title: t.order_status_name_vi,
                                    // class: " m-badge--info btn-accepted kt-padding-10",
                                },
                                "3": {
                                    title: t.order_status_name_vi,
                                    // class: " m-badge--warning btn-waiting-payment kt-padding-10",
                                },
                                "4": {
                                    title: t.order_status_name_vi,
                                    // class: " m-badge--success btn-finished kt-padding-10",
                                },
                                "5": {
                                    title: t.order_status_name_vi,
                                    // class: " m-badge--danger btn-cancelled kt-padding-10",
                                },
                                "6": {
                                    title: t.order_status_name_vi,
                                },
                            }
                        ;
                        // return '<span class="m-badge ' + '' + ' m-badge--wide">' + '' + "</span>"

                        return '<span class="m-badge ' + a[t.order_status_id].class + ' m-badge--wide">' + a[t.order_status_id].title + "</span>"
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
        $.ajaxSetup({global: false});
    });
});

var tab = {
    tab_order: function () {
        $('#search_order').trigger('keyup');
    },
    tab_service: function () {
        $('#search_service').trigger('keyup');
    },
    tab_contract: function () {
        $('#search_contract').trigger('keyup');
    },
    tab_receipt: function () {
        $('#search_receipt').trigger('keyup');
    },
    tab_childAccount: function () {
        $('#search_childAccount').trigger('keyup');
    }
}

