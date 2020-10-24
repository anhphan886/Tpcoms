<table class="table table-striped" id="table-list-user">
    <thead>
    <tr>
        <th>@lang('core::admin-group.user_full_name')</th>
        <th>@lang('core::admin-group.user_email')</th>
    </tr>
    </thead>
    <tbody>
    @if (isset($admin_has_group) && count($admin_has_group) > 0)
        @foreach ($admin_has_group as $item)
            <tr class="user-item">
                <td>
                    <p title="{{ $item['full_name'] }}">{{ subString($item['full_name']) }}</p>
                </td>
                <td>
                    <p title="{{ $item['email'] }}">{{ subString($item['email']) }}</p>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
