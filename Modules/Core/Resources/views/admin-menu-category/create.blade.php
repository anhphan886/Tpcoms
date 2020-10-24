@extends('layout')
@section('title')
    @parent
    {{ $title }}
@endsection
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <form id="form-submit" method="POST" action="{{ route('core.admin-menu-category.store') }}">
        {{ csrf_field() }}
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('core::admin-menu-category.index.CREATE_ADMIN_MENU_CATEGORY')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>
                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <button type="button" class="btn btn-info btn-bold" onclick="adminMenuCategory.save()">
                    @lang('core::admin-menu-category.input.BUTTON_SAVE_ADD_NEW')
                </button>
                <button type="button" class="btn btn-info btn-bold" onclick="adminMenuCategory.save(1)">
                    @lang('core::admin-menu-category.input.BUTTON_SAVE_EXIT')
                </button>
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
                        <input class="form-control{{ $errors->has('menu_name') ? ' is-invalid' : '' }}"
                               id="menu_category_name"
                               name="menu_category_name" type="text"
                               value="{{ old('menu_category_name') }}"
                               placeholder="@lang('core::admin-menu-category.input.PLACEHOLDER_NAME')" required>
                        @if ($errors->has('menu_category_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('menu_category_name') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">
                        @lang('core::admin-menu-category.index.ADMIN_MENU_CATEGORY_POSITION')
                    </label>
                    <div class="col-lg-9 col-xl-9">
                        <input class="form-control{{ $errors->has('menu_position') ? ' is-invalid' : '' }}" type="number"
                               id="menu_category_position"
                               name="menu_category_position"
                               max="1000000"
                               value="{{ old('menu_category_position', 1) }}"
                               placeholder="@lang('core::admin-menu-category.input.PLACEHOLDER_POSITION')">
                        @if ($errors->has('menu_category_position'))
                            <div class="invalid-feedback">
                                {{ $errors->first('menu_category_position') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">
                        @lang('core::admin-menu-category.index.ADMIN_MENU_CATEGORY_ICON')
                    </label>
                    <div class="col-lg-9 col-xl-9">
                        <div class="row">
                            @foreach ($list_icons as $key => $icon)
                                <div class="col-6 col-sm-3 col-md-2">
                                    <label class="kt-radio kt-radio--solid kt-radio--brand">
                                        <input type="radio" name="menu_category_icon" value="{{ $icon }}" {{ $key == 0 ? 'checked' : '' }}>
                                        <div class="kt-demo-icon">
                                            <div class="kt-demo-icon__preview">
                                                <i class="fa {{ $icon }}"></i>
                                            </div>
                                        </div>
                                        <span></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/core/admin-menu-category/script.js?v='.time()) }}"></script>
@endsection
