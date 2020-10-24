<table class="table table-striped" id="table-popup-menu">
    <thead>
    <tr>
        <th>
            <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                <input type="checkbox" onclick="adminGroup.selectAll(this, 'table-popup-menu')">
                <span></span>
            </label>
        </th>
        <th>@lang('core::admin-group.admin_menu_name')</th>
        <th>@lang('core::admin-group.admin_menu_position')</th>
    </tr>
    </thead>
    <tbody>
    @if (isset($list_menu) && count($list_menu) > 0)
        @foreach ($list_menu as $item)
            <tr>
                <td>
                    <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                        <input type="checkbox" value="{{ $item['menu_id'] }}">
                        <span></span>
                    </label>
                </td>
                <td>
                    <p title="{{ $item['menu_name'] }}">
                        {{ subString($item['menu_name']) }}
                    </p>
                </td>
                <td>{{ $item['menu_position'] }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3" class="text-center">@lang('core::admin-group.data_null')</td>
        </tr>
    @endif
    </tbody>
</table>
