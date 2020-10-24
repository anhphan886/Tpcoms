<div class="table_responsive">
    <table class="table table-striped" id="table-admin-group">
        <thead>
        <tr>
            <th>@lang('core::admin-menu.create.ADMIN_GROUP_NAME')</th>
            <th>@lang('core::admin-menu.create.ADMIN_GROUP_DESCRIPTION')</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @if (isset($list_group) && count($list_group) > 0)
            @foreach ($list_group as $item)
                <tr class="group-item">
                    <td>
                        <p title="{{ $item['group_name'] }}">
                            {{ subString($item['group_name']) }}
                        </p>
                        <input type="hidden" name="group_id[]" value="{{ $item['group_id'] }}">
                    </td>
                    <td>
                        <p title="{{ $item['group_description'] }}">
                            {{ subString($item['group_description']) }}
                        </p>
                    </td>
                    <td>
                        <select class="form-control" onchange="adminMenu.removeRow(this)">
                            <option value="">Hành động</option>
                            <option value="1">@lang('core::admin-menu.index.TABLE_REMOVE')</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        @endif
        <tr id="row-btn-add">
            <td colspan="3">
                <a href="javascript:void(0)" onclick="adminMenu.showPopupAdminGroup()">
                    @lang('core::admin-menu.input.BUTTON_ADD')
                </a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div id="modal-list-group">
    <div class="modal fade" id="kt_modal_list_group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @lang('core::admin-menu.create.ADD_ADMIN_GROUP')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="kt-scroll ps ps--active-y" data-scroll="true" data-height="500" style="height: 500px; overflow: hidden;">
                        <div class="kt-section__content" id="popup-list-group"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('core::admin-menu.input.BUTTON_CLOSE')
                    </button>
                    <button type="button"
                            id="btn-add-group-to-list"
                            class="btn btn-primary"
                            onclick="adminMenu.addGroup()"
                    >
                        @lang('core::admin-menu.input.BUTTON_ADD')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
