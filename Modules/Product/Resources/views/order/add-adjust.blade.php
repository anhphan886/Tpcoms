@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::order.index.create_order_adjust')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <form id="form-submit">
                    {{ csrf_field() }}
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Khách hàng:</label>
                            <div class="col-lg-4">
                                <select class="form-control --select2"
                                        id="customer_id"
                                        name="customer_id"
                                        onchange="orderAdjust.getServices(this)">
                                    <option value="">----- Chọn khách hàng -----</option>
                                    @foreach($arrOption['arrCustomer'] as $customer)
                                        <option value="{{$customer['customer_id']}}">{{$customer['customer_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-lg-2 col-form-label">Nhân viên hỗ trợ:</label>
                            <div class="col-lg-4">
                                <select class="form-control --select2 ss--width-100"
                                        id="staff_id"
                                        name="staff_id">
                                    <option value="">----- Chọn nhân viên -----</option>
                                    @foreach($arrOption['arrStaff'] as $staff)
                                        <option value="{{$staff['id']}}">{{$staff['full_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Dịch vụ:</label>
                            <div class="col-lg-4">
                                <select class="form-control --select2"
                                        id="customer_service_id"
                                        name="customer_service_id"
                                        onchange="orderAdjust.getDetailService(this)">
                                    <option value="">----- Chọn dịch vụ -----</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="flaticon-list-1 kt-font-success"></i>
                        </span>
                        <h3 class="kt-portlet__head-title kt-font-brand">
                            @lang('product::order.create_adjust.info_service')
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-section__content">
                        <div class="row">
                            <div class="col-12">
                                <div class="table_responsive">
                                    <table class="table table-striped ss-unset-min-hight" id="info_service">
                                        <thead>
                                        <tr>
                                            <th>
                                                @lang('product::order.create_adjust.attribute')
                                            </th>
                                            <th class="text-center">
                                                @lang('product::order.create_adjust.type_service')
                                            </th>
                                            <th class="text-center">
                                                @lang('product::order.create_adjust.service_quantity')
                                            </th>
                                            <th class="text-align-right">
                                                @lang('product::order.create_adjust.price') (VNĐ)
                                            </th>
                                            <th class="text-align-right">
                                                @lang('product::order.create_adjust.amount') (VNĐ)
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="fa fa-align-justify kt-font-success"></i>
                        </span>
                        <h3 class="kt-portlet__head-title kt-font-brand">
                            @lang('product::order.create_adjust.info_after_adjust')
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <a href="javascript:void(0)" onclick="orderAdjust.adjust()" class="btn btn-label-brand btn-bold">
                                <i class="fa fa-adjust"></i>
                                @lang('product::order.create_adjust.adjust')
                            </a>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body" id="info_service_after">
                    <div class="table_responsive">
                        <table class="table table-striped ss-unset-min-hight">
                            <thead>
                            <tr>
                                <th>
                                    @lang('product::order.create_adjust.stt')
                                </th>
                                <th class="text-center">
                                    @lang('product::order.create_adjust.form')
                                </th>
                                <th class="text-center">
                                    @lang('product::order.create_adjust.service')
                                </th>
                                <th class="text-center">
                                    @lang('product::order.create_adjust.package')
                                </th>
                                <th class="text-center">
                                    @lang('product::order.create_adjust.attribute_change')
                                </th>
                                <th class="text-center">
                                    @lang('product::order.create_adjust.datetime')
                                </th>
                                <th class="text-center">
                                    @lang('product::order.create_adjust.cost')
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="kt-portlet__footer">
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-12 col-lg-5 col-md-8 offset-lg-7 offset-md-4">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td><strong>Giá chưa thuế :</strong></td>
                                        <td class="total">0 VNĐ</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Thuế :</strong></td>
                                       <td class="vat">0 VNĐ</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tổng :</strong></td>
                                        <td class="amount">0 VNĐ</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <a href="{{route('product.order')}}" class="btn btn-secondary">Hủy</a>
                        <a href="javascript:void(0)"
                           onclick="orderAdjust.save()"
                           class="btn btn-primary">
                            @lang('product::order.index.create_order_adjust')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="form-create-order"></div>
@endsection
@section('after_style')
    <link href="{{ asset('static/backend/css/style/style.css?v='.time()) }}" rel="stylesheet" type="text/css" />
@endsection
@section('after_script')
    <script type="text/template" id="tpl-info-service">
        <tr>
            <td>{service_content}</td>
            <td class="text-center">{payment_type}</td>
            <td class="text-center quantity">{quantity}</td>
            <td class="text-align-right">{price}</td>
            <td class="text-align-right">{amount}</td>
        </tr>
    </script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/order/add-adjust.js?v='.time()) }}"></script>
@endsection
