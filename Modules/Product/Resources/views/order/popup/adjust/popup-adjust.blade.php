<div class="modal fade" id="create-order" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-lg nt_modal" role="document" style="max-width: 80%;">
        <form class="kt-form" id="form-product" style="margin: 0 auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @lang('product::order.create_adjust.title_popup')
                        <span class="product_name_vi">{{$product['product_name_vi']}}</span>
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            {{--Thuộc tính thường--}}
                            @foreach($arrAttributeGroup as $group)
                                @if(isset($arrAttribute[$group['product_attribute_group_id']]))
                                    <div class="col-12 col-lg-3">
                                        <div class="kt-portlet">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        {{$group['product_attribute_group_name_vi']}}
                                                    </h3>
                                                </div>
                                            </div>
                                            <!--begin::Form-->
                                            <div class="kt-portlet__body">
                                                @foreach($arrAttribute[$group['product_attribute_group_id']] as $attribute)
                                                    <div class="form-group row">
                                                        <div class="col-lg-12">
                                                            <label>{{$attribute['product_attribute_name_vi']}}</label>
                                                            @if(isset($arrCart) && $arrCart['value'][$attribute['product_attribute_id']])
                                                                <input
                                                                        data-min="{{$attribute['min_value']}}"
                                                                        data-max="{{$attribute['max_value']}}"
                                                                        data-step="{{$attribute['min_unit']}}"
                                                                        type="text"
                                                                        class="kt_touchspin"
                                                                        name="value[{{$attribute['product_attribute_id']}}]"
                                                                        value="{{$arrCart['value'][$attribute['product_attribute_id']]}}"/>
                                                            @else
                                                                <input
                                                                        data-min="{{$attribute['min_value']}}"
                                                                        data-max="{{$attribute['max_value']}}"
                                                                        data-step="{{$attribute['min_unit']}}"
                                                                        type="text"
                                                                        class="kt_touchspin"
                                                                        name="value[{{$attribute['product_attribute_id']}}]"
                                                                        value="{{isset($detail_attribute[$attribute['product_attribute_id']]) ? $detail_attribute[$attribute['product_attribute_id']] : $attribute['min_value']}}"/>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            {{--End--}}
                            {{--Thuộc tính bán kèm--}}
                            @foreach($arrAttributeGroupBK as $groupBK)
                                @if(isset($arrAttributeBK[$groupBK['product_attribute_group_id']]))
                                    <div class="col-12 col-lg-3">
                                        <div class="kt-portlet">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        {{$groupBK['product_attribute_group_name_vi']}}
                                                    </h3>
                                                </div>
                                            </div>
                                            <!--begin::Form-->
                                            <div class="kt-portlet__body">
                                                @if($groupBK['quantity_attribute'] == 1)
                                                    <select class="form-control ss--select2"
                                                            name="input_attribute_bk[0]">
                                                        <option value="0">
                                                            Chọn thuộc tính
                                                        </option>
                                                        @foreach($arrAttributeBK[$groupBK['product_attribute_group_id']] as $attBK)
                                                            <option value="{{$attBK['product_attribute_id']}}"
                                                            {{isset($detail_attribute[$attBK['product_attribute_id']]) ? 'selected' : ''}}>
                                                                {{$attBK['product_attribute_name_vi']}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    @foreach($arrAttributeBK[$groupBK['product_attribute_group_id']] as $attBK)
                                                        <label class="kt-checkbox">
                                                            <input type="checkbox"
                                                                   name="input_attribute_bk[0]"
                                                                   value="{{$attBK['product_attribute_id']}}"
                                                                    {{isset($detail_attribute[$attBK['product_attribute_id']]) ? 'checked' : ''}}>
                                                            {{$attBK['product_attribute_name_vi']}}
                                                            <span></span>
                                                        </label>
                                                    @endforeach

                                                @endif
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            {{--End--}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('product::order.create_adjust.cancel')
                    </button>
                    <button onclick="orderAdjust.update()" type="button" class="btn btn-primary">
                        @lang('product::order.create_adjust.update')
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    orderAdjust._initModal();
</script>
