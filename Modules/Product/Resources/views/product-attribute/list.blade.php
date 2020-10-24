<div class="kt-section__content">
    <div class="row">
        <div class="col-12">
            <div class="table_responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute.index.stt')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute.index.code')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute.index.attribute')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute.index.attribute_group')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute.index.create_by')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute.index.create_at')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute.index.update_by')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute.index.update_at')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute.index.status')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute.index.action')
                            </p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($list) && $list->count() > 0)
                        <?php $tmp = ($list->currentPage()*$list->perPage()) - $list->perPage() + 1 ?>
                        @foreach ($list as $key => $item)
                            <tr>
                                <td>
{{--                                    {{$filter['page'] * $perpage + $key + 1}}--}}
                                    {{$tmp++}}
                                </td>
                                <td>
                                    <a href="{{route('product.product-attribute.show', ['code' => $item['product_attribute_code']])}}"
                                       title="{{$item['product_attribute_code'] }}">
                                        {{ subString($item['product_attribute_code']) }}
                                    </a>
                                </td>
                                <td>
                                    {{ subString($item[getValueByLang('product_attribute_name_')]) }}
                                </td>
                                <td>
                                    {{ subString($item[getValueByLang('product_attribute_group_name_')]) }}
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
                                    @if($item['modified_at'] != '')
                                        {{(new DateTime($item['modified_at']))->format('d/m/Y H:i:s')}}
                                    @endif
                                </td>
                                <td>
                                    @if($item['is_actived'] == 1)
                                        <span class="text-info text">
                                    @lang('product::attribute.index.is_active')
                                </span>
                                    @else
                                        <span class="text-danger">
                                    @lang('product::attribute.index.inactive')
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
                                                'route' => 'product.product-attribute.edit',
                                                'html' => '<a href="'.route('product.product-attribute.edit', ['code' => $item['product_attribute_code']]).'" class="dropdown-item">'
                                                .'<i class="la la-edit"></i>'
                                                .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::admin-group.edit').'</span>'.
                                                '</a>'
                                                ]])
                                                @include('helpers.button', ['button' => [
                                                'route' => 'product.product-attribute.destroy',
                                                'html' => '<a href="javascript:void(0)" onclick="attribute.remove('.$item['product_attribute_id'].')" class="dropdown-item">'
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
        </div>
    </div>

    {{--<input type="hidden" name="sort_admin_group$group_name" value="{{$filter['sort_admin_group$group_name']}}"--}}
    {{--id="sort_group_name">--}}
    {{--<input type="hidden" name="sort_admin_group$group_description" value="{{$filter['sort_admin_group$group_description']}}"--}}
    {{--id="sort_group_description">--}}
    {{$list->appends($filter)->links('helpers.paging')}}
</div>
