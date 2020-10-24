@if (isset($button['route']) && isset($button['html']))
    @if (in_array($button['route'], request()->session()->get('user_route')) || Auth::user()->is_admin)
        {!! $button['html'] !!}
    @else
        @if (isset($button['default']))
            {!! $button['default'] !!}
        @endif
    @endif
@endif
