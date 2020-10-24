<div class="kt-portlet__head">
    <div class="kt-portlet__head-toolbar">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-left nav-tabs-line-primary"
            role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#admin-list"
                   role="tab"
                   aria-selected="true">
                    @lang('ticket::ticket.index.tab_comment')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#admin-group-action-menu"
                   role="tab"
                   aria-selected="true">
                    @lang('ticket::ticket.index.tab_history')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#admin-survey"
                   role="tab"
                   aria-selected="true">
                    @lang('ticket::ticket.index.survey')
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="kt-form kt-form--label-right">
    <div class="kt-portlet__body">
        <div class="tab-content">
            <div class="tab-pane active" id="admin-list">
                <div class="kt-section kt-margin-t-30">
                    <div class="kt-section__body">
                        @include('ticket::ticket.partial.comment')
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="admin-group-action-menu">
                <div class="kt-section kt-margin-t-30">
                    <div class="kt-section__body">
                        @include('ticket::ticket.partial.history')
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="admin-survey">
                <div class="kt-section kt-margin-t-30">
                    <div class="kt-section__body">
                        @include('ticket::ticket.partial.survey')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__foot"></div>
</div>
