<div class="modal fade nt_padding_0" id="modal_add_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-center" role="document">
        <form id="form-modal-submit">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header kt-margin-b-0">
                    <h5 class="modal-title kt-margin-b-0" id="exampleModalLongTitle">
                        @lang('product::product-template.create.add_attribute')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">
                            @lang('product::product-template.create.category')
                        </label>
                        <select name="attribute_group_option" id="attribute_group_option"
                                class="form-control" style="width: 100%" onchange="productAdd.getAttribute(this)">
                            <option value="0" selected>
                                @lang('product::product-template.create.choose_category')
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
                            @lang('product::product-template.create.attribute')
                        </label>
                        <select name="attribute_option" id="attribute_option"
                                class="form-control" style="width: 100%">
                        </select>
                        <span class="text-danger error_choose_attribute"></span>
                    </div>
                    <div class="form-group">
                        <label class="kt-checkbox">
                            <input type="checkbox" name="no_limit" id="no_limit">
                            @lang('product::product-template.create.no_limit')
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="">
                            @lang('product::product-template.create.default_value')
                        </label>
                        <input type="text" class="form-control numeric" onchange="productAdd.formatInputNumber(this)"
                               name="default_value" id="default_value">
                        <span class="text-danger error_default_value"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('product::product-template.create.cancel')
                    </button>
                    <button type="button" class="btn btn-primary" onclick="productAdd.chooseAttribute(this)">
                        @lang('product::product-template.create.save')
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>