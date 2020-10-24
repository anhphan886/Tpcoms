@if (isset($list_menu) && count($list_menu) > 0)
    @foreach ($list_menu as $item)
        <tr class="menu-item">
            <td>
                <p title="{{ $item['menu_name'] }}">{{ subString($item['menu_name']) }}</p>
                <input type="hidden" name="menu_id[]" value="{{ $item['menu_id'] }}">
            </td>
            <td>
                <p>{{ $item['menu_position'] }}</p>
            </td>
            <td>
                <select class="form-control" onchange="adminGroup.removeRow(this)">
                    <option value="">Hành động</option>
                    <option value="1">@lang('core::admin-group.remove')</option>
                </select>
            </td>
        </tr>
    @endforeach
@endif
