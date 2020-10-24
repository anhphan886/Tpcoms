@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">

            <h3 class="kt-subheader__title">
            {{$is_edit ? 'Cập nhật' : 'Thêm'}} phí cộng thêm {{$invoice_no}}
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
                 'html' =>  '<a href="#"  class="btn btn-label-brand btn-bold" onclick="invoice_extends.update_invoice_extends()">'
                 .'<span class="kt-nav__link-text kt-margin-l-5">' . ($is_edit? 'Cập nhật' : 'Tạo mới').'</span>'.
                '</a>'
            ]])
            <a href="{{route('product.invoice.show', ['id' => $invoice_no])}}" class="btn btn-secondary btn-bold">
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
                                    Hóa đơn
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <input class="form-control" disabled value="{{$invoice_no}}">
                                </label>
                            </div>
                        </div>
                        @if($is_edit)
                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    Mã phí tăng thêm
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" disabled value="{{isset($invoiceExtend) ? $invoiceExtend['invoice_extends_code'] : '' }}">
                                </label>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="form-group col-lg-10" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    Giá tăng thêm
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                <input class="form-control" id="price" value="{{isset($invoiceExtend) ? $invoiceExtend['price'] : ''}}">
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12" style="margin-bottom: 0;">
                                <label class="col-lg-12 col-form-labe color_black">
                                    Nội dung
                                </label>
                                <label for="" class="col-md-12 col-form-label ">
                                    <textarea class="form-control" id="content">{{isset($invoiceExtend) ? $invoiceExtend['content'] : ''}}</textarea>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('after_script')
<script>
    $('#price').mask('000,000,000,000', {reverse: true});
    var is_edit = {{$is_edit}};
    var invoice_no = '{{$invoice_no}}';
    var invoice_extends_code = '{{isset($invoiceExtend) ? $invoiceExtend['invoice_extends_code'] : ''}}';

    var invoice_extends = {
        update_invoice_extends : () => {
            let price = Number($('#price').val().split(',').join(''));
            if(isNaN(price)){
                Swal.fire('Định dạng sai', 'Định dạng tiền của bạn không đúng', 'error');return;
            }
            let content = $('#content').val();
            if(is_edit){
                $.ajax({
                method : "POST", 
                url : laroute.route('invoice.extends.edit'),
                data : {
                    price, content, invoice_extends_code
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
                            window.location.href = '{{route('product.invoice.show', ['id' => $invoice_no])}}';
                        });

                    }
                    // response
                }
            })
                return;
            }
            $.ajax({
                method : "POST", 
                url : laroute.route('invoice.extends.insert'),
                data : {
                    price, content, invoice_no
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
                            window.location.href = '{{route('product.invoice.show', ['id' => $invoice_no])}}';
                        });

                    }
                    // response
                }
            })
        },
    }
    </script>    
@endsection