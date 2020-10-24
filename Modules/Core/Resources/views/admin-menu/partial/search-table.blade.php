<div class="row">
    <div class="form-group col-lg-4 col-12">
        <input class="form-control" type="text" id="keyword_admin_menu$menu_name"
               name="keyword_admin_menu$menu_name"
               placeholder="@lang('core::admin-menu.table.ADMIN_MENU_NAME')"
               value="{{$filter['keyword_admin_menu$menu_name'] != null?$filter['keyword_admin_menu$menu_name'] : ''}}">
    </div>
    <div class="form-group col-lg-4 col-12 text-align-right-mobile">
        <a class="btn btn-secondary btn-hover-brand" href="{{route('core.admin-menu.index')}}">
            @lang('core::admin-menu.input.BUTTON_REMOVE')
        </a>
        <button type="submit"
                class="btn btn-primary btn-hover-brand">
            @lang('core::admin-menu.input.BUTTON_SEARCH')
        </button>
    </div>
</div>
