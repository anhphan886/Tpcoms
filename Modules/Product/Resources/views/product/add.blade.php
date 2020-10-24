@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <style>
        .image-big {
            width: 200px !important;
            height: 200px !important;
        }
    </style>
    <form id="form-submit">
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title nt_text_bold ">
                    @lang('product::product.create.add_product')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <button type="button" class="btn btn-primary btn-hover-brand" onclick="productAdd.save(1)">
                    @lang('product::product.create.save')
                </button>
                <a href="{{route('product.product')}}" class="btn btn-secondary btn-bold">
                    @lang('product::product.create.cancel')
                </a>
            </div>
        </div>
        <!--begin: Datatable -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label class="col-form-label " for="product_category_id">
                                    @lang('product::product.create.category')
                                </label>
                                <select class="form-control kt-select2" name="product_category_id"
                                        id="product_category_id" style="width: 100%">
                                    <option value="">
                                        @lang('product::product.create.choose_category')
                                    </option>
                                    @foreach($productGroup as $item)
                                        <option value="{{$item['product_category_id']}}">
                                            {{$item[getValueByLang('category_name_')]}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::product.create.name_vi')
                                </label>
                                <input class="form-control" type="text" name="product_name_vi"
                                       id="product_name_vi">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::product.create.name_en')
                                </label>
                                <input class="form-control" type="text" name="product_name_en"
                                       id="product_name_en">
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label class="col-form-label">
                                        @lang('product::product.create.status')
                                    </label>
                                </div>
                                <div class="col-lg-10">
                                    <span class="kt-switch kt-switch--success">
                                    <label>
                                        <input type="checkbox" name="is_active" id="is_active" checked>
                                        <span></span>
                                    </label>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 nt_center_custome_box_img">
                            <div class="form-group ss-float-right nt_custome_box_img">
                                <div class="kt-avatar kt-avatar--outline image-big ss-float-right kt-margin-b-10"
                                     id="kt_user_add_avatar">
                                    <div id="div-image">
                                        <div class="kt-avatar__holder image-big"
                                             style="
                                                 background-image: url({{asset('static/backend/images/default-placeholder.png')}})"></div>
                                    </div>
                                </div>
                                <input style="display: none;" type="file" id="getFileImage"
                                       class="custom-file-input"
                                       name="getFileImage" accept="image/jpeg,image/png,image/jpeg,jpg|png|jpeg"
                                       onchange="productAdd.uploadAvatar(this);">
                                <label class="btn btn-primary ss-float-right ss--pointer nt_btn_center  btn-hover-brand"
                                       for="getFileImage" style="width: 73%">
                                    @lang('product::product.create.choose_file')
                                </label>
                                <input type="hidden" id="image-avatar" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-form-label ">
                                    @lang('product::product.create.description')
                                </label>
                                <textarea class="form-control" rows="6" name="description" id="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <span class="ss-font-size-1p2rem nt_text_bold">
                              @lang('product::product.create.list_product_attribute')
                            </span>
                        </div>
                        <div class="col-lg-4">
                            <button onclick="productAdd.addAttribute()" type="button"
                                    class="btn btn-warning ss-float-right btn-bold btn btn-primary btn-hover-brand">
                                <i class="fa flaticon2-plus"></i>
                                @lang('product::product.create.add_attribute')
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table_responsive">
                                <table class="table table-striped" id="tb-list-attribute">
                                    <thead>
                                    <tr>
                                        <th>
                                            @lang('product::product.create.stt')
                                        </th>
                                        <th>
                                            @lang('product::product.create.attribute_code')
                                        </th>
                                        <th>
                                            @lang('product::product.create.attribute')
                                        </th>
                                        <th>
                                            @lang('product::product.create.unit')
                                        </th>
                                        <th>
                                            @lang('product::product.create.Min')
                                        </th>
                                        <th>
                                            @lang('product::product.create.Max')
                                        </th>
                                        <th>
                                            @lang('product::product.create.jump')
                                        </th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button onclick="productGroupAdd.addAttributeGroup()" type="button"
                                class="btn btn-warning ss-float-right btn-bold btn btn-primary btn-hover-brand">
                            <i class="fa flaticon2-plus"></i>
                            @lang('product::product.create.add_attribute_group')
                        </button>
                    </div>
                    <br>
                    <div class="kt-margin-b-25">
                        <table class="table table-striped kt-margin-b-0">
                            <thead class="thead-dark">
                            <tr>
                                <th>Nhóm thuộc tính bán kèm</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="tbody-group-attr">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <input type="hidden" id="language" value="{{\Illuminate\Support\Facades\App::getLocale()}}">

    @include('product::product.modal.modal-add-attribute')
    @include('product::product.modal.modal-add-attribute-group')
@endsection
@section('after_script')
    <script src="{{asset('static/backend/js/general/numeric.js?v='.time())}}"
            type="text/javascript"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/product/add-script.js?v='.time()) }}"></script>
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/product/add-attribute-group.js?v='.time()) }}"></script>
    <script type="text/template" id="tpl-tr-attribute">
        <tr>
            <td>{stt}</td>
            <td>{attribute_code}
                <input type="hidden" class="id_attribute" value="{id_attribute}">
                <input type="hidden" class="input_id_attribute" value="{id_attribute}">
                <input type="hidden" class="input_product_attribute_code" value="{product_attribute_code}">
                <input type="hidden" class="input_price_month" value="{price_month}">
                <input type="hidden" class="input_price_year" value="{price_year}">
                <input type="hidden" class="input_unit_name" value="{unit_name}">
            </td>
            <td>{attribute}</td>
            <td>{unit}</td>
            <td>
                <input type="text" onclick="productAdd.clickInput(this)"
                       onchange="productAdd.formatInputNumber(this)"
                       class="input_min form-control input-tr col-lg-8 numeric" value="{min}">
                <span class="text-danger"></span>
            </td>
            <td>
                <input type="text" onclick="productAdd.clickInput(this)"
                       onchange="productAdd.formatInputNumber(this)"
                       class="input_max form-control input-tr col-lg-8 numeric" value="{max}">
                <span class="text-danger"></span>
            </td>
            <td>
                <input type="text" onclick="productAdd.clickInput(this)"
                       onchange="productAdd.formatInputNumber(this)"
                       class="input_jump form-control input-tr col-lg-8 numeric" value="{jump}">
                <span class="text-danger"></span>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm"
                        style="background-color: #ff2d2d" onclick="productAdd.removeTr(this)">
                    @lang('product::product.create.remove')
                </button>
            </td>
        </tr>
    </script>
    <script type="text/template" id="tpl-div-attribute">
        <tr>
            <td>
                <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample-{stt}">
                    <div class="card">
                        <div class="card-header" id="heading-{stt}">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo-{stt}"
                                 aria-expanded="false">
                                <input type="hidden" class="input_attribute_group" value="{attribute_group_id}">
                                {attribute_group}
                            </div>
                        </div>
                        <div id="collapseTwo-{stt}" class="collapse" data-parent="#accordionExample-{stt}" style="">
                            <div class="card-body">
                                <table class="table table-striped kt-margin-b-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Tên thuộc tính</th>
                                        <th>Đơn vị</th>
                                    </tr>
                                    </thead>
                                    <tbody id="attr-{stt}"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm"
                        style="background-color: #ff2d2d"
                        onclick="productGroupAdd.removeTr(this)">
                    Xoá
                </button>
            </td>
        </tr>
    </script>
    <script type="text/template" id="image-tpl">
        <div class="kt-avatar__holder image-big"
             style="background-image: url({link})"></div>
    </script>
    <script type="text/template" id="tpl-attr">
        <tr>
            <td>{attrName}</td>
            <td>{unitName}</td>
        </tr>
    </script>
@endsection
