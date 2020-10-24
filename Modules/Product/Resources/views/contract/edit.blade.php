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
    <form id="form-submit">
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::contract.detail.edit')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <button type="button" class="btn btn-info btn-bold"  onclick="contract.save()">
                @lang('product::customer.service.save')
            </button>
            <a href="{{route('product.contract')}}" class="btn btn-secondary btn-bold">
                @lang('product::contract.detail.cancel')
            </a>
        </div>
    </div>
    <!--begin: Datatable -->

    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="">
                                @lang('product::contract.detail.contract_code'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="{{$contract['contract_no']}}">
                                <input type="hidden" name="customer_contract_id" id="customer_contract_id" value="{{$contract['customer_contract_id']}}">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::contract.detail.customer'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value=" {{$contract['customer_no'] . ' - ' . $contract['customer_name']}}">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::contract.detail.created_at'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value=" @if($contract['created_at'] != ''){{(new DateTime($contract['created_at']))->format('d/m/Y')}}@endif">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::contract.index.province'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="{{$contract['type'] != null ? $contract['type'] : ''}} {{$contract['name'] != null ? $contract['name'] : ''}}">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::contract.detail.status'):
                            </label>
                            <label for="" class="kt-margin-l-20">
                                @if($contract['status'] == 'new')
                                    <span class="text-primary btn-new">
                                            @lang('product::contract.index.new')
                                        </span>
                                @elseif($contract['status'] == 'waiting_sign')
                                    <span class="text-info btn-new">
                                            @lang('product::contract.index.waiting_sign')
                                        </span>
                                @elseif($contract['status'] == 'waiting_approved')
                                    <span class="text-warning btn-waiting-payment">
                                            @lang('product::contract.index.waiting_approved')
                                        </span>
                                @elseif($contract['status'] == 'approved')
                                    <span class="text-success btn-finished">
                                        @lang('product::contract.index.approved')
                                        </span>
                                @elseif($contract['status'] == 'approved_cancel')
                                    <span class="text-danger btn-cancelled">
                                            @lang('product::contract.index.approved_cancel')
                                        </span>
                                @endif
                            </label>
                        </div>
                        @foreach($file as $item)
                            @if($item['file_type'] == 'contract_sample')
                                <div class="form-group">
                                    <label for="">
                                        @lang('product::contract.detail.contract_customer_example'):
                                    </label>
                                    <label for="" class="kt-margin-l-20">
                                        <a href="{{BASE_URL_API.($item['link_file'])}}" title="{{$item['file_name']}}"
                                           target="_blank">
                                            {{ subString($item['file_name']) }}
                                        </a>
                                    </label>
                                </div>
                            @elseif($item['file_type'] == 'contract_customer_sign')
                                <div class="form-group">
                                    <label for="">
                                        @lang('product::contract.detail.contract_customer_sign'):
                                    </label>
                                    <label for="" class="kt-margin-l-20">
                                        <a href="{{BASE_URL_API.($item['link_file'])}}" title="{{$item['file_name']}}"
                                           target="_blank">
                                            {{ subString($item['file_name']) }}
                                        </a>
                                    </label>
                                </div>
                            @endif

                        @endforeach
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">
                                @lang('product::contract.detail.contract_date'):
                            </label>
                            <div class="input-group date col-form-label">
                                <input type="text"  class="form-control" readonly   name="contract_date" id="kt_datepicker_2"
                                       value="@if ($contract['contract_date'] == '0000-00-00 00:00' || $contract['contract_date'] == null){{date('d/m/Y', strtotime($contract['contract_date'])) }}@else{{date('d/m/Y', strtotime($contract['contract_date'])) }}@endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::contract.index.contract_time') (Ngày):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" id="time_contract" name="time_contract"
                                       value="@if(isset($contract['time_contract']) && $contract['time_contract'] != '0'){{$contract['time_contract']}}@endif">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::contract.index.expired_date'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="@if($contract['expired_date'] != null && $contract['expired_date'] != '0000-00-00 00:00:00' ){{(new DateTime($contract['expired_date']))->format('d/m/Y ')}}@endif">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::contract.detail.created_by'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="{{$contract['create_full_name']}}">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::order.detail.updated_by'):
                            </label>
                            <label for="" class="col-md-12 col-form-label">
                                <input class="form-control" disabled value="{{$contract['update_full_name']}}">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::order.detail.updated_at'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="@if($contract['updated_at'] != ''){{(new DateTime($contract['updated_at']))->format('d/m/Y')}}@endif">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/product/contract/script.js?v='.time()) }}"></script>
    <script>
        $(document).ready(function () {
            var arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }

            $('#kt_datepicker_2').datepicker({
                rtl: KTUtil.isRTL(),
                format: 'dd/mm/yyyy',
                // pickerPosition: 'bottom-left',
                todayHighlight: true,
                autoclose: true,
                arrows: true,
            });
        });
    </script>
@endsection


