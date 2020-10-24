"use strict";
// Class definition

var KTAppExpireNotCanceledDatatable = function () {
    // variables
    var datatable;
    var heading;

    var setHeading = function (arrHeading) {
        heading = arrHeading;
    };
    // init
    var init = function () {
        $('.kt-selectpicker').selectpicker();
        datatable = $('#datatable_list_expire_not_canceled').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'POST',
                        headers: {},
                        url: laroute.route('admin.dashboard.get-list-service-expire-not-canceled'),
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
                input: $('#search_expire_not_canceled'),
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
                    textAlign: 'left',
                    template: function (row, index, datatable) {
                        return (index + 1 + (datatable.getCurrentPage()) * datatable.getPageSize()) - datatable.getPageSize();
                    }

                },
                {
                    field: 'customer_name',
                    title: heading.customer,
                    sortable: false,
                },
                {
                    field: 'name',
                    title: heading.service,
                    sortable: false,
                    template: function (row) {
                        let link = laroute.route('product.service.show', {id: row.customer_service_id});
                        return '<a href="' + link + '" class="m-link m--font-bolder link">' + row.name + '</a>';
                    }
                },
                {
                    field: 'type',
                    title: heading.serviceCategory,
                    sortable: false,
                    template: function (row) {
                        let type = '';
                        if (row.type == 'trial') {
                            type = heading.trial;
                        } else if (row.type == 'real') {
                            type = heading.real;
                        }
                        return type;
                    }
                },
                {
                    field: 'status',
                    title: heading.status_tt,
                    sortable: false,
                    template: function (row) {
                        let status = '';
                        if (row.status == 'not_actived') {
                            status = heading.not_actived;
                        } else if (row.status == 'actived') {
                            status = heading.actived;
                        } else if (row.status == 'spending') {
                            status = heading.spending;
                        } else if (row.status == 'cancel') {
                            status = heading.cancel;
                        }
                        return status;
                    }
                },
                {
                    field: 'actived_date',
                    title: heading.actived_date,
                    sortable: false,
                    template: function (row) {
                        let d = new Date(row.actived_date);
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
                    field: 'expired_date',
                    title: heading.expired_date,
                    sortable: false,
                    template: function (row) {
                        let d = new Date(row.expired_date);
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
    KTAppExpireNotCanceledDatatable.init();
});

