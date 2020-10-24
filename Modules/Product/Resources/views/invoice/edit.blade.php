@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <form id="form_invoice" action="{{ route('product.invoice.update') }}" method="POST">
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">

            <h3 class="kt-subheader__title">
                @lang('product::invoice.index.update')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">
            </div>

        </div>
        <div class="kt-subheader__toolbar">
            <button type="button" class="btn btn-info btn-bold"  onclick="objInvoice.save()">
                @lang('product::invoice.input.save')
            </button>
            <a href="{{route('product.invoice')}}" class="btn btn-secondary btn-bold">
                @lang('product::invoice.input.button_cancel')
            </a>
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.invoice_no'):
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control" id="invoice_no" name="invoice_no" disabled value="{{$detailInvoice['invoice_no']}}">
                                    <input type="hidden" id="invoice_id" name="invoice_id" value="{{$detailInvoice['invoice_id']}}">
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.invoice_number'):
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control" id="invoice_number" name="invoice_number" value="{{$detailInvoice['invoice_number']}}">
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.contract_no'):
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control" disabled value="{{$detailInvoice['contract_no']}}">
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.customer'):
                                </label>
                                <label for="" class="col-md-12 col-form-label">
                                    <input class="form-control" disabled value="{{$detailInvoice['customer_name']}}">
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-label color_black">
                                    @lang('product::invoice.index.invoice_at'):
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <div class="input-group date">
                                        <input class="form-control tung1"  name="invoice_at" id="invoice_at"
                                           value="@if($detailInvoice['invoice_at'] != null && $detailInvoice['invoice_at'] != '0000-00-00 00:00:00'){{(new DateTime($detailInvoice['invoice_at']))->format('d/m/Y')}}@endif"/>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-label color_black">
                                    @lang('product::invoice.index.invoice_by'):
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <div class="input-group">
                                        <select class="form-control kt-select2" id="v"  name="invoice_by" >
                                            <option value="" selected>Chọn người xuất</option>
                                            @if (isset($listAdmin))
                                                @foreach( $listAdmin as $item)
                                                    <option value="{{$item['id']}}" {{$detailInvoice['invoice_by'] == $item['id'] ? "selected" :""}}>{{$item['full_name']}} </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.net'):
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control"  disabled value="{{number_format($detailInvoice['net'],'0')}} VNĐ">
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.vat'):
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control" disabled value="{{number_format($detailInvoice['vat'],'0')}} VNĐ">
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    Phần trăm giảm giá:
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control" id="reduce_percent" name="reduce_percent" value="{{$detailInvoice['reduce_percent']}}">
                                </label>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.amount'):
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control" disabled value="{{number_format($detailInvoice['amount'],'0')}}  VNĐ">
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.status'):
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <select class="form-control kt-select2" id="status"  name="status" >
{{--                                        <option value="{{$detailInvoice['status']}}">--}}
{{--                                            @if($detailInvoice['status'] == 'new')--}}
{{--                                                <p class="color-green">@lang('product::invoice.index.new')</p>--}}
{{--                                            @elseif($detailInvoice['status'] == 'finish')--}}
{{--                                                <p class="color-red">@lang('product::invoice.index.finish')</p>--}}
{{--                                            @else--}}
{{--                                                <p class="color-brown">@lang('product::invoice.index.finish')</p>--}}
{{--                                            @endif--}}
{{--                                        </option>--}}
                                        <option value="new" {{$detailInvoice['status'] == 'new' ? "selected" :""}}>@lang('product::invoice.index.new')</option>
                                        <option value="finish" {{$detailInvoice['status'] == 'finish' ? "selected" :""}}>@lang('product::invoice.index.finish')</option>
                                        <option value="cancel" {{$detailInvoice['status'] == 'cancel' ? "selected" :""}}>@lang('product::invoice.index.cancel')</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.status_receipt'):
                                </label>
                                <label for="" class="col-md-12 col-form-label">
                                    @if($detailInvoice['receipt_status'] == 'paid')
                                        <p class="color-green nt_size">@lang('product::customer.receipt.paid')</p>
                                    @elseif($detailInvoice['receipt_status'] == 'unpaid')
                                        <p class="color-red nt_size">@lang('product::customer.receipt.unpaid')</p>
                                    @elseif($detailInvoice['receipt_status'] == 'refund')
                                        <p class="color-yellow nt_size">@lang('product::customer.receipt.refund')</p>
                                    @elseif($detailInvoice['receipt_status'] == 'part-paid')
                                        <p class="text-warning nt_size">@lang('product::customer.receipt.part_paid')</p>
                                    @elseif($detailInvoice['receipt_status'] == 'cancel')
                                        <p class="color-brown nt_size">@lang('product::customer.receipt.cancel')</p>
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    </form>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/product/invoice/script.js?v='.time()) }}"></script>
    <script>
        $('#invoice_by').select2();
        $('#status').select2();

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

            $('#invoice_at').datepicker({
                rtl: KTUtil.isRTL(),
                orientation: "bottom left",
                todayHighlight: true,
                templates: arrows,
                minDate: "01/01/1970",
                format: 'dd/mm/yyyy',
                autoclose:  true,
            });
        });
    </script>
@endsection
