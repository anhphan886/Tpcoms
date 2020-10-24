<div class="row">
    <div class="form-group col-lg-3 col-12">
        <input class="form-control" type="text" id="keyword_admin_menu_category$menu_category_name"
               name="keyword_admin_menu_category$menu_category_name"
               placeholder="@lang('core::admin-menu-category.index.ADMIN_MENU_CATEGORY_NAME')"
               value="{{$filter['keyword_admin_menu_category$menu_category_name'] != null?$filter['keyword_admin_menu_category$menu_category_name'] : ''}}">
    </div>
    <div class="form-group col-lg-3 col-12 text-align-right-mobile">
        <a class="btn btn-secondary btn-hover-brand" href="{{route('core.admin-menu-category.index')}}">
            @lang('core::admin-menu-category.input.BUTTON_REMOVE')
        </a>
        <button type="submit"
                class="btn btn-primary btn-hover-brand">
            @lang('core::admin-menu-category.input.BUTTON_SEARCH')
        </button>
    </div>
</div>
