<div class="kt-section__content">
    <div class="table_responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th id="th_group_name">
                    <p class="pn-pointer">
                        @lang('product::product-template.index.stt')
                    </p>
                </th>
                <th id="th_group_name">
                    <p class="pn-pointer">
                        @lang('product::product-template.index.code')
                    </p>
                </th>
                <th id="th_group_name">
                    <p class="pn-pointer">
                        @lang('product::product-template.index.service')
                    </p>
                </th>
                <th id="th_group_name">
                    <p class="pn-pointer">
                        @lang('product::product-template.index.category')
                    </p>
                </th>
                <th id="th_group_name">
                    <p class="pn-pointer">
                        @lang('product::product-template.index.create_by')
                    </p>
                </th>
                <th id="th_group_name">
                    <p class="pn-pointer">
                        @lang('product::product-template.index.create_at')
                    </p>
                </th>
                <th id="th_group_name">
                    <p class="pn-pointer">
                        @lang('product::product-template.index.update_by')
                    </p>
                </th>
                <th id="th_group_name">
                    <p class="pn-pointer">
                        @lang('product::product-template.index.update_at')
                    </p>
                </th>
                <th id="th_group_name">
                    <p class="pn-pointer">
                        @lang('product::product-template.index.status')
                    </p>
                </th>
                <th id="th_group_name">
                    <p class="pn-pointer">
                        @lang('product::product-template.index.action')
                    </p>
                </th>
            </tr>
            </thead>
            <tbody>
            @if (isset($list) && count($list) > 0)
                <?php $tmp = ($list->currentPage()*$list->perPage()) - $list->perPage() + 1 ?>
                @foreach ($list as $key => $item)
                    <tr>
                        <td>
{{--                            {{$filter['page']*10 + $key + 1}}--}}
                            {{$tmp++}}
                        </td>
                        <td>
                            <a href="{{route('product.product-template.show', ['code' => $item['product_code']])}}"
                               title="{{$item['product_code'] }}">
                                {{ subString($item['product_code']) }}
                            </a>
                        </td>
                        <td>
                            {{ subString($item[getValueByLang('product_name_')]) }}
                        </td>
                        <td>
                            @foreach($product as $value)
                                @if($value['product_id'] == $item['parent_id'])
                                    {{ subString($value[getValueByLang('product_name_')]) }}
                                @endif
                            @endforeach
                            {{ subString($item[getValueByLang('category_name_')]) }}
                        </td>
                        <td>
                            {{ subString($item['create_full_name']) }}
                        </td>
                        <td>
                            @if($item['created_at'] != '')
                                {{(new DateTime($item['created_at']))->format('d/m/Y H:i:s')}}
                            @endif
                        </td>
                        <td>
                            {{ subString($item['update_full_name']) }}
                        </td>
                        <td>
                            @if($item['updated_at'] != '')
                                {{(new DateTime($item['updated_at']))->format('d/m/Y H:i:s')}}
                            @endif
                        </td>
                        <td class="text-align-right">
                            @if($item['is_actived'] == 1)
                                <span class="text-info btn-new">
                                    @lang('product::product-template.index.is_active')
                                </span>
                            @else
                                <span class="text-danger btn-cancelled">
                                    @lang('product::product-template.index.inactive')
                                </span>
                            @endif
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
                                        'route' => 'product.product-template.edit',
                                        'html' => '<a href="'.route('product.product-template.edit', ['code' => $item['product_code']]).'" class="dropdown-item">'
                                        .'<i class="la la-edit"></i>'
                                        .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::admin-group.edit').'</span>'.
                                        '</a>'
                                        ]])
                                        @include('helpers.button', ['button' => [
                                        'route' => 'product.product.destroy',
                                        'html' => '<a href="javascript:void(0)" onclick="product.remove('.$item['product_id'].')" class="dropdown-item">'
                                        .'<i class="la la-trash"></i>'
                                        .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::admin-group.remove').'</span>'.
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
    {{--<input type="hidden" name="sort_admin_group$group_name" value="{{$filter['sort_admin_group$group_name']}}"--}}
    {{--id="sort_group_name">--}}
    {{--<input type="hidden" name="sort_admin_group$group_description" value="{{$filter['sort_admin_group$group_description']}}"--}}
    {{--id="sort_group_description">--}}
        {{$list->appends($filter)->links('helpers.paging')}}
</div>
