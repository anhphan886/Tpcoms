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
                @lang('product::customer.receipt.receipt')
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
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-filter" action="#">
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <input class="form-control" type="text" id="keyword_receipt$receipt_no"
                                   name="receipt$receipt_no"
                                   placeholder="@lang('product::attribute-group.index.search')"
                                   value="{{isset($filter['receipt$receipt_no']) ? $filter['receipt$receipt_no'] : ''}}">
                        </div>
                        <div class="form-group col-lg-3">
                            <div class="col-lg-12 form-group nt_padding_0">
                                <div class='input-group pull-right' id="">
                                    <input readonly type="text" class="form-control m-input daterange-picker" id="choose_day"
                                           name="choose_day" autocomplete="off"
                                           placeholder="@lang('product::customer.receipt.choose_day')"
                                           value="{{isset($filter['choose_day']) ? $filter['choose_day']  : ''}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-3">
                            <select name="receipt$status" style="width: 100%"
                                    id="receipt$status" class="form-control ss-select-2">
                                <option value="">
                                    @lang('product::customer.index.status')
                                </option>
                                <option value="paid" {{$filter['receipt$status'] == 'paid' ? 'selected' : ''}}>
                                    @lang('product::customer.receipt.paid')
                                </option>
                                <option value="unpaid" {{$filter['receipt$status'] == 'unpaid' ? 'selected' : ''}}>
                                    @lang('product::customer.receipt.unpaid')
                                </option>
                                <option value="part-paid" {{$filter['receipt$status'] == 'part-paid' ? 'selected' : ''}}>
                                    @lang('product::customer.receipt.part_paid')
                                </option>
                                <option value="refund" {{$filter['receipt$status'] == 'refund' ? 'selected' : ''}}>
                                    @lang('product::customer.receipt.refund')
                                </option>
                                <option value="cancel" {{$filter['receipt$status'] == 'cancel' ? 'selected' : ''}}>
                                    @lang('product::customer.receipt.cancel')
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
                                        <option value="{{$value['customer_id']}}" {{isset($filter['customer$customer_id'])
                                            &&  $filter['customer$customer_id'] == $value['customer_id'] ? 'selected' : ''}}>
                                            {{$value['customer_name']}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-lg-3 text-align-right-mobile">
                            <a class="btn btn-secondary btn-hover-brand" href="{{route('product.receipt')}}">
                                @lang('product::attribute-group.index.remove')
                            </a>
                            <button type="submit"
                                    class="btn btn-primary btn-hover-brand">
                                @lang('core::admin-menu.input.BUTTON_SEARCH')
                            </button>
                        </div>
                    </div>
                    <div class="kt-section">
                        @include('product::receipt.list')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/product/receipt/script.js?v='.time()) }}"></script>
    <script>
        $("#choose_day").daterangepicker({
            autoUpdateInput: false,
            autoApply: true,
            showCustomRangeLabel: true,
            buttonClasses: "m-btn btn",
            applyClass: "btn-primary",
            cancelClass: "btn-danger",
            // maxDate: moment().endOf("day"),
            startDate: moment().startOf("day"),
            endDate: moment().add(1, 'days'),
            locale: {
                customRangeLabel: "Tùy chọn ngày",
                format: 'DD/MM/YYYY',
                "applyLabel": "Đồng ý",
                "cancelLabel": "Thoát",
                daysOfWeek: [
                    "CN",
                    "T2",
                    "T3",
                    "T4",
                    "T5",
                    "T6",
                    "T7"
                ],
                "monthNames": [
                    "Tháng 1 năm",
                    "Tháng 2 năm",
                    "Tháng 3 năm",
                    "Tháng 4 năm",
                    "Tháng 5 năm",
                    "Tháng 6 năm",
                    "Tháng 7 năm",
                    "Tháng 8 năm",
                    "Tháng 9 năm",
                    "Tháng 10 năm",
                    "Tháng 11 năm",
                    "Tháng 12 năm"
                ],
                "firstDay": 1
            },
            ranges: {
                'Hết hạn hôm nay': [moment(), moment()],
                // 'Hôm qua': [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Hết hạn 7 ngày tiếp theo": [ moment(), moment().add(6, 'days'), ],
                "Hết hạn 15 ngày tiếp theo": [ moment(), moment().add(14, 'days')],
                // "Hết hạn trong tháng": [moment().startOf("month"), moment().endOf("month")],
                // "Hết hạn tháng trước": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            }
        }, function (start, end, label) {

        }).on('apply.daterangepicker', function(ev, picker) {
            $('#choose_day').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            $('#time').val('1').trigger('change');
        });
    </script>
@endsection
