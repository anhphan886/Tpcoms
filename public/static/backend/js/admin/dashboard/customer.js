"use strict";
// Class definition

var KTAppCustomerDatatable = function () {
    // variables
    var datatable;
    var heading;

    var setHeading = function (arrHeading) {
        heading = arrHeading;
    };
    // init
    var init = function () {
        $('.kt-selectpicker').selectpicker();
        datatable = $('#datatable_list_customer').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'POST',
                        headers: {},
                        url: laroute.route('admin.dashboard.list-customer'),
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
                scroll: !0,
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
                input: $('#search_customer'),
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
                    field: 'customer_no',
                    title: heading.customer_code,
                    sortable: false,
                    template: function (row) {
                        let link = laroute.route('product.customer.detail', {id: row.customer_id});
                        return '<a href="' + link + '" class="m-link m--font-bolder">' + row.customer_no + '</a>';
                    }
                },
                {
                    field: 'customer_name',
                    title: heading.customer,
                    sortable: false,
                }, {
                    field: 'customer_id_num',
                    title: heading.cmnd_mst,
                    sortable: false,
                }, {
                    field: 'customer_type',
                    title: heading.type,
                    textAlign: 'center',
                    sortable: false,
                    template: function (row) {
                        if (row.customer_type == "personal") {
                            return '<span>' + heading.customer_personal + '</span>';
                        } else {
                            return '<span>' + heading.customer_enterprise + '</span>';
                        }
                    }
                }, {
                    field: 'province_name',
                    title: heading.province,
                    sortable: false,
                    template: function (row) {
                        if (row.province_type != null && row.province_name != null) {
                            return '<span>' + row.province_type + ' ' + row.province_name + '</span>';
                        } else {
                            return '<span></span>';
                        }
                    }
                },
                {
                    field: 'status',
                    title: 'Trạng thái',
                    textAlign: 'center',
                    sortable: false,
                    template: function (row) {
                        if (row.status == 'new') {
                            return '<span class="text-primary btn-new">' + heading.status_new + '</span>';
                        } else {
                            return '<span class="text-success btn-finished">' + heading.verified + '</span>';
                        }
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
    KTAppCustomerDatatable.init();
    $('#search_customer').keyup(function () {
        $.ajaxSetup({global: false});
    });
});

var functionDataTable = {
    tab_customer:function () {
        $('#search_customer').keyup(function () {
            $.ajaxSetup({global: true});
        });
        $('#search_customer').trigger('keyup');
        $('#search_customer').keyup(function () {
            $.ajaxSetup({global: false});
        });
    },
    tab_order:function () {
        $('#search_order').keyup(function () {
            $.ajaxSetup({global: true});
        });
        $('#search_order').trigger('keyup');
        $('#search_order').keyup(function () {
            $.ajaxSetup({global: false});
        });
    },
};

