<div class="kt-section__content">
    <div class="row">
        <div class="col-12">
            <div class="table_responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>
                            <p class="pn-pointer">
                                @lang('product::order.index.stt')
                            </p>
                        </th>
                        <th>
                            <p class="pn-pointer">
                                @lang('product::order.index.order_code')
                            </p>
                        </th>
                        <th>
                            <p class="pn-pointer">
                                Loại
                            </p>
                        </th>
                        <th>
                            <p class="pn-pointer">
                                @lang('product::order.index.customer')
                            </p>
                        </th>
                        <th>
                            <p class="pn-pointer">
                                @lang('product::order.index.created_at')
                            </p>
                        </th>
                        <th>
                            <p class="pn-pointer">
                                @lang('product::order.index.voucher')
                            </p>
                        </th>
                        <th>
                            <p class="pn-pointer text-align-right">
                                @lang('product::order.index.amount')
                            </p>
                        </th>
                        <th>
                            <p class="pn-pointer text-align-right">
                                @lang('product::order.index.status')
                            </p>
                        </th>
                        <th>
                            <p class="pn-pointer text-align-right">
                                @lang('product::order.index.action')
                            </p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($list))
                        @foreach ($list as $key => $item)
                            <tr>
                                <td>
                                    {{($filter['page'] - 1) * $perpage + $key + 1}}
                                </td>
                                <td>
                                    <a href="{{route('product.order.detail',[$item['order_code']])}}">
                                        {{ ($item['order_code']) }}
                                    </a>
                                    <input type="hidden" value="{{$item['order_id']}}">
                                </td>
                                <td>
                                    @if($item['is_adjust'] == 1)
                                        Điều chỉnh
                                    @else
                                        Mới
                                    @endif
                                </td>
                                <td>
                                    {{ ($item['customer_name']) }}
                                    <input type="hidden" value="{{$item['customer_id']}}">
                                </td>
                                <td>
                                    @if($item['created_at'] != '')
                                        {{(new DateTime($item['created_at']))->format('d/m/Y H:i:s')}}
                                    @endif
                                </td>
                                <td>
                                    {{ ($item['voucher_code']) }}
                                </td>
                                <td class="text-align-right">
                                    {{ number_format($item['amount'], 0) }}
                                </td>
                                <td class="text-align-right">
                                    @foreach($status as $st)
                                        {{--@if($item['order_status_id'] == $st['order_status_id'])--}}
                                        @if($item['order_status_id'] == $st['order_status_id'])
                                            @if($st['order_status_id'] == 1)
                                                <span class="text-primary btn-new">
                                        {{$item[getValueByLang('order_status_name_')]}}
                                    </span>
                                            @elseif($st['order_status_id'] == 2)
                                                <span class="text-info btn-accepted">
                                        {{$item[getValueByLang('order_status_name_')]}}
                                    </span>
                                            @elseif($st['order_status_id'] == 3)
                                                <span class="text-warning btn-waiting-payment">
                                        {{$item[getValueByLang('order_status_name_')]}}
                                    </span>
                                            @elseif($st['order_status_id'] == 4)
                                                <span class="text-success btn-finished">
                                        {{$item[getValueByLang('order_status_name_')]}}
                                    </span>
                                            @elseif($st['order_status_id'] == 5)
                                                <span class="text-danger btn-cancelled">
                                        {{$item[getValueByLang('order_status_name_')]}}
                                    </span>
                                            @elseif($st['order_status_id'] == 6)
                                                <span class="text-danger btn-cancelled">
                                        {{$item[getValueByLang('order_status_name_')]}}
                                    </span>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-align-right">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @lang('product::order.index.action')
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            @include('helpers.button', ['button' => [
                                            'route' => 'product.order.detail',
                                            'html' => '<a href="'.route('product.order.detail', [$item['order_code']]).'" class="dropdown-item">'
                                            .'<i class="la la-eye"></i>'
                                            .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::order.index.detail').'</span>'.
                                            '</a>'
                                            ]])
                                            @if($item['order_status_id'] == 1 || $item['order_status_id'] == 6)
                                                @include('helpers.button', ['button' => [
                                                'route' => 'product.order.edit',
                                                'html' => '<a href="'.route('product.order.edit', $item['order_code']).'" class="dropdown-item">'
                                                .'<i class="la la-edit"></i>'
                                                .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::order.index.edit_order').'</span>'.
                                                '</a>'
                                                ]])
                                                @include('helpers.button', ['button' => [
                                                'route' => 'product.order.approveOrder',
                                                'html' => '<a href="javascript:void(0)" onclick="order.approveOrder('.$item['order_id'].', '.$item['quantity'].', '.$item['is_adjust'].')" class="dropdown-item">'
                                                .'<i class="la la-check"></i>'
                                                .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::order.index.approve').'</span>'.
                                                '</a>'
                                                ]])
                                            @endif
                                            @if($item['order_status_id'] == 1)
                                                @include('helpers.button', ['button' => [
                                                    'route' => 'ticket.create',
                                                    'html' => '<a href="'.route('ticket.create', ['order_id' =>$item['order_id'], 'customer_id' => $item['customer_id'],
                                                                           'order_name' => $item['order_code']]  ).'" class="dropdown-item">'
                                                    .'<i class="fa fa-mail-bulk"></i>'
                                                    .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::order.index.support_consult').'</span>'.
                                                    '</a>'
                                                    ]])
                                            @endif
                                            {{--@if($item['order_status_id'] == 8)--}}
                                                {{--<a href="javascript:void(0)" onclick="order.payOrder('{{$item['order_id']}}')"--}}
                                                   {{--class="dropdown-item">--}}
                                                    {{--<i class="la la-check"></i>--}}
                                                    {{--@lang('product::order.index.receipt')--}}
                                                {{--</a>--}}
                                            {{--@endif--}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12" class="text-center">
                                @lang('ticket::ticket.table.data_null')
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if (isset($list) && $list != null)
        {{$list->appends($filter)->links('helpers.paging')}}
    @else
        @php
            $listOption = [10, 20, 30, 50, 100, ];
            $selected = (isset($_GET['perpage'])) ? $_GET['perpage'] : 10;
            $frm = isset($frm) ? $frm : 'form-filter';
            $displaySelect = isset($display) ? $display : true;
        @endphp
        <div class="kt-pagination kt-pagination--brand kt-pagination--circle">
            <div class="kt-pagination__toolbar">
                @if ($displaySelect)
                    <select class="form-control kt-font-brand"
                            name="perpage" onchange="filterDisplay('{{ $frm }}')" style="width: 60px">
                        @foreach ($listOption as $option)
                            <option value="{{ $option }}" {{ $selected == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                @endif
                <span class="m-datatable__pager-detail">Hiển thị {{ 0 }} - {{ 0 }} của {{ 0 }}</span>
            </div>
        </div>
    @endif
</div>
