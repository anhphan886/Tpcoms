@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::customer.index.customer_list')
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
                'route' => 'product.product-attribute-group.create',
                'html' => '<a href="'.route('product.customer.create').'" class="btn btn-label-brand btn-bold">'
                .__('product::customer.index.add_customer').
            '</a>'
            ]])
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content " id="kt_content">

        <input type="hidden" id="language" value="{{ App::getLocale()}}">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-filter" action="{{route('product.customer')}}">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="text" id="keyword"
                                   name="keyword"
                                   placeholder="Tên khách hàng"
                                   value="{{$filter['keyword']}}">
                        </div>
                        <div class="form-group row col-lg-6 kt-padding-r-0">
                            <div class="col-lg-6 nt_padding_0 form-group">
                                <input readonly type="text" class="form-control m-input daterange-picker"
                                       id="choose_day" name="choose_day" autocomplete="off"
                                       placeholder="@lang('product::order.index.choose_day')"
                                       onkeyup="order.removeInput(this)" value="{{$filter['choose_day']}}">
                            </div>
                            <div class="col-lg-6 kt-padding-r-0">
                                <select name="customer$status" id="customer$status" class="form-control ss-select-2" style="width: 100%">
                                    <option value="">
                                        @lang('product::customer.index.status')
                                    </option>
                                    <option value="new" {{$filter['customer$status'] == 'new' ? 'selected' : ''}}>
                                        @lang('product::customer.index.new')
                                    </option>
                                    <option value="verified" {{$filter['customer$status'] == 'verified' ? 'selected' : ''}}>
                                        @lang('product::customer.index.verified')
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <select name="customer$province_id" id="customer$province_id" class="form-control ss-select-2 select_province" style="width: 100%" onchange="order.changeProvince(this)">
                                <option value="">
                                    @lang('product::order.index.choose_province')
                                </option>
                                @if(isset($province))
                                    @if(count($province) > 0)
                                        @foreach($province as $key => $value)
                                            <option {{$filter['customer$province_id'] == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>

                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <select name="customer$district_id" id="customer$district_id" class="form-control ss-select-2 district" style="width: 100%">
                                <option value="">
                                    @lang('product::order.index.choose_district')
                                </option>
                                {{--@if(isset($district))--}}
                                    {{--@if(count($district) > 0)--}}
                                        {{--@if($filter['customer$district_id'] != 0 && $filter['customer$district_id'] != '' && $filter['customer$district_id'] != null)--}}
                                            {{--@foreach($district as $key => $value)--}}
                                                {{--<option {{$filter['customer$district_id'] == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>--}}
                                            {{--@endforeach--}}
                                        {{--@endif--}}
                                    {{--@endif--}}
                                {{--@endif--}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <select name="customer$customer_type" id="customer$customer_type" class="form-control ss-select-2" style="width: 100%">
                                <option value="">
                                    @lang('product::customer.index.choose_type')
                                </option>
                                <option value="personal" {{$filter['customer$customer_type'] == 'personal' ? 'selected' : ''}}>
                                    @lang('product::customer.index.personal')
                                </option>
                                <option value="enterprise" {{$filter['customer$customer_type'] == 'enterprise' ? 'selected' : ''}}>
                                    @lang('product::customer.index.enterprise')
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <select name="customer$created_by" id="customer$created_by" class="form-control ss-select-2" style="width: 100%">
                                <option value="">
                                    @lang('product::order.index.choose_create_by')
                                </option>
                                @if(isset($district))
                                    @if(count($district) > 0)
                                        @foreach($createBy as $item)
                                            <option {{$filter['customer$created_by'] == $item['id'] ? 'selected' : ''}} value="{{$item['id']}}">
                                                {{$item['full_name']}}
                                            </option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-align-right">
                            <a class="btn btn-secondary btn-hover-brand"
                               href="{{route('product.customer')}}">
                                @lang('product::attribute-group.index.remove')
                            </a>
                            <button type="submit"
                                    class="btn btn-primary btn-hover-brand">
                                @lang('core::admin-menu.input.BUTTON_SEARCH')
                            </button>
                        </div>
                    </div>
                    <div class="kt-section">
                        @include('product::customer.list')
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="hidden_district_id" value="{{isset($filter['customer$district_id']) ? $filter['customer$district_id'] : 0}}">

@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/product/customer/script.js?v='.time()) }}"></script>
@endsection
