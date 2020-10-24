<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Error 404</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <link href="{{asset('static/backend/css/pages/general/error/error-6.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('static/backend/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed">
<div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid  kt-error-v6" style="background-image: url(./../static/backend/images/error-image/bg6.jpg);">
        <div class="kt-error_container">
            <div class="kt-error_subtitle kt-font-light">
                <h1>404</h1>
            </div>
            <p class="kt-error_description kt-font-light">
                @lang('shared.ERROR_404_CONTENT')
            </p>
            @php
                if (session()->has('user_route')) {
                    $sessionUserRoute = session()->get('user_route');
                } else {
                    $sessionUserRoute = [];
                }
            @endphp
            @if (count($sessionUserRoute) > 0)
                <a href="{{ route($sessionUserRoute[0]) }}" class="btn btn-dark btn-bold">
                    Trang chủ
                </a>
            @endif
            <a href="{{route('logout')}}" class="btn btn-primary btn-bold">
                Đăng xuất</a>
        </div>
    </div>
</div>
</body>
</html>
