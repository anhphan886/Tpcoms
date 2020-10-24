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
                @lang('product::customer.service.invoice')
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
                        <div class="form-group col-lg-4">
                            <input class="form-control" type="text" id="invoice$invoice_no"
                                   name="invoice$invoice_no"
                                   placeholder="@lang('product::attribute-group.index.search')"
                            value="{{isset($filter['invoice$invoice_no']) ? $filter['invoice$invoice_no'] : ''}}">
                        </div>
                        <div class="form-group col-lg-3 ">
                            <select name="invoice$status" id="invoice$status" class="form-control ss-select-2" style="width: 100%">
                                <option value="">
                                    @lang('product::invoice.index.status')
                                </option>
                                <option value="new" {{$filter['invoice$status'] == 'new' ? 'selected' : ''}}>
                                    @lang('product::customer.service.new')
                                </option>
                                <option value="finish" {{$filter['invoice$status'] == 'finish' ? 'selected' : ''}}>
                                    @lang('product::customer.service.finish')
                                </option>
                                <option value="cancel" {{$filter['invoice$status'] == 'cancel' ? 'selected' : ''}}>
                                    @lang('product::customer.service.cancel')
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 text-align-right-mobile">
                            <a class="btn btn-secondary btn-hover-brand" href="{{route('product.invoice')}}">
                                @lang('product::attribute-group.index.remove')
                            </a>
                            <button type="submit"
                                    class="btn btn-primary btn-hover-brand">
                                @lang('core::admin-menu.input.BUTTON_SEARCH')
                            </button>
                        </div>
                    </div>
                    <div class="kt-section">
                        @include('product::invoice.list')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script>
        $('.ss-select-2').select2();
    </script>
    <script>

    </script>
@endsection
