$('#attribute_group_option').select2();
$('#attribute_option').select2();
$('#parent_id').select2();
$('#price_month').mask('000,000,000,000', {reverse: true});
$('#price_day').mask('000,000,000,000', {reverse: true});
$(".numeric").numeric({decimal: ".", negative: false, scale: 1});
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
        $(".numeric").numeric({decimal: ".", negative: false, scale: 1});
        $('#default_value').val(0);
        $('#modal_add_product').modal('show');
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
            url: laroute.route('product.product-template.get-option-attribute'),
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
        var noLimit = $(t).parents('.modal-content').find('#no_limit');
        var defaultValue = $(t).parents('.modal-content').find('#default_value');

        var attribute_option = $('#attribute_option').val();
        var error_choose_attribute = $('.error_choose_attribute');
        var error_default_value = $('.error_default_value');
        var no_limit = 0;
        var flag = true;
        $.getJSON(laroute.route('product.validation'), function (json) {
            var form = $('#form-modal-submit');
            form.validate({
                rules: {
                    default_value: {
                        required: true,
                        number: true
                    }
                },
                messages: {
                    default_value: {
                        required: json.product_template.enter_default_value,
                        number: json.product_template.please_enter
                    }
                }
            });
            if (form.valid()) {
                if (attribute_option == 0) {
                    flag = false;
                    error_choose_attribute.text(json.product_template.enter_attribute);
                } else {
                    error_choose_attribute.text('');
                }
                if (defaultValue.val() == '') {
                    flag = false;
                    error_default_value.text(json.product_template.enter_default_value);
                } else {
                    if (defaultValue.val() < 0) {
                        flag = false;
                        error_default_value.text(json.product_template.please_enter);
                    } else {
                        error_default_value.text('');
                    }
                }

                if (flag == true) {
                    $.ajax({
                        url: laroute.route('product.product-template.get-detail-attribute'),
                        method: "POST",
                        data: {idAttribute: idAttribute},
                        success: function (res) {
                            let stt = 1;
                            $('.id_attribute').each(function () {
                                stt++;
                            });
                            var checked = '';
                            if (noLimit.is(':checked')) {
                                checked = '<input type="checkbox" checked class="input_no_limit">';
                                no_limit = 1;
                            } else {
                                checked = '<input type="checkbox" class="input_no_limit">'
                            }

                            let tpl = $('#tpl-tr-attribute').html();
                            tpl = tpl.replace(/{stt}/g, stt);
                            tpl = tpl.replace(/{attribute_code}/g, res.product_attribute_code);
                            tpl = tpl.replace(/{id_attribute}/g, res.product_attribute_id);
                            tpl = tpl.replace(/{default_value}/g, defaultValue.val());
                            tpl = tpl.replace(/{checked}/g, checked);
                            if ($('#language').val() == 'vi') {
                                tpl = tpl.replace(/{attribute}/g, res.product_attribute_name_vi);
                            } else {
                                tpl = tpl.replace(/{attribute}/g, res.product_attribute_name_en);
                            }
                            tpl = tpl.replace(/{unit}/g, res.unit_name);


                            tpl = tpl.replace(/{product_attribute_code}/g, res.product_attribute_code);
                            tpl = tpl.replace(/{unit_name}/g, res.unit_name);
                            tpl = tpl.replace(/{price_month}/g, res.price_month);
                            tpl = tpl.replace(/{price_day}/g, res.price_day);
                            noLimit.prop('checked', false);
                            defaultValue.val('');
                            $('#tb-list-attribute > tbody').prepend(tpl);
                            $('#modal_add_product').modal('hide');
                            $(".numeric").numeric({decimal: ".", negative: false, scale: 1});
                            productAdd.calPriceMonthByAttribute();
                            let td_stt = 0;
                            $('.td_stt').each(function () {
                                td_stt++;
                                $(this).text(td_stt);
                            });
                        }
                    });
                }
            }
        });

    },
    keyUpValue: function (t) {
        var test_value = $(t).val().replace(/\,/g, "");
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
            var fileInput = input,
                file = fileInput.files && fileInput.files[0];
            var img = new Image();

            if (Math.round(fsize / 1024) <= 10240) {
                $('.error_img').text('');
                $.ajax({
                    url: laroute.route("product.product-category.upload"),
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        if (res.success == 1) {
                            $('#image').val(res.file);
                        }
                    }
                });
            }
        }
    },
    save: function (type) {
        var form = $('#form-submit');
        $.getJSON(laroute.route('product.validation'), function (json) {
            form.validate({
                rules: {
                    parent_id: {
                        required: true
                    },
                    product_name_vi: {
                        required: true,
                        maxlength:255
                    },
                    product_name_en: {
                        required: true,
                        maxlength:255
                    },
                    price_month: {
                        required: true,
                        number: true
                    },
                    price_day: {
                        required: true,
                        number: true
                    },
                    description: {
                        maxlength:255
                    }
                },
                messages: {
                    parent_id: {
                        required: json.product_template.enter_parent_id
                    },
                    product_name_vi: {
                        required: json.product_template.enter_product_name_vi,
                        maxlength: json.product.maxlength,
                    },
                    product_name_en: {
                        required: json.product_template.enter_product_name_en,
                        maxlength: json.product.maxlength,
                    },
                    price_month: {
                        required: json.product_template.enter_price_month,
                        number: json.product_template.please_enter
                    },
                    price_day: {
                        required: json.product_template.enter_price_day,
                        number: json.product_template.please_enter
                    },
                    description: {
                        maxlength: json.product.maxlength,
                    },

                }
            });
            if (form.valid()) {
                var parent_id = $('#parent_id').val();
                var product_name_vi = $('#product_name_vi').val();
                var product_name_en = $('#product_name_en').val();
                var description = $('#description').val();
                var price_month = $('#price_month').val();
                var price_day = $('#price_day').val();
                var price_by_attribute = 0;
                if ($('#price_by_attribute').is(':checked')) {
                    price_by_attribute = 1;
                } else {
                    price_by_attribute =0;
                }
                var is_active = 0;
                var is_feature = 0;
                if ($('#is_active').is(':checked')) {
                    is_active = 1;
                }
                if ($('#is_feature').is(':checked')) {
                    is_feature = 1;
                }
                var arrayAttribute = [];
                $('#tb-list-attribute tbody tr').each(function () {
                    var checkChooseAttribute = $(this).find('.choose_attribute');
                    if (checkChooseAttribute.is(':checked')) {
                        var temp = {};
                        var attribute_id = $(this).find('.input_id_attribute').val();
                        var product_attribute_code = $(this).find('.input_product_attribute_code').val();
                        var priceMonth = $(this).find('.input_price_month').val();
                        var priceDay = $(this).find('.input_price_day').val();
                        var price_year = $(this).find('.input_price_year').val();
                        var unit_name = $(this).find('.input_unit_name').val();
                        var default_value = $(this).find('.input_default_value').val();
                        var noLimit = $(this).find('.input_no_limit');
                        var no_limit = 0;

                        if (noLimit.is(':checked')) {
                            no_limit = 1;
                        }
                        temp = {
                            attribute_id: attribute_id,
                            product_attribute_code: product_attribute_code,
                            price_day: priceDay,
                            price_month: priceMonth,
                            price_year: price_year,
                            unit_name: unit_name,
                            default_value: default_value,
                            no_limit: no_limit
                        };
                        arrayAttribute.push(temp);
                    }
                });
                if (arrayAttribute.length > 0) {

                    $.ajax({
                        url: laroute.route('product.product-template.store'),
                        method: "POST",
                        data: {
                            parent_id: parent_id,
                            product_name_vi: product_name_vi,
                            product_name_en: product_name_en,
                            price_by_attribute: price_by_attribute,
                            price_month: price_month,
                            price_day: price_day,
                            description: description,
                            arrayAttribute: arrayAttribute,
                            is_active: is_active,
                            is_feature: is_feature,
                        },
                        success: function (res) {
                            if (res.error == false) {
                                swal.fire(res.message, "", "success").then(function () {
                                    window.location.href = laroute.route('product.product-template');
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
                } else {
                    swal.fire(json.product_template.choose_attribute, "", "error");
                }
            }
        });
    },
    chooseAllAttribute: function (t) {
        if ($(t).is(':checked')) {
            $('.choose_attribute').prop('checked', true);
        } else {
            $('.choose_attribute').prop('checked', false);
        }
        productAdd.calPriceMonthByAttribute();
    },
    priceByAttribute: function (t) {
        if ($(t).is(':checked')) {
            productAdd.calPriceMonthByAttribute();
        } else {
            $('#price_month').val('');
            $('#price_day').val('');
        }
    },
    getAttributeByParent: function () {
        var parentId = $('#parent_id').val();
        $.getJSON(laroute.route('product.validation'), function (json) {
            if (parentId != '') {
                $.ajax({
                    url: laroute.route('product.product-template.get-attribute-by-product'),
                    method: "POST",
                    data: {parentId: parentId},
                    success: function (res) {
                        $('#tb-list-attribute > tbody').empty();
                        if (res.length > 0) {
                            let stt = 1;
                            $('.id_attribute').each(function () {
                                stt++;
                            });

                            $.each(res, function (key, value) {
                                var product_attribute_name = '';
                                if ($('#language').val() == 'vi') {
                                    product_attribute_name = value.product_attribute_name_vi;
                                } else {
                                    product_attribute_name = value.product_attribute_name_en;
                                }
                                var checked = '<input type="checkbox" checked class="input_no_limit">';
                                let tpl = $('#tpl-tr-attribute').html();
                                tpl = tpl.replace(/{stt}/g, stt);
                                tpl = tpl.replace(/{attribute_code}/g, value.product_attribute_code);
                                tpl = tpl.replace(/{id_attribute}/g, value.product_attribute_id);
                                tpl = tpl.replace(/{default_value}/g, 0);
                                tpl = tpl.replace(/{checked}/g, checked);
                                tpl = tpl.replace(/{attribute}/g, product_attribute_name);
                                tpl = tpl.replace(/{unit}/g, value.unit_name);


                                tpl = tpl.replace(/{product_attribute_code}/g, value.product_attribute_code);
                                tpl = tpl.replace(/{unit_name}/g, value.unit_name);
                                tpl = tpl.replace(/{price_month}/g, value.price_month);
                                tpl = tpl.replace(/{price_day}/g, value.price_day);


                                $('#tb-list-attribute > tbody').append(tpl);
                                stt++;
                                $(".numeric").numeric({decimal: ".", negative: false, scale: 1});
                            });
                            productAdd.calPriceMonthByAttribute();
                        }
                    }
                });
            } else {
                swal.fire(json.product_template.enter_parent_id, "", "error");
            }
        });
    },
    formatInputNumber: function (t) {
        if ($(t).val() == '') {
            $(t).val(0);
        } else {
            $(t).val(parseFloat($(t).val()));
        }
        productAdd.calPriceMonthByAttribute();
    },
    clickInput: function (t) {
        var val = $(t).val();
        $(t).focus().val("").val(val);
    },
    calPriceMonthAttRecord: function () {
        if ($('#price_by_attribute').is(':checked')) {
            //Tính giá từng thuộc tính theo tháng..
            $('#tb-list-attribute tbody tr').each(function () {
                var checkChooseAttribute = $(this).find('.choose_attribute');
                if (checkChooseAttribute.is(':checked')) {
                    var priceMonth = $(this).find('.input_price_month').val();
                    var priceDay = $(this).find('.input_price_day').val();
                    var default_value = $(this).find('.input_default_value').val();
                    var price_month_by_value = $(this).find('.input_price_month_by_value');
                    var price_day_by_value = $(this).find('.input_price_day_by_value');
                    price_month_by_value.val(productAdd.calTowNumber(priceMonth, default_value));
                    price_day_by_value.val(productAdd.calTowNumber(priceDay, default_value));
                }
            });
        }
    },
    calPriceMonthByAttribute: function () {
        productAdd.calPriceMonthAttRecord();
        //Tính giá sản phẩm theo thuộc tính.
        if ($('#price_by_attribute').is(':checked')) {
            //Tính giá template theo thuộc tính
            var result = 0;
            var resultDay = 0;
            $('#tb-list-attribute tbody tr').each(function () {
                var checkChooseAttribute = $(this).find('.choose_attribute');
                if (checkChooseAttribute.is(':checked')) {
                    var price_month_by_value = $(this).find('.input_price_month_by_value').val();
                    var price_day_by_value = $(this).find('.input_price_day_by_value').val();
                    if (price_month_by_value == 'NaN') {
                        result += 0;
                    } else {
                        result += parseInt(price_month_by_value);
                    }
                    if (price_day_by_value == 'NaN') {
                        resultDay += 0;
                    } else {
                        resultDay += parseInt(price_day_by_value);
                    }

                }
            });
            $('#price_month').val(productAdd.format(result));
            $('#price_day').val(productAdd.format(resultDay));
        }
    },
    calTowNumber: function (price_month, default_value) {
        var result = parseInt(price_month) * parseFloat(default_value);
        return parseInt(result);
    },
    format: function (x) {
        return isNaN(x)?"":x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
};