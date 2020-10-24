<div class="kt-section__content">
    <div class="row">
        <div class="col-12">
            <div class="table_responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::contract.index.stt')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::contract.index.contract_code')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::contract.index.customer')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::contract.index.province')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::contract.index.status')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::contract.index.file_contract_example')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::contract.index.file_contract')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::contract.index.sign')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::contract.index.upload_file_scan')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::contract.index.contract_date')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::contract.index.action')
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
                                    <a href="{{route('product.contract.show', ['id' => $item['customer_contract_id']])}}"
                                       title="{{$item['contract_no'] }}">
                                        {{ subString($item['contract_no']) }}
                                    </a>
                                </td>
                                <td>
                                    {{ ($item['customer_name']) }}
                                </td>
                                <td>
                                    {{ $item['type'] != null ? $item['type'] : '' }} {{ $item['name'] != null ? $item['name'] : '' }}
                                </td>
                                <td class="text-right">
                                    @if($item['status'] == 'new')
                                        <span class="text-primary btn-new">
                                            @lang('product::contract.index.new')
                                        </span>
                                    @elseif($item['status'] == 'waiting_sign')
                                                    <span class="text-info btn-new">
                                            @lang('product::contract.index.waiting_sign')
                                        </span>
                                    @elseif($item['status'] == 'waiting_approved')
                                                    <span class="text-warning btn-waiting-payment">
                                            @lang('product::contract.index.waiting_approved')
                                        </span>
                                    @elseif($item['status'] == 'approved')
                                                    <span class="text-success btn-finished">
                                        @lang('product::contract.index.approved')
                                        </span>
                                    @elseif($item['status'] == 'approved_cancel')
                                                    <span class="text-danger btn-cancelled">
                                            @lang('product::contract.index.approved_cancel')
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @foreach($contractFile as $value)
                                        @if($value['file_type'] == 'contract_sample' && $value['customer_contract_id'] == $item['customer_contract_id'])
                                            <a href="{{BASE_URL_API.($value['link_file'])}}" title="{{$value['file_name']}}" target="_blank">
                                                {{ subString($value['file_name'], 25) }}<br>
                                            </a>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($contractFile as $value)
                                        @if($value['file_type'] == 'contract_customer_sign' && $value['customer_contract_id'] == $item['customer_contract_id'])
                                            <a href="{{BASE_URL_API.($value['link_file'])}}" title="{{$value['file_name']}}" target="_blank">
                                                {{ subString($value['file_name'], 25) }}<br>
                                            </a>
                                        @endif
                                    @endforeach
                                </td>
                                <td></td>
                                <td>
                                    <label class="btn btn-sm btn-secondary">
                                        Upload
                                        <input accept="application/pdf, .doc, .docx"
                                         onchange="contract.upload('{{$item['customer_contract_id']}}', this)" type="file"
                                        style="display: none" value="{{1}}">
                                    </label>
                                </td>
                                <td>
                                    @if($item['contract_date'] != '')
                                        {{(new DateTime($item['contract_date']))->format('d/m/Y')}}
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-secondary"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @lang('product::order.index.action')
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"
                                             x-placement="bottom-start"
                                             style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a href="javascript:void(0)"
                                               onclick="contract.action({{$item['customer_contract_id']}}, 'approve')"
                                               class="dropdown-item">
                                                <i class="la la-check"></i>
                                                @lang('product::contract.index.approved_action')
                                            </a>
                                            <a href="javascript:void(0)"
                                               onclick="contract.action({{$item['customer_contract_id']}}, 'cancel')"
                                               class="dropdown-item">
                                                <i class="la la-remove"></i>
                                                @lang('product::contract.index.cancel')
                                            </a>
                                            @include('helpers.button', ['button' => [
                                               'route' => 'product.contract.edit',
                                               'html' => '<a href="'.route('product.contract.edit', ['id' => $item['customer_contract_id']]).'" class="dropdown-item">'
                                               .'<i class="la la-edit"></i>'
                                               .'<span class="kt-nav__link-text kt-margin-l-5">'.'Chỉnh Sửa'.'</span>'.
                                               '</a>'
                                               ]])
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

    {{--<input type="hidden" name="sort_admin_group$group_name" value="{{$filter['sort_admin_group$group_name']}}"--}}
    {{--id="sort_group_name">--}}
    {{--<input type="hidden" name="sort_admin_group$group_description" value="{{$filter['sort_admin_group$group_description']}}"--}}
    {{--id="sort_group_description">--}}
    {{$list->appends($filter)->links('helpers.paging')}}
</div>
