"use strict";
// Class definition

var KTAppServiceDatatable = function () {
    // variables
    var datatable;
    var heading;

    var setHeading = function (arrHeading) {
        heading = arrHeading;
    };
    // init
    var init = function () {
        $('#datatable_list_service').selectpicker();
        datatable = $('#datatable_list_service').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'POST',
                        headers: {},
                        url: laroute.route('product.customer.list-service'),
                        params: {
                            customer_id: $('#customer_id_hidden').val()
                        },
                        map: function(raw) {
                            // sample data mapping
                            console.log(2, raw);
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
                input: $('#search_service'),
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
                    field: 'customer_service_id',
                    title: 'Mã dịch vụ',
                    sortable: false,
                    template: function (row) {
                        return '<a class="m-link m--font-bolder">'+row.customer_service_id+'</a>';
                    }
                },
                // {
                //     field: 'payment_type',
                //     title: 'Hình thức thanh toán',
                //     sortable: false,
                //     template: function (row) {
                //         let payment_type = '';
                //         if (row.payment_type == 'postpaid') {
                //             payment_type = 'Trả sau';
                //         } else if (row.payment_type == 'prepaid') {
                //             payment_type = 'Trả trước';
                //         } else if (row.payment_type == 'payuse') {
                //             payment_type = 'Thanh toán song song';
                //         }
                //         return payment_type;
                //     }
                // },
                {
                    field: 'type',
                    title: 'Loại dịch vụ',
                    sortable: false,
                    template: function (row) {
                        let type = '';
                        let payment_type = '';
                        if ( row.type == 'trial') {
                            type = 'Dùng thử';
                            return type;
                        } else {
                            if (row.payment_type == 'postpaid') {
                                payment_type = 'Trả sau';
                            } else if (row.payment_type == 'prepaid') {
                                payment_type = 'Trả trước';
                            } else if (row.payment_type == 'payuse') {
                                payment_type = 'Thanh toán song song';
                            }
                            return payment_type;
                        }
                    }
                },
                {
                    field: 'quantity',
                    title: 'Số tháng sử dụng',
                    sortable: false,
                    template: function (row) {
                        return '<span class="m--font-bolder">' + parseInt(row.quantity).toLocaleString() + '</span>';
                    }
                },
                {
                    field: 'price',
                    title: 'Đơn giá',
                    sortable: false,
                    template: function (row) {
                        return '<span class="m--font-bolder">' + parseInt(row.price).toLocaleString() + ' VNĐ</span>';
                    }
                },
                {
                    field: 'amount',
                    title: 'Thành tiền',
                    sortable: false,
                    template: function (row) {
                        return '<span class="m--font-bolder">' + parseInt(row.amount).toLocaleString() + ' VNĐ</span>';
                    }
                },
                {
                    field: 'status',
                    title: 'Trạng thái',
                    sortable: false,
                    template: function (row) {
                        let status = '';
                        if (row.status == 'not_actived') {
                            status = 'Chưa kích hoạt';
                        } else if (row.status == 'actived') {
                            status = 'Đã kích hoạt';
                        } else if (row.status == 'spending') {
                            status = 'Đang sử dụng';
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
    KTAppServiceDatatable.init();
    $('#search_service').keypress(function () {
        $.ajaxSetup({ global: false });
    });
});

