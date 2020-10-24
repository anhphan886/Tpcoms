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
                    @lang('product::voucher.edit.edit')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <button type="button" onclick="voucher.editVoucher()" class="btn btn-info btn-bold">
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
                                    @lang('product::voucher.edit.code')
                                </label>
                                <input class="form-control"  type="text" name="code"
                                       value="{{$list['code']}}" id="code">

                            </div>
                            <div class="form-group">
                                <label>
                                    @lang('product::voucher.edit.type')
                                </label>
                                <div class="kt-radio-inline">
                                    <label class="kt-radio">
                                        <input type="radio" name="type" id="type1" value="sale_cash"
                                            {{$list['type'] == 'sale_cash' ? 'checked' : ''}} >
                                        @lang('product::voucher.edit.sale_cash')
                                        <span></span>
                                    </label>
                                    <label class="kt-radio">
                                        <input type="radio" name="type" id="type2" value="sale_percent"
                                            {{$list['type'] == 'sale_percent' ? 'checked' : ''}}>
                                        @lang('product::voucher.edit.sale_percent')
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::voucher.edit.cash_percent')
                                </label>
                                @if($list['type'] == 'sale_cash')
                                    <input class="form-control"  type="text" name="cash"
                                           value="{{ $list['cash'] }}{{$list['percent']}}" id="cash_percent" >
                                @else
                                    <input class="form-control"  type="text" name="percent"
                                           value="{{ $list['cash'] }}{{$list['percent']}}" id="cash_percent" >
                                @endif

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::voucher.edit.quota')
                                        </label>
                                        <input class="form-control" type="text" name="quota"
                                               value="{{$list['quota']}}" id="quota" >
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::voucher.edit.expire_date')
                                        </label>
                                        <input class="form-control" type="text" name="expired_date"  autocomplete="off" readonly="readonly"
                                               value="{{(new DateTime($list['expired_date']))->format('d/m/Y')}}"  id="expired_date">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    @if($list['type'] == 'sale_cash' )
                                        <div class="col-lg-6">
                                            <label class="col-form-label">
                                                @lang('product::voucher.edit.max_price')
                                            </label>
                                            <input class="form-control" type="text" name="max_price" disabled
                                                   value="{{ number_format($list['max_price'], 0) }}" id="max_price">
                                        </div>
                                    @else
                                        <div class="col-lg-6">
                                            <label class="col-form-label">
                                                @lang('product::voucher.edit.max_price')
                                            </label>
                                            <input class="form-control" type="text" name="max_price"
                                                   value="{{ number_format($list['max_price'], 0) }}" id="max_price">
                                        </div>
                                    @endif


                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::voucher.edit.required_price')
                                        </label>
                                        <input class="form-control" type="text" name="required_price"
                                               value="{{ number_format($list['required_price'], 0) }}" id="required_price" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" value="{{$list['voucher_id']}}">
    </form>
@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/voucher/script.js?v='.time()) }}"></script>
@endsection
