<table class="table table-striped" id="table-popup-group">
    <thead>
    <tr>
        <th>
            <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                <input type="checkbox" id="select-all-group">
                <span></span>
            </label>
        </th>
        <th>@lang('core::admin-action.edit.ADMIN_GROUP_NAME')</th>
    </tr>
    </thead>
    <tbody>
    @if (isset($list_group) && count($list_group) > 0)
        @foreach ($list_group as $item)
            <tr>
                <td>
                    <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                        <input type="checkbox"
                               value="{{ $item['group_id'] }}"
                        >
                        <span></span>
                    </label>
                </td>
                <td>
                    <p title="{{ $item['group_name'] }}">{{ subString($item['group_name']) }}</p>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
