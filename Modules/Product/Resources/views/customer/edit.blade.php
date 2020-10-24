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
    <form method="post" id="edit-customer" >
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::customer.detail.edit')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <button type="button" onclick="customerAccount.editCustomer()" class="btn btn-info btn-bold">
                @lang('product::product-category.create.save')
            </button>
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
                            <input class="form-control"  type="text" name="customer_name"
                                   value="{{$list['customer_name']}}" id="customer_name">

                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                Lĩnh vực
                            </label>
                            <select name="segment_id" id="segment_id" class="form-control ss-select-2 select_province">
                                <option value="">
                                    Chọn lĩnh vực
                                </option>
                                @foreach($segment as $s)
                                    <option value="{{$s['id']}}" {{$list['segment_id'] == $s['id'] ? 'selected' : ''}}>
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
                            <input class="form-control"  type="text" name="customer_no"
                                   value="{{$list['customer_no']}}" id="customer_no" disabled>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                @lang('product::customer.detail.cmnd_mst')
                            </label>
                            <input class="form-control"  type="text" name="customer_id_num"
                                   value="{{$list['customer_id_num']}}" id="customer_id_num" >
                        </div>
                        <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="col-form-label">
                                        @lang('product::customer.detail.phone')
                                    </label>
                                    <input class="form-control" type="text" name="customer_phone"
                                           value="{{$list['customer_phone']}}" id="customer_phone" >
                                </div>
                                <div class="col-lg-6">
                                    <label class="col-form-label">
                                        @lang('product::customer.detail.phone2')
                                    </label>
                                    <input class="form-control" type="text" name="customer_phone2"
                                           value="{{$list['customer_phone2']}}"  id="customer_phone2" >
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                Website
                            </label>
                            <input class="form-control"  type="text" name="customer_website"
                                   value="{{$list['customer_website']}}" id="customer_website">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label">
                                @lang('product::customer.detail.province_id')
                            </label>
                            <select  name="province_id" id="province_id" class="form-control ss-select-2 select_province" style="width: 100%" onchange="order.changeProvince(this)">
                                @if(isset($province))
                                    @if(count($province) > 0)
                                        <option value=""></option>
                                        @foreach($province as $key => $value)
                                            <option value="{{$key}}" {{$key == $list['province_id'] ? "selected" : ""}}>{{$value}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                @lang('product::customer.index.choose_district')
                            </label>
                            <select  name="district_id" id="district_id" class="form-control ss-select-2 district" style="width: 100%">
                                @if(isset($district))
                                    @if(count($district) > 0)
                                        <option value="">@lang('product::order.index.choose_district')</option>
                                        @foreach($district as $key => $value)
                                            <option value="{{$key}}" {{$key == $list['district_id'] ? "selected" : ""}}>{{$value}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                @lang('product::customer.detail.address') <span style="color: #ffffff"></span>
                            </label>
                            <input class="form-control"  type="text" name="customer_address_desc"
                                   value="{{$list['customer_address_desc']}}" id="customer_address_desc" >
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                Email
                            </label>
                            <input class="form-control"  type="text" name="customer_email"
                                   value="{{$list['customer_email']}}" id="customer_email" disabled>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">
                                Thời gian khóa dịch vụ sau khi trễ hẹn thanh toán (ngày):
                            </label>
                            <input class="form-control"  type="text" name="block_service_time" placeholder="{{$list['block_service_time'] == 0 ? 'Không báo trễ' : ''}}"
                                   value="{{$list['block_service_time'] == 0 ? '' : $list['block_service_time']}}" id="block_service_time">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <input type="hidden" name="id" value="{{$list['customer_id']}}">
</form>
@endsection
@section('after_script')

    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/script-edit.js?v='.time()) }}"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/script.js?v='.time()) }}"></script>
@endsection
