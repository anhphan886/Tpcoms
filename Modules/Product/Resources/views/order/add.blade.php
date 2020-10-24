@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::attribute-group.index.btn_add_attribute')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <button type="button" class="btn btn-info btn-bold" onclick="attributeGroup.save(1)">
                @lang('product::attribute.create.save')
            </button>
            <a href="{{route('product.product-attribute')}}" class="btn btn-secondary btn-bold">
                @lang('product::attribute.create.cancel')
            </a>
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-submit">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::attribute-group.create.attribute_name_vi')
                                </label>
                                <input class="form-control" type="text" name="product_attribute_group_name_vi"
                                       id="product_attribute_group_name_vi">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::attribute-group.create.attribute_name_en')
                                </label>
                                <input class="form-control" type="text" name="product_attribute_group_name_en"
                                       id="product_attribute_group_name_en">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/product/attribute-group/script.js?v='.time()) }}"></script>
@endsection
