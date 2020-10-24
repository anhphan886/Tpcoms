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
                @lang('product::customer.receipt.db_detail')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            @if($receipt['status'] == 'paid' && $receipt['status'] == 'cancel')
                <a class="btn btn-info btn-bold" href="{{route('product.receipt.payment-receipt',$receipt['receipt_no'])}}">
                    @lang('product::customer.receipt.receipt_action')
                </a>
            @endif
            <a href="{{route('product.debt-receipt')}}" class="btn btn-secondary btn-bold">
                @lang('product::product.create.cancel')
            </a>
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form>
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
                                    @lang('product::customer.receipt.day_receipt')
                                </label>
                                <input disabled class="form-control" type="text" name="receipt_amount"

                                       value="{{(new DateTime($receipt['created_at']))->format('d/m/Y H:i:s')}}">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.receipt.pay_expired')
                                </label>
                                <input disabled class="form-control" type="text" name="receipt_amount"

                                       value="{{(new DateTime($receipt['pay_expired']))->format('d/m/Y')}}">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.receipt.receipt_content')
                                </label>
                                <textarea disabled class="form-control" rows="6" name="description"
                                          id="description">{{$receipt['receipt_content']}}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.receipt.customer')
                                </label>
                                <input disabled class="form-control" type="text" name="receipt_no"
                                       id="receipt_no" value="{{$order['customer_no'] . ' - ' . $order['customer_name']}}">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::customer.receipt.order_code')
                                </label>
                                <input disabled class="form-control" type="text" name="receipt_no"
                                       id="receipt_no" value="{{$order['order_code']}}">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label text-align-right">
                                    @lang('product::customer.receipt.amount')
                                </label>
                                <input disabled class="form-control" type="text" name="receipt_amount"
                                        value="{{number_format($receipt['amount'] + $receipt['vat'], 0)}} VNĐ">
                            </div>
                            <div class="form-group kt-margin-t-40 kt-margin-b-45">
                                <label class="">
                                    @lang('product::customer.receipt.status')
                                </label>
                                <div class="">
                                    @php $color = 'kt-badge--success'; $status = '' @endphp
                                    @if($receipt['status'] == 'paid')
                                        <span class="kt-badge kt-badge--inline kt-badge--success
                                                ss--radius-10 kt-padding-1 ss-font-size-1p1rem ss--white">
                                                @lang('product::customer.receipt.paid')
                                            </span>
                                    @elseif($receipt['status'] == 'unpaid')
                                        <span class="kt-badge kt-badge--inline kt-badge--danger
                                                ss--radius-10 kt-padding-1 ss-font-size-1p1rem ss--white">
                                                @lang('product::customer.receipt.unpaid')
                                            </span>
                                    @elseif($receipt['status'] == 'refund')
                                        <span class="kt-badge kt-badge--inline kt-badge--dark
                                                ss--radius-10 kt-padding-1 ss-font-size-1p1rem ss--white">
                                                @lang('product::customer.receipt.refund')
                                            </span>
                                    @elseif($receipt['status'] == 'part-paid')
                                        <span class="kt-badge kt-badge--inline kt-badge--warning
                                                ss--radius-10 kt-padding-1 ss-font-size-1p1rem ss--white">
                                                @lang('product::customer.receipt.part_paid')
                                            </span>
                                    @elseif($receipt['status'] == 'cancel')
                                        <span class="kt-badge kt-badge--inline kt-badge--dark
                                                ss--radius-10 kt-padding-1 ss-font-size-1p1rem ss--white">
                                                @lang('product::customer.receipt.cancel')
                                            </span>
                                    @endif

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::customer.detail.created_by')
                                        </label>
                                        <input class="form-control" disabled type="text" name="product_name_en"
                                               value="{{$receipt['create_full_name']}}" id="product_name_en">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::customer.detail.created_at')
                                        </label>
                                        <input class="form-control" disabled type="text" name="product_name_en"
                                               value="{{(new DateTime($receipt['created_at']))->format('d/m/Y H:i:s')}}"
                                               id="product_name_en">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::customer.detail.updated_by')
                                        </label>
                                        <input class="form-control" disabled type="text" name="product_name_en"
                                               value="{{$receipt['update_full_name']}}" id="product_name_en">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-form-label">
                                            @lang('product::customer.detail.updated_at')
                                        </label>
                                        <input class="form-control" disabled type="text" name="product_name_en"
                                               value="{{(new DateTime($receipt['modified_at']))->format('d/m/Y H:i:s')}}"
                                               id="product_name_en">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <span class="ss-font-size-1p2rem nt_text_bold">
                                @lang('product::customer.receipt.receipt_detail_list')
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table_responsive">
                                <table class="table table-striped" id="tb-list-attribute">
                                    <thead>
                                    <tr>
                                        <th>
                                            @lang('product::customer.receipt.stt')
                                        </th>
                                        <th>
                                            @lang('product::customer.receipt.product_code')
                                        </th>
                                        <th>
                                            @lang('product::customer.receipt.service')
                                        </th>
                                        <th class="text-align-right">
                                            @lang('product::customer.receipt.receipt_money')
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($getCustomerService) > 0)
                                        @foreach($getCustomerService as $key => $value)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$value['product_code']}}</td>
                                                <td>{{$value[getValueByLang('product_name_')]}}</td>
                                                <td class="text-align-right">{{number_format($value['amount'], 0)}} VNĐ</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-8">
                            <span class="ss-font-size-1p2rem nt_text_bold">
                                @lang('product::customer.receipt.receipt_history')
                            </span>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table_responsive">
                                    <table class="table table-striped" id="tb-list-attribute">
                                        <thead>
                                        <tr>
                                            <th>
                                                @lang('product::customer.receipt.stt')
                                            </th>
                                            <th>
                                                @lang('product::customer.receipt.receipt_detail_created_at')
                                            </th>
                                            <th>
                                                @lang('product::customer.receipt.receipt_detail_created_by')
                                            </th>
                                            <th>
                                                @lang('product::customer.receipt.payer')
                                            </th>
                                            <th >
                                                @lang('product::customer.receipt.form_payment')
                                            </th>
                                            <th class="text-align-right">
                                                @lang('product::customer.receipt.money')
                                            </th>
                                            <th>
                                                @lang('product::customer.receipt.note')
                                            </th>
                                            <th>
                                                @lang('product::customer.receipt.document')
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($receiptDetail as $key => $item)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$item['receipt_date']}}</td>
                                                <td>{{$item['full_name']}}</td>
                                                <td>{{$item['payer']}}</td>
                                                <td>
                                                    @if($item['payment_type'] == 'cash')
                                                        @lang('product::customer.receipt.cash')
                                                    @elseif($item['payment_type'] == 'visa')
                                                        @lang('product::customer.receipt.visa')
                                                    @elseif($item['payment_type'] == 'tranfer')
                                                        @lang('product::customer.receipt.transfer')
                                                    @endif
                                                </td>
                                                <td class="text-align-right">{{number_format($item['amount'], 0)}} VNĐ</td>
                                                <td>{{$item['note']}}</td>
                                                <td>
                                                    <a href="{{asset($item['link_file'])}}" target="_blank">
                                                        {{substr($item['link_file'], -19)}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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

@endsection
