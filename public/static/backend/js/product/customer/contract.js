"use strict";
// Class definition

var KTAppContractDatatable = function () {
    // variables
    var datatable;
    var heading;

    var setHeading = function (arrHeading) {
        heading = arrHeading;
    };
    // init
    var init = function () {
        $('#datatable_list_contract').selectpicker();
        datatable = $('#datatable_list_contract').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'POST',
                        headers: {},
                        url: laroute.route('product.customer.list-contract'),
                        params: {
                            customer_id: $('#customer_id_hidden').val()
                        },
                        map: function(raw) {
                            console.log(3, raw);
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
                input: $('#search_contract'),
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
                    field: 'contract_no',
                    title: 'Mã hợp đồng',
                    sortable: false,
                    template: function (row) {
                        return '<a class="m-link m--font-bolder">'+row.contract_no+'</a>';
                    }
                },
                {
                    field: 'link_file',
                    title: 'Filer hợp đồng mẫu',
                    sortable: false,
                    template: function (row) {
                        if (row.link_file != null && row.link_file != null) {
                            return '<a href="'+ linkApi + row.link_file +'" class="m-link m--font-bolder">' + row.link_file + '</a>';
                            // return  row.link_file;
                        } else {
                            return '<span></span>';
                        }
                    }
                },
                {
                    field: 'contract_date',
                    title: 'Ngày ký',
                    sortable: false,
                    template: function (row) {
                        return '<a class="m-link m--font-bolder">'+row.contract_date+'</a>';
                    }
                },
                {
                    field: 'status',
                    title: 'Trạng thái',
                    sortable: false,
                    template: function (row) {
                        let status = '';
                        if (row.status == 'new') {
                            status = 'Mới tạo';
                        } else if (row.status == 'waiting_sign') {
                            status = 'Chờ ký tên';
                        } else if (row.status == 'waiting_approved') {
                            status = 'Chờ duyệt';
                        } else if (row.status == 'approved') {
                            status = 'Đã duyệt';
                        } else if (row.status == 'approved_cancel') {
                            status = 'Đã huỷ';
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
    KTAppContractDatatable.init();
    $('#search_contract').keypress(function () {
        $.ajaxSetup({ global: false });
    });
});

