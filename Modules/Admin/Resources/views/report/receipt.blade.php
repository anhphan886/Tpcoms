@extends('layout')
@section('header')
{{--    @include('components.header',['title' => 'Config'])--}}
@endsection
@section('after_style')
    <style>
        .amcharts-chart-div > a {
            display: none !important;
        }
        #pie-chart-status svg > g > g:last-child { pointer-events: none }
        #pie-chart-payment-type svg > g > g:last-child { pointer-events: none }
    </style>
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                Báo cáo công nợ tổng hợp
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <form method="post" action="{{ route('admin.report.expoft-excel-invoice')}}" class="col-lg-3">
        <div class="kt-subheader__toolbar">
            {{-- START XUẤT BÁO CÁO --}}
            <button type="submit" id="export-invoice" class="btn btn-label-brand  btn-bold" >Export Excel</button>
            {{-- END XUẤT BÁO CÁO --}}
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-lg-3" style="margin-left: 70%">
                        @csrf
                        <input name="choose_day" id="choose_day" readonly=""
                               type="text" class="form-control m-input daterange-picker"
                                name="choose_day_order" autocomplete="off"
                               placeholder="@lang('admin::dashboard.choose_day')" value="">
                    </div>
                    <form/>
                </div>
                <div id="chartdiv" style="width: 100%; height: 355px;"></div>
            </div>
        </div>
    </div>
    <div class="row" id="kt-content-3">
        <div class="col-lg-6">
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
        <div class="col-lg-6">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Tỉ lệ theo hình thức thanh toán
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div id="pie-chart-payment-type" style="height: 350px;"></div>
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
    <script src="//www.amcharts.com/lib/3/themes/light.js" type="text/javascript"></script>

    <script type="text/javascript"
            src="{{ asset('static/backend/js/admin/report/receipt.js?v='.time()) }}">
    </script>

@endsection
