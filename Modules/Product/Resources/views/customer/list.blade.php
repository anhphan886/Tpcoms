<div class="kt-section__content">
    <div class="row">
        <div class="col-12">
            <div class="table_responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th id="th_group_name">
                            <p>
                                @lang('product::customer.index.stt')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p>
                                @lang('product::customer.index.customer_code')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p>
                                @lang('product::customer.index.customer')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p>
                                @lang('product::customer.index.cmnd_mst')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p>
                                @lang('product::customer.index.type')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p>
                                @lang('product::customer.index.province')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p>
                                @lang('product::customer.index.created_at')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="text-align-right">
                                @lang('product::customer.index.status')
                            </p>
                        </th>
                        <th>

                        </th>
                        <th id="th_group_name">
                            <p>
                                @lang('product::customer.index.action')
                            </p>
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($list) && count($list) > 0)
                        @foreach ($list as $key => $item)
                            <tr>
                                <td>
                                    {{($filter['page'] - 1) * $perpage + $key + 1}}
                                </td>
                                <td>
                                    <a href="{{route('product.customer.detail', ['id'=> $item['customer_id']])}}">
                                        {{$item['customer_no']}}
                                    </a>
                                </td>
                                <td>
                                    {{ ($item['customer_name']) }}
                                </td>
                                <td>
                                    {{ ($item['customer_id_num']) }}
                                </td>
                                <td>
                                    @if($item['customer_type'] == 'personal')
                                        @lang('product::customer.index.customer_personal')
                                    @elseif($item['customer_type'] == 'enterprise')
                                        @lang('product::customer.index.customer_enterprise')
                                    @endif
                                </td>
                                <td>
                                    {{ $item['province_type'] != null ? $item['province_type'] : '' }}
                                    {{ $item['province_name'] != null ? $item['province_name'] : '' }}
                                </td>
                                <td>
                                    @if($item['created_at'] != '')
                                        {{(new DateTime($item['created_at']))->format('d/m/Y H:i:s')}}
                                    @endif
                                </td>
                                <td class="text-align-right">
                                    @if($item['status'] == 'new')
                                        <span class="text-primary btn-new">
                                        @lang('product::customer.index.new')
                                    </span>
                                    @elseif($item['status'] == 'verified')
                                        <span class="text-success btn-finished">
                                            @lang('product::customer.index.verified')
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="kt-switch kt-switch--success">
                                    <label>
                                        <input type="checkbox" name="" onchange="customer.changeStatus('{{$item['customer_email']}}',this)"
                                               @if($item['is_active'] == 1) checked @endif>
                                        <span></span>
                                    </label>
                            </span>
                                </td>
                                <td>
                                    <div class="kt-portlet__head-toolbar">
                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                    class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                @lang('product::attribute-group.index.action')
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                @include('helpers.button', ['button' => [
                                                'route' => 'product.customer.edit',
                                                'html' => '<a href="'.route('product.customer.edit', ['id' => $item['customer_id']]).'" class="dropdown-item">'
                                                .'<i class="la la-edit"></i>'
                                                .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::customer.index.edit').'</span>'.
                                                '</a>'
                                                ]])
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

    @if(isset($list) && count($list) > 0)
        {{$list->appends($filter)->links('helpers.paging')}}
    @endif
</div>
