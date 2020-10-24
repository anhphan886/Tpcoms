<div class="kt-section__content">
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
                                Trạng thái thanh toán
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
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::customer.table_service.acction')
                            </p>
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($list) && $list->count()>0)
                        @foreach ($list as $key => $item)
                            <tr>
                                <td>
                                    {{($filter['page'] - 1) * $perpage + $key + 1}}
                                </td>
                                <td>
                                    {{ ($item['customer_name']) }}
                                </td>
                                <td>
                                    <a href="{{route('product.service.show',['id' => $item['customer_service_id']])}}"> {{$item['product_name_'.getValueByLang('')]}}</a>
                                </td>
                                <td>
                                    @if ($item['type'] == 'trial')
                                        @lang('product::customer.service.trial')
                                    @else
                                        @if ($item['payment_type'] == 'postpaid')
                                            @lang('product::customer.service.postpaid')
                                        @elseif($item['payment_type'] == 'prepaid')
                                            @lang('product::customer.service.prepaid')
                                        @else
                                            @lang('product::customer.service.payuse')
                                        @endif
                                    @endif

                                </td>
                                <td>
                                    @if($item['status'] == 'actived' )
                                        @lang('product::customer.service.actived')

                                    @elseif($item['status'] == 'not_actived')
                                        @lang('product::customer.service.not_actived')

                                    @elseif($item['status'] == 'spending')
                                        @lang('product::customer.service.spending')
                                    @elseif($item['status'] == 'block')
                                        @lang('product::customer.service.block')

                                    @else
                                        @lang('product::customer.service.cancel')
                                    @endif
                                </td>
                                <td>
                                    @if($item['stop_payment'] == 1)
                                        Đã tạm dừng thanh toán
                                    @else
                                        {{--                            Đang thanh toán--}}
                                    @endif
                                </td>
                                <td>
                                    @if ( $item['actived_date'] == null || $item['actived_date'] == '0000-00-00')

                                    @else
                                        {{date("d/m/Y",strtotime($item['actived_date']))}}
                                    @endif
                                    {{--                        {{date("d/m/Y",strtotime($item['actived_date']))}}--}}
                                </td>
                                <td>
                                    @if($item['payment_type'] == 'postpaid')
                                        @lang('product::customer.service.unknown')
                                    @elseif($item['payment_type'] == 'payuse')
                                        @lang('product::customer.service.unknown')
                                    @elseif($item['payment_type'] == 'prepaid')
                                        @if ( $item['expired_date'] == null || $item['expired_date'] == '0000-00-00' || $item['status'] == 'not_actived')
                                        @else
                                            {{date("d/m/Y",strtotime($item['expired_date']))}}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($item['status'] != 'cancel')
                                        <div class="kt-portlet__head-toolbar">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    @lang('ticket::issue-group.table.action')
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                    @include('helpers.button', ['button' => [
                                                                'route' => 'product.service.edit',
                                                                 'html' =>  '<a href="'.route('product.service.edit', ['id' => $item['customer_service_id']]).'"  class="dropdown-item">'
                                                                 .'<i class="la la-edit"></i>'
                                                                 .'<span class="kt-nav__link-text kt-margin-l-5">'.__('ticket::queue.index.edit').'</span>'.
                                                            '</a>'
                                                        ]])
                                                    @if($item['status'] != 'cancel')
                                                        <div class="dropdown-item"
                                                             onclick="objService.cancel_service({{$item['customer_service_id']}})">
                                                            <i class="la la-close"></i>
                                                            <span class="kt-nav__link-text kt-margin-l-5"
                                                                  style="cursor: pointer">Hủy dịch vụ</span>
                                                        </div>

                                                    @endif
                                                    @if($item['stop_payment'] == 0 && $item['type'] != 'trial')
                                                        <div class="dropdown-item"
                                                             onclick="objService.stop_payment({{$item['customer_service_id']}})">
                                                            <i class="la flaticon-multimedia-5"></i>
                                                            <span class="kt-nav__link-text kt-margin-l-5"
                                                                  style="cursor: pointer">Dừng thanh toán</span>
                                                        </div>
                                                    @endif
                                                    @if($item['type'] != 'trial' && $item['status'] == 'spending' && $item['payment_type'] == 'prepaid')
                                                        <div class="dropdown-item"
                                                             onclick="objService.open_model_extends('{{$item['customer_service_id']}}',
                                                                 '{{$item['type']}}','{{$item['payment_type']}}')">
                                                            <i class="la la-rotate-right"></i>
                                                            <span class="kt-nav__link-text kt-margin-l-5"
                                                                  style="cursor: pointer">Gia hạn dịch vụ</span>
                                                        </div>
                                                    @endif

    {{--                                            @if($item['status'] == 'cancel')--}}
    {{--                                            <div class="dropdown-item" onclick="objService.resume_service({{$item['customer_service_id']}})">--}}
    {{--                                                <i class="la la-rotate-right"></i>--}}
    {{--                                                <span class="kt-nav__link-text kt-margin-l-5" style="cursor: pointer">Phục hồi dịch vụ</span>--}}
    {{--                                            </div>--}}
    {{--                                            @endif--}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12" class="text-center"><p>@lang('ticket::ticket.table.data_null')</p></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{$list->appends($filter)->links('helpers.paging')}}
</div>
