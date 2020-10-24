@extends('layout')
@section('header')
@include('components.header',['title' => 'Config'])
@endsection
@section('content')
<div class="kt-subheader kt-grid__item" id="kt_subheader">
    <div class="kt-subheader__main">
        <h3 class="kt-subheader__title">
            @lang('product::order.index.order_list')
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
                    'route' => 'product.order.create-adjust',
                    'html' => '<a href="'.route('product.order.create-adjust').'" class="btn btn-label-brand btn-bold">'
                    .__('product::order.index.create_order_adjust').
                '</a>'
                ]])
        @include('helpers.button', ['button' => [
                    'route' => 'product.order.create',
                    'html' => '<a href="'.route('product.order.create').'" class="btn btn-label-brand btn-bold">'
                    .__('product::order.index.create-order').
                '</a>'
                ]])
    </div>
</div>
<!--begin: Datatable -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__body nt_body_custom">
            <form id="form-filter" action="{{route('product.order')}}">
                <div class="row">
                    <div class="form-group col-lg-6 ">
                        <input class="form-control" type="text" id="keyword" name="keyword"
                            value="{{$filter['keyword']}}" placeholder="@lang('product::attribute-group.index.search')"
                            {{--value="{{$filter['keyword']}}"--}}>
                    </div>
                    <div class="form-group row col-lg-6 kt-padding-r-0">
                        <div class="col-lg-6 form-group nt_padding_0">
                            <input readonly type="text" class="form-control m-input daterange-picker" id="choose_day"
                                name="created_at" autocomplete="off"
                                placeholder="@lang('product::order.index.choose_day')"
                               value = "{{isset($filter['created_at']) ? $filter['created_at'] : ''}}">

                        </div>
                        <div class="col-lg-6 kt-padding-r-0">
                            <select name="order_status_id" id="order_status_id" class="form-control ">
                                <option value="">
                                    @lang('product::order.index.choose_status')
                                </option>
                                @if(isset($status))
                                @if(count($status) > 0)
                                @foreach($status as $item)
                                <option value="{{$item['order_status_id']}}"
                                    {{$filter['order_status_id'] == $item['order_status_id'] ? 'selected' : ''}}>
                                    {{$item[getValueByLang('order_status_name_')]}}
                                </option>
                                @endforeach
                                @endif
                                @endif

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3 col-12 col-sm-12 col-md-6">
                        <select name="province_id" id="province_id" class="form-control --select2 select_province"
                                onchange="order.changeProvince(this)">
                            <option value="">
                                @lang('product::order.index.choose_province')
                            </option>
                            @if(isset($province))
                                @if(count($province) > 0)
                                    @foreach($province as $key => $value)
                                        <option value="{{$key}}" {{$filter['province_id'] == $key ? 'selected' : ''}}>
                                            {{$value}}
                                        </option>
                                    @endforeach
                                @endif
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-lg-3 col-12 col-sm-12 col-md-6">
                        <select name="district_id" id="district_id" class="form-control district">
                            <option value="">
                                @lang('product::order.index.choose_district')
                            </option>
                            {{--@if(isset($district))--}}
                            {{--@if(count($district) > 0)--}}
                            {{--@if($filter['district_id'] != 0 && $filter['district_id'] != '' && $filter['district_id'] != null)--}}
                            {{--@foreach($district as $key => $value)--}}
                            {{--<option {{$filter['district_id'] == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>--}}
                            {{--@endforeach--}}
                            {{--@endif--}}
                            {{--@endif--}}
                            {{--@endif--}}
                        </select>
                    </div>
                    <div class="form-group col-lg-3 col-12 col-sm-12 col-md-6">
                        <select name="product_id" id="product_id" class="form-control">
                            <option value="">
                                @lang('product::order.index.choose_product')
                            </option>
                            @if(isset($product))
                                @if(count($product) > 0)
                                    @foreach($product as $item)
                                        <option value="{{$item['product_id']}}"
                                                {{$filter['product_id'] == $item['product_id'] ? 'selected' : ''}}>
                                            {{$item[getValueByLang('product_name_')]}}
                                        </option>
                                    @endforeach
                                @endif
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-lg-3 col-12 col-sm-12 col-md-6">
                        <select name="created_by" id="staff_id" class="form-control">
                            <option value="">
                                @lang('product::order.index.choose_create_by')
                            </option>
                            @if(isset($createBy))
                                @if(count($createBy) > 0)
                                    @foreach($createBy as $item)
                                        <option value="{{$item['id']}}" {{$filter['created_by'] == $item['id'] ? 'selected' : ''}}>
                                            {{$item['full_name']}}
                                        </option>
                                    @endforeach
                                @endif
                            @endif
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-align-right">
                        <a class="btn btn-secondary btn-hover-brand" href="{{route('product.order')}}">
                            @lang('product::attribute-group.index.remove')
                        </a>
                        <button type="submit" class="btn btn-primary btn-hover-brand">
                            @lang('core::admin-menu.input.BUTTON_SEARCH')
                        </button>
                    </div>
                </div>
                <div class="kt-section">
                    @include('product::order.list')
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="approveModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalTitle">@lang('product::order.popup.order_approval')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="radio">
                            <label>
                                <input type="radio" name="approveOption" value="trial"
                                    onchange="order.selecttrial(this)">
                                @lang('product::order.popup.trial')
                            </label>
                            <div id="trialDate" style="display: none;">
                                @lang('product::order.popup.trial_time') <input style="border-radius: 3px;" type="number" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="radio">
                            <label>
                                <input type="radio" name="approveOption" value="prepaid"
                                    onchange="order.selecttrial(this)">
                                @lang('product::order.popup.prepaid_confirm')
                            </label>
                            <div id="paidDate" style="display: none;">
                                @lang('product::order.popup.prepayment_period') <input style="border-radius: 3px;" type="number" min="0" max="1000"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="radio">
                            <label>
                                <input type="radio" name="approveOption" value="payuse"
                                    onchange="order.selecttrial(this)">
                                @lang('product::order.popup.payuse')
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="radio">
                            <label>
                                <input type="radio" name="approveOption" value="postpaid"
                                    onchange="order.selecttrial(this)">
                                @lang('product::order.popup.postpaid_confirm')
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="radio">
                            <label>
                                <input type="radio" name="approveOption" value="cancel"
                                    onchange="order.selecttrial(this)">
                                @lang('product::order.popup.cancel')
                            </label>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('product::order.popup.exit')</button>
                <button type="button" id="submitConfirm" class="btn btn-primary" onclick="order.confirmApproveOrder(this)">@lang('product::order.popup.approval')</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="language" value="{{\Illuminate\Support\Facades\App::getLocale()}}">
<input type="hidden" id="hidden_district_id" value="{{isset($filter['district_id']) ? $filter['district_id'] : 0}}">

@endsection
@section('after_script')
<script type="text/javascript" src="{{ asset('static/backend/js/product/order/script.js?v='.time()) }}"></script>
<script>

</script>
@endsection
