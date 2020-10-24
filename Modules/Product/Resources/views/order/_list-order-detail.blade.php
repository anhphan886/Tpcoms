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

    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="fomr-group">
                            <label for="">
                                @lang('product::order.detail.order_code'):
                            </label>
                            <label for="" class="kt-margin-l-20">
                                {{$order['order_info']['order_code']}}
                            </label>
                        </div>
                        <div class="fomr-group">
                            <label for="">
                                @lang('product::order.detail.created_at')
                            </label>
                            <label for="" class="kt-margin-l-20">
                                {{$order['order_info']['created_at']}}
                            </label>
                        </div>
                        <div class="fomr-group">
                            <label for="">
                                @lang('product::order.detail.order_status')
                            </label>
                            <label for="" class="kt-margin-l-20">
                                @if($order['order_info']['order_status_id'] == 5)
                                    {{$order['order_info'][getValueByLang('order_status_name_')]}}
                                @endif
                            </label>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="fomr-group">
                            <label for="">
                                @lang('product::order.detail.created_by'):
                            </label>
                            <label for="" class="kt-margin-l-30">
                                {{$order['order_info']['create_full_name']}}
                            </label>
                        </div>
                        <div class="fomr-group">
                            <label for="">
                                @lang('product::order.detail.updated_by')
                            </label>
                            <label for="" class="kt-margin-l-15">
                                {{$order['order_info']['update_full_name']}}
                            </label>
                        </div>
                        <div class="fomr-group">
                            <label for="">
                                @lang('product::order.detail.updated_at')
                            </label>
                            <label for="" class="kt-margin-l-20">
                                {{$order['order_info']['updated_at']}}
                            </label>
                        </div>
                    </div>
                </div>
            @if($order['order_info']['order_status_id'] != 5)
                <!-- begin:: Content -->
                    <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white" id=""
                         data-ktwizard-state="first">
                        <div class="kt-grid__item">
                            <!--begin: Form Wizard Nav -->
                            <div class="kt-wizard-v1__nav">
                                <div class="kt-wizard-v1__nav-items">
                                    @php $count = 0; @endphp
                                    @foreach($status as $item)
                                        @if($item['order_status_id'] != 5)
                                            @php $count += 1; @endphp

                                            <a class="kt-wizard-v1__nav-item" href="#"
                                               data-ktwizard-type="step"
                                               data-ktwizard-state="{{$order['order_info']['order_status_id'] >= $count ? 'current' : 'pending'}}">
                                                <div class="kt-wizard-v1__nav-body ">
                                                    <div class="kt-wizard-v1__nav-icon">
                                                        {{$item['order_status_id']}}
                                                    </div>
                                                    <div class="kt-wizard-v1__nav-label">
                                                        {{($item[getValueByLang('order_status_name_')])}}
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <!--end: Form Wizard Nav -->
                        </div>
                    </div>
            @endif
            {{--            @include('product::order.list-service')--}}

            <!-- end:: Content -->
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/attribute-group/script.js?v='.time()) }}"></script>
@endsection
