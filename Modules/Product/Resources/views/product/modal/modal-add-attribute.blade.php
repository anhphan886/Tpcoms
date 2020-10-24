<div class="modal fade" id="modal_add_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center" role="document">
        <form id="form_modal_add_attribute">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        @lang('product::product.create.add_attribute')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">
                            @lang('product::product.create.category')
                        </label>
                        <select name="attribute_group_option" id="attribute_group_option"
                                class="form-control" style="width: 100%" onchange="productAdd.getAttribute(this)">
                            <option value="0" selected>
                                @lang('product::product.create.choose_category')
                            </option>
                            @if(count($attributeGroup) > 0)
                                @foreach($attributeGroup as $item)
                                    <option value="{{$item['product_attribute_group_id']}}">
                                        {{$item[getValueByLang('product_attribute_group_name_')]}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">
                            @lang('product::product.create.attribute')
                        </label>
                        <select name="attribute_option" id="attribute_option"
                                class="form-control" style="width: 100%">
                        </select>
                        <span class="text-danger error_choose_attribute"></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">
                                    @lang('product::product.create.Min')
                                </label>
                                <input onclick="productAdd.clickInput(this)" onchange="productAdd.formatInputNumber(this)" type="text" class="form-control numeric" name="min" id="min" onkeyup="productAdd.keyUpValue(this)">
                                <span class="text-danger error_min"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">
                                    @lang('product::product.create.Max')
                                </label>
                                <input type="text" class="form-control numeric" name="max" id="max" onkeyup="productAdd.keyUpValue(this)">
                                <span class="text-danger error_max"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">
                            @lang('product::product.create.jump')
                        </label>
                        <input type="text" class="form-control numeric" name="jump" id="jump" onkeyup="productAdd.keyUpValue(this)">
                        <span class="text-danger error_jump"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('product::product.create.cancel')
                    </button>
                    <button type="button" class="btn btn-primary" onclick="productAdd.chooseAttribute(this)">
                        @lang('product::product.create.save')
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>