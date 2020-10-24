<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">
    <!-- begin:: Header Menu -->
    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
    <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
        <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
        </div>
    </div>
    <!-- end:: Header Menu -->

    <!-- begin:: Header Topbar -->
    <div class="kt-header__topbar">

        <div class="kt-header__topbar-item dropdown add_show">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="30px,0px" aria-expanded="false">
                <span class="kt-header__topbar-icon">
                    <i class="flaticon2-bell-alarm-symbol chuong"></i>
                </span>
            </div>
            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-lg dropdown-notification" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-246px, 64px, 0px);">
                <form>

                    <!--begin: Head -->
                    <div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b" style="background-image: url({{asset('/static/backend/images/bg-1.jpg')}})">
                        <h3 class="kt-head__title" onclick="notification.viewAll()">
                            @lang('core::account.header.notification')
                            &nbsp;
                            <span class="btn btn-success btn-sm btn-bold btn-font-md ss-span-new">
                                <span class="quantity-noti">23</span> @lang('core::account.header.new')
                            </span>
                        </h3>
                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link show active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab" aria-selected="true"></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#topbar_notifications_events" role="tab" aria-selected="false"></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#topbar_notifications_logs" role="tab" aria-selected="false"></a>
                            </li>
                        </ul>
                    </div>

                    <!--end: Head -->
                    <div class="tab-content">
                        <div class="tab-pane show active" id="topbar_notifications_notifications" role="tabpanel">
                            <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll ps ps--active-y div-notification" data-scroll="true" data-height="300" data-mobile-height="200" style="height: 300px; overflow: hidden;">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--begin: User Bar -->
        <div class="kt-header__topbar-item kt-header__topbar-item--user">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                <div class="kt-header__topbar-user">
                    <span class="kt-header__topbar-welcome kt-hidden-mobile">{{ (Auth::user()) ? Auth::user()->account_name : ''}}</span>
                    <img class="kt-hidden" alt="Pic" src="{{asset('/static/backend/images/300_25.jpg')}}" />

                    <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                    <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">
                        {{(Auth::user()) ? substr(Auth::user()->full_name,0, 1) : ""}}
                    </span>
                </div>
            </div>
            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

                <!--begin: Head -->
                <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url({{asset('static/backend/images/bg-1.jpg')}})">
                    <div class="kt-user-card__avatar">
                        <img class="kt-hidden" alt="Pic" src="{{asset('/static/backend/images/300_25.jpg')}}">

                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                        <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">
                            {{(Auth::user()) ? substr(Auth::user()->full_name,0, 1) : ""}}
                        </span>
                    </div>
                    <div class="kt-user-card__name">
                        {{ (Auth::user()) ? Auth::user()->full_name : ''}}
                    </div>
                    <div class="kt-user-card__badge">
                        {{--<span class="btn btn-success btn-sm btn-bold btn-font-md">23 messages</span>--}}
                    </div>
                </div>
                <!--end: Head -->
                <!--begin: Navigation -->
                <div class="kt-notification">
                    <div class="kt-notification__custom kt-space-between text-center1 magin20">
                        <a href="{{route('logout')}}" class="btn btn-label btn-label-brand btn-sm btn-bold">@lang('core::account.change_password.log_out')</a>
                        <a href="{{route('admin.change-password')}}" class="btn btn-label btn-label-brand btn-sm btn-bold">
                            @lang('core::account.change_password.chang_pass')
                        </a>
                    </div>
                </div>
                <!--end: Navigation -->
            </div>
        </div>

        <!--end: User Bar -->
    </div>

    <!-- end:: Header Topbar -->
</div>