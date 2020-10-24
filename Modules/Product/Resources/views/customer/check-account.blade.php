@extends('core::layouts.login')
@section('title')
    @lang('user::register.index.register-active')
@endsection
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-padding-0" id="kt_content">
        <div class="kt-grid__item kt-grid__item--fluid margin-20">
            <div class="kt-register-success">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <img class="img-fluid" src="{{asset('static/backend/images/logo-frontend.png')}}">
                        </div>

                        <div class="col-12 background-form">
                            <div class="row">
                                <div class="col-12 margin-top">
                                    <div class="form-group text-center">
                                        <img class="img-fluid" src="{{asset('static/backend/images/image-1.png')}}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group text-center">
                                        <h2 class="text-uppercase color-black font-weight-bold margin-20">Kích hoạt tài khoản</h2>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="color-black font-25 font-weight-400">Chúc mừng bạn đã kích hoạt tài khoản thành công</p>
                                            <p class="font-25 font-weight-400 return-login"><a href="{{route('admin/login')}}">Quay lại đăng nhập</a> </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('after_style')
    <style>
        html, body {
            font-size: 14px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('static/backend/css/style.css?v='.time()) }}">
@endsection
