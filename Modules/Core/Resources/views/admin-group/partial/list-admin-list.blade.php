<table class="table table-striped" id="table-list-user">
    <thead>
        <tr>
            <th>@lang('core::admin-group.user_full_name')</th>
            <th>@lang('core::admin-group.user_email')</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if (isset($admin_has_group) && count($admin_has_group) > 0)
            @foreach ($admin_has_group as $item)
                <tr class="user-item">
                    <td>
                        <p title="{{ $item['full_name'] }}">{{ subString($item['full_name']) }}</p>
                        <input type="hidden" name="admin_id[]" value="{{ $item['id'] }}">
                    </td>
                    <td>
                        <p title="{{ $item['email'] }}">{{ subString($item['email']) }}</p>
                    </td>
                    <td>
                        <select class="form-control" onchange="adminGroup.removeRow(this)">
                            <option value="">Hành động</option>
                            <option value="1">@lang('core::admin-group.remove')</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        @endif
        <tr id="row-btn-add-user">
            <td colspan="3">
                <a href="javascript:void(0)" onclick="adminGroup.showPopupUserList()">
                    @lang('core::admin-group.button_add_new')
                </a>
            </td>
        </tr>
    </tbody>
</table>
<div id="modal-list-user">
    <div class="modal fade" id="kt_modal_list_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @lang('core::admin-group.add_user')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="kt-scroll ps ps--active-y" data-scroll="true" data-height="500" style="height: 500px; overflow: hidden;">
                        <div class="kt-section__content" id="popup-list-user"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('core::admin-group.button_close')
                    </button>
                    <button type="button"
                            id="btn-add-group-child-to-list"
                            class="btn btn-primary"
                            onclick="adminGroup.addUser()"
                    >
                        @lang('core::admin-group.button_add')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
