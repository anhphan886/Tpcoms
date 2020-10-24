<input type="hidden" value="{{$id}}" name="product_id">
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
                                            type="number"
                                            class="kt_touchspin number-only"
                                            name="value[{{$attribute['product_attribute_id']}}]"
                                            value="{{$arrCart['value'][$attribute['product_attribute_id']]}}"/>
                                @else
                                    <input
                                            data-min="{{$attribute['min_value']}}"
                                            data-max="{{$attribute['max_value']}}"
                                            data-step="{{$attribute['min_unit']}}"
                                            type="number"
                                            class="kt_touchspin number-only"
                                            name="value[{{$attribute['product_attribute_id']}}]"
                                            value="{{$attribute['min_value']}}"/>
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
@if(isset($arrAttributeGroupSoldTogether))
    @foreach($arrAttributeGroupSoldTogether as $groupSoldTogether)
        @if(isset($arrAttributeMap[$groupSoldTogether['product_attribute_group_id']]))
            <div class="col-12 col-lg-3">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{$groupSoldTogether['product_attribute_group_name_vi']}}
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <div class="kt-portlet__body">
                        @if($groupSoldTogether['quantity_attribute'] == 1)
                            <label>Thuộc tính</label>
                            @if(count($arrAttributeMap) > 0)
                                @if(isset($arrCart['attribute_sold_together'])
                                && count($arrCart['attribute_sold_together']) > 0)
                                    <select class="form-control ss--select2"
                                            name="attribute_sold_together[{{$attributeMap['product_attribute_id']}}]">
                                        @if(count($arrCart['attribute_sold_together']) > 0)
                                            <option value="0">
                                                Chọn thuộc tính
                                            </option>
                                            @foreach($arrCart['allAttribute'] as $attributeMap)
                                                @if($groupSoldTogether['product_attribute_group_id'] == $attributeMap['product_attribute_group_id'])
                                                        <option
                                                            value="{{$attributeMap['product_attribute_id']}}"
                                                            {{in_array($attributeMap['product_attribute_id'], $arrCart['attribute_sold_together']) ? 'selected' : ''}}
                                                    >
                                                        {{$attributeMap['product_attribute_name_vi']}}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="0">
                                                Chọn thuộc tính
                                            </option>
                                        @endif
                                    </select>
                                @else
                                    <select class="form-control ss--select2"
                                            name="attribute_sold_together[{{$attributeMap['product_attribute_id']}}]">
                                        @if(count($arrAttributeMap) > 0)
                                            <option value="0">
                                                Chọn thuộc tính
                                            </option>
                                            @foreach($arrAttributeMap[$groupSoldTogether['product_attribute_group_id']] as $attributeMap)
                                                <option value=" {{$attributeMap['product_attribute_id']}}">
                                                    {{$attributeMap['product_attribute_name_vi']}}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="0">
                                                Chọn thuộc tính
                                            </option>
                                        @endif
                                    </select>
                                @endif
                            @endif
                        @else
                            <label>Thuộc tính</label>
                            @foreach($arrAttributeMap[$groupSoldTogether['product_attribute_group_id']] as $attributeMap)
                                @if(isset($arrCart['value_sold_together']) && count($arrCart['value_sold_together']) > 0)
                                    <label class="kt-checkbox">
                                        <input type="checkbox"
                                               {{isset($arrCart['value_sold_together'][$attributeMap['product_attribute_id']]) ? 'checked' : ''}}
                                               name="value_sold_together[{{$attributeMap['product_attribute_id']}}]"
                                               value="{{$attributeMap['product_attribute_id']}}">
                                        {{$attributeMap['product_attribute_name_vi']}}
                                        <span></span>
                                    </label>
                                @else
                                    <label class="kt-checkbox">
                                        <input type="checkbox"
                                               name="value_sold_together[{{$attributeMap['product_attribute_id']}}]"
                                               value="{{$attributeMap['product_attribute_id']}}">
                                        {{$attributeMap['product_attribute_name_vi']}}
                                        <span></span>
                                    </label>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        @endif
    @endforeach
@endif
