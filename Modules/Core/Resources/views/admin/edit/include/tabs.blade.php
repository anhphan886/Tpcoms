<div class="kt-portlet__head">
    <div class="kt-portlet__head-toolbar">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-left nav-tabs-line-primary"
            role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#admin-group-child"
                   role="tab"
                   aria-selected="true">
                    @lang('core::user.create.ROLE_GROUP')
                </a>
            </li>

        </ul>
    </div>
</div>
<div class="kt-form kt-form--label-right">
    <div class="kt-portlet__body" style="margin-top: -50px">
        <div class="tab-content">
            <div class="tab-pane active" id="admin-group-child">
                <div class="kt-section kt-margin-t-30">
                    <div class="kt-section__body">
                        @include('core::user.edit.include.list-admin-group-child')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__foot"></div>
</div>
