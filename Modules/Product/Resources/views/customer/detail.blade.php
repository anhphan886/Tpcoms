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
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::customer.detail.detail')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__toolbar">
                {{-- @include('helpers.button', ['button' => [
                    'route' => 'product.customer.add-childAccount',
                    'html' => '<a href="#" onclick="vcloud.create_org(\''.$customer['customer_no'].'\')" class="btn btn-label-brand btn-bold">Tạo Organization</a>'
                ]])
                @include('helpers.button', ['button' => [
                    'route' => 'product.customer.add-childAccount',
                    'html' => '<a href="#" onclick="vcloud.config_firewall(\''.$customer['customer_no'].'\')" class="btn btn-label-brand btn-bold">Mở tường lửa</a>'
                ]]) --}}
                @include('helpers.button', ['button' => [
                    'route' => 'product.customer.add-childAccount',
                    'html' => '<a href="'.route('product.customer.add-childAccount',['id' => $customer['customer_id']]).'" class="btn btn-label-brand btn-bold">'
                    .__('product::childAccount.input.add_childAccount').
                '</a>'
                ]])
            </div>
            <a href="{{route('product.customer')}}" class="btn btn-secondary btn-bold">
                @lang('product::customer.detail.cancel')
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
                                @lang('product::customer.detail.customer_name')
                            </label>
                            <input class="form-control" disabled type="text" name="product_name_vi"
                                 value="{{$customer['customer_name']}}" id="product_name_vi">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                Lĩnh vực
                            </label>
                            <select disabled name="segment_id" id="segment_id" class="form-control ss-select-2 select_province">
                                @foreach($segment as $s)
                                    <option value="{{$s['id']}}" {{$customer['segment_id'] == $s['id'] ? 'selected' : ''}}>
                                        {{$s['name']}}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                @lang('product::customer.detail.customer_code')
                            </label>
                            <input class="form-control" disabled type="text" name="product_name_vi"
                                   value="{{$customer['customer_no']}}" id="product_name_vi">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                @lang('product::customer.detail.cmnd_mst')
                            </label>
                            <input class="form-control" disabled type="text" name="product_name_en"
                                  value="{{$customer['customer_id_num']}}" id="product_name_en">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="col-form-label">
                                        @lang('product::customer.detail.phone')
                                    </label>
                                    <input class="form-control" disabled type="text" name="product_name_en"
                                           value="{{$customer['customer_phone']}}" id="product_name_en">
                                </div>
                                <div class="col-lg-6">
                                    <label class="col-form-label">
                                        @lang('product::customer.detail.phone2')
                                    </label>
                                    <input class="form-control" disabled type="text" name="product_name_en"
                                           value="{{$customer['customer_phone2']}}"  id="product_name_en">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                Email
                            </label>
                            <input class="form-control" disabled type="text" name="customer_email"
                                   value="{{$customer['customer_email']}}" id="customer_email">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                Website
                            </label>
                            <input class="form-control" disabled type="text" name="product_name_en"
                                 value="{{$customer['customer_website']}}" id="product_name_en">
                        </div>
                    </div>
                    <div class="col-lg-6">
                       <div class="form-group">
                            <label class="col-form-label">
                                @lang('product::customer.detail.address') <span style="color: #ffffff"></span>
                            </label>
                            <input class="form-control" disabled type="text" name="product_name_vi"
                                  value="{{$customer['customer_address_desc']}}" id="product_name_vi">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                @lang('product::customer.detail.customer_type')
                            </label>
                            <select disabled name="customer_type" id="customer_type" class="form-control ss-select-2 select_province">
                                <option value="">
                                    @lang('product::order.index.customer_type')
                                </option>
                                <option value=" "{{$customer['customer_type'] == 'personal' ? 'selected' : ''}}>@lang('product::customer.detail.personal')</option>
                                <option value=" " {{$customer['customer_type'] == 'enterprise' ? 'selected' : ''}}>@lang('product::customer.detail.enterprise')</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                @lang('product::customer.detail.province_id')
                            </label>
                            <select disabled name="province_id" id="province_id" class="form-control ss-select-2 select_province" style="width: 100%" onchange="order.changeProvince(this)">
                                @if(isset($province))
                                    @if(count($province) > 0)
                                        <option value=""></option>
                                        @foreach($province as $key => $value)
                                            <option value="{{$key}}" {{$key == $customer['province_id'] ? "selected" : ""}}>{{$value}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                @lang('product::customer.index.district_id')
                            </label>
                            <select disabled name="district_id" id="district_id" class="form-control ss-select-2 district" style="width: 100%">
                                @if(isset($district))
                                    @if(count($district) > 0)
                                        <option value="">@lang('product::order.index.choose_district')</option>
                                        @foreach($district as $key => $value)
                                            <option value="{{$key}}" {{$key == $customer['district_id'] ? "selected" : ""}}>{{$value}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            {{--<div class="row">--}}
                                {{--<div class="col-lg-6">--}}
                                    {{--<label class="col-form-label">--}}
                                        {{--@lang('product::customer.detail.created_by')--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<div class="col-lg-6">--}}
                                    {{--<label class="col-form-label">--}}
                                        {{--@lang('product::customer.detail.created_at')--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="col-form-label">
                                        @lang('product::customer.detail.created_by')
                                    </label>
                                    <input class="form-control" disabled type="text" name="product_name_en"
                                          value="{{$customer['create_full_name']}}" id="product_name_en">
                                </div>
                                <div class="col-lg-6">
                                    <label class="col-form-label">
                                        @lang('product::customer.detail.created_at')
                                    </label>
                                    <input class="form-control" disabled type="text" name="product_name_en"
                                           value="{{(new DateTime($customer['created_at']))->format('d/m/Y H:i:s')}}"  id="product_name_en">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{--<div class="row">--}}
                                {{--<div class="col-lg-6">--}}
                                    {{--<label class="col-form-label">--}}
                                        {{--@lang('product::customer.detail.updated_by')--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<div class="col-lg-6">--}}
                                    {{--<label class="col-form-label">--}}
                                        {{--@lang('product::customer.detail.updated_at')--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="col-form-label">
                                        @lang('product::customer.detail.updated_by')
                                    </label>
                                    <input class="form-control" disabled type="text" name="product_name_en"
                                          value="{{$customer['update_full_name']}}" id="product_name_en">
                                </div>
                                <div class="col-lg-6">
                                    <label class="col-form-label">
                                        @lang('product::customer.detail.updated_at')
                                    </label>
                                    <input class="form-control" disabled type="text" name="product_name_en"
                                           value="{{(new DateTime($customer['updated_at']))->format('d/m/Y H:i:s')}}" id="product_name_en">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="kt-section__content">
                        <div class="kt-portlet">
                            <div class="kt-portlet__body nt_master_padding_0 kh-customer">
                                <ul class="nav nav-pills nav-fill" role="tablist">
                                    <li class="nav-item" onclick="tab.tab_order()">
                                        <a class="nav-link active" data-toggle="tab" href="#kt_tabs_1_1" data-target="#kt_tabs_1_1">@lang('product::contract.tab.invoice') ({{$cOrder}}) </a>
                                    </li>
                                    <li class="nav-item" onclick="tab.tab_service()">
                                        <a class="nav-link " data-toggle="tab" href="#kt_tabs_1_2" data-target="#kt_tabs_1_2" >@lang('product::contract.tab.service') ({{$cService}}) </a>
                                    </li>
                                    <li class="nav-item" onclick="tab.tab_contract()">
                                        <a class="nav-link " data-toggle="tab" href="#kt_tabs_1_3" data-target="#kt_tabs_1_3">@lang('product::contract.tab.contract') ({{$cContract}}) </a>
                                    </li>
                                    <li class="nav-item" onclick="tab.tab_receipt()">
                                        <a class="nav-link " data-toggle="tab" href="#kt_tabs_1_4" data-target="#kt_tabs_1_4">@lang('product::contract.tab.pay') ({{$cReceipt}}) </a>
                                    </li>
                                    <li class="nav-item" onclick="tab.tab_childAccount()">
                                        <a class="nav-link " data-toggle="tab" href="#kt_tabs_1_5" data-target="#kt_tabs_1_5">@lang('product::contract.tab.child_account') ({{$c_childAccount}}) </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="kt_tabs_1_1" role="tabpanel">
                                        @include('product::customer.include.list-order')
                                    </div>

                                    <div class="tab-pane" id="kt_tabs_1_2" role="tabpanel">
                                        @include('product::customer.include.list-service')
                                    </div>

                                    <div class="tab-pane" id="kt_tabs_1_3" role="tabpanel">
                                        @include('product::customer.include.list-contract')
                                    </div>

                                    <div class="tab-pane" id="kt_tabs_1_4" role="tabpanel">
                                        @include('product::customer.include.list-receipt')
                                    </div>

                                    <div class="tab-pane" id="kt_tabs_1_5" role="tabpanel">
                                        @include('product::customer.include.list-childAccount')
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        @if(count($list) > 0)--}}
{{--                        {{$list->links('helpers.paging')}}--}}
{{--                            @endif--}}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="customer_id_hidden" value="{{$customer['customer_id']}}">
@endsection
@section('after_script')
    <script>
        var linkApi = '{{BASE_URL_API}}';
    </script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/script.js?v='.time()) }}"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/order.js?v='.time()) }}"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/service.js?v='.time()) }}"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/contract.js?v='.time()) }}"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/receipt.js?v='.time()) }}"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/child-account.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('static/backend/js/product/customer/vcloud.js?v='.time()) }}"></script>

@endsection
