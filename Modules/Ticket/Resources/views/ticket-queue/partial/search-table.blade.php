    <div  class="row">
        <div class="form-group col-12 col-sm-4 col-md-6 nt-padding">
            <div class="col-lg-12">
                <select class="form-control kt-select2" id="kt_select2_1" name="keyword_ad1$full_name" >
                    <option value="">
                        @lang('ticket::queue.index.select-creator')
                    </option>
                    @if (isset($listAdmin))
                        @foreach( $listAdmin as $item)
                                <option value="{{$item['full_name']}}" {{ isset($filter['keyword_ad1$full_name']) && $filter['keyword_ad1$full_name'] == $item['full_name'] ? "selected" : "" }} >{{ $item['full_name'] }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group col-12 col-sm-4 col-md-6">
            <div class="col-lg-12">
                <div class="input-group date">
                    <input class="form-control tung1" readonly name="keyword_ticket_queue$date_created" value="{{isset($filter['keyword_ticket_queue$date_created']) ? $filter['keyword_ticket_queue$date_created'] :"" }}" placeholder="@lang('ticket::queue.index.select-creation-date')" id="kt_datepicker_2" />
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-12 col-sm-4 col-md-8">
            <div class="row">
                <div class="form-group col-lg-6 col-md-6">
                    <input class="form-control" type="text" id="keyword_ticket_queue$queue_name"
                           name="keyword_ticket_queue$queue_name"
                           placeholder="@lang('ticket::queue.table.queue_name')" value="{{isset($filter['keyword_ticket_queue$queue_name']) ? $filter['keyword_ticket_queue$queue_name'] :"" }}">
                </div>

                <div class="form-group col-lg-6 col-md-6 text-align-right-mobile">
                    <a class="btn btn-secondary btn-hover-brand" href="{{route('ticket.queue.index')}}">
                        @lang('ticket::queue.input.button-remove')
                    </a>
                    <button type="submit"
                            class="btn btn-primary btn-hover-brand">
                        @lang('ticket::queue.input.button-search')
                    </button>
                </div>
            </div>
        </div>
    </div>


