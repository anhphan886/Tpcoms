@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('after_style')
    <link href="{{ asset('static/backend/css/dashboard/index.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div id="m-dashbroad">
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('admin::dashboard.dashboard')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">

            </div>
        </div>
        <!--begin: Datatable -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    @include('admin::dashboard.include.head')
                </div>
            </div>
        </div>
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt-content-1">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <div class="kt-portlet__body border-tab">
                        <ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-success" role="tablist">
                            <li class="nav-item tab-hover" onclick="functionDataTable.tab_order()">
                                <a class="nav-link active tab-hover ss-font-size-1p2rem ss-font-weight tab_order"
                                   data-toggle="tab" href="#kt_tabs_order" role="tab">
                                    <i class="fa fa-cart-plus"></i>
                                    @lang('admin::dashboard.order_day')
                                </a>
                            </li>
                            <li class="nav-item tab-hover" onclick="functionDataTable.tab_customer()">
                                <a class="nav-link tab-hover ss-font-size-1p2rem ss-font-weight tab_customer" data-toggle="tab"
                                   href="#kt_tabs_customer" role="tab">
                                    <i class="fa fa-user"></i>
                                    @lang('admin::dashboard.customer_day')
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content kt-margin-t-20">
                            <div class="tab-pane active div_tab_order" id="kt_tabs_order" role="tabpanel">
                                @include('admin::dashboard.include.list-order')
                            </div>
                            <div class="tab-pane div_tab_customer" id="kt_tabs_customer" role="tabpanel">
                                @include('admin::dashboard.include.list-customer')
                            </div>
                        </div>
                        <div class="kt-separator kt-separator--dashed"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt-content-2">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <div class="kt-portlet__body border-tab">
                        <ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-success" role="tablist">
                            <li class="nav-item tab-hover" onclick="functionClickTab.tab_1()">
                                <a class="nav-link active tab-hover ss-font-size-1p2rem ss-font-weight"
                                   data-toggle="tab" href="#expire_not_canceled" role="tab">
                                    <i class="fa fa-exchange-alt"></i>
                                    @lang('admin::dashboard.expire_not_canceled')
                                </a>
                            </li>
                            <li class="nav-item tab-hover" onclick="functionClickTab.tab_2()">
                                <a class="nav-link tab-hover ss-font-size-1p2rem ss-font-weight" data-toggle="tab"
                                   href="#expire_to_day" role="tab">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                    @lang('admin::dashboard.expire_to_day')
                                </a>
                            </li>
                            <li class="nav-item tab-hover" onclick="functionClickTab.tab_3()">
                                <a class="nav-link tab-hover ss-font-size-1p2rem ss-font-weight"
                                   data-toggle="tab" href="#expire_7_day" role="tab">
                                    <i class="fa fa-hourglass"></i>
                                    @lang('admin::dashboard.expire_7_day')
                                </a>
                            </li>
                            <li class="nav-item tab-hover" onclick="functionClickTab.tab_4()">
                                <a class="nav-link tab-hover ss-font-size-1p2rem ss-font-weight" data-toggle="tab"
                                   href="#expire_30_day" role="tab">
                                    <i class="fa fa-hockey-puck"></i>
                                    @lang('admin::dashboard.expire_30_day')
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content kt-margin-t-20">
                            <div class="tab-pane active" id="expire_not_canceled" role="tabpanel">
                                @include('admin::dashboard.include.list-expire-not-canceled')
                            </div>
                            <div class="tab-pane" id="expire_to_day" role="tabpanel">
                                @include('admin::dashboard.include.expire-to-day')
                            </div>
                            <div class="tab-pane" id="expire_7_day" role="tabpanel">
                                @include('admin::dashboard.include.expire-7-day')
                            </div>
                            <div class="tab-pane" id="expire_30_day" role="tabpanel">
                                @include('admin::dashboard.include.expire-30-day')
                            </div>
                        </div>
                        <div class="kt-separator kt-separator--dashed"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt-content-3">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <div class="kt-portlet__body border-tab">
                        <ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-success" role="tablist">
                            <li class="nav-item tab-hover" onclick="exportTab.tab_invoice()">
                                <a class="nav-link active tab-hover ss-font-size-1p2rem ss-font-weight tab_invoice" data-toggle="tab"
                                   href="#kt_tabs_invoice" role="tab">
                                    <i class="fa fa-user"></i>
                                    @lang('admin::dashboard.invoice_need_exported2')
                                </a>
                            </li>
                            <li class="nav-item tab-hover" onclick="exportTab.tab_receipt()">
                                <a class="nav-link tab-hover ss-font-size-1p2rem ss-font-weight tab_receipt"
                                   data-toggle="tab" href="#kt_tabs_receipt" role="tab">
                                    <i class="fa fa-cart-plus"></i>
                                    @lang('admin::dashboard.receipt_exported2')
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content kt-margin-t-20">
                            <div class="tab-pane active div_tab_invoice" id="kt_tabs_invoice" role="tabpanel">
                                @include('admin::dashboard.include.invoice')
                            </div>
                            <div class="tab-pane div_tab_receipt" id="kt_tabs_receipt" role="tabpanel">
                                @include('admin::dashboard.include.receipt')
                            </div>
                        </div>
                        <div class="kt-separator kt-separator--dashed"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="kt-content-3">
        <div class="col-lg-6">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
												<span class="kt-portlet__head-icon">
													<i class="fa fa-cart-arrow-down"></i>
												</span>
                        <h3 class="kt-portlet__head-title">
                            @lang('admin::dashboard.order')
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-actions">
                            <div class="row">
                                <div class="col-lg-6">
                                    <select name="month" class="form-control m_selectpicker"
                                             id="m_month" data-width="100px" onchange="chart.filterDateTime()">
                                        <option value="">
                                            @lang('admin::dashboard.all')
                                        </option>
                                        @for($i=1;$i<=12;$i++)
                                            <option value="{{$i}}" title="Tháng {{$i}}">
                                                @lang('admin::dashboard.month') {{$i}}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <select name="year" class="form-control m_selectpicker"
                                            data-width="100px"  id="m_year" onchange="chart.filterDateTime()">
                                        @for($i=0;$i<=4;$i++)
                                            <option value="{{\Carbon\Carbon::now()->subYear($i)->year}}">
                                                {{ \Carbon\Carbon::now()->subYear($i)->year}}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div id="m_orders" style="height: 350px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
												<span class="kt-portlet__head-icon">
													<i class="flaticon-statistics"></i>
												</span>
                        <h3 class="kt-portlet__head-title">
                            @lang('admin::dashboard.order_by_status')
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar" style="width: 40%">
                        <div class="kt-portlet__head-actions" style="width: 100%">
                            <input readonly=""
                                   type="text" class="form-control m-input daterange-picker"
                                   id="choose_day_order" name="choose_day_order" autocomplete="off"
                                   placeholder="@lang('admin::dashboard.choose_day')" value="">
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div id="m_order_by_status" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="language" value="{{\Illuminate\Support\Facades\App::getLocale()}}">
@endsection
@section('after_script')
    @include('admin::dashboard.include.inc-js')
    <script src="//www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/radar.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/pie.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/plugins/tools/polarScatter/polarScatter.min.js"
            type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/plugins/animate/animate.min.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/plugins/export/export.min.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/themes/light.js" type="text/javascript"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/admin/dashboard/chart.js?v='.time()) }}">
    </script>
@endsection
