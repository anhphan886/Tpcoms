<div class="kt-section__content">
    <div class="row">
        <div class="col-12">
            <div class="table_responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::customer.receipt.stt')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::customer.receipt.receipt_no')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::customer.receipt.customer_name')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::customer.receipt.receipt_content')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::customer.receipt.created_at')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer ">
                                @lang('product::customer.receipt.amount')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::customer.receipt.owed')
                            </p>
                        </th>
                        <th id="th_group_name" class="text-align-right">
                            <p class="pn-pointer">
                                @lang('product::customer.receipt.pay_expired')
                            </p>
                        </th>
                        <th id="th_group_name" class="text-align-right">
                            <p class="pn-pointer ">
                                @lang('product::customer.receipt.status')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer ">
                                @lang('product::customer.receipt.action')
                            </p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($list_receipt) && $list_receipt->count()>0)
                        @foreach ($list_receipt as $key => $item)
                            <tr>
                                <td>
                                    {{($filter['page'] - 1) * $perpage + $key + 1}}
                                </td>
                                <td>
                                    <a href="{{route('product.receipt.show', ['id' => $item['receipt_no']])}}">
                                        {{ $item['receipt_no']}}
                                    </a>
                                </td>
                                <td>
                                    {{ $item['customer_name'] }}
                                </td>
                                <td>
                                    {{ subString($item['receipt_content'])  }}
                                </td>
                                <td>
                                    {{(new DateTime($item['created_at']))->format('d/m/Y')}}
                                </td>
                                <td  >
                                    {{ number_format($item['amount'] + $item['vat'] )  }}
                                </td>
                                <td>
                                    @if ( isset($amount_paid[$item['receipt_id']]))
                                        {{number_format( ($item['amount'] + $item['vat']) - $amount_paid[$item['receipt_id']])}}
                                    @else
                                        {{ number_format($item['amount'] + $item['vat'] )  }}
                                    @endif
                                </td>
                                <td class="text-align-right">
                                    {{(new DateTime($item['pay_expired']))->format('d/m/Y')}}
                                </td>
                                <td class="text-align-right">
                                    @if($item['status'] == 'paid')
                                        <p class="color-green">@lang('product::customer.receipt.paid')</p>
                                    @elseif($item['status'] == 'unpaid')
                                        <p class="color-red">@lang('product::customer.receipt.unpaid')</p>
                                    @elseif($item['status'] == 'refund')
                                        <p class="color-yellow">@lang('product::customer.receipt.refund')</p>
                                    @elseif($item['status'] == 'part-paid')
                                        <p class="text-warning">@lang('product::customer.receipt.part_paid')</p>
                                    @elseif($item['status'] == 'cancel')
                                        <p class="color-brown">@lang('product::customer.receipt.cancel')</p>
                                    @endif
                                </td>
                                <td class="text-align-right">
                                    <div class="kt-portlet__head-toolbar">
                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                    class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                @lang('product::attribute-group.index.action')
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                @include('helpers.button', ['button' => [
                                                'route' => 'product.receipt.show',
                                                'html' => '<a href="'.route('product.receipt.show', ['id' => $item['receipt_no']]).'" class="dropdown-item">'
                                                .'<i class="la la-eye"></i>'
                                                .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::customer.receipt.detail').'</span>'.
                                                '</a>'
                                                ]])
                                                @if ($item['status'] == 'unpaid' || $item['status'] == 'part-paid' )
                                                    @include('helpers.button', ['button' => [
                                                    'route' => 'product.receipt.showEdit',
                                                    'html' => '<a href="'.route('product.receipt.showEdit', ['id' => $item['receipt_no']]).'" class="dropdown-item">'
                                                    .'<i class="la la-edit"></i>'
                                                    .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::customer.receipt.edit_Receipt').'</span>'.
                                                    '</a>'
                                                    ]])
                                                @endif
                                                @if($item['status'] != 'paid' && $item['status'] != 'cancel')
                                                    @include('helpers.button', ['button' => [
                                                        'route' => 'product.receipt.payment-receipt',
                                                        'html' => '<a href="'.route('product.receipt.payment-receipt', ['id' => $item['receipt_no']]).'" class="dropdown-item">'
                                                        .'<i class="la la-money"></i>'
                                                        .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::customer.receipt.receipt_action').'</span>'.
                                                        '</a>'
                                                        ]])
                                                    @include('helpers.button', ['button' => [
                                                        'route' => 'product.receipt.cancel',
                                                        'html' => '<a href="javascript:void(0)" onclick="receipt.cancel('.$item['receipt_id'].')" class="dropdown-item">'
                                                        .'<i class="la la-remove"></i>'
                                                        .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::customer.receipt.cancel').'</span>'.
                                                        '</a>'
                                                    ]])
                                                @endif
                                            </div>
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

        {{$list_receipt->appends($filter)->links('helpers.paging')}}
</div>
