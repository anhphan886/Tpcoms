<table class="table table-striped" id="table-popup-group-child">
    <thead>
    <tr>
        <th>
            <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                <input type="checkbox" id="select-all-group-child" onclick="Add.selectAllGroup(this)">
                <span></span>
            </label>
        </th>
        <th>@lang('core::admin-group.admin_group_name')</th>
    </tr>
    </thead>
    <tbody>
    @if (isset($list_group_child) && count($list_group_child) > 0)
        @foreach ($list_group_child as $item)
            <tr>
                <td>
                    <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                        <input type="checkbox"
                               value="{{ $item['group_id'] }}"
                        >
                        <span></span>
                    </label>
                </td>
                <td>{{ $item['group_name'] }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
