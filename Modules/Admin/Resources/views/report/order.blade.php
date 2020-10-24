@extends('layout')
@section('header')
{{--    @include('components.header',['title' => 'Config'])--}}
@endsection
@section('after_style')
    <style>
        .amcharts-chart-div > a {
            display: none !important;
        }
        svg > g > g:last-child { pointer-events: none }
    </style>
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                Thống kê đơn hàng
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
                <div class="row">
                    <div class="col-lg-9"></div>
                    <div class="col-lg-3">
                        <input readonly=""
                               type="text" class="form-control m-input daterange-picker"
                               id="choose_day" name="choose_day_order" autocomplete="off"
                               placeholder="@lang('admin::dashboard.choose_day')" value="">
                    </div>
                </div>
                <div id="chartdiv" style="width: 100%; height: 355px;"></div>
            </div>
        </div>
    </div>
    <div class="row" id="kt-content-3">
        <div class="col-lg-4">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Tỉ lệ theo trạng thái
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div id="pie-chart-status" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/general/amcharts.js?v='.time()) }}">
    </script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/general/serial.js?v='.time()) }}">
    </script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/general/loader.js?v='.time()) }}">
    </script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/admin/report/order.js?v='.time()) }}">
    </script>
@endsection