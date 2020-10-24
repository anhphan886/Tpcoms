@if (isset($list_user) && count($list_user) > 0)
    @foreach ($list_user as $item)
        <tr class="user-item">
            <td>
                <p title="{{ $item['full_name'] }}">{{ subString($item['full_name']) }}</p>
                <input type="hidden" name="admin_id[]" value="{{ $item['id'] }}">
            </td>
            <td>
                <p title="{{ $item['email'] }}">{{ subString($item['email']) }}</p>
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
