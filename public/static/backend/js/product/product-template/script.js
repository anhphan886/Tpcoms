$('.ss-select-2').select2();
var product = {
    remove: function (id) {
        $.getJSON(laroute.route('product.validation'), function (json) {
            Swal.fire({
                title: json.product_template.TITLE_POPUP,
                html: json.product_template.HTML_POPUP,
                buttonsStyling: false,

                confirmButtonText: json.product_template.YES_BUTTON,
                confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",

                showCancelButton: true,
                cancelButtonText: json.product_template.CANCEL_BUTTON,
                cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: laroute.route('product.product.destroy'),
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function (res) {
                            console.log(res);
                            if (res.error === 0) {
                                swal.fire(res.message, "", "success").then(function () {
                                    location.reload();
                                });
                            } else {
                                swal.fire("Lỗi!", res.message, "error");
                            }
                        }
                    });
                }
            });
        });
    },
};
