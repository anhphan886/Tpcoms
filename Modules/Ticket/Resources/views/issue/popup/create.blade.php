<div class="modal fade" id="modal-issue-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('ticket.issue.store') }}" method="POST" id="form-issue-submit">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('ticket::issue.index.issue_create')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">@lang('ticket::issue.index.issue_group')</label>
                                    <select class="form-control"
                                            name="portal_ticket_issue_group_id"
                                            id="portal_ticket_issue_group_id">
                                        <option value="">@lang('ticket::issue.input.select_placeholder_issue_group_id')</option>
                                        @if (isset($listGroup) && $listGroup != null)
                                            @foreach ($listGroup as $item)
                                                <option value="{{ $item['portal_ticket_issue_group_id'] }}">
                                                    {{ $item[getValueByLang('issue_group_name_')] }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">@lang('ticket::issue.index.issue_name_vi')</label>
                                    <input type="text" id="issue_name_vi" name="issue_name_vi" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">@lang('ticket::issue.index.issue_name_en')</label>
                                    <input type="text" id="issue_name_en" name="issue_name_en" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">@lang('ticket::issue.index.queue')</label>
                                    <select class="form-control"
                                            name="queue_id"
                                            id="queue_id">
                                        <option value="">@lang('ticket::issue.input.select_placeholder_queue_id')</option>
                                        @if (isset($listQueue) && $listQueue != null)
                                            @foreach ($listQueue as $item)
                                                <option value="{{ $item['ticket_queue_id'] }}">
                                                    {{ $item['queue_name'] }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">@lang('ticket::issue.index.issue_level_id')</label>
                                    <select class="form-control"
                                            name="portal_ticket_issue_level_id"
                                            id="portal_ticket_issue_level_id">
                                        <option value="">@lang('ticket::issue.input.select_placeholder_issue_level_id')</option>
                                        @if (isset($listLevel) && $listLevel != null)
                                            @foreach ($listLevel as $item)
                                                <option value="{{ $item['portal_ticket_issue_level_id'] }}">
                                                    {{ $item['issue_level_value'] }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="process_time">@lang('ticket::issue.index.process_time')</label>
                                        <input type="text" name="process_time" id="process_time" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="crictical_time2">@lang('ticket::issue.index.crictical_time2')</label>
                                        <input type="text" name="crictical_time2" id="crictical_time2" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="crictical_time3">@lang('ticket::issue.index.crictical_time3')</label>
                                        <input type="text" name="crictical_time3" id="crictical_time3" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="crictical_time4">@lang('ticket::issue.index.crictical_time4')</label>
                                        <input type="text" name="crictical_time4" id="crictical_time4" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('ticket::issue.input.button_cancel')</button>
                    <button type="button" class="btn btn-primary" onclick="objIssue.save()">
                        @lang('ticket::issue.input.button_create')
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
