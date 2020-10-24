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
                @lang('product::customer.receipt.list_db')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-padding-0" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-filter" action="#">
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <input class="form-control" type="text" id="keyword_customer_service$customer_service_id"
                                   name="receipt$receipt_no"
                                   placeholder="Mã phiếu thu"
                                   value="{{$filter['receipt$receipt_no']}}">
                        </div>
                        <div class="form-group col-lg-3">
                            {{--                            <div class="col-lg-12 form-group nt_padding_0">--}}
                            {{--                                <input readonly type="text" class="form-control m-input daterange-picker" id="choose_day"--}}
                            {{--                                       name="choose_day" autocomplete="off"--}}
                            {{--                                       placeholder="@lang('product::order.index.choose_day')"--}}
                            {{--                                       value="">--}}
                            {{--                                <div class="input-group-append">--}}
                            {{--                                    <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            <div class="col-lg-12 form-group nt_padding_0">
                                <div class='input-group pull-right' id="">
                                    <input readonly type="text" class="form-control m-input daterange-picker" id="choose_day"
                                           name="out_of_day" autocomplete="off"
                                           placeholder="Ngày hết hạn"
                                           value="{{isset($filter['out_of_day']) ? $filter['out_of_day']  : ''}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-3">
                            <select name="receipt$pay_expired" style="width: 100%"
                                    id="receipt$pay_expired" class="form-control ss-select-2">
                                <option value="">
                                    @lang('product::customer.index.status')
                                </option>
                                <option value="out_of_day" {{$filter['receipt$pay_expired'] == 'out_of_day' ? 'selected' : ''}}>
                                    @lang('product::customer.receipt.out_of_date')
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <select name="customer$customer_id" style="width: 100%"
                                    id="customer" class="form-control ss-select-2">
                                <option value="">
                                    @lang('product::customer.receipt.choose_customer')
                                </option>
                                @if(isset($optionCustomer))
                                    @foreach($optionCustomer as $key => $value)
                                        <option value="{{$value['customer_id']}}"
                                            {{isset($filter['customer$customer_id']) &&
                                            $filter['customer$customer_id']== $value['customer_id'] ?  "selected" : ""}}>
                                            {{$value['customer_name']}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-lg-3 text-align-right-mobile">
                            <a class="btn btn-secondary btn-hover-brand" href="{{route('product.debt-receipt')}}">
                                @lang('product::attribute-group.index.remove')
                            </a>
                            <button type="submit"
                                    class="btn btn-primary btn-hover-brand">
                                @lang('core::admin-menu.input.BUTTON_SEARCH')
                            </button>
                        </div>

                    </div>
                    <div class="kt-section">
                        @include('product::debt-receipt.list')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/product/receipt/script.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('static/backend/js/product/receipt/debt-receipt.js?v='.time()) }}"></script>
    <script>
        // $(document).ready(function () {
        //     var start = moment().subtract(29, 'days');
        //     var end = moment();
        //
        //     $('#kt_daterangepicker_6').daterangepicker({
        //         format: 'mm/dd/yyyy',
        //         buttonClasses: ' btn',
        //         applyClass: 'btn-primary',
        //         cancelClass: 'btn-secondary',
        //
        //
        //         startDate: start,
        //         endDate: end,
        //         ranges: {
        //             'Hôm nay': [moment(), moment()],
        //             'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //             '7 ngày trước': [moment().subtract(6, 'days'), moment()],
        //             '30 ngày trước': [moment().subtract(29, 'days'), moment()],
        //             'Trong tháng': [moment().startOf('month'), moment().endOf('month')],
        //             'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        //         }
        //     }, function(start, end, label) {
        //         $('#kt_daterangepicker_6 .form-control').val( start.format('DD/MM/YYYY') + ' -- ' + end.format('DD/MM/YYYY'));
        //     });
        // })
    </script>
@endsection
