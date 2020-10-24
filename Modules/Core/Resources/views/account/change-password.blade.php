@extends('layout')

@section('header')
    @include('components.header',['title'=> __('core.user.create.CREATE_ACCOUNT')])
@endsection
@section('content')
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                    <span class="kt-subheader__title" id="kt_subheader_total">
                                        @lang('core::account.change_password.change_password')
                                    </span>
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                                    <span class="kt-subheader__desc text-capitalize" id="kt_subheader_total">
                                    </span>
            </div>
        </div>
        <div class="kt-subheader__toolbar">

            <div class="btn-group">
                <button type="button" class="btn btn-primary" onclick="changePassword.save()">
                    @lang('core::account.change_password.save')
                </button>
                <a href="{{ URL::previous() }}" class="btn btn-secondary">
                    @lang('core::user.create.CANCEL')
                </a>
            </div>
        </div>
    </div>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-submit">
                    <div class="tab-content">
                        <div class="tab-pane active" id="kt_apps_user_edit_tab_1" role="tabpanel">
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="form-group row">
                                            <label class="col-xl-2 col-lg-2 col-form-label">
                                                @lang('core::account.change_password.old_password'):
                                                <span class="color_red">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="password" class="form-control"
                                                       id="old_password"
                                                       name="old_password"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-2 col-lg-2 col-form-label">
                                                @lang('core::account.change_password.new_password'):
                                                <span class="color_red">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="password" class="form-control"
                                                       id="new_password"
                                                       name="new_password"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-2 col-lg-2 col-form-label">
                                                @lang('core::user.create.CONFIRM_PASSWORD'):</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="password" class="form-control"
                                                       id="password_confirm"
                                                       name="password_confirm"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script src="{{asset('static/backend/js/core/account/change-password.js?v='.time())}}"
            type="text/javascript"></script>
@endsection
