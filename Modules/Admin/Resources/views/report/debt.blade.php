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
                    Báo cáo công nợ khách hàng chưa thu
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
                            <input readonly=""
                                   type="text" class="form-control m-input daterange-picker"
                                   id="choose_day" name="choose_day_order" autocomplete="off"
                                   placeholder="@lang('admin::dashboard.choose_day')" value="">
                        </div>
                        <div class="col-lg-2 col-xs-6">
                            <select name="customer_id" id="customer_id" class="form-control" style="width: 100%">
                                <option value="">Chọn khách hàng</option>
                                @foreach($customer as $item)
                                    <option value="{{$item['customer_id']}}">{{$item['customer_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-xs-6">
                            <select name="segment_id" id="segment_id" class="form-control" style="width: 100%">
                                <option value="">Chọn lĩnh vực</option>
                                @foreach($segment as $item)
                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-xs-6">
                            <select name="display_customer" id="display_customer" class="form-control"
                                    style="width: 100%">
                                <option value="">Số lượng khách hàng</option>
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
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
    <script src="{{asset('static/backend/js/general/highcharts.js')}}"></script>
    <script src="{{asset('static/backend/js/general/exporting.js')}}"></script>
    <script src="{{asset('static/backend/js/general/export-data.js')}}"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/admin/report/debt.js?v='.time()) }}">
    </script>
@endsection
