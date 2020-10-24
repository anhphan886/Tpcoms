<div class="modal fade" id="modal-issue-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('ticket.issue.store') }}" method="POST" id="form-issue-submit">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> @lang('product::customer.service.edit_staff')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">@lang('product::customer.service.staff')</label>
                                    <select class="form-control"
                                            name="staff_id"
                                            id="staff_id">
                                        <option value=""></option>
                                        @if (isset($listGroup) && $listGroup != null)
                                            @foreach ($listGroup as $item)
                                                <option value="{{ $item['portal_ticket_issue_group_id'] }}">
                                                    {{ $item[getValueByLang('issue_group_name_')] }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
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
