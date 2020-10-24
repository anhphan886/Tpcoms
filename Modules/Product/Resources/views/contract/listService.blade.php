
<div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    @lang('product::contract.index.list_service'):
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-12">
                    <div class="table_responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::customer.table_service.stt')
                                    </p>
                                </th>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::customer.table_service.customer')
                                    </p>
                                </th>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::customer.table_service.service')
                                    </p>
                                </th>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::customer.table_service.type')
                                    </p>
                                </th>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::customer.table_service.status')
                                    </p>
                                </th>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::customer.table_service.actived_date')
                                    </p>
                                </th>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::customer.table_service.expired_date')
                                    </p>
                                </th>
{{--                                <th id="th_group_name">--}}
{{--                                    <p class="pn-pointer">--}}
{{--                                        @lang('product::customer.table_service.acction')--}}
{{--                                    </p>--}}
{{--                                </th>--}}

                            </tr>
                            </thead>
                            <tbody>
                            @if (isset($service['data']))
                                @foreach ($service['data'] as $key=>$value)
                                    <tr>
                                        <td>
                                            {{$key + 1}}
                                        </td>
                                        <td>
                                            {{$value['customer_name']}}
                                        </td>
                                        <td>
                                            <a href="{{route('product.service.show',['id' => $value['customer_service_id']])}}" >
                                                {{$value['product_name_'.getValueByLang('')]}}</a>
                                        </td>
                                        <td>
                                            @if ($value['type'] == 'trial')
                                                @lang('product::customer.service.trial')
                                            @else
                                                @if ($value['payment_type'] == 'postpaid')
                                                    @lang('product::customer.service.postpaid')
                                                @elseif($value['payment_type'] == 'prepaid')
                                                    @lang('product::customer.service.prepaid')
                                                @else
                                                    @lang('product::customer.service.payuse')
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($value['status'] == 'actived')
                                                @lang('product::customer.service.actived')

                                            @elseif($value['status'] == 'not_actived')
                                                @lang('product::customer.service.not_actived')

                                            @elseif($value['status'] == 'spending')
                                                @lang('product::customer.service.spending')
                                            @elseif($value['status'] == 'block')
                                                @lang('product::customer.service.block')

                                            @else
                                                @lang('product::customer.service.cancel')
                                            @endif
                                        </td>
                                        <td>
                                            @if ( $value['actived_date'] == null || $value['actived_date'] == '0000-00-00')

                                            @else
                                                {{date("d/m/Y",strtotime($value['actived_date']))}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($value['payment_type'] == 'postpaid')
                                                @lang('product::customer.service.unknown')
                                            @elseif($value['payment_type'] == 'payuse')
                                                @lang('product::customer.service.unknown')
                                            @elseif($value['payment_type'] == 'prepaid')
                                                @if ( $value['expired_date'] == null || $value['expired_date'] == '0000-00-00')
                                                @else
                                                    {{date("d/m/Y",strtotime($value['expired_date']))}}
                                                @endif
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

