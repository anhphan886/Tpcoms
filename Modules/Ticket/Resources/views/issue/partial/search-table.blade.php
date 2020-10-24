
    <div class="row">
        <div class="form-group col-lg-6 col-md-6 nt-padding">
            <div class=" col-lg-12">
                <select class="form-control kt-select2" id="kt_select2_1" name="keyword_ad1$full_name" >
                    <option value="">
                        @lang('ticket::issue.index.select_creator')
                    </option>
                    @if (isset($listAdmin))
                        @foreach( $listAdmin as $item)
                            <option   value="{{$item['full_name']}}" {{ isset($filter['keyword_ad1$full_name']) &&
                                                $filter['keyword_ad1$full_name'] == $item['full_name'] ? "selected" : "" }} >
                                {{ $item['full_name'] }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            <div class="col-lg-12">
                <div class="input-group date">
                    <input class="form-control tung1" readonly
                           name="keyword_ticket_issue$date_created"
                           placeholder="@lang('ticket::issue.index.select_creation_date')" id="kt_datepicker_2"
                           value="{{isset($filter['keyword_ticket_issue$date_created']) ? $filter['keyword_ticket_issue$date_created'] :"" }}"  />
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-lg-6 col-md-6">
            <div class="row">
                <div class="col-12">
                    <input class="form-control" type="text" id="keyword_ticket_issue$issue_name_vi"
                           name="keyword_ticket_issue$issue_name_vi"
                           placeholder="@lang('ticket::issue.index.issue_name')"
                           value="{{isset($filter['keyword_ticket_issue$issue_name_vi']) ? $filter['keyword_ticket_issue$issue_name_vi'] :"" }}" >
                </div>
            </div>
        </div>
        <div class="form-group col-lg-6 col-md-6">
           <div class="row">
               <div class="col-12 ">
                   <div class="form-group col-lg-12">
                       <a class="btn btn-secondary btn-hover-brand" href="{{route('ticket.issue.index')}}">
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
    </div>




