<div class="kt-section__content">
    <div class="row">
        <div class="col-12">
            <div class="table_responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute-group.index.stt')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::product-category.index.product_category')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute-group.index.create_by')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute-group.index.create_at')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute-group.index.update_by')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute-group.index.update_at')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::attribute-group.index.action')
                            </p>
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($list) && $list->count() > 0)
                        @foreach ($list as $key => $item)
                            <tr>
                                <td>
                                    {{$filter['page']*10 + $key + 1}}
                                </td>
                                <td>
                                    <a href="{{route('product.product-category.show', ['id' => $item['product_category_id']])}}"
                                       title="{{$item['product_attribute_group_name_'] }}">
                                        {{ subString($item[getValueByLang('category_name_')]) }}
                                    </a>

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
                                    <div class="kt-portlet__head-toolbar">
                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                    class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                @lang('product::product-category.index.action')
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                @include('helpers.button', ['button' => [
                                                'route' => 'product.product-category.edit',
                                                'html' => '<a href="'.route('product.product-category.edit', ['id' => $item['product_category_id']]).'" class="dropdown-item">'
                                                .'<i class="la la-edit"></i>'
                                                .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::admin-group.edit').'</span>'.
                                                '</a>'
                                                ]])
                                                @include('helpers.button', ['button' => [
                                                'route' => 'product.product-category',
                                                'html' => '<a href="javascript:void(0)" onclick="productCategory.remove('.$item['product_category_id'].')" class="dropdown-item">'
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
