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
                @lang('product::contract.index.annex_detail')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            @include('helpers.button', ['button' => [
                  'route' => 'product.annex.edit',
                   'html' => '<a href="'.route('product.annex.edit', ['id' => $detail['customer_contract_annex_id']]).'"
                    class="btn btn-label-brand btn-bold">Chỉnh sửa</a>'
               ]])
            <a href="{{route('product.annex')}}" class="btn btn-secondary btn-bold">
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
                                @lang('product::contract.index.annex_no'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="{{$detail['contract_annex_no']}}">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::contract.index.contract_code'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="{{$detail['contract_no']}}">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::contract.index.customer'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="{{$detail['customer_name']}}">
                            </label>
                        </div>
                        @foreach($file as $item)
                            @if($item['file_type'] == 'contract_annex_sample')
                                <div class="form-group">
                                    <label for="">
                                        @lang('product::contract.index.contract_annex_sample'):
                                    </label>
                                    <label for="" class="kt-margin-l-20">
                                        <a href="{{BASE_URL_API.($item['link_file'])}}" title="{{$item['file_name']}}"
                                           target="_blank">
                                            {{ subString($item['file_name']) }}
                                        </a>
                                    </label>
                                </div>
                            @elseif($item['file_type'] == 'contract_annex_customer_sign')
                                <div class="form-group">
                                    <label for="">
                                        @lang('product::contract.index.contract_annex_customer_sign'):
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
                                @lang('product::contract.index.annex_date'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="@if($detail['contract_annex_date'] != null && $detail['contract_annex_date'] != '0000-00-00 00:00:00'){{(new DateTime($detail['contract_annex_date']))->format('d/m/Y ')}}@endif">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">
                                @lang('product::contract.index.annex_created'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="@if($detail['created_at'] != null && $detail['created_at'] != '0000-00-00 00:00:00'){{(new DateTime($detail['created_at']))->format('d/m/Y ')}}@endif">
                            </label>
                        </div>
                        <div class="fomr-group">
                            <label for="">
                                @lang('product::contract.detail.created_by'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="{{$detail['created_by']}}">
                            </label>
                        </div>
                        <div class="fomr-group">
                            <label for="">
                                @lang('product::order.detail.updated_by'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="{{$detail['updated_by']}}">
                            </label>
                        </div>
                        <div class="fomr-group">
                            <label for="">
                                @lang('product::order.detail.updated_at'):
                            </label>
                            <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="@if($detail['updated_at'] != null && $detail['updated_at'] != '0000-00-00 00:00:00'){{(new DateTime($detail['updated_at']))->format('d/m/Y ')}}@endif">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


