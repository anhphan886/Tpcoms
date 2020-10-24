<div class="modal fade" id="modal_add_product_group" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center" role="document">
        <form id="form_modal_add_attribute">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        @lang('product::product.create.add_attribute_group') bán kèm
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">
                            Nhóm thuộc tính bán kèm
                        </label>
                        <select name="attribute_group_option" id="attribute_group_id"
                                class="form-control" style="width: 100%">
                            @if(count($attributeGroupSoldTogether) > 0)
                                @foreach($attributeGroupSoldTogether as $item)
                                    <option value="{{$item['product_attribute_group_id']}}">
                                        {{$item[getValueByLang('product_attribute_group_name_')]}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('product::product.create.cancel')
                    </button>
                    <button type="button" class="btn btn-primary" onclick="productGroupAdd.listAttribute(this)">
                        @lang('product::product.create.save')
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
