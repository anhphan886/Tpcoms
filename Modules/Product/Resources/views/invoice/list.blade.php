<div class="kt-section__content">
    <div class="row">
        <div class="col-12">
            <div class="table_responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::customer.service.stt')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::customer.service.invoice_no')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::invoice.index.invoice_number')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">

                                @lang('product::customer.service.customer_name')
                            </p>
                        </th>
                        <th id="th_group_name" class="text-align-right">
                            <p class="pn-pointer">
                                @lang('product::invoice.index.status')
                            </p>
                        </th>
                        <th id="th_group_name" class="text-align-right">
                            <p class="pn-pointer">
                                @lang('product::invoice.index.status_receipt')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer text-align-right">
                                @lang('product::customer.service.amount')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::customer.service.invoice_by')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::customer.service.invoice_at')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer text-align-right">
                                @lang('product::invoice.index.action')
                            </p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($list_invoice) && $list_invoice->count()>0)
                        @foreach ($list_invoice as $key => $item)
                            <tr>
                                <td>
                                    {{($filter['page'] - 1)* $perpage + $key + 1}}
                                </td>
                                <td>
                                   <a href="{{route('product.invoice.show',['id' => $item['invoice_no']])}}"> {{ ($item['invoice_no']) }}</a>
                                </td>
                                <td>
                                    {{$item['invoice_number']}}
                                </td>
                                <td>
                                    {{ ($item['customer_name']) }}
                                </td>
                                <td class="text-align-right">
                                    @if($item['status'] == 'new')
                                        <p class="color-green">@lang('product::customer.service.new')</p>
                                    @elseif($item['status'] == 'finish')
                                        <p class="color-brown">@lang('product::customer.service.finish')</p>
                                    @elseif($item['status'] == 'cancel')
                                        <p class="color-red">@lang('product::customer.service.cancel')</p>
                                    @endif
                                </td>
                                <td class="text-align-right">
                                    @if($item['receipt_status'] == 'paid')
                                        <p class="color-green">@lang('product::customer.receipt.paid')</p>
                                    @elseif($item['receipt_status'] == 'unpaid')
                                        <p class="color-red">@lang('product::customer.receipt.unpaid')</p>
                                    @elseif($item['receipt_status'] == 'refund')
                                        <p class="color-yellow">@lang('product::customer.receipt.refund')</p>
                                    @elseif($item['receipt_status'] == 'part-paid')
                                        <p class="text-warning">@lang('product::customer.receipt.part_paid')</p>
                                    @elseif($item['receipt_status'] == 'cancel')
                                        <p class="color-brown">@lang('product::customer.receipt.cancel')</p>
                                    @endif

                                </td>
                                <td class="text-align-right">
                                    {{ number_format($item['amount']) }}
                                </td>
                                <td>
                                    {{ ($item['create_full_name']) }}
                                </td>
                                <td>
                                    @if($item['invoice_at'] != null && $item['invoice_at'] != '0000-00-00 00:00:00')
                                        {{(new DateTime($item['invoice_at']))->format('d/m/Y')}}
                                    @endif
                                </td>
                                <td class="text-align-right">
                                    <div class="kt-portlet__head-toolbar">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @lang('product::invoice.index.action')
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                @include('helpers.button', ['button' => [
                                                            'route' => 'product.service.edit',
                                                             'html' =>  '<a href="'.route('product.invoice.edit', ['id' => $item['invoice_no']]).'"  class="dropdown-item">'
                                                             .'<i class="la la-edit"></i>'
                                                             .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::invoice.input.update').'</span>'.
                                                        '</a>'
                                                    ]])
                                                @if($item['status'] == 'new')
{{--                                                    CHức năng xuất hóa đơn điện tử--}}
{{--                                                    @include('helpers.button', ['button' => [--}}
{{--                                                            'route' => '',--}}
{{--                                                             'html' =>  '<a href=""  class="dropdown-item">'--}}
{{--                                                             .'<i class="fa fa-file-invoice-dollar"></i>'--}}
{{--                                                             .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::invoice.input.invoice').'</span>'.--}}
{{--                                                        '</a>'--}}
{{--                                                    ]])--}}
                                                @endif
                                                @if($item['receipt_status'] == 'unpaid' || $item['receipt_status'] == 'part-paid' )
                                                    @include('helpers.button', ['button' => [
                                                        'route' => 'product.receipt.payment-receipt',
                                                        'html' => '<a href="'.route('product.receipt.payment-receipt', ['id' => $item['receipt_no'],
                                                        'invoice_no'=>$item['invoice_no'] ]).'" class="dropdown-item">'
                                                        .'<i class="la la-money"></i>'
                                                        .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::customer.receipt.receipt_action').'</span>'.
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

        {{$list_invoice->appends($filter)->links('helpers.paging')}}
</div>
