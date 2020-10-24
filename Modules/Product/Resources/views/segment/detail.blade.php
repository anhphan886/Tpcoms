@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                @lang('product::segment.index.detail_segment')
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
                'route' => 'product.segment.edit',
                'html' => '<a href="'.route('product.segment.edit', ['id' => $detail['id']]).'" class="btn btn-label-brand btn-bold">'
                .'<i class="la la-edit"></i>'
                .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::admin-group.edit').'</span>'.
                '</a>'
                ]])
            <a href="{{route('product.segment')}}" class="btn btn-secondary btn-bold">
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
                                    @lang('product::segment.index.name_vi')
                                </label>
                                <input disabled value="{{$detail['name']}}" class="form-control" type="text" name="name_vi"
                                       id="name_vi">
                                <input type="hidden" name="id" id="id" value="{{$detail['id']}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::segment.index.name_en')
                                </label>
                                <input disabled value="{{$detail['name_en']}}" class="form-control" type="text" name="name_en"
                                       id="name_en">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::segment.index.created_at')
                                </label>
                                <input disabled value="{{(new DateTime($detail['created_at']))->format('d/m/Y')}}" class="form-control" type="text" name="name_en"
                                       id="name_en">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::segment.index.created_by')
                                </label>
                                <input disabled value="{{$detail['created_by']}}" class="form-control" type="text" name="name_en"
                                       id="name_en">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::segment.index.updated_at')
                                </label>
                                <input disabled value="{{(new DateTime($detail['updated_at']))->format('d/m/Y')}}" class="form-control" type="text" name="name_en"
                                       id="name_en">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('product::segment.index.updated_by')
                                </label>
                                <input disabled value="{{$detail['updated_by']}}" class="form-control" type="text" name="name_en"
                                       id="name_en">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/product/segment/script.js?v='.time()) }}"></script>
@endsection
