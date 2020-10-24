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
    <form method="post" id="save-customer" >
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('product::customer.detail.add')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <button type="button" onclick="customerAccount.save()" class="btn btn-info btn-bold">
                    @lang('product::customer.detail.save')
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
                                        id="customer_name">

                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.detail.customer_type')
                                </label>
                                <select name="customer_type" id="customer_type"
                                        class="form-control ss-select-2 select_province">
                                    <option value="">
                                        @lang('product::order.index.customer_type')
                                    </option>
                                    <option value="personal">@lang('product::customer.detail.personal')</option>
                                    <option value="enterprise">@lang('product::customer.detail.enterprise')</option>
                                </select>
                                <div class="form-text"></div>
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
                                        <option value="{{$s['id']}}">
                                            {{$s['name']}}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.detail.cmnd_mst')
                                </label>
                                <input class="form-control"  type="text" name="customer_id_num"
                                       id="customer_id_num">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.detail.account_type')
                                </label>
                                <input class="form-control"  type="text" name="account_type"
                                       id="account_type" value="master" disabled>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.detail.phone')
                                </label>
                                <div class="row">
                                    <div class="col">
                                        <input class="form-control"  type="text" name="customer_phone"
                                               id="customer_phone">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.detail.phone2')
                                </label>
                                <div class="row">
                                    <div class="col">
                                        <input class="form-control"  type="text" name="customer_phone2"
                                               id="customer_phone2">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    Email
                                </label>
                                <input class="form-control"  type="text" name="customer_email"
                                       id="customer_email">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.detail.account_password')
                                </label>
{{--                                <input class="form-control eye-on"  type="password" name="account_password"--}}
{{--                                       id="account_password">--}}
{{--                                <input type="checkbox" onclick="showPassword()">Hiển thị mật khẩu--}}
                                <div class="kt-input-icon kt-input-icon--right">
                                    <input type="password" class="form-control" id="account_password" name="account_password" placeholder="Hãy nhập mật khẩu...">
                                    <span></span>
                                    <a href="javascript:void(0)" onclick="showPassword()" class="kt-input-icon__icon kt-input-icon__icon--right">
                <span class="kt-input-icon__icon kt-input-icon__icon--right">
                    <span><i class="la la-eye"></i></span>
                 </span>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    Website
                                </label>
                                <input class="form-control"  type="text" name="customer_website"
                                       id="customer_website">
                            </div>
                            <div class="form-group">
                            <label class="col-form-label">
                                @lang('product::customer.detail.province_id')
                            </label>
                                <select name="province_id" id="province_id" class="form-control ss-select-2 select_province" style="width: 100%" onchange="order.changeProvince(this)">
                                    <option value="">
                                        @lang('product::order.index.choose_province')
                                    </option>
                                    @if(isset($province))
                                        @if(count($province) > 0)
                                            @foreach($province as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>

                                            @endforeach
                                        @endif
                                    @endif
                                </select>
                                <div class="form-text"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.index.choose_district')
                                </label>
                                <select name="district_id" id="district_id" class="form-control ss-select-2 district" style="width: 100%">
                                    <option value="">
                                        @lang('product::order.index.choose_district')
                                    </option>
                                    @if(isset($district))
                                        @if(count($district) > 0)
                                                @foreach($district as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                </select>
                                <div class="form-text"></div>
{{--                                <span class="form-text text-muted"></span>--}}
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.detail.address') <span style="color: #ffffff"></span>
                                </label>
                                <input class="form-control"  type="text" name="customer_address_desc"
                                       id="customer_address_desc">
                            </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/script-edit.js?v='.time()) }}"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/script.js?v='.time()) }}"></script>
    <script>
        function showPassword() {
            var x = document.getElementById("account_password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
