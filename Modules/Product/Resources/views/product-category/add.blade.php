@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::product-category.index.btn_add_product_category')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <button type="button" class="btn btn-info btn-bold" onclick="productCategory.save(1)">
                @lang('product::product-category.create.save')
            </button>
            <a href="{{route('product.product-category')}}" class="btn btn-secondary btn-bold">
                @lang('product::product-category.create.cancel')
            </a>
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-submit">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::product-category.create.category_name_vi')
                                </label>
                                <input class="form-control" type="text" name="category_name_vi"
                                       id="category_name_vi">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::product-category.create.category_name_en')
                                </label>
                                <input class="form-control" type="text" name="category_name_en"
                                       id="category_name_en">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/product/product-category/script.js?v='.time()) }}"></script>
@endsection
