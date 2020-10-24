<div class="kh-df">
<div class="kt-timeline-v3">
    <div class="kt-timeline-v3__items">
        @if (isset($listHistory))
            @foreach ($listHistory as $item)
                <div class="kt-timeline-v3__item kt-timeline-v3__item--info">
                    <span class="kt-timeline-v3__item-time">{{ date('d-m-Y H:i', strtotime($item['date_modified'])) }}</span>
                    <div class="kt-timeline-v3__item-desc">
                        <span class="kt-timeline-v3__item-text">
                            {!! $item['note'] !!}
                        </span><br>
                        <span class="kt-timeline-v3__item-user-name">By {{ $item['full_name'] }}</span>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
</div>
@if (isset($listHistory))
    {{ $listHistory->links('helpers.paging') }}
@endif
