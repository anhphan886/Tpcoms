@if (isset($list_group) && count($list_group) > 0)
    @foreach ($list_group as $item)
        <tr class="group-item">
            <td>
                <p title="{{ $item['group_name'] }}">
                    {{ subString($item['group_name']) }}
                </p>
                <input type="hidden" name="group_id[]" value="{{ $item['group_id'] }}">
            </td>
            <td>
                <p title="{{ $item['group_description'] }}">
                    {{ subString($item['group_description']) }}
                </p>
            </td>
            <td>
                <select class="form-control" onchange="adminMenu.removeRow(this)">
                    <option value="">Hành động</option>
                    <option value="1">@lang('core::admin-menu.index.TABLE_REMOVE')</option>
                </select>
            </td>
        </tr>
    @endforeach
@endif
