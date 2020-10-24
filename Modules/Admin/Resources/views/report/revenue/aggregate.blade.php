@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('after_style')
    <link href="{{ asset('static/backend/css/dashboard/index.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        svg > g > g:last-child { pointer-events: none }
    </style>
@endsection
@section('content')
    <div id="m-dashbroad">
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    Báo cáo doanh thu tổng hợp
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                {{--<a href="{{route('admin.report.export-excel-customer-revenue')}}" class="btn btn-label-brand btn-bold">--}}
                    {{--Export excel--}}
                {{--</a>--}}
            </div>
        </div>
        <!--begin: Datatable -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <div class="row" id="m--star-dashbroad">
                        <div class="col-lg-3 col-xs-6">
                            <div class="m-portlet m--bg-brand m-portlet--bordered-semi m-portlet--full-height  m-portlet--head-sm tongtien ss--radius-10">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text m--font-light">
                                                Tổng số tiền
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-portlet__body">
                                    <div class="m-widget25">
                                        <span class="m-widget25__price m--font-brand total_money" style="font-size: 2rem">0</span>
                                        <span class="m-widget25__desc">
                                            VNĐ
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="m-portlet m--bg-brand m-portlet--bordered-semi m-portlet--full-height  m-portlet--head-sm dathanhtoan ss--radius-10">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text m--font-light">
                                                Đã thanh toán
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-portlet__body">
                                    <div class="m-widget25">
                                        <span class="m-widget25__price m--font-brand total_paid" style="font-size: 2rem">0</span>
                                        <span class="m-widget25__desc">
                                            VNĐ
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="m-portlet m--bg-brand m-portlet--bordered-semi m-portlet--full-height  m-portlet--head-sm chuathanhtoan ss--radius-10">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text m--font-light">
                                                Chưa thanh toán
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-portlet__body">
                                    <div class="m-widget25">
                                        <span class="m-widget25__price m--font-brand total_unpaid" style="font-size: 2rem">0</span>
                                        <span class="m-widget25__desc">
                                            VNĐ
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="form-group">
                                <input readonly=""
                                       type="text" class="form-control m-input daterange-picker"
                                       id="choose_day" name="choose_day_order" autocomplete="off"
                                       placeholder="@lang('admin::dashboard.choose_day')" value="">
                            </div>
                            <div class="form-group">
                                <select name="year" id="year" class="form-control ">
                                    <option value="">Chọn năm</option>
                                    @for($i=0;$i<=4;$i++)
                                        <option value="{{\Carbon\Carbon::now()->subYear($i)->year}}">
                                            {{ \Carbon\Carbon::now()->subYear($i)->year}}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group kt-margin-t-10">
                        <div id="container" style="min-width: 280px; height: 273px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="language" value="{{\Illuminate\Support\Facades\App::getLocale()}}">
@endsection
@section('after_script')
    <script src="{{asset('static/backend/js/general/amcharts.js')}}"></script>
    <script src="{{asset('static/backend/js/general/serial.js')}}"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/admin/report/revenue/aggregate.js?v='.time()) }}">
    </script>
@endsection
