var annex = {
    save: function () {
        var form = $('#form-submit');
        $.getJSON(laroute.route('product.validation'), function () {
            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.annex.update'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function (res) {
                        if (!res.error) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.annex');
                            });
                        } else {
                            swal.fire(res.message, "", "error");
                        }
                    },
                    error: function (res) {
                        var mess_error = '';
                        jQuery.each(res.responseJSON.errors, function (key, val) {
                            mess_error = mess_error.concat(val + '<br/>');
                        });
                        swal.fire(mess_error, "", "error");
                    }
                });
            }
        });

    },
};
