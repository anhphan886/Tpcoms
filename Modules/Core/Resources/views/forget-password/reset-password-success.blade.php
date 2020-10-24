@extends('core::layouts.master')

@section('content')
    <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper" style="font-family: 'Segoe UI'">
        <div class="kt-login__container">
            <div class="kt-login__logo">
                <a href="#">
                    <img src="{{asset('static/backend/images/logo.png')}}"
                         style="max-width:150px;border-radius: 30px;">
                </a>
            </div>
            <div class="kt-login__signin remove-class">
                <div class="kt-login__head">
                    <h6 class="kt-login__title" style="font-size: 1.3rem !important;">
                        Đổi mật khẩu thành công
                    </h6>
                    <div class="kt-login__desc">
                        Mật khẩu đã được thay đổi. Vui lòng sử dụng mật khẩu mới để đăng nhập.
                    </div>
                </div>
            </div>
            <div class="kt-login__actions form-group text-center remove-class">
                <button id="kt_login_forgot_cancel" onclick="forgetPassword.goToLogin()"
                        class="btn btn-brand btn-elevate kt-login__btn-primary">
                    Tiến hành đăng nhập
                </button>
            </div>
        </div>
    </div>
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
    <script type="text/javascript" src="{{ asset('static/backend/js/core/login/forget-password.js?v='.time()) }}">
    </script>
@stop

