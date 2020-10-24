@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::product.index.product_list')
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
                'route' => 'product.product.create',
                'html' => '<a href="'.route('product.product.create').'" class="btn btn-label-brand btn-bold">'
                .__('product::product.index.btn_add').
            '</a>'
            ]])
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-filter" action="{{route('product.product')}}">
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <input class="form-control" type="text" id="keyword"
                                   name="keyword"
                                   placeholder="@lang('product::product.index.search')"
                                   value="{{$filter['keyword']}}">
                        </div>
                        <div class="form-group col-lg-3">
                            <select name="product$product_category_id"
                                    id="product$product_category_id"
                                    class="form-control ss-select-2" style="width: 100%">
                                <option value="">
                                    @lang('product::product.index.choose_product_category')
                                </option>
                                @foreach($productGroup as $item)
                                    <option value="{{$item['product_category_id']}}"
                                    {{$filter['product$product_category_id'] == $item['product_category_id'] ? 'selected' : ''}}>
                                        {{$item[getValueByLang('category_name_')]}}
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
                                <option value="" {{$status == 10 ? 'selected' : ''}}>
                                    @lang('product::product.index.status')
                                </option>
                                <option value="1" {{$status == 1 ? 'selected' : ''}}>
                                    @lang('product::product.index.is_active')
                                </option>
                                <option value="0" {{$status == 0 ? 'selected' : ''}}>
                                    @lang('product::product.index.inactive')
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-lg-3 text-align-right-mobile">
                            <a class="btn btn-secondary btn-hover-brand" href="{{route('product.product')}}">
                                @lang('product::product.index.remove')
                            </a>
                            <button type="submit"
                                    class="btn btn-primary btn-hover-brand">
                                @lang('product::product.index.search')
                            </button>
                        </div>
                    </div>
                    <div class="kt-section">
                       <div class="row">
                           <div class="col-12">
                               @include('product::product.list')
                           </div>
                       </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/product/script.js?v='.time()) }}">
        $('#attribute_group_option').select2();
    </script>
@endsection
