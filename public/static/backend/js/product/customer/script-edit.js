var customerAccount = {
    checkPositiveNumer : (number) => {
        let num = Number(number);
        return !isNaN(num) && num >= 0;
    },
  editCustomer : function () {
      jQuery.validator.addMethod("phone", function(phone_number, element) {
          phone_number = phone_number.replace(/\s+/g, "");
          return this.optional(element) || phone_number.length > 9 &&
              phone_number.match(/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/);
      });
      $.validator.addMethod("validatePassword", function (value, element) {
          return this.optional(element) || /^(?=.*\d)(?=.*[a-z])[0-9a-zA-Z!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{8,}$/i.test(value);
      });
      var form = $('#edit-customer');
      $.getJSON(laroute.route('product.validation'), function (json) {
          form.validate({
              rules: {
                  customer_name: {
                      required: true,
                      maxlength:255
                  },
                  customer_id_num: {
                      required: true,
                      maxlength:255
                  },
                  customer_type: {
                      required: true,
                  },
                  segment_id: {
                      required: true,
                  },
                  province_id: {
                      required: true,
                  },
                  district_id: {
                      required: true,
                  },
                  customer_phone: {
                      required: true,
                      number: true,
                      phone: true,
                      maxlength:255
                  },
                  customer_phone2: {
                      number: true,
                      phone: true,
                      maxlength:255
                  },

                  customer_website: {
                      maxlength:255
                  },
                  customer_address_desc: {
                      required: true,
                      maxlength:255
                  },
              },
              messages: {
                  customer_name: {
                      required: json.customer.enter_customer_name,
                      maxlength: json.product.maxlength,
                  },
                  customer_id_num: {
                      required: json.customer.enter_customer_id_num,
                      maxlength: json.product.maxlength,
                  },
                  customer_type: {
                      required: json.customer.enter_customer_type,
                  },
                  segment_id: {
                      required: json.customer.enter_segment,
                  },
                  province_id: {
                      required: json.customer.enter_province_id,
                  },
                  district_id: {
                      required: json.customer.enter_district_id,
                  },
                  customer_phone: {
                      number: json.customer.type_phone,
                      required: json.customer.enter_customer_phone,
                      maxlength: json.customer.maxlength_phone,
                      phone: json.customer.phone,
                  },
                  customer_phone2: {
                      number: json.customer.type_phone,
                      maxlength: json.customer.maxlength_phone,
                      phone: json.customer.phone,
                  },
                  customer_website:{
                      maxlength:json.product.maxlength,
                  },
                  customer_address_desc:{
                      required: json.customer.enter_customer_address,
                      maxlength:json.product.maxlength,
                  },
              }
          });
          if (form.valid()) {
              if(!customerAccount.checkPositiveNumer($('#block_service_time').val())){
                swal.fire("Thời gian khóa dịch vụ sau khi trễ phiếu thu nên là số nguyên dương", "", "error");
                return;
              }
      $.ajax({
          url: laroute.route('product.customer.editPost'),
          method: 'POST',
          dataType: 'JSON',
          data: $('#edit-customer').serialize(),
          success: function (res) {
              if (res.message.error == false) {
                  swal.fire(res.message.message, "", "success").then(function () {
                      window.location.href = laroute.route('product.customer');
                  });
              } else{
                  swal.fire("Lỗi", "", "error").then(function () {
                  });
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
    save: function () {
        $.validator.addMethod("validatePhone", function(phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/);
        });
        $.validator.addMethod("validatePassword", function (value, element) {
            return this.optional(element) || /^(?=.*\d)(?=.*[a-z])[0-9a-zA-Z!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{8,}$/i.test(value);
        });
        var form = $('#save-customer');
        $.getJSON(laroute.route('product.validation'), function (json) {
            form.validate({
                rules: {
                    customer_name: {
                        required: true,
                        maxlength:255
                    },
                    customer_id_num: {
                        required: true,
                        maxlength:12
                    },
                    customer_type: {
                        required: true,
                    },
                    segment_id: {
                        required: true,
                    },
                    province_id: {
                        required: true,
                    },
                    district_id: {
                        required: true,
                    },
                    customer_phone: {
                        required: true,
                        number: true,
                        validatePhone: true,
                        maxlength:255
                    },
                    customer_phone2: {
                        number: true,
                        validatePhone: true,
                        maxlength:255
                    },
                    customer_email: {
                        email: true,
                        required: true,
                        maxlength:255
                    },
                    account_password: {
                        required: true,
                        maxlength:20,
                        validatePassword:true
                    },
                    customer_website: {
                        maxlength:255
                    },
                    customer_address_desc: {
                        required: true,
                        maxlength:255
                    },
                    create_full_name: {
                        maxlength:255
                    },
                    created_at: {
                        maxlength:255
                    },
                    update_full_name: {
                        maxlength:255
                    },
                    modified_at: {
                        maxlength:255
                    },
                },
                messages: {
                    customer_name: {
                        required: json.customer.enter_customer_name,
                        maxlength: json.product.maxlength,
                    },
                    customer_id_num: {
                        required: json.customer.enter_customer_id_num,
                        maxlength: json.customer.cmnd_max,
                    },
                    customer_type: {
                        required: json.customer.enter_customer_type,
                    },
                    segment_id: {
                        required: json.customer.enter_segment,
                    },
                    province_id: {
                        required: json.customer.enter_province_id,
                    },
                    district_id: {
                        required: json.customer.enter_district_id,
                    },
                    customer_phone: {
                        number: json.customer.type_phone,
                        required: json.customer.enter_customer_phone,
                        maxlength: json.customer.maxlength_phone,
                        validatePhone: json.customer.phone,
                    },
                    customer_phone2: {
                        number: json.customer.type_phone,
                        maxlength: json.customer.maxlength_phone,
                        validatePhone: json.customer.phone,
                    },
                    customer_email: {
                        required: json.customer.enter_customer_email,
                        email: json.customer.format_email,
                        maxlength: json.product.maxlength,
                    },
                    account_password: {
                        required: json.customer.enter_account_password,
                        maxlength: json.customer.maxlength_password,
                        validatePassword: json.customer.account_password_regex,
                    },
                    customer_website:{
                        maxlength:json.product.maxlength,
                    },
                    customer_address_desc:{
                        required: json.customer.enter_customer_address,
                        maxlength:json.product.maxlength,
                    },
                }
            });
            if (form.valid()) {
                $.ajax({
                    url: laroute.route('product.customer.store'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: $('#save-customer').serialize(),
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('product.customer');
                            });
                        } else{
                            swal.fire(res.message, "", "error").then(function () {
                            });
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
