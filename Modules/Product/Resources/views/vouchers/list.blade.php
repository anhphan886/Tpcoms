<div class="kt-section__content">
    <div class="row">
        <div class="col-12">
            <div class="table_responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::voucher.index.stt')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::voucher.index.code')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::voucher.index.type')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::voucher.index.expire_date')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::voucher.index.total_use')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::voucher.index.is_actived')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::voucher.index.action')
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
                                    <a href="{{route('product.voucher.detail', ['id' => $item['voucher_id']])}}">
                                        {{ subString($item['code']) }}
                                    </a>
                                </td>
                                <td>
{{--                                    {{ ($item['type']) }}--}}
                                    @if($item['type'] == 'sale_cash')
                                        @lang('product::voucher.index.sale_cash')
                                    @elseif($item['type'] == 'sale_percent')
                                        @lang('product::voucher.index.sale_percent')
                                    @endif
                                </td>
                                <td> @if( $item['expired_date'] == null || $item['expired_date'] == '0000-00-00 00:00:00')
                                     @else
                                        {{(new DateTime($item['expired_date']))->format('d/m/Y')}}
                                     @endif

                                </td>
                                <td>
                                    @if(isset($totalUse[$item['code']]))
                                        {{$totalUse[$item['code']]}}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
{{--                                    @if(($item['quota'] != 0 && $item['total_use'] >= $item['quota']) || \Carbon\Carbon::now() >= $item['expired_date'])--}}
{{--                                    @if( isset($item['voucher_code']) && $item['voucher_code'] != null)--}}
{{--                                        <span class="kt-switch kt-switch--success">--}}
{{--                                            <label>--}}
{{--                                                <input disabled type="checkbox" name="" onchange="voucher.change_status('{{$item['voucher_id']}}',this)"--}}
{{--                                                       @if($item['is_actived'] == 1) checked @endif>--}}
{{--                                                <span></span>--}}
{{--                                            </label>--}}
{{--                                        </span>--}}
{{--                                    @else--}}
                                        <span class="kt-switch kt-switch--success">
                                            <label>
                                                <input type="checkbox" name="" onchange="voucher.change_status('{{$item['voucher_id']}}',this)"
                                                       @if($item['is_actived'] == 1) checked @endif>
                                                <span></span>
                                            </label>
                                        </span>
{{--                                    @endif--}}
                                </td>
                                <td>
                                    @if( isset($item['voucher_code']) && $item['voucher_code'] != null)
{{--                                        @if( \Carbon\Carbon::now() >= $item['expired_date'])--}}
                                    @else
                                        <div class="kt-portlet__head-toolbar">
                                            <div class="btn-group" role="group">
                                                <button type="button"
                                                        class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    @lang('product::voucher.index.action')
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                    @include('helpers.button', ['button' => [
                                                        'route' => 'product.voucher.destroy',
                                                        'html' => '<a href="javascript:void(0)" onclick="voucher.remove('.$item['voucher_id'].')" class="dropdown-item">'
                                                        .'<i class="la la-trash"></i>'
                                                        .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::admin-group.remove').'</span>'.
                                                        '</a>'
                                                    ]])

                                                    @include('helpers.button', ['button' => [
                                                    'route' => 'product.voucher.edit',
                                                    'html' => '<a href="'.route('product.voucher.edit', ['id' => $item['voucher_id']]).'" class="dropdown-item">'
                                                    .'<i class="la la-edit"></i>'
                                                    .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::admin-group.edit').'</span>'.
                                                    '</a>'
                                                    ]])
                                                </div>
                                            </div>
                                        </div>
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

    {{--<input type="hidden" name="sort_admin_group$group_name" value="{{$filter['sort_admin_group$group_name']}}"--}}
    {{--id="sort_group_name">--}}
    {{--<input type="hidden" name="sort_admin_group$group_description" value="{{$filter['sort_admin_group$group_description']}}"--}}
    {{--id="sort_group_description">--}}
    {{$list->appends($filter)->links('helpers.paging')}}
</div>
