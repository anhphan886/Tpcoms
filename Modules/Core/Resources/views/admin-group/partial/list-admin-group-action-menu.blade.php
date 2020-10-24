<table class="table table-striped" id="table-list-menu">
    <thead>
    <tr>
        <th>@lang('core::admin-group.admin_menu_name')</th>
        <th>@lang('core::admin-group.admin_menu_position')</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        @if (isset($list_menu) && count($list_menu) > 0)
            @foreach ($list_menu as $item)
                <tr class="menu-item">
                    <td>
                        <p title="{{ $item['menu_name'] }}">{{ subString($item['menu_name']) }}</p>
                        <input type="hidden" name="menu_id[]" value="{{ $item['menu_id'] }}">
                    </td>
                    <td>
                        <p>{{ $item['menu_position'] }}</p>
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
        <tr id="row-btn-add-menu">
            <td colspan="3">
                <a href="javascript:void(0)" onclick="adminGroup.showPopupMenuList()">
                    @lang('core::admin-group.button_add_new')
                </a>
            </td>
        </tr>
    </tbody>
</table>
<div id="modal-list-menu">
    <div class="modal fade" id="kt_modal_list_menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @lang('core::admin-group.add_admin_menu')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="kt-scroll ps ps--active-y" data-scroll="true" data-height="500" style="height: 500px; overflow: hidden;">
                        <div class="kt-section__content" id="popup-list-menu"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('core::admin-group.button_close')
                    </button>
                    <button type="button"
                            id="btn-add-menu-to-list"
                            class="btn btn-primary"
                            onclick="adminGroup.addMenu()"
                    >
                        @lang('core::admin-group.button_add')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
