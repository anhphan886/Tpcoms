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
                            {{--<div class="row">--}}
                                {{--<div class="col-lg-6">--}}
                                    {{--<label class="col-form-label">--}}
                                        {{--@lang('product::customer.detail.phone')--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<div class="col-lg-6">--}}
                                    {{--<label class="col-form-label">--}}
                                        {{--@lang('product::customer.detail.phone2')--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
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
                            <input class="form-control" disabled type="text" name="product_name_vi"
                                   value="{{$customer['customer_email']}}" id="product_name_vi">
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
                            <div class="kt-portlet__body nt_master_padding_0">
                                <ul class="nav nav-pills nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#kt_tabs_1_1" data-target="#kt_tabs_1_1">@lang('product::contract.tab.invoice') ({{$cOrder}})</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " data-toggle="tab" href="#kt_tabs_1_2" data-target="#kt_tabs_1_2" >@lang('product::contract.tab.service') ({{$cService}})</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " data-toggle="tab" href="#kt_tabs_1_3" data-target="#kt_tabs_1_3">@lang('product::contract.tab.contract') ({{$cContract}})</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " data-toggle="tab" href="#kt_tabs_1_4" data-target="#kt_tabs_1_4">@lang('product::contract.tab.pay') ({{$cReceipt}})</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="kt_tabs_1_1" role="tabpanel">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table_responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.order.stt')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.order.order_code')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.order.total')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.order.discount')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.order.vat')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.order.amount')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.order.voucher_code')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.order.order_status_id')
                                                                </p>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        @if (isset($list_order))
                                                            @foreach ($list_order as $key => $item)
                                                                <tbody>
                                                                <tr>
                                                                    <td>
                                                                        {{($key + 1)}}
                                                                    </td>
                                                                    <td>{{ subString($item['order_code']) }}</td>
                                                                    <td> {{ number_format($item['total']) }}</td>
                                                                    <td>{{ number_format($item['discount']) }}</td>
                                                                    <td>{{ number_format($item['vat']) }}</td>
                                                                    <td>{{ number_format($item['amount']) }}</td>
                                                                    <td>{{ subString($item['voucher_code']) }}</td>
                                                                    <td>@if($item['order_status_name_vi'] == 'Mới')
                                                                            <p class="color-red">@lang('product::order.index.New')</p>
                                                                        @elseif($item['order_status_name_vi'] == 'Đã duyệt')
                                                                            <p class="color-green">@lang('product::order.index.Accepted')</p>
                                                                        @elseif($item['order_status_name_vi'] == 'Chờ thanh toán')
                                                                            <p class="color-yellow">@lang('product::order.index.Waiting Payment')</p>
                                                                        @elseif($item['order_status_name_vi'] == 'Hoàn tất')
                                                                            <p class="color-brown">@lang('product::order.index.Finished')</p>
                                                                        @elseif($item['order_status_name_vi'] == 'Hủy')
                                                                            <p class="color-brown">@lang('product::order.index.Cancelled')</p>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            @endforeach
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
{{--                                        {{$list->appends($filter)->links('helpers.paging')}}--}}
                                    </div>


                                    <div class="tab-pane" id="kt_tabs_1_2" role="tabpanel">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table_responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.service.stt')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.service.service_code')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.service.payment_type')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.service.quantity')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.service.price')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.service.amount')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.service.type')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.service.status')
                                                                </p>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        @if (isset($list_service))
                                                            @foreach ($list_service as $key => $item)
                                                                <tbody>
                                                                <tr>
                                                                    <td>
                                                                        {{($key + 1)}}
                                                                    </td>
                                                                    <td>{{ subString($item['customer_service_id']) }}</td>
                                                                    <td>
                                                                        @if($item['payment_type'] == 'postpaid')
                                                                            @lang('product::customer.service.postpaid')

                                                                        @elseif($item['payment_type'] == 'prepaid')
                                                                            @lang('product::customer.service.prepaid')
                                                                        @else
                                                                            @lang('product::customer.service.payuse')
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ subString($item['quantity']) }}</td>
                                                                    <td> {{ number_format($item['price']) }}</td>
                                                                    <td>{{ number_format($item['amount']) }}</td>
                                                                    <td>
                                                                        @if ($item['type'] == 'trial')
                                                                            @lang('product::customer.service.trial')
                                                                        @elseif($item['type'] == 'real')
                                                                            @lang('product::customer.service.real')
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($item['status'] == 'actived')
                                                                            <p class="color-green">@lang('product::contract.service.actived')</p>
                                                                        @elseif($item['status'] == 'not_actived')
                                                                            <p class="color-red">@lang('product::contract.service.not_actived')</p>
                                                                        @elseif($item['status'] == 'spending')
                                                                            <p class="color-yellow">@lang('product::contract.service.spending')</p>
                                                                        @elseif($item['status'] == 'cancel')
                                                                            <p class="color-brown">@lang('product::contract.service.cancel')</p>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            @endforeach
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
{{--                                        {{$list->appends($filter)->links('helpers.paging')}}--}}
                                    </div>
                                    <div class="tab-pane" id="kt_tabs_1_3" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table_responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.index.stt')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.index.contract_code')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.index.status')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.index.file_contract')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.index.sign')
                                                                </p>
                                                            </th>
{{--                                                            <th id="th_group_name">--}}
{{--                                                                <p class="pn-pointer">--}}
{{--                                                                    @lang('product::contract.index.upload_file_scan')--}}
{{--                                                                </p>--}}
{{--                                                            </th>--}}
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.index.contract_date')
                                                                </p>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        @if (isset($list))
                                                            @foreach ($list as $key => $item)
                                                                <tbody>
                                                                <tr>
                                                                    <td>
                                                                        {{($key + 1)}}
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{route('product.contract.show', ['code' => $item['contract_no']])}}"
                                                                           title="{{$item['contract_no'] }}">
                                                                            {{ subString($item['contract_no']) }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        @if($item['status'] == 'new')
                                                                            <span class="">
                                                                    @lang('product::contract.index.new')
                                                                </span>
                                                                        @elseif($item['status'] == 'waiting_sign')
                                                                            <span class="">
                                                                    @lang('product::contract.index.waiting_sign')
                                                                </span>
                                                                        @elseif($item['status'] == 'waiting_approved')
                                                                            <span class="">
                                                                    @lang('product::contract.index.waiting_approved')
                                                                </span>
                                                                        @elseif($item['status'] == 'approved')
                                                                            <span class="">
                                                                    @lang('product::contract.index.approved')
                                                                </span>
                                                                        @elseif($item['status'] == 'approved_cancel')
                                                                            <span class="">
                                                                    @lang('product::contract.index.approved_cancel')
                                                                </span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @foreach($contractFile as $value)
                                                                            @if($value['file_type'] == 'contract_sample' && $value['customer_contract_id'] == $item['customer_contract_id'])
                                                                                <a href="{{BASE_URL_API.($value['link_file'])}}" title="{{$value['file_name']}}" target="_blank">
                                                                                    {{ subString($value['file_name'], 25) }}
                                                                                </a>
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td></td>
{{--                                                                    <td>--}}
{{--                                                                        <label class="btn btn-primary btn-sm">--}}
{{--                                                                            Upload--}}
{{--                                                                            <input accept="application/pdf"--}}
{{--                                                                                   onchange="order.upload('{{$item['customer_contract_id']}}', this)" type="file"--}}
{{--                                                                                   style="display: none" value="{{1}}">--}}
{{--                                                                        </label>--}}
{{--                                                                    </td>--}}
                                                                    <td>
                                                                        @if($item['contract_date'] != '')
                                                                            {{(new DateTime($item['contract_date']))->format('d/m/Y H:i:s')}}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            @endforeach
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        {{$list->appends($filter)->links('helpers.paging')}}
                                    </div>


                                    <div class="tab-pane" id="kt_tabs_1_4" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table_responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::contract.invoice.stt')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::customer.receipt.receipt_no')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::customer.receipt.receipt_content')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::customer.receipt.amount')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::customer.receipt.pay_expired')
                                                                </p>
                                                            </th>
                                                            <th id="th_group_name">
                                                                <p class="pn-pointer">
                                                                    @lang('product::customer.receipt.status')
                                                                </p>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        @if (isset($list_receipt))
                                                            @foreach ($list_receipt as $key => $item)
                                                                <tbody>
                                                                <tr>
                                                                    <td>
                                                                        {{($key + 1)}}
                                                                    </td>
                                                                    <td>{{ subString($item['receipt_no']) }}</td>
                                                                    <td>{{ subString($item['receipt_content']) }}</td>
                                                                    <td> {{ number_format($item['amount'])  }}</td>
                                                                    <td>{{(new DateTime($item['pay_expired']))->format('d/m/Y H:i:s')}}</td>
                                                                    <td>
                                                                        @if($item['status'] == 'paid')
                                                                            <p class="color-green">@lang('product::customer.receipt.paid')</p>
                                                                        @elseif($item['status'] == 'unpaid')
                                                                            <p class="color-red">@lang('product::customer.receipt.unpaid')</p>
                                                                        @elseif($item['status'] == 'refund')
                                                                            <p class="color-yellow">@lang('product::customer.receipt.refund')</p>
                                                                        @elseif($item['status'] == 'part-paid')
                                                                            <p class="text-warning">@lang('product::customer.receipt.part_paid')</p>
                                                                        @elseif($item['status'] == 'cancel')
                                                                            <p class="color-brown">@lang('product::customer.receipt.cancel')</p>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            @endforeach
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
{{--                                        {{$list->appends($filter)->links('helpers.paging')}}--}}
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

@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/script.js?v='.time()) }}"></script>
@endsection
