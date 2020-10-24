@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <form id="form-submit">
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('product::product-template.create.add_product')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <button type="button" class="btn btn-info btn-bold" onclick="productAdd.save(1)">
                    @lang('product::product-template.create.save')
                </button>
                <a href="{{route('product.product-template')}}" class="btn btn-secondary btn-bold">
                    @lang('product::product-template.create.cancel')
                </a>
            </div>
        </div>
        <!--begin: Datatable -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="col-form-label" for="product_category_id">
                                    @lang('product::product-template.create.product')
                                </label>
                                <select class="form-control kt-select2" name="parent_id"
                                        id="parent_id" style="width: 100%">
                                    <option value="">
                                        @lang('product::product-template.create.choose_product')
                                    </option>
                                    @foreach($product as $item)
                                        <option value="{{$item['product_id']}}">
                                            {{$item[getValueByLang('product_name_')]}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::product-template.create.name_vi')
                                </label>
                                <input class="form-control" type="text" name="product_name_vi"
                                       id="product_name_vi">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::product-template.create.name_en')
                                </label>
                                <input class="form-control" type="text" name="product_name_en"
                                       id="product_name_en">
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="col-form-label">
                                        @lang('product::product.create.status')
                                    </label>
                                </div>
                                <div class="col-lg-6">
                                    <span class="kt-switch kt-switch--success float-right">
                                    <label>
                                        <input type="checkbox" name="is_active" id="is_active" checked>
                                        <span></span>
                                    </label>
                                </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="col-form-label">
                                        @lang('product::product.create.is_feature')
                                    </label>
                                </div>
                                <div class="col-lg-6">
                                    <span class="kt-switch kt-switch--success float-right">
                                    <label>
                                        <input type="checkbox" name="is_feature" id="is_feature">
                                        <span></span>
                                    </label>
                                </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-6 col-form-label">
                                    @lang('product::product-template.create.price_by_attribute')
                                </label>
                                <div class="col-6">
                                    <span class="kt-switch kt-switch--info ss-float-right">
                                        <label>
                                            <input type="checkbox" onchange="productAdd.priceByAttribute(this)"
                                                   name="price_by_attribute" id="price_by_attribute">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::product-template.create.price_month')
                                </label>
                                <input class="form-control" type="text" name="price_month"
                                       id="price_month">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::product-template.create.price_day')
                                </label>
                                <input class="form-control" type="text" name="price_day"
                                       id="price_day">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::product-template.create.description')
                                </label>
                                <textarea class="form-control" rows="10" name="description" id="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-12 magin10">
                            <span class="ss-font-size-1p2rem nt_text_bold ">
                              @lang('product::product-template.create.list_product_attribute')
                            </span>
                        </div>
                        <div class="col-lg-5">
                            <div class="row">
                                <div class="col-6">
                                    <button onclick="productAdd.getAttributeByParent()" type="button"
                                            class="btn btn-brand ss-float-right" style="color: #ffffff">
                                        <i class="fa flaticon2-refresh"></i>
                                        @lang('product::product-template.create.get_by_parent')
                                    </button>
                                </div>

                                <div class="col-6">
                                    <button onclick="productAdd.addAttribute()" type="button"
                                            class="btn btn-warning ss-float-right btn-info btn-bold" style="color: #ffffff">
                                        <i class="fa flaticon2-plus"></i>
                                        @lang('product::product-template.create.add_attribute')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped" id="tb-list-attribute">
                            <thead>
                            <tr>
                                <th>
                                    @lang('product::product-template.create.stt')
                                </th>
                                <th>
                                    @lang('product::product-template.create.attribute_code')
                                </th>
                                <th>
                                    @lang('product::product-template.create.attribute')
                                </th>
                                <th>
                                    @lang('product::product-template.create.unit')
                                </th>
                                <th>
                                    @lang('product::product-template.create.value')
                                </th>
                                <th>
                                    @lang('product::product-template.create.no_limit')
                                </th>
                                <th>
                                     <span>
                                        @lang('product::product-template.create.choose')
                                    </span>
                                    <label class="kt-checkbox">
                                        <input type="checkbox" checked onclick="productAdd.chooseAllAttribute(this)">
                                        <span></span>
                                    </label>
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <input type="hidden" id="language" value="{{\Illuminate\Support\Facades\App::getLocale()}}">

    @include('product::product-template.modal.modal-add-attribute')
@endsection
@section('after_script')
    <script src="{{asset('static/backend/js/general/numeric.js?v='.time())}}"
            type="text/javascript"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/product-template/add-script.js?v='.time()) }}"></script>
    <script type="text/template" id="tpl-tr-attribute">
        <tr>
            <td class="td_stt">{stt}</td>
            <td>{attribute_code}
                <input type="hidden" class="id_attribute" value="{id_attribute}">
                <input type="hidden" class="input_id_attribute" value="{id_attribute}">
                <input type="hidden" class="input_product_attribute_code" value="{product_attribute_code}">
                <input type="hidden" class="input_price_day" value="{price_day}">
                <input type="hidden" class="input_price_month" value="{price_month}">
                <input type="hidden" class="input_price_month_by_value" value="0">
                <input type="hidden" class="input_price_day_by_value" value="0">
                <input type="hidden" class="input_price_year" value="0">
                <input type="hidden" class="input_unit_name" value="{unit_name}">
            </td>
            <td>{attribute}
            <td>{unit}</td>
            <td>
                <input type="text" class="form-control input-tr col-lg-8 numeric input_default_value"
                       value="{default_value}" onclick="productAdd.clickInput(this)"
                       onchange="productAdd.formatInputNumber(this)"
                       onkeyup="productAdd.calPriceMonthByAttribute()">
            </td>
            <td>
                <label class="kt-checkbox">
                    {checked}
                    <span></span>
                </label>
            </td>
            <td>
                <label class="kt-checkbox">
                    <input type="checkbox" checked class="choose_attribute"
                           onclick="productAdd.calPriceMonthByAttribute()">
                    <span></span>
                </label>
            </td>
        </tr>
    </script>
@endsection
