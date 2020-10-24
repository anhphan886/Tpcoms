<table class="table table-striped" id="table-popup-user">
    <thead>
    <tr>
        <th>
            <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                <input type="checkbox" onclick="adminGroup.selectAll(this, 'table-popup-user')">
                <span></span>
            </label>
        </th>
        <th>@lang('core::admin-group.user_full_name')</th>
        <th>@lang('core::admin-group.user_email')</th>
    </tr>
    </thead>
    <tbody>
    @if (isset($list_user) && count($list_user) > 0)
        @foreach ($list_user as $item)
            <tr>
                <td>
                    <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                        <input type="checkbox"
                               value="{{ $item['id'] }}"
                        >
                        <span></span>
                    </label>
                </td>
                <td>
                    <p title="{{ $item['full_name'] }}">
                        {{ subString($item['full_name']) }}
                    </p>
                </td>
                <td>
                    <p title="{{ $item['email'] }}">
                        {{ subString($item['email']) }}
                    </p>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3" class="text-center">@lang('core::admin-group.data_null')</td>
        </tr>
    @endif
    </tbody>
</table>
