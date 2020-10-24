@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    @if (isset($detail))
        <form id="form-submit" method="POST" action="{{ route('core.admin-menu.update') }}">
            {{ csrf_field() }}
            <input type="hidden" name="menu_id" id="menu_id" value="{{ $detail['menu_id'] }}">
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        @lang('core::admin-menu.index.EDIT_ADMIN_MENU')
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <span class="kt-subheader__desc" id="kt_subheader_total"> </span>
                    </div>
                    <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <button type="button" class="btn btn-info btn-bold" onclick="adminMenu.save(1)">
                        @lang('core::admin-menu.input.BUTTON_SAVE')
                    </button>
                    @include('helpers.button', ['button' => [
                        'route' => 'core.admin-menu.create',
                        'html' => '<a href="'.route('core.admin-menu.create').'" class="btn btn-label-brand btn-bold">'
                        .__('core::admin-menu.input.BUTTON_ADD_NEW').
                    '</a>'
                    ]])
                    @include('helpers.button', ['button' => [
                        'route' => 'core.admin-menu.destroy',
                        'html' => '<a href="javascript:void(0)" class="btn btn-danger btn-bold" onclick="adminMenu.removeMenu('.$detail['menu_id'].')">'
                        .__('core::admin-menu.input.BUTTON_REMOVE').
                    '</a>'
                    ]])
                    <a href="{{route('core.admin-menu.index')}}" class="btn btn-secondary btn-bold">
                        @lang('core::admin-menu.input.BUTTON_CANCEL')
                    </a>
                </div>
            </div>
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-menu.edit.ADMIN_MENU_NAME')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control{{ $errors->has('menu_name') ? ' is-invalid' : '' }}"
                                   id="menu_name"
                                   name="menu_name" type="text"
                                   value="{{ old('menu_name', isset($detail['menu_name']) ? $detail['menu_name'] : null) }}"
                                   placeholder="@lang('core::admin-menu.input.PLACEHOLDER_NAME')" required>
                            @if ($errors->has('menu_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('menu_name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-menu.edit.ADMIN_MENU_DESCRIPTION')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control" type="text"
                                   id="description"
                                   name="description"
                                   value="{{ old('description', isset($detail['description']) ? $detail['description'] : null) }}"
                                   placeholder="@lang('core::admin-menu.input.PLACEHOLDER_DESCRIPTION')">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-menu.edit.ADMIN_MENU_POSITION')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control{{ $errors->has('menu_position') ? ' is-invalid' : '' }}" type="number"
                                   id="menu_position" max="100000000"
                                   name="menu_position"
                                   value="{{ old('menu_position', isset($detail['menu_position']) ? $detail['menu_position'] : null) }}"
                                   placeholder="@lang('core::admin-menu.input.PLACEHOLDER_POSITION')">
                            @if ($errors->has('menu_position'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('menu_position') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-menu.create.ADMIN_MENU_ACTION')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control select2" name="menu_route">
                                @if (isset($list_action) && count($list_action) > 0)
                                    @foreach ($list_action as $item)
                                        <option value="{{ $item['action_route'] }}"
                                                {{ ($detail['menu_route'] == $item['action_route']) ? ' selected' : ''}}>
                                            {{ $item['action_name'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-menu.create.ADMIN_MENU_CATEGORY')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control select2" name="menu_category_id">
                                <option value="0"
                                        {{ ($detail['menu_category_id'] == 0) ? ' selected' : ''}}>
                                    @lang('core::admin-menu.input.PLACEHOLDER_MENU_CATEGORY')
                                </option>
                                @if (isset($list_menu_category) && count($list_menu_category) > 0)
                                    @foreach ($list_menu_category as $item)
                                        <option value="{{ $item['menu_category_id'] }}"
                                                {{ ($detail['menu_category_id'] == $item['menu_category_id']) ? ' selected' : ''}}>
                                            {{ $item['menu_category_name'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-menu.create.ADMIN_MENU_ICON')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <div class="row">
                                @foreach ($list_icons as $key => $icon)
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <label class="kt-radio kt-radio--solid kt-radio--brand">
                                            <input type="radio" name="menu_icon" value="{{ $icon }}"
                                                @if ($detail['menu_icon'] == '<i class="fa '.$icon.'"></i>')
                                                    checked
                                                @endif
                                            >
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
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <div class="kt-section">
                        @include('core::admin-menu.partial.list-admin-group')
                    </div>
                </div>
            </div>
        </form>
    @endif
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/core/admin-menu/script.js?v='.time()) }}"></script>
@endsection
