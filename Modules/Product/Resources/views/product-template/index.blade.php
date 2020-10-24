@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::product-template.index.product_list')
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
                'route' => 'product.product-template.create',
                'html' => '<a href="'.route('product.product-template.create').'" class="btn btn-label-brand btn-bold">'
                .__('product::product-template.index.btn_add').
            '</a>'
            ]])
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-filter" action="{{route('product.product-template')}}">
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <input class="form-control" type="text" id="keyword"
                                   name="keyword"
                                   placeholder="@lang('product::product-template.index.search')"
                                   value="{{$filter['keyword']}}">
                        </div>
                        <div class="form-group col-lg-3">
                            <select name="product$parent_id"
                                    id="product$parent_id"
                                    class="form-control ss-select-2" style="width: 100%">
                                <option value="">
                                    @lang('product::product-template.index.choose_product_category')
                                </option>
                                @foreach($product as $item)
                                    <option value="{{$item['product_id']}}"
                                    {{$filter['product$parent_id'] == $item['product_id'] ? 'selected' : ''}}>
                                        {{$item[getValueByLang('product_name_')]}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            @php
                                $status = 10;
                            @endphp
                            @if($filter['product$is_actived'] == '')
                                @php
                                    $status = 10;
                                @endphp
                            @elseif($filter['product$is_actived'] == 1)
                                @php
                                    $status = 1;
                                @endphp
                            @elseif($filter['product$is_actived'] == 0)
                                @php
                                    $status = 0;
                                @endphp
                            @endif

                            <select name="product$is_actived"
                                    id="product$is_actived"
                                    class="form-control ss-select-2" style="width: 100%">
                                <option value="">
                                    @lang('product::product-template.index.status')
                                </option>
                                <option value="1" {{$status == 1 ? 'selected' : ''}}>
                                    @lang('product::product-template.index.is_active')
                                </option>
                                <option value="0" {{$status == 0 ? 'selected' : ''}}>
                                    @lang('product::product-template.index.inactive')
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-lg-3 text-align-right-mobile">
                            <a class="btn btn-secondary btn-hover-brand" href="{{route('product.product-template')}}">
                                @lang('product::product-template.index.remove')
                            </a>
                            <button type="submit"
                                    class="btn btn-primary btn-hover-brand">
                                @lang('product::product-template.index.search')
                            </button>
                        </div>
                    </div>
                    <div class="kt-section">
                        @include('product::product-template.list')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/product-template/script.js?v='.time()) }}"></script>
    <script>

    </script>
@endsection
