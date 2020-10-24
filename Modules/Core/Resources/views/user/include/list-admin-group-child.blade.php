<table class="table table-striped" id="table-admin-group-child">
    <thead>
    <tr>
        <th>@lang('core::admin-group.admin_group_name')</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @if (isset($userRoleGroup))
        @include('core::user.include.list-tr-group-child')
    @endif
    <tr id="row-btn-add">
        <td colspan="2">
            <a href="javascript:void(0)"
               onclick="Add.selectGroupChild({{ (isset($detail)) ? $detail['group_id'] : 0 }})">
                @lang('core::user.create.ADD_ROLE_GROUP')
            </a>
        </td>
    </tr>
    </tbody>
</table>
<div id="modal-list-group-child">
    <div class="modal fade" id="kt_modal_list_group_child" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @lang('core::admin-group.add_admin_group')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="kt-scroll" data-scroll="true" data-height="500">
                        <div class="kt-section__content" id="popup-list-group-child"></div>
                        {{--<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div>--}}
                        {{--<div class="ps__rail-y" style="top: 0px; height: 200px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 40px;"></div></div>--}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('core::admin-group.button_close')
                    </button>
                    <button type="button"
                            id="btn-add-group-child-to-list"
                            class="btn btn-primary"
                            onclick="Add.addGroupChild()"
                    >
                        @lang('core::admin-group.button_add')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
