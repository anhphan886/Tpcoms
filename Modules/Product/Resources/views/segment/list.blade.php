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
                                @lang('product::segment.index.name_vi')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::segment.index.name_en')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::segment.index.created_at')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::segment.index.created_by')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::segment.index.updated_at')
                            </p>
                        </th>
                        <th id="th_group_name">
                            <p class="pn-pointer">
                                @lang('product::segment.index.updated_by')
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
                                    <a href="{{route('product.segment.show', ['id' => $item['id']])}}"
                                       title="{{$item['name'] }}">
                                        {{ subString($item['name']) }}
                                    </a>
                                </td>
                                <td>
                                    {{subString($item['name_en'])}}
                                </td>
                                <td>
                                    @if($item['created_at'] != '')
                                        {{(new DateTime($item['created_at']))->format('d/m/Y')}}
                                    @endif
                                </td>
                                <td>
                                    {{$item['created_by']}}
                                </td>
                                <td>
                                    @if($item['created_at'] != '')
                                        {{(new DateTime($item['updated_at']))->format('d/m/Y')}}
                                    @endif
                                </td>
                                <td>
                                    {{$item['updated_by']}}
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
                                                'route' => 'product.segment.edit',
                                                'html' => '<a href="'.route('product.segment.edit', ['id' => $item['id']]).'" class="dropdown-item">'
                                                .'<i class="la la-edit"></i>'
                                                .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::admin-group.edit').'</span>'.
                                                '</a>'
                                                ]])
                                                @if(isset($item['cus_segment_id']) && $item['cus_segment_id'] != null)

                                                @else
                                                    @include('helpers.button', ['button' => [
                                                       'route' => 'product.segment.destroy',
                                                       'html' => '<a href="javascript:void(0)" onclick="segment.remove('.$item['id'].')" class="dropdown-item">'
                                                       .'<i class="la la-trash"></i>'
                                                       .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::admin-group.remove').'</span>'.
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

    {{--<input type="hidden" name="sort_admin_group$group_name" value="{{$filter['sort_admin_group$group_name']}}"--}}
    {{--id="sort_group_name">--}}
    {{--<input type="hidden" name="sort_admin_group$group_description" value="{{$filter['sort_admin_group$group_description']}}"--}}
    {{--id="sort_group_description">--}}
    {{$list->appends($filter)->links('helpers.paging')}}
</div>
