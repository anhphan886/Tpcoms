@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::attribute.index.attribute_list')
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
                'route' => 'product.product-attribute.create',
                'html' => '<a href="'.route('product.product-attribute.create').'" class="btn btn-label-brand btn-bold">'
                .__('product::attribute.index.btn_add_attribute').
            '</a>'
            ]])
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-filter" action="{{route('product.product-attribute')}}">
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <input class="form-control" type="text" id="keyword"
                                   name="keyword"
                                   placeholder="@lang('product::attribute.index.search')"
                                   value="{{$filter['keyword']}}">
                        </div>
                        <div class="form-group col-lg-3">
                            <select name="product_attribute$product_attribute_group_id"
                                    id="product_attribute$product_attribute_group_id"
                                    class="form-control ss-select-2" style="width: 100%">
                                <option value="">
                                    @lang('product::attribute.index.choose_category')
                                </option>
                                @foreach($attributeGroup as $item)
                                    <option value="{{$item['product_attribute_group_id']}}"
                                        {{$filter['product_attribute$product_attribute_group_id'] == $item['product_attribute_group_id'] ? 'selected'  : '' }}>
                                        {{$item[getValueByLang('product_attribute_group_name_')]}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <select name="product_attribute$is_actived"
                                    id="product_attribute$is_actived"
                                    class="form-control ss-select-2" style="width: 100%">
                                <option value="" {{$filter['product_attribute$is_actived'] == null ? 'selected': '' }}>
                                    @lang('product::attribute.index.status')
                                </option>
                                <option value="1" {{$filter['product_attribute$is_actived'] == 1 ? 'selected' : ''}}>
                                    @lang('product::attribute.index.is_active')
                                </option>
                                <option value="0" {{$filter['product_attribute$is_actived'] == 0 ? 'selected' : ''}}>
                                    @lang('product::attribute.index.inactive')
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-lg-3">
                            <a class="btn btn-secondary btn-hover-brand" href="{{route('product.product-attribute')}}">
                                @lang('product::attribute.index.remove')
                            </a>
                            <button type="submit"
                                    class="btn btn-primary btn-hover-brand">
                                @lang('core::admin-menu.input.BUTTON_SEARCH')
                            </button>
                        </div>
                    </div>
                    <div class="kt-section">
                        @include('product::product-attribute.list')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/attribute/script.js?v='.time()) }}"></script>
    <script>

    </script>
@endsection
