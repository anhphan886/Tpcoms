@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <style>
        .image-big {
            width: 250px !important;
            height: 250px !important;
        }
    </style>
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::customer.receipt.payment_receipt')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <button type="button" class="btn btn-info btn-bold" onclick="receipt.saveDBreceipt()">
                @lang('product::customer.receipt.receipt_action')
            </button>
            <a href="{{route('product.debt-receipt')}}" class="btn btn-secondary btn-bold">
                @lang('product::product.create.cancel')
            </a>
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-submit">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.receipt.receipt_no')
                                </label>
                                <input disabled class="form-control" type="text" name="receipt_no"
                                       id="receipt_no" value="{{$receipt['receipt_no']}}">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.receipt.amount')
                                </label>
                                <input disabled class="form-control" type="text" name="receipt_amount"
                                       id="receipt_amount" value="{{number_format($receipt['amount'] + $receipt['vat'], 0)}} VNĐ">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.receipt.remaining_money')
                                </label>
                                <input disabled class="form-control" type="text" name="remaining_money"
                                       id="remaining_money" value="{{number_format($amountReceipt, 0)}} VNĐ">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="receipt_by">
                                    @lang('product::customer.receipt.staff')
                                </label>
                                <div class="input-group">
                                    <select class="form-control kt-select2 ss-select-2" name="receipt_by"
                                            id="receipt_by" style="width: 100%">
                                        <option value="">
                                            @lang('product::customer.receipt.choose_staff')
                                        </option>
                                        @if(isset($staffOption))
                                            @if(count($staffOption) > 0)
                                                @foreach($staffOption as $item)
                                                    <option value="{{$item['id']}}">
                                                        {{$item['full_name']}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>
                                </div>
                                <div class="form-text"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.receipt.payer')
                                </label>
                                <input class="form-control" type="text" name="payer"
                                       id="payer">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="payment_type">
                                    @lang('product::customer.receipt.form_payment')
                                </label>
                                <select class="form-control kt-select2" name="payment_type"
                                        id="payment_type" style="width: 100%">
                                    <option value="cash">
                                        @lang('product::customer.receipt.cash')
                                    </option>
                                    <option value="tranfer">
                                        @lang('product::customer.receipt.transfer')
                                    </option>
                                    <option value="visa">
                                        @lang('product::customer.receipt.visa')
                                    </option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.receipt.money')
                                </label>
                                <input class="form-control" type="text" name="amount"
                                       id="amount" value="{{number_format($amountReceipt, 0)}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.receipt.note')
                                </label>
                                <textarea class="form-control" rows="7" name="description" id="description"></textarea>
                            </div>
                            <div class="form-group">
                                <p class="kt-margin-b-5">
                                    @lang('product::customer.receipt.document')
                                </p>

                                <div class="kt-avatar kt-avatar--outline image-big kt-margin-b-10 "
                                     id="kt_user_add_avatar">
                                    <div id="div-image">
                                        <div class="kt-avatar__holder image-big"
                                             style="
                                                     background-image: url({{asset('static/backend/images/default-placeholder.png')}})"></div>
                                    </div>
                                </div>
                                <input style="display: none;" type="file" id="getFileImage"
                                       class="custom-file-input"
                                       name="getFileImage" accept="image/jpeg,image/png,image/jpeg,jpg|png|jpeg"
                                       onchange="receipt.uploadAvatar(this);">
                                <br>
                                <label class="btn btn-primary label_getFileImage" for="getFileImage"
                                       style="width:250px; cursor: pointer;">
                                    @lang('product::product.create.choose_file')
                                </label>
                                <input type="hidden" id="image-avatar" name="image_avatar" value="">
                                <input type="hidden" id="receipt_id" name="receipt_id" value="{{$receipt['receipt_id']}}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="language" value="{{\Illuminate\Support\Facades\App::getLocale()}}">
@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/receipt/script.js?v='.time()) }}"></script>
    <script type="text/template" id="image-tpl">
        <div class="kt-avatar__holder image-big"
             style="background-image: url({link})"></div>
    </script>
@endsection

