@extends('layout')

@section('header')
    @include('components.header',['title'=> __('core.user.create.CREATE_ACCOUNT')])
@endsection
@section('content')
    <form id="form-adds">
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    <span class="kt-subheader__title" id="kt_subheader_total">
                                        @lang('core::user.index.MANAGEMENT_ACCOUNT')
                                    </span>
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                                    <span class="kt-subheader__desc text-capitalize" id="kt_subheader_total">
                                        @lang('core::user.create.CREATE_ACCOUNT')
                                    </span>
                </div>
            </div>
            <div class="kt-subheader__toolbar">

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary" onclick="Add.submitAdd(1)">
                        @lang('core::user.create.SAVE_CHANGE_NEW')
                    </button>
                    <button type="submit" class="btn btn-primary" onclick="Add.submitAdd(0)">
                        @lang('core::user.create.SAVE_CHANGE')
                    </button>
                    <a href="{{route('core.user.index')}}" class="btn btn-secondary">
                        @lang('core::user.create.CANCEL')
                    </a>
                </div>
            </div>
        </div>
        <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="kt_apps_user_edit_tab_1" role="tabpanel">
                            <div class="kt-form__body">

                                <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <div class="row">
                                                <label class="col-xl-3"></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <h3 class="kt-section__title kt-section__title-sm">
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    @lang('core::user.create.NAME'):
                                                    <span class="color_red">*</span></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input type="text" class="form-control"
                                                           id="full_name"
                                                           name="full_name"
                                                           placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    @lang('core::user.create.EMAIL'):
                                                    <span class="color_red">*</span></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input type="text" class="form-control"
                                                           id="email"
                                                           name="email"
                                                           placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    @lang('core::user.create.PASSWORD'):
                                                    <span class="color_red">*</span></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input type="password" class="form-control"
                                                           id="password"
                                                           name="password"
                                                           placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    @lang('core::user.create.CONFIRM_PASSWORD'):</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input type="password" class="form-control"
                                                           id="password_confirm"
                                                           name="password_confirm"
                                                           placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    @lang('core::user.index.ACTIVE'):
                                                </label>
                                                <div class="col-lg-9 col-xl-6">
                                                   <span class="kt-switch kt-switch--success">
                                                        <label>
                                                            <input type="checkbox" name="is_actived" checked
                                                                   id="is_actived"
                                                                   onchange="Add.changeIsActive(this)"
                                                            >
                                                            <span></span>
                                                        </label>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet kt-portlet--tabs">
                @include('core::user.include.tabs')
            </div>
        </div>
    </form>

@endsection
@section('after_script')
    <script>
        var PLEASE_ENTER_NAME = '@lang('core::user.create.PLEASE_ENTER_NAME')';
        var PLEASE_ENTER_EMAIL = '@lang('core::user.create.PLEASE_ENTER_EMAIL')';
        var PLEASE_ENTER_EMAIL_FORMAT = '@lang('core::user.create.PLEASE_ENTER_EMAIL_FORMAT')';
        var PLEASE_ENTER_PASSWORD = '@lang('core::user.create.PLEASE_ENTER_PASSWORD')';
        var PASSWORD_LENGTH = '@lang('core::user.create.PASSWORD_LENGTH')';
        var PLEASE_ENTER_CONFIRM_PASSWORD = '@lang('core::user.create.PLEASE_ENTER_CONFIRM_PASSWORD')';
        var PLEASE_ENTER_ADMIN_MENU = '@lang('core::user.create.PLEASE_ENTER_ADMIN_MENU')';
        var VALIDATE_PASSWORD = '@lang('core::user.create.VALIDATE_PASSWORD')';
        var FAIL_CONFIRM_PASSWORD = '@lang('core::user.create.FAIL_CONFIRM_PASSWORD')';
    </script>
    <script src="{{asset('static/backend/js/core/user/add.js?v='.time())}}" type="text/javascript"></script>
@endsection
