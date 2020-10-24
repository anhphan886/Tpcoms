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
    <form method="post" id="edit-voucher" >
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('product::voucher.edit.detail')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
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
                                    @lang('product::voucher.edit.code')
                                </label>
                                <input class="form-control"  type="text" name="code"
                                       value="{{$list['code']}}" id="code" disabled>

                            </div>
                            <div class="form-group">
                                <label>
                                    @lang('product::voucher.edit.type')
                                </label>
                                <div class="kt-radio-inline">
                                    <label class="kt-radio">
                                        <input type="radio" name="type" id="type" value="sale_cash"
                                            {{$list['type'] == 'sale_cash' ? 'checked' : ''}} disabled>
                                        @lang('product::voucher.edit.sale_cash')
                                        <span></span>
                                    </label>
                                    <label class="kt-radio">
                                        <input type="radio" name="type" id="type" value="sale_percent"
                                            {{$list['type'] == 'sale_percent' ? 'checked' : ''}} disabled>
                                        @lang('product::voucher.edit.sale_percent')
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            @if ($list['type'] == 'sale_cash')
                                <div class="form-group">
                                    <label class="col-form-label">
                                        @lang('product::voucher.edit.cash_percent') (VNĐ)
                                    </label>
                                    <input class="form-control"  type="text" name="cash_percent"
                                           value="{{ $list['cash'] }} {{$list['percent']}}" id="cash_percent" disabled>
                                </div>
                             @else
                                <div class="form-group">
                                    <label class="col-form-label">
                                        @lang('product::voucher.edit.cash_percent') (%)
                                    </label>
                                    <input class="form-control"  type="text" name="cash_percent"
                                           value="{{$list['cash']}} {{$list['percent']}}" id="cash_percent" disabled>
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::voucher.edit.quota')
                                        </label>
                                        <input class="form-control" type="text" name="quota"
                                               value="{{$list['quota'] == '0' ? 'Không giới hạn' : $list['quota'] }}" id="quota" disabled>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::voucher.edit.expire_date')
                                        </label>
                                        <input class="form-control" type="text" name="expired_date"  autocomplete="off" readonly="readonly"
                                               value="{{(new DateTime($list['expired_date']))->format('d/m/Y')}}"  id="expired_date" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::voucher.edit.max_price')
                                        </label>
                                        <input class="form-control" type="text" name="max_price"
                                               value="{{ number_format($list['max_price'], 0) }}" id="max_price" disabled>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::voucher.edit.total_use')
                                        </label>
                                        <input class="form-control" type="text" name="total_use"
                                               value="{{ number_format($countVoucherLog, 0) }}" id="total_use" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::voucher.edit.required_price')
                                        </label>
                                        <input class="form-control" type="text" name="max_price"
                                               value="{{ number_format($list['required_price'], 0) }}" id="max_price" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label class="col-form-label">@lang('product::voucher.edit.status')</label>
                                @if($list['is_actived'] == '1')
                                    <span class="text-info btn-new">
                                    @lang('product::voucher.edit.on')
                                    </span>
                                @elseif($list['is_actived'] == '0')
                                    <span class="text-danger btn-cancelled">
                                    @lang('product::voucher.edit.off')
                                    </span>
                                @endif
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
