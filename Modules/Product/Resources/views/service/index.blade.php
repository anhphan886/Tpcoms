@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('before_style')
    <link href="{{asset('static/backend/css/wizard.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::customer.service.service')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            {{--@include('helpers.button', ['button' => [--}}
            {{--'route' => 'product.product-attribute-group.create',--}}
            {{--'html' => '<a href="'.route('product.product-attribute-group.create').'" class="btn btn-label-brand btn-bold">'--}}
            {{--.__('product::attribute-group.index.btn_add_attribute').--}}
            {{--'</a>'--}}
            {{--]])--}}
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-filter" action="#">
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <input class="form-control" type="text" id="keyword_product$product_name_vi"
                                   name="{{getValueByLang('keyword_product$product_name_')}}"
                                   placeholder=" @lang('product::customer.service.search')"
                                    value="{{isset($filter[getValueByLang('keyword_product$product_name_')]) ?
                                        $filter[getValueByLang('keyword_product$product_name_')] :"" }}" >
                        </div>

                        <div class="form-group col-lg-3">
                            <select name="keyword_customer_service$status" style="width: 100%"
                                    id="keyword_customer_service$status" class="form-control ss-select-2">
                                <option value="">
                                    @lang('product::customer.index.status')
                                </option>
                                <option value="actived" {{isset($filter['keyword_customer_service$status']) && $filter['keyword_customer_service$status'] == 'actived' ? 'selected' : ''}}>
                                    @lang('product::customer.service.actived')
                                </option>
                                <option value="not_actived" {{isset($filter['keyword_customer_service$status']) && $filter['keyword_customer_service$status'] == 'not_actived' ? 'selected' : ''}}>
                                    @lang('product::customer.service.not_actived')
                                </option>
                                <option value="spending" {{isset($filter['keyword_customer_service$status']) && $filter['keyword_customer_service$status'] == 'spending' ? 'selected' : ''}}>
                                    @lang('product::customer.service.spending')
                                </option>
                                <option value="cancel" {{isset($filter['keyword_customer_service$status']) && $filter['keyword_customer_service$status'] == 'cancel' ? 'selected' : ''}}>
                                    @lang('product::customer.service.cancel')
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <select name="keyword_customer_service$stop_payment" style="width: 100%"
                                    id="keyword_customer_service$stop_payment" class="form-control ss-select-2">
                                <option value="">
                                    Trạng thái thanh toán
                                </option>
                                <option value="1" {{isset($filter['keyword_customer_service$stop_payment'])
                                    && $filter['keyword_customer_service$stop_payment'] == '1' ? 'selected' : ''}}>
                                    Đã tạm dừng thanh toán
                                </option>
{{--                                <option value="0" {{isset($filter['keyword_customer_service$stop_payment'])--}}
{{--                                    && $filter['keyword_customer_service$stop_payment'] == '0' ? 'selected' : ''}}>--}}
{{--                                   Đang thanh toán--}}
{{--                                </option>--}}
                            </select>
                        </div>

                        <div class="form-group col-lg-3">
                            <select name="keyword_customer$customer_id" style="width: 100%"
                                    id="keyword_customer$customer_id" class="form-control ss-select-2">
                                <option value="">
                                    Chọn khách hàng
                                </option>
                                @if(isset($optionCustomer))
                                    @foreach($optionCustomer as $key => $value)
                                        <option value="{{$value['customer_id']}}" {{isset($filter['keyword_customer$customer_id']) && $filter['keyword_customer$customer_id'] == $value['customer_id'] ? 'selected' : ''}} >
                                            {{$value['customer_name']}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-lg-3 text-align-right-mobile">
                            <a class="btn btn-secondary btn-hover-brand" href="{{route('product.service')}}">
                                @lang('product::attribute-group.index.remove')
                            </a>
                            <button type="submit"
                                    class="btn btn-primary btn-hover-brand">
                                @lang('core::admin-menu.input.BUTTON_SEARCH')
                            </button>
                        </div>
                    </div>
                    <div class="kt-section">
                        @include('product::service.list')
                    </div>
                </form>
                <div class="modal fade" id="approveModal">
                    <form id="form-extends">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="approveModalTitle">Gia hạn dịch vụ</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="input-group date">
                                            <input type="text" placeholder="Nhập số tháng muốn gia hạng" class="form-control" id="month" name="month">
                                            <input type="hidden" id="type" name="type" value="">
                                            <input type="hidden" id="payment_type" name="payment_type" value="">
                                            <input type="hidden" id="customer_service_id" name="customer_service_id" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                                <button type="button" id="submitConfirm" class="btn btn-primary" onclick="objService.call_extends(this)">Gia hạn</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

                <div class="modal fade" id="stop_payment">
                    <form id="form-stop-payment">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="approveModalTitle">Chọn ngày tạm dừng thanh toán dịch vụ</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="input-group date">
                                            <input type="text"  class="form-control" readonly
                                                   name="stop_payment_at" id="stop_payment_at">
                                            <input type="hidden" name="customer_service_id"
                                                    value="" id="customer_service_id">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                                <button type="button" id="submitConfirm" class="btn btn-primary" onclick="objService.payment(this)">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

{{--                gia han dich vu--}}
                <div class="modal fade" id="stop_payment">
                    <form id="form-stop-payment">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="approveModalTitle">Chọn ngày tạm dừng thanh toán dịch vụ</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="input-group date">
                                                <input type="text"  class="form-control" readonly
                                                       name="stop_payment_at" id="stop_payment_at"
                                                       value="">
                                                <input type="hidden" name="customer_service_id"
                                                       value="" id="customer_service_id">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                                    <button type="button" id="submitConfirm" class="btn btn-primary" onclick="objService.payment(this)">Xác nhận</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/product/service/script.js?v='.time()) }}"></script>
    <script>

        window.json = ((lang)=>{
            return lang=='vi'?{
                title : 'Hủy dịch vụ này?',
                text : '',
                confirm_button_text: 'Hủy dịch vụ',
                cancel_button_text: 'Bỏ qua',
                cancel_fail : 'Hủy dịch vụ thất bại!',
                cancel_success : 'Hủy dịch vụ thành công!',
                cancel_success_message : 'Việc hủy dịch vụ của bạn đã được thực thi.',
                extends_title : 'Thời gian(tháng) bạn muốn gia hạn dịch vụ này?',
                extends_text : '',
                extends_confirm_button_text: 'Gia hạn dịch vụ',
                extends_cancel_button_text: 'Bỏ qua',
                extends_cancel_fail : 'Gia hạn dịch vụ thất bại!',
                extends_cancel_success : 'Gia hạn dịch vụ thành công!',
                extends_cancel_success_message : '',
                extends_month_invalid : 'Thời gian gia hạn là số nguyên dương.'
            }:{
                title : 'Do you want to cancel this service?',
                text : '',
                confirm_button_text: 'Cancel service',
                cancel_button_text: 'Dismiss',
                cancel_fail : 'Cancel service fail!',
                cancel_success : 'Cancel service successfully!',
                cancel_success_message : 'Your service cancelation is fulfilled.',
                extends_title : 'Service extension\'s time (months) which you want to extends this service?',
                extends_text : '',
                extends_confirm_button_text: 'Extends service',
                extends_cancel_button_text: 'Dismiss',
                extends_cancel_fail : 'Extends service fail!',
                extends_cancel_success : 'Extends service successfully!',
                extends_cancel_success_message : '',
                extends_month_invalid : 'Extension\'s time must be positive integer.'
            }
        })('{{app()->getLocale()}}');

        $(document).ready(function () {
            $('.kt-select2').select2();
        });

        $(document).ready(function () {
            var arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }

            $('#stop_payment_at').datepicker({
                rtl: KTUtil.isRTL(),
                format: 'dd/mm/yyyy',
                // pickerPosition: 'bottom-left',
                todayHighlight: true,
                autoclose: true,
                arrows: true,
            });
        });
    </script>
@endsection
