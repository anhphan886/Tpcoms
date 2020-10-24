@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <style>
        .image-big {
            width: 170px !important;
            height: 170px !important;
        }
    </style>
    <form method="post" id="save-voucher">
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('product::voucher.edit.add')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <button type="button" onclick="voucher.save()" class="btn btn-info btn-bold">
                    @lang('product::voucher.edit.save')
                </button>
                <a href="{{route('product.voucher')}}" class="btn btn-secondary btn-bold">
                    @lang('product::voucher.edit.cancel')
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
                                <label class="col-form-label" for="product_category_id">
                                    @lang('product::voucher.edit.code') <span class="color_red">*</span>
                                </label>
                                <input class="form-control" type="text" name="code" id="code"
                                       style="text-transform: uppercase">
                                {{--                                pattern="[^\s]+" title="Mã không có khoảng trắng và ký tự đặc biệt !"--}}

                            </div>
                            <div class="form-group">
                                <label>
                                    @lang('product::voucher.edit.type') <span class="color_red">*</span>
                                </label>
                                <div class="kt-radio-inline form-text">
                                    <label class="kt-radio">
                                        <input type="radio" name="type" id="type1" value="sale_cash">
                                        @lang('product::voucher.edit.sale_cash')
                                        <span></span>
                                    </label>
                                    <label class="kt-radio">
                                        <input type="radio" name="type" id="type2" value="sale_percent">
                                        @lang('product::voucher.edit.sale_percent')
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" id="value-voucher">
                                    {{--                                    @lang('product::voucher.edit.cash_percent') <span class="color_red">*</span>--}}
                                </label>
                                <input class="form-control" type="text" name="cash" id="cash_percent">
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label class="col-form-label">
                                        @lang('product::voucher.edit.max_price')
                                    </label>
                                    <input class="form-control" type="text" name="max_price" id="max_price">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="col-form-label">
                                        @lang('product::voucher.edit.required_price') <span class="color_red">*</span>
                                    </label>
                                    <input class="form-control" type="text" name="required_price" id="required_price">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::voucher.edit.quota')
                                        </label>
                                        <input class="form-control" type="text" placeholder="Mặc định là không giới hạn" name="quota" id="quota">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::voucher.edit.expire_date') <span class="color_red">*</span>
                                        </label>
                                        <input class="form-control date-picker-expire" type="text" name="expired_date"
                                               autocomplete="off" readonly="readonly" id="expired_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" value="">
    </form>
@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/voucher/script.js?v='.time()) }}"></script>
@endsection
