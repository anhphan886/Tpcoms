@extends('layout')
@section('title')
    @parent
    {{ $title }}
@endsection
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">@lang('core::admin-menu-category.index.ADMIN_MENU_CATEGORY')</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            @include('helpers.button', ['button' => [
                'route' => 'core.admin-menu-category.create',
                'html' => '<a href="'.route('core.admin-menu-category.create').'" class="btn btn-label-brand btn-bold">'
                .__('core::admin-menu-category.index.CREATE_ADMIN_MENU_CATEGORY').
            '</a>'
            ]])
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-filter" action="{{route('core.admin-menu-category.index')}}">
                    @include('core::admin-menu-category.partial.search-table')
                    <div class="kt-section">
                        @include('core::admin-menu-category.list')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/core/admin-menu-category/script.js?v='.time()) }}"></script>
@endsection
