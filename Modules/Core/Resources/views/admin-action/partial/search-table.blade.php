<div class="row">
    <div class="form-group col-lg-3">
        <input class="form-control" type="text" id="keyword_admin_action$action_name"
               name="keyword_admin_action$action_name"
               placeholder="@lang('core::admin-action.index.ADMIN_ACTION_NAME')"
               value="{{$filter['keyword_admin_action$action_name'] != null?$filter['keyword_admin_action$action_name'] : ''}}">
    </div>
    <div class="form-group col-lg-3">
        <input class="form-control" type="text" id="keyword_adgn$action_group_name"
               name="keyword_adgn$action_group_name"
               placeholder="@lang('core::admin-action.index.ADMIN_ACTION_GROUP_NAME')"
               value="{{$filter['keyword_adgn$action_group_name'] != null?$filter['keyword_adgn$action_group_name'] : ''}}">
    </div>
    <div class="form-group col-lg-3">
        <input class="form-control" type="text" id="keyword_admin_action$description"
               name="keyword_admin_action$description"
               placeholder="@lang('core::admin-action.index.ADMIN_ACTION_DESCRIPTION')"
               value="{{$filter['keyword_admin_action$description'] != null?$filter['keyword_admin_action$description'] : ''}}">
    </div>
    <div class="form-group col-lg-3">
        <input class="form-control" type="text" id="keyword_admin_action$action_name_default"
               name="keyword_admin_action$action_name_default"
               placeholder="@lang('core::admin-action.index.ADMIN_ACTION_NAME_DEFAULT')"
               value="{{$filter['keyword_admin_action$action_name_default'] != null?$filter['keyword_admin_action$action_name_default'] : ''}}">
    </div>
</div>
<div class="row">
    <div class="form-group col-12 text-align-right">
        <a class="btn btn-secondary btn-hover-brand" href="{{route('core.admin-action.index')}}">
            @lang('core::admin-action.input.BUTTON_REMOVE')
        </a>
        <button type="submit" class="btn btn-primary btn-hover-brand">
            @lang('core::admin-action.input.BUTTON_SEARCH')
        </button>
    </div>
</div>