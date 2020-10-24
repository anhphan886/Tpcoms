@extends('core::layouts.login')
@section('title')
    @lang('product::customer.index.new-verify')
@endsection
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-padding-0" id="kt_content">
        <div class="kt-grid__item kt-grid__item--fluid margin-20">
            <form method="POST"  autocomplete="off" id="form-filter">
                @csrf
                <div class="form-login">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 text-center">
                                <img class="img-fluid" src="{{asset('static/backend/images/logo-frontend.png')}}">
                            </div>

                            <div class="col-12 background-form padding-form-login">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group text-center">
                                            <h2 class="color-login font-weight-bold"> @lang('product::customer.index.new-verify')</h2>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group text-center  font-size-20 color-black text-size-mobile">
                                            <p>@lang('product::customer.index.input-email-new-verify')</p>
                                        </div>
                                        @error('active-email')
                                        <div class="input-group mb-2">
                                            <div class="text-danger">{{ $message }}</div>
                                        </div>
                                        @enderror
                                        <div class="input-group mb-2">

                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-none @error('email') is-invalid @enderror @error('not-email') is-invalid @enderror"><i class="fas fa-user"></i></div>
                                            </div>
                                            <input type="text" class="form-control form-group border-none background-input @error('email') is-invalid @enderror @error('not-email') is-invalid @enderror " name="email" value="{{isset($filter['email']) ? $filter['email'] : ""}}" placeholder="Email">
                                            @error('email')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                            @error('not-email')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-8 img-captcha login-center refereshrecapcha">
                                                <label >@lang('product::customer.index.captcha')</label>
                                                <span>{!! captcha_img() !!}</span>
                                                <div class="input-group margin-top text-error">
                                                    <input type="text" class="form-control form-group @error('captcha') is-invalid @enderror" name="captcha" placeholder="@lang('user::account.index.input-captcha')" autocomplete="off">
                                                    <a href="javascript:void(0)" class="btn button-fix-reload-catpcha captcha-button-reload" onclick="captcha.refreshCaptcha()"><i class="flaticon-refresh"></i></a>
                                                </div>
                                                @error('captcha')
                                                <div class="error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 margin-top">
                                        <div class="row">
                                            <div class="col-8 center-block">
                                                <button type="submit" class="form-control text-uppercase btn-login">@lang('product::customer.index.send')</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 margin-top text-center text-remember-password">
                                        <p><strong><a href="{{route('user.account.login')}}">@lang('product::customer.index.return-login-page')</a></strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
@section('after_style')
    <link rel="stylesheet" href="{{ asset('static/backend/css/style.css?v='.time()) }}">
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/captcha.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('static/backend/js/account/account.js?v='.time()) }}"></script>
@endsection
