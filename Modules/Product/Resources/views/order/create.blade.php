@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title nt_text_bold ">
                Tạo đơn hàng
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
    <div class="kt-content1  kt-grid__item kt-grid__item--fluid create-order-form" id="kt_content">
        <div class="kt-portlet">
            <form class="kt-form kt-form--fit kt-form--label-right">
            <div class="kt-portlet__body">
                <div class="kt-portlet__body">
                    <input type="hidden" value="private" name="source" id="source">
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Khách hàng:</label>
                        <div class="col-lg-4">
                            <select class="form-control --select2" id="customer_id">
                                <option value="" >----- Chọn khách hàng -----</option>
                                @foreach($arrCustomer as $customer)
                                    <option value="{{$customer['customer_id']}}" >{{$customer['customer_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-lg-2 col-form-label">Nhân viên hỗ trợ:</label>
                        <div class="col-lg-4">
                            <select class="form-control --select2 ss--width-100" id="staff_id" name="staff_id">
                                <option value="" >----- Chọn nhân viên -----</option>
                                @foreach($arrStaff as $staff)
                                    <option value="{{$staff['id']}}" >{{$staff['full_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="flaticon-list-1 kt-font-success"></i>
                        </span>
                        <h3 class="kt-portlet__head-title kt-font-brand">
                            Danh sách dịch vụ đã chọn
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <a href="javascript:void(0)" onclick="orderItem.loadPopup()" class="btn btn-label-brand btn-bold">
                                <i class="fa fa-plus"></i>
                                Thêm sản phẩm
                            </a>
                        </div>
                    </div>
                </div>
                <div id="load-cart">
{{--                    @include('product::order.load-cart')--}}
                </div>
                <div id="form-create-order"></div>
                <div id="popup-promotion"></div>
            </div>
        </div>
    </div>
    <div>
    </div>
@endsection
@section('after_style')
    <link href="{{ asset('static/backend/css/style/style.css?v='.time()) }}" rel="stylesheet" type="text/css" />
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/order/script.js?v='.time()) }}"></script>
    <script>
        orderItem.sessionId = '{{$sessionId}}';
        orderItem.loadCart();
    </script>
@endsection
