<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<!-- begin::Head -->
<head>
    <!--begin::Base Path (base relative path for assets of this page) -->
    <meta charset="utf-8">
    <title>TPCloud</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="shortcut icon" href="{{asset('static/backend/images/logo.png')}}" type="image/png" />
    @include('components.styles')
    <link href="{{asset('static/backend/css/nt-custome.css?v='.time())}}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{asset('static/backend/images/logo.png')}}" type="image/png" />
    @yield('after_style')
</head>
<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed">
<!-- begin:: Page -->

<!-- begin:: Header Mobile -->
@include('components.header-mobile')
<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <!-- begin:: Aside -->
    @include('components.aside')
    <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            <!-- begin:: Header -->
        @include('components.header',['title' => 'Config'])
        <!-- end:: Header -->
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
                <!-- begin:: Content -->
                <div class="kt-content kt-grid__item kt-grid__item--fluid" id="kt_content">
                    <div class="kt-portlet kt-portlet--tabs">
                        <div class="kt-portlet__body">
                            <h1 class="text-center kt-margin-b-15">
                                @lang('shared.BLANK_CONTENT')
                            </h1>
                        </div>
                    </div>
                </div>
                <!-- end:: Content -->
            </div>
            <!-- begin:: Footer -->
        @include('components.footer')
        <!-- end:: Footer -->
        </div>
    </div>
</div>
<!-- end:: Page -->
<!-- begin::Scrolltop -->
@include('components.scroll-top')
<!-- end::Scrolltop -->
<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#2c77f4",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>
<!-- end::Global Config -->

<!--begin:: Global Optional Vendors -->
<script src="{{asset('js/laroute.js?v='.time())}}" type="text/javascript"></script>
<!--end:: Global Optional Vendors -->

@include('components.scripts')


<!--end::Global Theme Bundle -->
<script type="text/javascript">
    $(window).on('load', function() {
        $('body').removeClass('m-page--loading');
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.kt-menu__item a').each(function () {
        var href = this.href;
        if (href == window.location.href){
            $(this).parent().addClass('kt-menu__item--active');
        }
    });
</script>

<!--begin::Page Scripts(used by this page) -->
{{--<script src="{{asset('static/backend/assets/js/demo12/pages/dashboard.js')}}" type="text/javascript"></script>--}}
<script type="text/template" id="notification-tpl">
    <div class="kt-notification__item">
        <div class="kt-notification__item-icon">
            <i class="flaticon2-box-1 kt-font-brand"></i>
        </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title">
                {title}
            </div>
            <div class="kt-notification__item-time">
            </div>
        </div>
        <div class="kt-notification__item--read">
            <button type="button" class="btn btn-info btn-sm" onclick="notification.seen('{id_log}','{id_user}')">Seen</button>
        </div>
    </div>
</script>
<script type="text/template" id="footer-notification-tpl">
    <div class="kt-widget__footer ">
        <a href="{link}" class="btn btn-label-primary btn-sm btn-upper w-100">View All</a>
    </div>
</script>

@yield('after_script')
<!--end::Page Scripts -->
</body>
<!-- end::Body -->
</html>
