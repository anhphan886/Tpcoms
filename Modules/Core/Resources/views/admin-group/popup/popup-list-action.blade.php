<table class="table table-striped" id="table-popup-action">
    <thead>
    <tr>
        <th>
            <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                <input type="checkbox" onclick="adminGroup.selectAll(this, 'table-popup-action')">
                <span></span>
            </label>
        </th>
        <th>@lang('core::admin-group.admin_action_name')</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @if (isset($list_action) && count($list_action) > 0)
        @foreach ($list_action as $index => $item)
            @if (count($item) > 0)
                @foreach ($item as $key => $value)
                    <tr>
                        <td>
                            <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                                <input type="checkbox"
                                       value="{{ $value['action_id'] }}"
                                >
                                <span></span>
                            </label>
                        </td>
                        <td>
                               {{ subString($value['action_name']) }}
                        </td>
                        @if ($key == 0)
                            {{--<td rowspan="{{ count($item) }}">--}}
                                {{--{{ $value['action_group_name'] }}--}}
                            {{--</td>--}}
                        @endif
                        <td></td>
                    </tr>
                @endforeach
            @endif
        @endforeach
    @else
        <tr>
            <td colspan="2" class="text-center">@lang('core::admin-group.data_null')</td>
        </tr>
    @endif
    </tbody>
</table>
