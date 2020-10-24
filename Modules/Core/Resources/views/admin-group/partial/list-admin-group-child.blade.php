<table class="table table-striped" id="table-admin-group-child">
    <thead>
        <tr>
            <th>@lang('core::admin-group.create.ADMIN_GROUP_NAME')</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if (isset($detail))
            @include('core::admin-group.partial.list-tr-group-child')
        @endif
        <tr id="row-btn-add">
            <td colspan="2">
                <a href="javascript:void(0)" onclick="adminGroup.selectGroupChild({{ (isset($detail)) ? $detail['group_id'] : 0 }})">
                    @lang('core::admin-group.input.BUTTON_ADD_NEW')
                </a>
            </td>
        </tr>
    </tbody>
</table>
<div id="modal-list-group-child">
    <div class="modal fade" id="kt_modal_list_group_child" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @lang('core::admin-group.create.ADD_ADMIN_GROUP_CHILD')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="kt-scroll ps ps--active-y" data-scroll="true" data-height="500" style="height: 500px; overflow: hidden;">
                        <div class="kt-section__content" id="popup-list-group-child"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('core::admin-group.input.BUTTON_CLOSE')
                    </button>
                    <button type="button"
                            id="btn-add-group-child-to-list"
                            class="btn btn-primary"
                            onclick="adminGroup.addGroupChild()"
                    >
                        @lang('core::admin-group.input.BUTTON_ADD')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
