$(document).ready(function () {
    $('.invoice_by').select2();
    $('#reduce_percent').on('keyup', e => {
        let val = $('#reduce_percent').val();
        if(isNaN(Number(val)) || !(Number(val) >= 0 && Number(val) <= 100)){
            let newVal = $('#reduce_percent').val().substr(0, $('#reduce_percent').val().length-1);
            if(isNaN(Number(newVal)) || !(Number(newVal) >= 0 && Number(newVal) <= 100)){
                $('#reduce_percent').val('');
            }else{
                $('#reduce_percent').val(Number(newVal));
            }
        }else{
            $('#reduce_percent').val(Number(newVal));
        }
    })
});

var objInvoice = {
    save: function (){
        var form = $('#form_invoice');
        $.getJSON(laroute.route('product.validation'), function (json) {
            if($('#status').val() == 'new' || $('#status').val() == 'cancel'){
                form.validate({
                    rules: {
                        invoice_at: {
                            required : false
                        },
                        invoice_by: {
                            required: false
                        },
                        // // status: {
                        // //     required: true
                        // // },
                        // invoice_number: {
                        //     required: true
                        // }
                    },
                    messages: {
                        invoice_at: {
                            required: json.invoice.invoice_at_required
                        },
                        invoice_by: {
                          required: json.invoice.invoice_by_required
                        },
                        // // status: {
                        // //   required: json.invoice.status_required
                        // //   // required: "123"
                        // // },
                        // invoice_number: {
                        //     required: json.invoice.invoice_number_required
                        //     // required: "123"
                        // },
                    }
                });
            }else{
                form.validate({
                    rules: {
                        invoice_at: {
                            required : true
                        },
                        invoice_by: {
                            required: true
                        },
                        // // status: {
                        // //     required: true
                        // // },
                        // invoice_number: {
                        //     required: true
                        // }
                    },
                    messages: {
                        invoice_at: {
                            required: json.invoice.invoice_at_required
                        },
                        invoice_by: {
                        required: json.invoice.invoice_by_required
                        },
                        // // status: {
                        // //   required: json.invoice.status_required
                        // //   // required: "123"
                        // // },
                        // invoice_number: {
                        //     required: json.invoice.invoice_number_required
                        //     // required: "123"
                        // },
                    }
                });
            }
            if(form.valid()) {
                let url = laroute.route('product.invoice.update');
                $.ajax({
                   url: url,
                   method: 'POST',
                   dataType: 'JSON',
                   data: form.serialize(),
                    // if(!res.data){return;},
                   success: function (res) {
                       if (!res.error) {
                           swal.fire(res.message, "", "success").then(function () {
                              window.location.href = laroute.route('product.invoice') ;
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
    }
}
