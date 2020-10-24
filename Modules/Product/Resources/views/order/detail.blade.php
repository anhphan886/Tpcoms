@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('after_style')
    <link href="{{asset('static/backend/css/wizard.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <style>
        .kt-wizard-v1 .kt-wizard-v1__nav .kt-wizard-v1__nav-items .kt-wizard-v1__nav-item .kt-wizard-v1__nav-body .kt-wizard-v1__nav-icon {
            font-size: 3.3rem;
            color: #a7abc3;
            margin-bottom: 0.5rem;
        }
    </style>

    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::order.detail.info_order')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <a href="{{route('product.order')}}" class="btn btn-secondary btn-bold">
                @lang('product::order.detail.back')
            </a>
        </div>
    </div>
    <!--begin: Datatable -->

    <div class="kt-content1  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">
                                @lang('product::order.detail.order_code'):
                            </label>
                            <label for="" class="kt-margin-l-20">
                                {{$order['order_info']['order_code']}}
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::order.detail.created_at'):
                            </label>
                            <label for="" class="kt-margin-l-20">
                                @if($order['order_info']['created_at'] != '')
                                    {{(new DateTime($order['order_info']['created_at']))->format('d/m/Y H:i:s')}}
                                @endif
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                Nhân viên hỗ trợ:
                            </label>
                            <label for="" class="kt-margin-l-20">
                                {{$orderSelect['staff_support']}}
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::order.detail.order_content')
                            </label>
                            <textarea class="form-control textarea-h" disabled rows="5" >{{$order['order_info']['order_content']}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::order.detail.order_status'):
                            </label>
                            <label for="" class="kt-margin-l-20">
                                @if($order['order_info']['order_status_id'] == 5)
                                    {{$order['order_info'][getValueByLang('order_status_name_')]}}
                                @else
                                    {{$order['order_info'][getValueByLang('order_status_name_')]}}
                                @endif
                            </label>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">
                                @lang('product::order.detail.created_by'):
                            </label>
                            <label for="" class="kt-margin-l-30">
                                {{$order['order_info']['create_full_name']}}
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::order.detail.updated_by'):
                            </label>
                            <label for="" class="kt-margin-l-15">
                                {{$order['order_info']['update_full_name']}}
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::order.detail.updated_at'):
                            </label>
                            <label for="" class="kt-margin-l-20">
                                @if($order['order_info']['updated_at'] != '')
                                    {{(new DateTime($order['order_info']['updated_at']))->format('d/m/Y H:i:s')}}
                                @endif
                            </label>
                        </div>
                    </div>
                </div>
                @if($order['order_info']['order_status_id'] != 5)
                    <div class="row">
                            <div class="kt-grid vw-100  kt-wizard-v1 kt-wizard-v1--white" id="kt_wizard_v1" data-ktwizard-state="step-first">
                                <div class="kt-grid__item">
                                    <div class="kt-wizard-v1__nav">
                                        <div class="kt-wizard-v1__nav-items">
{{--                                            @if($order['order_info']['order_status_id'] != 6)--}}
{{--                                                @php $count = 0; @endphp--}}
{{--                                                @foreach($status as $item)--}}
{{--                                                    @php $count ++; @endphp--}}
{{--                                                    @if($item['order_status_id'] != 5 )--}}
{{--                                                        <a class="kt-wizard-v1__nav-item" href="javascipt:void(0)"--}}
{{--                                                           data-ktwizard-type="step"--}}
{{--                                                           data-ktwizard-state="{{$order['order_info']['order_status_id'] >= $item['order_status_id'] ? 'current' : ''}}">--}}
{{--                                                            <div class="kt-wizard-v1__nav-body">--}}
{{--                                                                <div class="kt-wizard-v1__nav-icon">--}}
{{--                                                                    @if($count == 1)--}}
{{--                                                                        <i class="flaticon2-shopping-cart-1"></i>--}}
{{--                                                                    @elseif($count == 2)--}}
{{--                                                                        <i class="flaticon2-laptop"></i>--}}
{{--                                                                    @elseif($count == 3)--}}
{{--                                                                        <i class="flaticon2-laptop"></i>--}}
{{--                                                                    @elseif($count == 4)--}}
{{--                                                                        <i class="flaticon2-hourglass-1"></i>--}}
{{--                                                                    @elseif($count == 5)--}}
{{--                                                                        <i class="flaticon2-checkmark"></i>--}}
{{--                                                                    @endif--}}
{{--                                                                </div>--}}
{{--                                                                <div class="kt-wizard-v1__nav-label">--}}
{{--                                                                    {{$count}}) {{$item[getValueByLang('order_status_name_')]}}--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </a>--}}
{{--                                                    @endif--}}
{{--                                                @endforeach--}}
{{--                                            @else--}}
{{--                                            @endif--}}
                                            <a class="kt-wizard-v1__nav-item" href="javascipt:void(0)"
                                               data-ktwizard-type="step"
                                               data-ktwizard-state="{{$order['order_info']['order_status_id'] >= 1 ? 'current' : ''}}">
                                                <div class="kt-wizard-v1__nav-body">
                                                    <div class="kt-wizard-v1__nav-icon">
                                                            <i class="flaticon2-shopping-cart-1"></i>
                                                    </div>
                                                    <div class="kt-wizard-v1__nav-label">
                                                        1) {{$status[0][getValueByLang('order_status_name_')]}}
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="kt-wizard-v1__nav-item" href="javascipt:void(0)"
                                               data-ktwizard-type="step"
                                               data-ktwizard-state="{{$order['order_info']['order_status_id'] == 6 || $order['order_info']['order_status_id'] > 1 ? 'current' : ''}}">
                                                <div class="kt-wizard-v1__nav-body">
                                                    <div class="kt-wizard-v1__nav-icon">
                                                        <i class="flaticon2-laptop"></i>
                                                    </div>
                                                    <div class="kt-wizard-v1__nav-label">
                                                        2) {{$status[4][getValueByLang('order_status_name_')]}}
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="kt-wizard-v1__nav-item" href="javascipt:void(0)"
                                                   data-ktwizard-type="step"
                                                   data-ktwizard-state="{{$order['order_info']['order_status_id'] >= 2 && $order['order_info']['order_status_id'] != 6 ? 'current' : ''}}">
                                                <div class="kt-wizard-v1__nav-body">
                                                    <div class="kt-wizard-v1__nav-icon">
                                                        <i class="flaticon2-laptop"></i>
                                                    </div>
                                                    <div class="kt-wizard-v1__nav-label">
                                                        3) {{$status[1][getValueByLang('order_status_name_')]}}
                                                    </div>
                                                </div>
                                            </a>
{{--                                            <a class="kt-wizard-v1__nav-item" href="javascipt:void(0)"--}}
{{--                                               data-ktwizard-type="step"--}}
{{--                                               data-ktwizard-state="{{$order['order_info']['order_status_id'] >= 3 && $order['order_info']['order_status_id'] != 6 ? 'current' : ''}}">--}}
{{--                                                <div class="kt-wizard-v1__nav-body">--}}
{{--                                                    <div class="kt-wizard-v1__nav-icon">--}}
{{--                                                        <i class="flaticon2-hourglass-1"></i>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="kt-wizard-v1__nav-label">--}}
{{--                                                        4) {{$status[2][getValueByLang('order_status_name_')]}}--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
                                            <a class="kt-wizard-v1__nav-item" href="javascipt:void(0)"
                                               data-ktwizard-type="step"
                                               data-ktwizard-state="{{$order['order_info']['order_status_id'] >= 4 && $order['order_info']['order_status_id'] != 6 ? 'current' : ''}}">
                                                <div class="kt-wizard-v1__nav-body">
                                                    <div class="kt-wizard-v1__nav-icon">
                                                        <i class="flaticon2-checkmark"></i>
                                                    </div>
                                                    <div class="kt-wizard-v1__nav-label">
                                                        4) {{$status[2][getValueByLang('order_status_name_')]}}
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endif
                        @include('product::order.list-order-detail')
                    <!-- end:: Content -->
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/attribute-group/script.js?v='.time()) }}"></script>
@endsection
@section('after_style')
    <link rel="stylesheet" href="{{ asset('static/backend/css/order-detail.css?v='.time()) }}">
@endsection
