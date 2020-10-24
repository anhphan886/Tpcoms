@if (isset($list_action_all) && count($list_action_all) > 0)
    @foreach ($list_action_all as $menu_name => $list_item)
        @if ($menu_name == $item->menu_name && count($list_item) > 0)
            @foreach ($list_item as $value)
                <div class="col">
                    {{ $value['action_name'] }}
                </div>
            @endforeach
        @endif
    @endforeach
@endif
