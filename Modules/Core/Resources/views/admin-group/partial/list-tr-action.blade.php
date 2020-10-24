@if (isset($list_action) && count($list_action) > 0)
    @foreach ($list_action as $item)
        <tr class="action-item">
            <td>
                <p title="{{ $item['action_name'] }}">{{ subString($item['action_name']) }}</p>
                <input type="hidden" name="action_id[]" value="{{ $item['action_id'] }}">
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
