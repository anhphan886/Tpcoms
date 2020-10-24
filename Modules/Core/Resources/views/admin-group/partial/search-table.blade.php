<div class="row">
    <div class="form-group col-lg-3">
        <input class="form-control" type="text" id="keyword_admin_group$group_name"
               name="keyword_admin_group$group_name"
               placeholder="@lang('core::admin-group.admin_group_name')"
               value="{{$filter['keyword_admin_group$group_name'] != null?$filter['keyword_admin_group$group_name'] : ''}}">
    </div>
    <div class="form-group col-lg-3 nt_btn_box_right">
        <a class="btn btn-secondary btn-hover-brand" href="{{route('core.admin-group.index')}}">
            @lang('core::admin-group.button_remove')
        </a>
        <button type="submit" class="btn btn-primary btn-hover-brand">
            @lang('core::admin-group.button_search')
        </button>
    </div>
</div>
