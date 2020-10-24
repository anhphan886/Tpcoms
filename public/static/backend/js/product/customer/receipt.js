"use strict";
// Class definition

var KTAppReceiptDatatable = function () {
    // variables
    var datatable;
    var heading;

    var setHeading = function (arrHeading) {
        heading = arrHeading;
    };
    // init
    var init = function () {
        $('#datatable_list_receipt').selectpicker();
        datatable = $('#datatable_list_receipt').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'POST',
                        headers: {},
                        url: laroute.route('product.customer.list-receipt'),
                        params: {
                            customer_id: $('#customer_id_hidden').val()
                        },
                        map: function(raw) {
                            // console.log(4, raw);
                            // sample data mapping
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },
                pageSize: 10,
                serverPaging:!0,
                serverFiltering:!0,
                serverSorting:0
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
            sortable:!0,
            toolbar: {
                placement:["bottom"], items: {
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
                input: $('#search_receipt'),
                delay: 100,
            },
            // columns definition
            columns: [
                {
                    field: '',
                    title: '#',
                    sortable: false, // disable sort for this column
                    width: 20,
                    selector: false,
                    // textAlign: 'center',
                    textAlign: 'left',
                    template: function (row, index, datatable) {
                        return (index + 1 + (datatable.getCurrentPage()) * datatable.getPageSize()) - datatable.getPageSize();
                    }

                },
                {
                    field: 'receipt_no',
                    title: 'Mã phiếu thu',
                    sortable: false,
                    template: function (row) {
                        return '<a class="m-link m--font-bolder">'+row.receipt_no+'</a>';
                    }
                },
                {
                    field: 'amount',
                    title: 'Tổng tiền',
                    sortable: false,
                    template: function (row) {
                        return '<span class="m--font-bolder">' + parseInt(parseInt(row.amount) + parseInt(row.vat)).toLocaleString() + ' VNĐ</span>';
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
                        let hour = d.getHours();
                        let minute = d.getMinutes();
                        let second =d.getSeconds();
                        if (day < 10) {
                            day = "0" + day;
                        }
                        if (month < 10) {
                            month = "0" + month;
                        }
                        if (hour < 10) {
                            hour = "0" + hour;
                        }
                        if (minute < 10) {
                            minute = "0" + minute;
                        }
                        if (second < 10) {
                            second = "0" + second;
                        }
                        let date = day + "/" + month + "/" + year + " " + hour + ":" + minute + ":" + second;
                        return '<span>' + date + '</span>';
                    }

                },
                {
                    field: 'receipt_content',
                    title: 'Nội dung phiếu thu',
                    sortable: false,
                    template: function (row) {
                        return '<a class="m-link m--font-bolder">'+row.receipt_content+'</a>';
                    }
                },
                {
                    field: 'status',
                    title: 'Trạng thái',
                    sortable: false,
                    template: function (row) {
                        let status = '';
                        if (row.status == 'unpaid') {
                            status = 'Chưa thanh toán';
                        } else if (row.status == 'paid') {
                            status = 'Đã thanh toán';
                        } else if (row.status == 'part-paid') {
                            status = 'Còn nợ';
                        } else if (row.status == 'refund') {
                            status = 'Hoàn tiền';
                        } else if (row.status == 'cancel') {
                            status = 'Huỷ';
                        }
                        return status;
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
        setHeading: function (arrHeading) {
            setHeading(arrHeading);
        }
    };
}();

// On document ready

KTUtil.ready(function () {
    KTAppReceiptDatatable.init();
    $('#search_receipt').keypress(function () {
        $.ajaxSetup({ global: false });
    });
});

