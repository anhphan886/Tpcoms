$('#attribute_group_option').select2();
$('#attribute_option').select2();
$(".numeric").numeric({ decimal : ".",  negative : false, scale: 1 });

var productAdd = {
    abc: {},
    removeTr: function (t) {
        $(t).closest('tr').remove();
    },
    addAttribute: function () {
        var attributeGroup = $('#attribute_group_option').val();
        var arrayIdAttribute = [0];
        $('.id_attribute').each(function () {
            arrayIdAttribute.push($(this).val());
        });
        productAdd.getOptionAttribute(attributeGroup, arrayIdAttribute);

        $('#attribute_option').empty();
        if (productAdd.abc.length > 0) {
            $.each(productAdd.abc, function (key, value) {
                if ($('#language').val() == 'vi') {
                    $('#attribute_option').append('<option value="' + value.product_attribute_id + '">' + value.product_attribute_name_vi + '</option>');
                } else {
                    $('#attribute_option').append('<option value="' + value.product_attribute_id + '">' + value.product_attribute_name_en + '</option>');
                }
            });
        } else {
            if ($('#language').val() == 'vi') {
                $('#attribute_option').append('<option value="0">' + 'Chọn thuộc tính' + '</option>');
            } else {
                $('#attribute_option').append('<option value="0">' + 'Choose attribute' + '</option>');
            }
        }
        $('#modal_add_product').modal('show');
        $(".numeric").numeric({ decimal : ".",  negative : false, scale: 1 });
    },
    getAttribute: function (t) {
        var groupId = $(t).val();
        var arrayIdAttribute = [0];
        $('.id_attribute').each(function () {
            arrayIdAttribute.push($(this).val());
        });
        productAdd.getOptionAttribute(groupId, arrayIdAttribute);
        $('#attribute_option').empty();
        if (productAdd.abc.length > 0) {
            $.each(productAdd.abc, function (key, value) {
                if ($('#language').val() == 'vi') {
                    $('#attribute_option').append('<option value="' + value.product_attribute_id + '">' + value.product_attribute_name_vi + '</option>');
                } else {
                    $('#attribute_option').append('<option value="' + value.product_attribute_id + '">' + value.product_attribute_name_en + '</option>');
                }
            });
        } else {
            if ($('#language').val() == 'vi') {
                $('#attribute_option').append('<option value="0">' + 'Chọn thuộc tính' + '</option>');
            } else {
                $('#attribute_option').append('<option value="0">' + 'Choose attribute' + '</option>');
            }
        }
    },
    getOptionAttribute: function (attributeGroup, arrayIdAttribute) {
        $.ajax({
            url: laroute.route('product.product.get-option-attribute'),
            method: "POST",
            async: false,
            data: {
                attributeGroup: attributeGroup,
                arrayIdAttribute: arrayIdAttribute
            },
            success: function (res) {
                productAdd.abc = res;
            }
        });
    },
    chooseAttribute: function (t) {
        var idAttribute = $(t).parents('.modal-content').find('#attribute_option').val();
        var min = $(t).parents('.modal-content').find('#min');
        var max = $(t).parents('.modal-content').find('#max');
        var jump = $(t).parents('.modal-content').find('#jump');
        var attribute_option = $('#attribute_option').val();
        var error_choose_attribute = $('.error_choose_attribute');
        var error_min = $('.error_min');
        var error_max = $('.error_max');
        var error_jump = $('.error_jump');
        var flag = true;
        $.getJSON(laroute.route('product.validation'), function (json) {
            if (attribute_option == 0) {
                flag = false;
                error_choose_attribute.text(json.product.enter_attribute);
            } else {
                error_choose_attribute.text('');
            }
            if (min.val() == '') {
                flag = false;
                error_min.text(json.product.enter_min);
            } else {
                if (min.val() < 0) {
                    flag = false;
                    error_min.text(json.product.please_enter);
                } else {
                    error_min.text('');
                }
            }

            if (max.val() == '') {
                flag = false;
                error_max.text(json.product.enter_max);
            } else {
                if (parseFloat(min.val()) >= parseFloat(max.val())) {
                    flag = false;
                    error_max.text(json.product.please_enter + " ( Max > Min )");
                } else {
                    error_max.text('');
                }
            }
            if (jump.val() == '' || jump.val() == 0) {
                flag = false;
                error_jump.text(json.product.enter_jump);
            } else {
                error_jump.text('');
            }
            if (flag == true) {
                $.ajax({
                    url: laroute.route('product.product.get-detail-attribute'),
                    method: "POST",
                    data: {idAttribute: idAttribute},
                    success: function (res) {
                        let stt = 1;
                        $('.id_attribute').each(function () {
                            stt++;
                        });
                        let tpl = $('#tpl-tr-attribute').html();
                        tpl = tpl.replace(/{stt}/g, stt);
                        tpl = tpl.replace(/{attribute_code}/g, res.product_attribute_code);
                        tpl = tpl.replace(/{id_attribute}/g, res.product_attribute_id);
                        if ($('#language').val() == 'vi') {
                            tpl = tpl.replace(/{attribute}/g, res.product_attribute_name_vi);
                        } else {
                            tpl = tpl.replace(/{attribute}/g, res.product_attribute_name_en);
                        }
                        tpl = tpl.replace(/{unit}/g, res.unit_name);
                        tpl = tpl.replace(/{min}/g, parseFloat(min.val()));
                        tpl = tpl.replace(/{max}/g, parseFloat(max.val()));
                        tpl = tpl.replace(/{jump}/g, parseFloat(jump.val()));

                        tpl = tpl.replace(/{product_attribute_code}/g, res.product_attribute_code);
                        tpl = tpl.replace(/{price_month}/g, res.price_month);
                        tpl = tpl.replace(/{price_year}/g, res.price_year);
                        tpl = tpl.replace(/{unit_name}/g, res.unit_name);

                        $('#tb-list-attribute > tbody').prepend(tpl);
                        min.val('');
                        max.val('');
                        jump.val('');
                        $('#modal_add_product').modal('hide');
                        $(".numeric").numeric({ decimal : ".",  negative : false, scale: 1 });
                    }
                });
            }
        });

    },
    keyUpValue: function (t) {
        var test_value = $(t).val().replace(/\,/g, "");
        // $(t).val(test_value);
        // console.log(test_value)
        // var test_value2 = $(t).val().replace(/\-/g, "");
        // $(t).val(test_value2);
        // var test_value3 = $(t).val().replace(/\+/g, "");
        // $(t).val(test_value3);
    },
    uploadAvatar: function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#div-image').empty();
                var tpl = $('#image-tpl').html();
                tpl = tpl.replace(/{link}/g, e.target.result);
                $('#div-image').append(tpl);
            };
            reader.readAsDataURL(input.files[0]);
            var file_data = $('#getFileImage').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);
            var fsize = input.files[0].size;
            var img = new Image();

            if (Math.round(fsize / 1024) <= 10240) {
                $('.error_img').text('');
                $.ajax({
                    url: laroute.route("product.product.uploads-image"),
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        if (res != 'error') {
                            $('#image-avatar').val(res);
                        }
                    }
                });
            }
        }
    },
    save: function () {
        var form = $('#form-submit');
        $.getJSON(laroute.route('product.validation'), function (json) {
            form.validate({
                rules: {
                    product_category_id: {
                        required: false
                    },
                    product_name_vi: {
                        required: true,
                        maxlength:255
                    },
                    product_name_en: {
                        required: true,
                        maxlength:255
                    },
                    description: {
                        maxlength:255
                    }
                },
                messages: {
                    product_category_id: {
                        required: json.product.enter_product_category
                    },
                    product_name_vi: {
                        required: json.product.enter_product_name_vi,
                        maxlength: json.product.maxlength,
                    },
                    product_name_en: {
                        required: json.product.enter_product_name_en,
                        maxlength: json.product.maxlength,
                    },
                    description: {
                        maxlength: json.product.maxlength,
                    },
                }
            });
            if (form.valid()) {
                var product_id = $('#product_id').val();
                var product_category_id = $('#product_category_id').val();
                var product_name_vi = $('#product_name_vi').val();
                var product_name_en = $('#product_name_en').val();
                var description = $('#description').val();
                var avatar = $('#image-avatar').val();
                var arrayAttribute = [];
                var is_active = 0;
                if ($('#is_active').is(':checked')) {
                    is_active = 1;
                }
                var flag = true;
                $('#tb-list-attribute tbody tr').each(function () {
                    var temp = {};
                    var attribute_id = $(this).find('.input_id_attribute').val();
                    var product_attribute_code = $(this).find('.input_product_attribute_code').val();
                    var price_month = $(this).find('.input_price_month').val();
                    var price_year = $(this).find('.input_price_year').val();
                    var unit_name = $(this).find('.input_unit_name').val();
                    var min = $(this).find('.input_min').val();
                    var max = $(this).find('.input_max').val();
                    var jump = $(this).find('.input_jump').val();

                    var error_min = $(this).find('.input_min').parents('td').find('span');
                    var error_max = $(this).find('.input_max').parents('td').find('span');
                    var error_jump = $(this).find('.input_jump').parents('td').find('span');

                    if (min == '') {
                        error_min.text(json.product.enter_min);
                        flag = false;
                    } else {
                        error_min.text('');
                    }
                    if (max == '') {
                        error_max.text(json.product.enter_max);
                        flag = false;
                    } else {
                        error_max.text('');
                    }
                    if (jump == '' || jump == 0 || jump == 0.0) {
                        error_jump.text(json.product.enter_jump);
                        flag = false;
                    } else {
                        if (parseFloat(jump) > parseFloat(max)) {
                            error_jump.text(json.product.enter_jump);
                            flag = false;
                        } else {
                            error_jump.text('');
                        }
                    }

                    if (parseFloat(min) >= parseFloat(max)) {
                        error_max.text(json.product.please_enter + " ( Max > Min )");
                        flag = false;
                    } else {
                        error_max.text('');
                    }

                    temp = {
                        attribute_id: attribute_id,
                        product_attribute_code: product_attribute_code,
                        price_month: price_month,
                        price_year: price_year,
                        unit_name: unit_name,
                        min: min,
                        max: max,
                        jump: jump,
                    };
                    arrayAttribute.push(temp);
                });
                if (flag == true) {
                    if (arrayAttribute.length > 0) {
                        var arrayGroup = [];
                        $('.input_attribute_group').each(function () {
                            arrayGroup.push($(this).val());
                        });
                        $.ajax({
                            url: laroute.route('product.product.update'),
                            method: "POST",
                            data: {
                                product_id: product_id,
                                product_category_id: product_category_id,
                                product_name_vi: product_name_vi,
                                product_name_en: product_name_en,
                                description: description,
                                avatar: avatar,
                                is_active: is_active,
                                arrayAttribute: arrayAttribute,
                                arrayGroup: arrayGroup,
                            },
                            success: function (res) {
                                if (res.error == false) {
                                    swal.fire(res.message, "", "success").then(function () {
                                        window.location.href = laroute.route('product.product');
                                    });
                                }else{
                                    swal.fire(res.message, "", "error").then(function () {
                                        window.location.reload();
                                        // window.location.href = laroute.route('product.product');
                                    });
                                }
                            },
                            error: function (res) {console.log('err', res); return;
                                var mess_error = '';
                                jQuery.each(res.responseJSON.errors, function (key, val) {
                                    mess_error = mess_error.concat(val + '<br/>');
                                });
                                swal.fire(mess_error, "", "error");
                            }
                        });
                    } else {
                        swal.fire(json.product_template.choose_attribute, "", "error");
                    }
                }
            }
        });
    },
    formatInputNumber: function (t) {
        if ($(t).val() == '') {
            $(t).val(0);
        } else {
            $(t).val(parseFloat($(t).val()));
        }
    },
    clickInput: function (t) {
        var val = $(t).val();
        $(t).focus().val("").val(val);
    }
};
