@extends('core::layouts.master')
@section('content')
    <!--begin::Content-->
    @if($user)
        <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper" style="font-family: 'Segoe UI'">
            <div class="kt-login__container">
                <div class="kt-login__logo">
                    <a href="#">
                        <img src="{{asset('static/backend/images/logo.png')}}"
                             style="max-width:150px;border-radius: 30px;">
                    </a>
                </div>
                <div class="kt-login__signin" id="tool-detail">
                    <div class="kt-login__head">
                        <h3 class="kt-login__title">
                            @lang('core::forget-password.index.TITLE_CHANGE_PASSWORD')
                        </h3>
                        <div class="kt-login__desc">
                            @lang('core::forget-password.index.CHANGE_PASSWORD_TITLE')
                        </div>
                    </div>
                    <form id="form-reset">
                        <div class="form-group">
                            <input class="form-control" type="password" placeholder="Mật khẩu mới" name="new_password"
                                   id="new_password"
                                   autocomplete="off">
                            <span class="text-danger error_new_password"></span>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" placeholder="Xác nhận mật khẩu"
                                   name="confirm_new_password" id="confirm_new_password"
                                   autocomplete="off">
                            <span class="text-danger error_confirm_new_password"></span>
                        </div>
                        <div class="kt-login__actions form-group text-center">
                            <a style="border-color: #d7d7d7;" id="kt_login_forgot_cancel"
                               class="btn btn-light btn-elevate kt-login__btn-secondary"
                               href="{{route('logout')}}">
                                @lang('core::forget-password.index.CLOSE')
                            </a>&nbsp;&nbsp;
                            <button id="submit-forget" type="button"
                                    class="btn btn-brand btn-elevate kt-login__btn-primary"
                                    onclick="forgetPassword.changePassword('{{$token}}')">
                                @lang('core::forget-password.index.CHANGE_PASSWORD')
                            </button>
                        </div>
                    </form>
                </div>
                <div class="kt-login__account">
                </div>
            </div>
        </div>
    @else
        <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper" style="font-family: 'Segoe UI'">
            <div class="kt-login__container">
                <div class="kt-login__logo">
                    <a href="#">
                        <img src="{{asset('static/backend/images/icon-dms.png')}}"
                             style="max-width:150px;border-radius: 30px;">
                    </a>
                </div>
                <div class="kt-login__signin remove-class">
                    <div class="kt-login__head">
                        <h6 class="kt-login__title" style="font-size: 1.3rem !important;">
                            @lang('core::forget-password.index.LINK_FAIL')
                        </h6>
                    </div>
                </div>
                <div class="kt-login__actions form-group text-center remove-class">
                    <a style="border-color: #d7d7d7;" id="kt_login_forgot_cancel" href="{{route('logout')}}"
                       class="btn btn-light btn-elevate kt-login__btn-secondary">
                        @lang('core::forget-password.index.CLOSE')
                    </a>&nbsp;&nbsp;
                    <button id="submit-forget" type="button" onclick="forgetPassword.forgetPassword()"
                            class="btn btn-brand btn-elevate kt-login__btn-primary">
                        @lang('core::forget-password.index.GET_PASSWORD')
                    </button>&nbsp;&nbsp;
                </div>
                <div class="kt-login__forgot">
                    <div class="kt-login__head">
                        <h3 class="kt-login__title">
                            @lang('core::forget-password.index.TITLE_FORGET_PASSWORD')
                        </h3>
                        <div class="kt-login__desc">
                            @lang('core::forget-password.index.TB_ENTER_EMAIL')
                        </div>
                    </div>
                    <form id="form-send-email">
                        <div class="form-group">
                            <input class="form-control"
                                   type="text" placeholder="Email"
                                   name="email_reset"
                                   id="email_reset"
                                   autocomplete="off"
                                   onkeyup="forgetPassword.reset()">
                            <span class="text-danger error-email-reset"></span>
                        </div>
                        <div class="kt-login__actions form-group text-center">
                            <a style="border-color: #d7d7d7;" id="kt_login_forgot_cancel"
                               class="btn btn-light btn-elevate kt-login__btn-secondary">
                                @lang('core::forget-password.index.CLOSE')
                            </a>
                            <button id="submit-forget" type="button" onclick="forgetPassword.getPassword()"
                                    class="btn btn-brand btn-elevate kt-login__btn-primary">
                                @lang('core::forget-password.index.GET_PASSWORD')
                            </button>&nbsp;&nbsp;
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <!--end::Content-->

@stop

@section('after_script')
    <script src="{{ asset('js/laroute.js?v='.time()) }}" type="text/javascript"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        var PLEASE_EMAIL="@lang('user::forget-password.index.PLEASE_EMAIL')";
        var EMAIL_FAIL_FORMAT="@lang('user::forget-password.index.EMAIL_FAIL_FORMAT')";
        $('#swal2-title').css("font-family", 'Segoe UI');
    </script>
    <script type="text/javascript" src="{{ asset('static/backend/js/core/login/forget-password.js?v='.time()) }}">
    </script>
@stop
