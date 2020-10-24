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
                <h3 class="kt-subheader__title">
                    @lang('product::product.index.detail')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="{{route('product.product')}}" class="btn btn-secondary btn-bold">
                    @lang('product::product.create.cancel')
                </a>
            </div>
        </div>
        <!--begin: Datatable -->
        <div class="kt-content1  kt-grid__item kt-grid__item--fluid" id="kt_content">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label class="col-form-label" for="product_category_id">
                                    @lang('product::product.create.category')
                                </label>
                                <select disabled class="form-control kt-select2" name="product_category_id"
                                        id="product_category_id" style="width: 100%">
                                    <option value="">
                                        @lang('product::product.create.choose_category')
                                    </option>
                                    @foreach($productGroup as $item)
                                        <option value="{{$item['product_category_id']}}"
                                                {{$product['product_category_id'] == $item['product_category_id'] ? 'selected' : ''}}>
                                            {{$item[getValueByLang('category_name_')]}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::product.create.name_vi')
                                </label>
                                <input disabled class="form-control" type="text" name="product_name_vi"
                                       id="product_name_vi" value="{{$product['product_name_vi']}}">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::product.create.name_en')
                                </label>
                                <input disabled class="form-control" type="text" name="product_name_en"
                                       id="product_name_en" value="{{$product['product_name_en']}}">
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
                                        <input disabled type="checkbox" name="is_active" id="is_active"
                                                {{$product['is_actived'] == 1 ? 'checked' : ''}}>
                                        <span></span>
                                    </label>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 nt_custome_box_img ">

                            <div class="form-group ss-float-right nt_custome_box_img">
                                <div class="kt-avatar kt-avatar--outline image-big ss-float-right kt-margin-b-10 nt_custome_box_img"
                                     id="kt_user_add_avatar">
                                    <div id="div-image">
                                        @if($product['avatar'] != '')
                                            <div class="kt-avatar__holder image-big"
                                                 style="
                                                     background-image: url({{asset($product['avatar'])}})"></div>
                                        @else
                                            <div class="kt-avatar__holder image-big"
                                                 style="
                                                     background-image: url({{asset('static/backend/images/default-placeholder.png')}})"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::product.create.description')
                                </label>
                                <textarea disabled class="form-control" rows="6" name="description"
                                          id="description">{{$product[getValueByLang('description_')]}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <span class="ss-font-size-1p2rem nt_bold">
                              @lang('product::product.create.list_product_attribute')
                            </span>
                        </div>
                        <div class="col-lg-4">

                        </div>
                    </div>
                    <div class="row">
                       <div class="col-12">
                           <div class="table_responsive">
                               <table class="table table-striped table-order table-responsive-md" id="tb-list-attribute">
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
                                   </tr>
                                   </thead>
                                   <tbody>
                                   @if(isset($productAttributeMap))
                                       @if(count($productAttributeMap) > 0)
                                           @foreach($productAttributeMap as $key => $value)
                                               <tr>
                                                   <td>{{$key + 1}}</td>
                                                   <td>{{$value['product_attribute_code']}}</td>
                                                   <td>{{$value[getValueByLang('product_attribute_name_')]}}</td>
                                                   <td>{{$value['unit_name']}}</td>
                                                   <td>{{$value['min_value']}}</td>
                                                   <td>{{$value['max_value']}}</td>
                                                   <td>{{$value['min_unit']}}</td>
                                               </tr>
                                           @endforeach
                                       @endif
                                   @endif
                                   </tbody>
                                   <div class="kt-margin-b-25">
                                       <table class="table table-striped kt-margin-b-0">
                                           <thead class="thead-dark">
                                           <tr>
                                               <th>Nhóm thuộc tính bán kèm</th>
                                               <th></th>
                                           </tr>
                                           </thead>
                                           <tbody id="tbody-group-attr">
                                           @if(isset($productAttributeGroupMap))
                                               @if(count($productAttributeGroupMap) > 0)
                                                   @foreach($productAttributeGroupMap as $value)
                                                   <tr>
                                                       <td>
                                                           <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample-{{$value['product_attribute_group_id']}}">
                                                               <div class="card">
                                                                   <div class="card-header" id="heading-{{$value['product_attribute_group_id']}}">
                                                                       <div class="card-title" data-toggle="collapse" data-target="#collapseTwo-{{$value['product_attribute_group_id']}}" aria-expanded="true">
                                                                           <input type="hidden" class="input_attribute_group" value="{attribute_group_id}">
                                                                           {{$value['product_attribute_group_name_vi']}}
                                                                       </div>
                                                                   </div>
                                                                   <div id="collapseTwo-{{$value['product_attribute_group_id']}}" class="collapse " data-parent="#accordionExample-{{$value['product_attribute_group_id']}}" style="">
                                                                       <div class="card-body">
                                                                           <table class="table table-striped kt-margin-b-0">
                                                                               <thead class="thead-light">
                                                                               <tr>
                                                                                   <th>Tên thuộc tính</th>
                                                                                   <th>Đơn vị</th>
                                                                               </tr>
                                                                               </thead>
                                                                               <tbody id="attr-{stt}">
                                                                               @foreach($infoGroupAttr as $valueAttr)
                                                                                   @if($valueAttr['product_attribute_group_id'] == $value['product_attribute_group_id'])
                                                                               <tr>
                                                                                   <td>
                                                                                       {{$valueAttr['product_attribute_name_vi']}}
                                                                                   </td>
                                                                                   <td>
                                                                                       {{$valueAttr['unit_name']}}
                                                                                   </td>
                                                                               </tr>
                                                                                @endif
                                                                               @endforeach
                                                                               </tbody>
                                                                           </table>
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                       </td>
                                                   </tr>
                                                   @endforeach
                                               @endif
                                           @endif
                                           </tbody>

                                       </table>
                                   </div>
                               </table>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
