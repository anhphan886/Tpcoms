@extends('layout')
@section('title')
    @parent
    {{ $title }}
@endsection
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    @if (isset($detail))
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('core::admin-menu-category.index.DETAIL_ADMIN_MENU_CATEGORY')
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
                        'route' => 'core.admin-menu-category.edit',
                        'html' => '<a href="'.route('core.admin-menu-category.edit', ['id' => $detail['menu_category_id']]).'" class="btn btn-info btn-bold">'
                        .__('core::admin-menu-category.input.BUTTON_EDIT').
                    '</a>'
                    ]])
                @include('helpers.button', ['button' => [
                    'route' => 'core.admin-menu-category.create',
                    'html' => '<a href="'.route('core.admin-menu-category.create').'" class="btn btn-label-brand btn-bold">'
                    .__('core::admin-menu-category.input.BUTTON_ADD').
                '</a>'
                ]])
                @include('helpers.button', ['button' => [
                    'route' => 'core.admin-menu-category.destroy',
                    'html' => '<a href="javascript:void(0)" class="btn btn-danger btn-bold" onclick="adminMenuCategory.remove('.$detail['menu_category_id'].')">'
                    .__('core::admin-menu-category.input.BUTTON_REMOVE').
                '</a>'
                ]])
                <a href="{{route('core.admin-menu-category.index')}}" class="btn btn-secondary btn-bold">
                    @lang('core::admin-menu-category.input.BUTTON_CANCEL')
                </a>
            </div>
        </div>
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">
                        @lang('core::admin-menu-category.index.ADMIN_MENU_CATEGORY_NAME')
                    </label>
                    <div class="col-lg-9 col-xl-9">
                        <label class="form-control">{{ $detail['menu_category_name'] }}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">
                        @lang('core::admin-menu-category.index.ADMIN_MENU_CATEGORY_POSITION')
                    </label>
                    <div class="col-lg-9 col-xl-9">
                        <label class="form-control">{{ $detail['menu_category_position'] }}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">
                        @lang('core::admin-menu-category.index.ADMIN_MENU_CATEGORY_ICON')
                    </label>
                    <div class="col-lg-9 col-xl-9">
                        <div class="row">
                            <div class="col-6 col-sm-3 col-md-2">
                                <div class="kt-demo-icon">
                                    <div class="kt-demo-icon__preview">
                                        {!! $detail['menu_category_icon'] !!}
                                    </div>
                                    <div class="kt-demo-icon__class"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/core/admin-menu-category/script.js?v='.time()) }}"></script>
@endsection
