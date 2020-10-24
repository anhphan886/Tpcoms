// $('#attribute_group_option').select2();
// $('#attribute_option').select2();
// $('#min').mask('000000', {reverse: true});
// $('#max').mask('000000', {reverse: true});
// $('#jump').mask('000000', {reverse: true});
$(".numeric").numeric({ decimal : ".",  negative : false, scale: 1 });
$('#attribute_group_id').select2();
var productGroupAdd = {
    abc: {},
    removeTr: function (t) {
        $(t).closest('tr').remove();
    },
    addAttributeGroup: function () {
        // danh sach nhom da co
        var arrayGroup = [0];
        $('.input_attribute_group').each(function () {
            arrayGroup.push($(this).val());
        });
        // console.log(arrayGroup);

        $.ajax({
            url: laroute.route('product.product.get-attribute-group-wni'),
            method: "POST",
            async: false,
            data: {
                arrayGroup : arrayGroup
            },
            success: function (res) {
                $('#attribute_group_id').empty();
                if(res.length > 0) {
                    $.each(res, function (key, value) {
                        var id = value.product_attribute_group_id;
                        var name = value.product_attribute_group_name_vi;
                        $('#attribute_group_id').append('<option value="' + id + '">' + name + '</option>');
                    });
                } else {
                    $('#attribute_group_id').append('<option value="0">Chọn nhóm thuộc tính</option>');
                }
                $('#modal_add_product_group').modal('show');
            }
        });

    },
    listAttribute: function () {
        if ($('#attribute_group_id').val() != 0) {
            $.ajax({
                url:laroute.route('product.product.choose-attr'),
                method:'POST',
                dataType:'JSON',
                data:{
                    attribute_group_id : $('#attribute_group_id').val()
                },
                success:function (res) {
                    if(res.info != null) {
                        let tpl = $('#tpl-div-attribute').html();
                        tpl = tpl.replace(/{attribute_group}/g, res.info.product_attribute_group_name_vi);
                        tpl = tpl.replace(/{attribute_group_id}/g, res.info.product_attribute_group_id);
                        tpl = tpl.replace(/{stt}/g, res.info.product_attribute_group_id);
                        $('#tbody-group-attr').append(tpl);

                        $.map(res.attr,function (data) {
                            let tpl1 = $('#tpl-attr').html();
                            tpl1 = tpl1.replace(/{attrName}/g, data.product_attribute_name_vi);
                            tpl1 = tpl1.replace(/{unitName}/g, data.unit_name);
                            $('#attr-'+ res.info.product_attribute_group_id +'').append(tpl1);
                        });
                    }
                    $('#modal_add_product_group').modal('hide');
                }
            });
        } else {
            $('#modal_add_product_group').modal('hide');
        }
    },
    attGroupBK: function () {
        var arrayGroup = [];
        $('.input_attribute_group').each(function () {
            arrayGroup.push($(this).val());
        })
    },
};
