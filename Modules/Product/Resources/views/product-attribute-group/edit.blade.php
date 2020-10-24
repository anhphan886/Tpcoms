@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::attribute-group.index.edit_attribute_group')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <button type="button" class="btn btn-info btn-bold" onclick="attributeGroup.edit()">
                @lang('product::attribute.create.save')
            </button>
            <a href="{{route('product.product-attribute-group')}}" class="btn btn-secondary btn-bold">
                @lang('product::attribute.create.cancel')
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
                                    @lang('product::attribute-group.create.attribute_name_vi')
                                </label>
                                <input class="form-control" type="text" value="{{$detail['product_attribute_group_name_vi']}}"
                                       name="product_attribute_group_name_vi"
                                       id="product_attribute_group_name_vi">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::attribute-group.create.attribute_name_en')
                                </label>
                                <input class="form-control" type="text" value="{{$detail['product_attribute_group_name_en']}}"
                                       name="product_attribute_group_name_en"
                                       id="product_attribute_group_name_en">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::attribute-group.create.positions')                                </label>
                                <input class="form-control col-lg-3" type="text" name="positions"
                                       id="positions" value="{{$detail['positions']}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-lg-6">
                                <div class="">
                                    <label class="col-form-label">
                                        @lang('product::attribute-group.create.sold_together')
                                    </label>
                                </div>
                                <div class="">
                                <span class="kt-switch kt-switch--success">
                                    <label>
                                        <input onchange="attributeGroup.showSoldTogether(this)"
                                               type="checkbox"
                                               name="is_sold_together"
                                               id="is_sold_together"
                                                {{$detail['is_sold_together'] == 1 ? 'checked' : ''}}
                                        />
                                        <span></span>
                                    </label>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row quantity_attribute" style="{{$detail['is_sold_together'] == 1 ? '' : 'display: none'}}">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::attribute-group.create.quantity')
                                </label>
                                <select class="form-control"
                                        name="quantity_attribute"
                                        id="quantity_attribute"
                                >
                                    <option value="0" {{$detail['quantity_attribute'] == '0' ? 'selected' : ''}}>
                                        @lang('product::attribute-group.create.much_attribute')
                                    </option>
                                    <option value="1" {{$detail['quantity_attribute'] == '1' ? 'selected' : ''}}>
                                        @lang('product::attribute-group.create.one_attribute')
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <input class="form-control" type="hidden" value="{{$detail['product_attribute_group_id']}}"
                           name="product_attribute_group_id"
                           id="product_attribute_group_id">
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/product/attribute-group/script.js?v='.time()) }}"></script>
@endsection
