<div class="kt-section__content">
    <form id="form-filter" action="{{route('core.admin-group.index')}}">
        <table class="table table-striped">
            <thead>
            <tr>
                <th id="th_group_name">
                    <p class="pn-pointer" onclick="adminGroup.sort(this, 'group_name')"
                       data-sort="{{ ($filter['sort_admin_group$group_name'] == 'asc') ? 'desc' : 'asc' }}">
                        @lang('core::admin-group.admin_group_name')
                        @if (isset($_GET['sort_admin_group$group_name']) && $_GET['sort_admin_group$group_name'] != null)
                            <i class="fa {{ ($filter['sort_admin_group$group_name'] == 'asc') ? 'fa-sort-amount-up' : 'fa-sort-amount-down' }}"></i>
                        @endif
                    </p>
                </th>
                <th id="th_group_description">
                    <p class="pn-pointer" onclick="adminGroup.sort(this, 'group_description')"
                       data-sort="{{ ($filter['sort_admin_group$group_description'] == 'asc') ? 'desc' : 'asc' }}">
                        @lang('core::admin-group.admin_group_description')
                        @if (isset($_GET['sort_admin_group$group_description']) && $_GET['sort_admin_group$group_description'] != null)
                            <i class="fa {{ ($filter['sort_admin_group$group_description'] == 'asc') ? 'fa-sort-amount-up' : 'fa-sort-amount-down' }}"></i>
                        @endif
                    </p>
                </th>
                <th>
                    <p class="pn-pointer">
                        @lang('core::user.index.ACTION')
                    </p>
                </th>
            </tr>
            </thead>
            <tbody>
            @if (isset($list) && $list->count() > 0)
                @foreach ($list as $item)
                    <tr>
                        <td>
                            <a href="{{ route('core.admin-group.show', ['id' => $item->group_id]) }}"
                               title="{{ $item->group_name }}">
                                {{ subString($item->group_name) }}
                            </a>
                        </td>
                        <td>
                            <p title="{{ $item->group_description }}">
                                {{ subString($item->group_description) }}
                            </p>
                        </td>
                        <td>
                            <div class="kt-portlet__head-toolbar">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Hành động
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                        @include('helpers.button', ['button' => [
                                                    'route' => 'core.admin-group.edit',
                                                     'html' => '<a href="'.route('core.admin-group.edit', ['id' => $item->group_id]).'" class="dropdown-item">'
                                                     .'<i class="la la-edit"></i>'
                                                     .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::admin-group.edit').'</span>'.
                                                '</a>'
                                            ]])
                                        @include('helpers.button', ['button' => [
                                                    'route' => 'core.admin-group.add-user-into-group',
                                                     'html' => '<a href="'.route('core.admin-group.add-user-into-group', ['id' => $item->group_id]).'" class="dropdown-item">'
                                                     .'<i class="la la-user"></i>'
                                                     .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::admin-group.add_user_into_group').'</span>'.
                                                '</a>'
                                            ]])
                                        @include('helpers.button', ['button' => [
                                                   'route' => 'core.admin-group.destroy',
                                                    'html' => '<a href="javascript:void(0)" onclick="adminGroup.removeGroup('.$item->group_id.')" class="dropdown-item">'
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
        <input type="hidden" name="sort_admin_group$group_name" value="{{$filter['sort_admin_group$group_name']}}"
               id="sort_group_name">
        <input type="hidden" name="sort_admin_group$group_description" value="{{$filter['sort_admin_group$group_description']}}"
               id="sort_group_description">
    </form>
    {{$list->appends($filter)->links('helpers.paging')}}
</div>
