@extends('core::layouts.master')

@section('content')
    <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper" style="font-family: 'Segoe UI'">
        <div class="kt-login__container">
            <div class="kt-login__logo">
                <a href="#">
                    <img src="{{asset('static/backend/images/logo.png')}}" style="max-width:150px">
                </a>
            </div>
            <div class="kt-login__signin">
                <form class="kt-form" novalidate="novalidate" method="POST" id="form-login">
                    @csrf
                    <div class="input-group">
                        <input class="form-control" type="email" placeholder="@lang('core::login.email')" name="email" autocomplete="off" id="email">
                        @if ($errors->has('email'))
                            <div id="email-error" class="form-control-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="input-group">
                        <input class="form-control" type="password" placeholder="@lang('core::login.password')" name="password" id="password">
                        @if ($errors->has('password'))
                            <div id="password-error"
                                 class="form-control-feedback">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                    <div class="row kt-login__extra">
                        <div class="col">
                            <label class="kt-checkbox">
                                <input type="checkbox" name="remember">
                                @lang('core::login.remember')
                                <span></span>
                            </label>
                        </div>
                        <div class="col kt-align-right">
                            <a href="javascript:void(0);" id="kt_login_forgot" class="kt-login__link">
                                @lang('core::login.forget_password')
                            </a>
                        </div>
                    </div>
                    <div class="kt-login__actions">
                        <button id="kt_login_signin_submit" type="button" onclick="login.submit(this)" class="btn btn-brand btn-elevate kt-login__btn-primary">
                            @lang('core::login.login')
                        </button>
                    </div>
                </form>
            </div>
            <div class="kt-login__forgot">
                <div class="kt-login__head">
                    <h3 class="kt-login__title">
                        @lang('core::login.title_forget_password')
                    </h3>
                    <div class="kt-login__desc">
                        @lang('core::login.message_forget_password')
                    </div>
                </div>
                <form id="form-reset">
                    <div class="form-group">
                        <input onkeyup="forgetPass.reset()" class="form-control" type="text" placeholder="Email" name="email_reset" id="email_reset">
                        <span class="text-danger error-email-reset"></span>
                    </div>
                    <div class="kt-login__actions form-group text-center">
                        <a style="border-color: #d7d7d7;" id="kt_login_forgot_cancel" class="btn btn-light btn-elevate kt-login__btn-secondary">
                            @lang('core::login.close')
                        </a>
                        <button id="submit-forget" type="button" onclick="forgetPass.init()"
                                class="btn btn-brand btn-elevate kt-login__btn-primary">
                            @lang('core::login.get_password')
                        </button>&nbsp;&nbsp;
                    </div>
                </form>
            </div>
            <div class="kt-login__account">
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script src="{{ asset('js/laroute.js?v='.time()) }}" type="text/javascript"></script>
    <script>
        let form = $("#form-login");
    document.addEventListener("keydown", function(e){
       if (e.keyCode == 13){
            login.submit(form);
       }
 
});
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#swal2-title').css("font-family", 'Segoe UI');
    </script>
    <script src="{{ asset('static/backend/js/core/login/script.js?v='.time()) }}"
            type="text/javascript"></script>
@endsection
