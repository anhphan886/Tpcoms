
    <div  class="row">
        <div class="form-group col-lg-6 nt-padding">
            <div class=" col-lg-12">
                <select class="form-control kt-select2" id="kt_select2_1" name="keyword_ad1$full_name" >
                    <option value="">
                        @lang('ticket::issue-group.index.select-creator')
                    </option>
                    @if (isset($listAdmin))
                        @foreach( $listAdmin as $item)
                                <option value="{{$item['full_name']}}" {{ isset($filter['keyword_ad1$full_name']) && $filter['keyword_ad1$full_name'] == $item['full_name'] ? "selected" : "" }}>
                                        {{ $item['full_name'] }}
                                </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group col-lg-6 ">
            <div class="col-lg-12">
                <div class="input-group date">
                    <input class="form-control tung1" readonly
                           name="keyword_ticket_issue_group$date_created"
                           placeholder="@lang('ticket::issue-group.index.select-creation-date')" id="kt_datepicker_2"
                           value="{{isset($filter['keyword_ticket_issue_group$date_created']) ? $filter['keyword_ticket_issue_group$date_created'] :"" }}"  />
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-lg-12">
            <div class="row">
                <div class="form-group col-lg-6">
                    <input class="form-control" type="text" id="keyword_ticket_issue_group$issue_group_name_vi"
                           name="keyword_ticket_issue_group$issue_group_name_vi"
                           placeholder="@lang('ticket::issue-group.index.issue_group')"
                           value="{{isset($filter['keyword_ticket_issue_group$issue_group_name_vi']) ? $filter['keyword_ticket_issue_group$issue_group_name_vi'] :"" }}" >
                </div>

                <div class="form-group col-lg-6 text-align-right-mobile">
                    <a class="btn btn-secondary btn-hover-brand" href="{{route('ticket.issue-group.index')}}">
                        @lang('ticket::issue-group.input.button_remove')
                    </a>
                    <button type="submit"
                            class="btn btn-primary btn-hover-brand">
                        @lang('ticket::issue-group.input.button_search')
                    </button>
                </div>
            </div>
        </div>
    </div>


