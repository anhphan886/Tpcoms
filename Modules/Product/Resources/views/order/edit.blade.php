@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid create-order-form nt_content magin-50" id="kt_content">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
												<span class="kt-portlet__head-icon">
													<i class="flaticon-users-1 kt-font-success"></i>
												</span>
                    <h3 class="kt-portlet__head-title kt-font-brand kt-subheader__title">
                        Cập nhật đơn hàng
                    </h3>
                </div>
            </div>
            <form class="kt-form kt-form--fit kt-form--label-right">
                <div class="kt-portlet__body">
                    <div class="kt-portlet__body">
                        <div class="form-group row nt-padding_none">
                            <div class="col-lg-6 col-md-6 col-12 col-sm-12">
                                <input type="hidden" value="{{$arrOrder['source']}}" name="source" id="source">
                                @if($arrOrder['source'] == 'private')
                                    <label class="col-form-label nt_text_bold">Khách hàng:</label>
                                    <select class="form-control --select2" id="customer_id" name="customer_id">
                                        <option value="" >----- Chọn khách hàng -----</option>
                                        @foreach($arrCustomer as $customer)
                                            <option @if($customer['customer_id'] == $arrOrder['customer_id']) selected @endif value="{{$customer['customer_id']}}" >{{$customer['customer_name']}}</option>
                                        @endforeach
                                    </select>
                                @else
{{--                                    <div class="kt-widget24">--}}
{{--                                        <div class="kt-widget24__details">--}}
{{--                                            <div class="kt-widget24__info">--}}
                                                <p class="kt-widget24__title nt_text_bold">
                                                    Khách hàng: {{$arrOrder['create_full_name']}}
                                                </p>
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                @endif

                                <label class="col-form-label nt_text_bold">Nội dung tư vấn đơn hàng:</label>
                                <textarea name="order_content" id="order_content" rows="5" class="form-control">{{$arrOrder['order_content']}}</textarea>

                            </div>
                            <div class="col-lg-6 col-md-6 col-12 col-sm-12">
                                <label class="col-form-label nt_text_bold">Nhân viên hỗ trợ:</label>
                                <select class="form-control --select2" id="staff_id" name="staff_id">
                                    <option value="" >----- Chọn nhân viên -----</option>
                                    @foreach($arrStaff as $staff)
                                        <option @if($staff['id'] == $arrOrder['staff_id']) selected @endif value="{{$staff['id']}}" >{{$staff['full_name']}}</option>
                                    @endforeach
                                </select>


                                @if($arrOrder['order_status_id'] == '1' )
                                    <label class="col-form-label nt_text_bold">Trạng thái đơn hàng:</label>
                                    <select class="form-control --select2" id="order_status_id" name="order_status_id">
                                        <option value="{{$arrOrder['order_status_id']}}" >{{$arrOrder['order_status_name_vi']}}</option>
                                        <option value="6" >Đã tư vấn</option>
                                    </select>
                                @else
                                    <input type="hidden" id="order_status_id" name="order_status_id" value="{{$arrOrder['order_status_id']}}">
                                @endif
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
                        <h3 class="kt-portlet__head-title kt-font-brand nt_text_bold">
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
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/order/script.js?v='.time()) }}"></script>
    <script>
        orderItem.sessionId = '{{$sessionId}}';
        orderItem.loadCart();
    </script>
@endsection
