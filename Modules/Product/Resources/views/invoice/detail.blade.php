@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">

            <h3 class="kt-subheader__title">
                @lang('product::invoice.index.detail')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">
            </div>

        </div>
        <div class="kt-subheader__toolbar">
            @include('helpers.button', ['button' => [
                'route' => 'product.service.edit',
                 'html' =>  '<a href="'.route('product.invoice.edit', ['id' => $detailInvoice['invoice_no']]).'"  class="btn btn-label-brand btn-bold">'
                 .'<span class="kt-nav__link-text kt-margin-l-5">'.__('product::invoice.input.update').'</span>'.
                '</a>'
            ]])
            <a href="{{route('product.invoice')}}" class="btn btn-secondary btn-bold">
                @lang('product::invoice.input.button_exit')
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
                                    <input class="form-control" disabled value="{{$detailInvoice['invoice_no']}}">
                                </label>
                            </div>
                        </div>



                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.invoice_number'):
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control" disabled value="{{$detailInvoice['invoice_number']}}">
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
                                <label class="col-lg-12 col-form-labe color_black">
                                    Ngày tạo:
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control" disabled value="@if($detailInvoice['created_at'] != null && $detailInvoice['created_at'] != '0000-00-00 00:00:00'){{(new DateTime($detailInvoice['created_at']))->format('d/m/Y')}}@endif">
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.invoice_by'):
                                </label>
                                <label for="" class="col-md-12 col-form-label">
                                    <input class="form-control" disabled value="{{$detailInvoice['full_name']}}">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.invoice_at'):
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control" disabled value="@if($detailInvoice['invoice_at'] != null && $detailInvoice['invoice_at'] != '0000-00-00 00:00:00'){{(new DateTime($detailInvoice['invoice_at']))->format('d/m/Y')}}@endif">
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.net'):
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control" disabled value="{{number_format($detailInvoice['net'],'0')}} VNĐ">
                                </label>
                            </div>
                        </div>



                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.vat'):
                                </label>
                                <label for="" class="col-md-12 col-form-labe">
                                    <input class="form-control" disabled value="{{number_format($detailInvoice['vat'],'0')}} VNĐ">
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    Phần trăm giảm giá
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control" id="reduce_percent" disabled name="reduce_percent" value="{{$detailInvoice['reduce_percent'] ?? 0}}">
                                </label>
                            </div>
                        </div> 


                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.amount'):
                                </label>
                                <label for="" class="col-md-12 col-form-label">
                                    <input class="form-control" disabled value="{{number_format($detailInvoice['amount'],'0')}} VNĐ">
                                </label>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    @lang('product::invoice.index.status'):
                                </label>
                                <label for="" class="col-md-12 col-form-label">
                                    @if($detailInvoice['status'] == 'new')
                                        <p class="color-green nt_size">@lang('product::invoice.index.new')</p>
                                    @elseif($detailInvoice['status'] == 'finish')
                                        <p class="color-red nt_size">@lang('product::invoice.index.finish')</p>
                                    @else
                                        <p class="color-brown nt_size">@lang('product::invoice.index.cancel')</p>
                                    @endif
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
                                @if(count($getOrderDetail) > 0)
                                    @foreach($getOrderDetail as $key => $value)
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
                <div class="row">
                    <div class="col-lg-8">
                            <span class="ss-font-size-1p2rem nt_text_bold">
                                Danh sách phí cộng thêm
                            </span>
                    </div>
                    <div class="col-lg-4">
                        <span class="ss-font-size-1p2rem nt_text_bold">
                        <a href="{{route('product.invoice.extendInsert', ['id' => $detailInvoice['invoice_no']])}}" class="btn btn-label-brand btn-bold float-right"><span class="kt-nav__link-text kt-margin-l-5">Thêm phí</span></a>
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
                                        STT
                                    </th>
                                    <th>
                                        Mã phí cộng thêm
                                    </th>
                                    <th>
                                        Số tiền (VNĐ)
                                    </th>
                                    <th>
                                        Nội dung
                                    </th>
                                    <th>
                                        Ngày thêm
                                    </th>
                                    <th>
                                        Thêm bởi
                                    </th>
                                    <th>
                                        Chức năng
                                    </th>                                    
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($listInvoiceExtends) > 0)
                                    @foreach($listInvoiceExtends as $key => $value)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$value['invoice_extends_code']}}</td>
                                            <td>{{number_format($value['price'], 0)}} VNĐ</td>
                                            <td style="white-space: -o-pre-wrap;
                                            word-wrap: break-word;
                                            white-space: pre-wrap;
                                            white-space: -moz-pre-wrap;
                                            white-space: -pre-wrap;">{{$value['content']}}</td>
                                            <td>{{\Carbon\Carbon::parse($value['created_at'])->format('d-m-Y H:i:s')}}</td>
                                            <td>{{$value['created_by']}}</td>
                                            <td class="text-align-right">
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            @lang('product::invoice.index.action')
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                            @include('helpers.button', ['button' => [
                                                                        'route' => 'product.service.edit',
                                                                            'html' =>  '<a href="' . route("product.invoice.extendEdit", ["invoice_extends_code" =>   $value["invoice_extends_code"]]).'"  class="dropdown-item">'
                                                                            .'<i class="la la-edit"></i>'
                                                                            .'<span class="kt-nav__link-text kt-margin-l-5">Chỉnh sửa</span>'.
                                                                    '</a>'
                                                                ]])
                                                            @include('helpers.button', ['button' => [
                                                                'route' => 'product.receipt.payment-receipt',
                                                                'html' => '<a href="#" onclick="invoice_object.removeExtend(\''.$value['invoice_extends_code'].'\')" class="dropdown-item">'
                                                                .'<i class="la la-trash"></i>'
                                                                .'<span class="kt-nav__link-text kt-margin-l-5">Xóa</span>'.
                                                                '</a>'
                                                                ]])
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
<script>
var invoice_no = '{{$detailInvoice['invoice_no']}}';
var invoice_object = {
    removeExtend : (invoice_extends_code) => {
        Swal.fire({
            title: 'Xóa phí thêm cho hóa đơn',
            text: 'Bạn có xóa mức phí này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff8830',
            cancelButtonColor: '#6c7293',
            confirmButtonText: 'Xóa',
            cancelButtonText : 'Bỏ qua'
          }).then((result) => {
            if (result.value) {
                $.ajax({
            url : laroute.route('invoice.extends.delete'),
            method : 'POST',
            data : {
                invoice_no, invoice_extends_code
            },
            success : e => {
                if(e.error){
                        Swal.fire(
                            'Lỗi',
                            e.message,
                            'error'
                        ).then(()=>{
                            window.location.reload();
                        });
                    }else{
                        Swal.fire(
                            'Thành công',
                            e.message,
                            'success'
                        ).then(()=>{
                            window.location.reload();
                        });

                    }
            }
        })
            }
          })
    }
};
</script>
@endsection