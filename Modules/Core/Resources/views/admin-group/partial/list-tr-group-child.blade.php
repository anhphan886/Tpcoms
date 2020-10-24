@if (isset($list_group_child) && count($list_group_child) > 0)
    @foreach ($list_group_child as $item)
        <tr class="group-child-item">
            <td>
                <p>{{ $item['group_name'] }}</p>
                <input type="hidden" name="group_child_id[]" value="{{ $item['group_id'] }}">
            </td>
            <td>
                <button type="button" class="btn btn-danger" onclick="adminGroup.removeRow(this)">
                    @lang('core::admin-group.index.TABLE_REMOVE')
                </button>
            </td>
        </tr>
    @endforeach
@endif
