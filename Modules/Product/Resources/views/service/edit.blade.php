@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <form id="form-service-submit" action="{{ route('product.service.update') }}" method="POST" >
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">

            <h3 class="kt-subheader__title">
                @lang('product::customer.service.edit_service')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">
            </div>

        </div>
        <div class="kt-subheader__toolbar">
            <button type="button" class="btn btn-info btn-bold"  onclick="objService.save()">
                @lang('product::customer.service.save')
            </button>
{{--            <a href="{{ URL::previous() }}" class="btn btn-secondary btn-bold">--}}
{{--                @lang('ticket::issue.input.button_cancel')--}}
{{--            </a>--}}
            <a href="{{ route('product.service') }}" class="btn btn-secondary btn-bold">
                @lang('ticket::issue.input.button_cancel')
            </a>
        </div>
    </div>
        <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body nt_bold">
                <div class="row">
                    <div class="col-lg-6">

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="col-lg-3 col-form-label ">
                                @lang('product::customer.service.customer_name'):
                            </label>
                            <label for="" class="col-md-8 col-form-label kt-margin-l-20">
                                {{$detail['customer_name']}}
                                <input type="hidden" class="form-control" id="customer_service_id" name="customer_service_id" value="{{ $detail['customer_service_id']}}">
                            </label>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="col-lg-3 col-form-label ">
                                @lang('product::customer.service.product_name'):
                            </label>
                            <label  class="col-md-8 col-form-label kt-margin-l-20">
                                {{$detail['product_name_'.getValueByLang('')]}}
                            </label>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="col-lg-3 col-form-label">
                                @lang('product::customer.service.staff'):
                            </label>

                            <label  class="col-md-8 col-form-label kt-margin-l-20">
                                <select class="form-control  kt-select2" name="staff_id" id="staff_id" >
                                    <option value=" {{$detail['id']}}">
                                        @if($detail['full_name'] == null)
                                            @lang('product::customer.service.chosse_staff')
                                        @endif
                                    </option>
                                    @if (isset($listStaff) && $listStaff != null)
                                        @foreach ($listStaff as $item)
                                            <option value="{{ $item['id']}}" {{$detail['staff_id'] == $item['id'] ? "selected" :""}}>
                                                {{ $item['full_name'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </label>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="col-lg-3 col-form-label ">
                                @lang('product::customer.service.type'):
                            </label>
                            <label for="" class="col-md-8 col-form-label kt-margin-l-20">
                                @if ( $detail['type'] == 'trial')
                                    @lang('product::customer.service.trial')
                                @else ()
                                    @if ( $detail['payment_type'] == 'postpaid')
                                        @lang('product::customer.service.postpaid')

                                    @elseif ( $detail['payment_type'] == 'prepaid')
                                        @lang('product::customer.service.prepaid')

                                    @else
                                        @lang('product::customer.service.payuse')
                                    @endif
                                @endif
                            </label>
                        </div>

                    </div>
                    <div class="col-lg-6">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="col-lg-5 col-form-label ">
                                    @lang('product::customer.service.status'):
                                </label>
                                <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                    @if($detail['status'] == 'not_actived')
                                        <select class="form-control  kt-select2" name="status" id="status">
                                            <option value="not_actived" selected>
                                                @lang('product::customer.service.not_actived')
                                            </option>

                                            <option value="actived" >
                                                @lang('product::customer.service.actived')
                                            </option>
                                        </select>
                                    @else
                                        @if($detail['status'] == 'actived')
                                            @lang('product::customer.service.actived')

                                        @elseif($detail['status'] == 'spending')
                                            @lang('product::customer.service.spending')
                                        @elseif($detail['status'] == 'block')
                                            @lang('product::customer.service.block')
                                        @else
                                            @lang('product::customer.service.cancel')
                                        @endif
                                    @endif
                                </label>
                            </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="col-lg-5 col-form-label">
                                Trạng thái thanh toán:
                            </label>
                            <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                @if($detail['stop_payment'] == 1)
                                    Đã  tạm dừng thanh toán
                                @else
                                    {{--                                        Đang thanh toán--}}
                                @endif
                            </label>
                        </div>
                        @if($detail['stop_payment'] == 1)
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="col-lg-5 col-form-label">
                                    Thời gian dừng thanh toán dịch vụ:
                                </label>
                                <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                    @if ( $detail['stop_payment_at'] != null && $detail['stop_payment_at'] != '0000-00-00 00:00:00')
                                        {{date("d/m/Y",strtotime($detail['stop_payment_at']))}}
                                    @endif
                                </label>
                            </div>
                        @endif
                            @if( $detail['type'] != 'trial')
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="col-lg-5 col-form-label ">
                                        @lang('product::customer.service.charg_date'):
                                    </label>
                                    <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" name="charg_date" readonly id="kt_datepicker_2"
                                                   value=" @if ( $detail['charg_date'] != null && $detail['charg_date'] != '0000-00-00 00:00:00'){{date("d/m/Y",strtotime($detail['charg_date']))}}@endif"/>
                                            <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-calendar-check-o"></i>
                                                    </span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endif
                            <div class="form-group" style="margin-bottom: 0;" >
                                <label class="col-lg-5 col-form-label ">
                                    Thời gian sử dụng:
                                </label>
                                <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                    @if($detail['payment_type'] == 'payuse')
                                        Không xác định
                                    @else
                                        @if ($detail['quantity'] == null)
                                            Chưa sử dụng
                                        @else
                                            {{$detail['quantity']}}
                                            {{$detail['type'] == 'trial' ? 'Ngày' : 'Tháng'}}
                                        @endif
                                    @endif
                                </label>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;" >
                                <label class="col-lg-5 col-form-label ">
                                    @lang('product::customer.service.actived_date'):
                                </label>
                                <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                    @if ( $detail['actived_date'] == null || $detail['actived_date'] == '0000-00-00')
                                    @else
                                        {{date("d/m/Y",strtotime($detail['actived_date']))}}
                                    @endif
                                </label>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="col-lg-5 col-form-label ">
                                    @lang('product::customer.service.expired_date'):
                                </label>
                                <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                    @if($detail['payment_type'] == 'postpaid')
                                        @lang('product::customer.service.unknown')
                                    @elseif($detail['payment_type'] == 'payuse')
                                        @lang('product::customer.service.unknown')
                                    @elseif($detail['payment_type'] == 'prepaid')
                                        @if ( $detail['expired_date'] == null || $detail['expired_date'] == '0000-00-00' || $detail['status'] == 'not_actived')
                                        @else
                                            {{date("d/m/Y",strtotime($detail['expired_date']))}}
                                        @endif
                                    @endif
                                </label>
                            </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label  class="col-lg-4 col-form-label   nt_bold">
                            @lang('product::customer.service.service_cotent'):
                        </label>
                        <textarea  id="service_content" name="service_content" class="form-control textarea-h"  rows="12" >{{$detail['service_content']}}</textarea>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </form>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/product/service/script.js?v='.time()) }}"></script>
    <script>
        $('#staff_id').select2();

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

            // input group layout for modal demo
            $('#kt_datepicker_2').datepicker({
                rtl: KTUtil.isRTL(),
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                orientation: "bottom left",
                templates: arrows,
                autoclose: true,
            });
        });
    </script>
@endsection
