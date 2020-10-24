<div class="modal fade" id="modal-issue-group-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('ticket.issue-group.store') }}" method="POST" id="form-issue-group-submit">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('ticket::issue-group.index.issue_group_create')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">@lang('ticket::issue-group.index.issue_group_name_vi')</label>
                                    <input type="text" id="issue_group_name_vi" name="issue_group_name_vi" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">@lang('ticket::issue-group.index.issue_group_name_en')</label>
                                    <input type="text" id="issue_group_name_en" name="issue_group_name_en" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('ticket::issue-group.input.button_cancel')</button>
                    <button type="button" class="btn btn-primary" onclick="objIssueGroup.save()">
                        @lang('ticket::issue-group.input.button_create')
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
