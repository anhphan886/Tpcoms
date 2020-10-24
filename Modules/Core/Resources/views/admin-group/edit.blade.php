@extends('layout')
@section('header')
    @include('components.header', ['title' => 'Config'])
@endsection
@section('content')
    @if (isset($detail))
        <form id="form-submit" method="POST" action="{{ route('core.admin-group.update') }}">
            {{ csrf_field() }}
            <input type="hidden" name="group_id" id="group_id" value="{{ $detail['group_id'] }}">
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        @lang('core::admin-group.edit') nhóm quyền
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <span class="kt-subheader__desc" id="kt_subheader_total"> </span>
                    </div>
                    <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <button type="button" onclick="adminGroup.save(1)"
                            class="btn btn-info btn-bold">
                        @lang('core::admin-group.button_save')
                    </button>
                    @include('helpers.button', ['button' => [
                        'route' => 'core.admin-group.create',
                        'html' => '<a href="'.route('core.admin-group.create').'" class="btn btn-label-brand btn-bold">'
                        .__('core::admin-group.button_add_new').
                    '</a>'
                    ]])
                    @include('helpers.button', ['button' => [
                        'route' => 'core.admin-group.destroy',
                        'html' => '<a href="javascript:void(0)" class="btn btn-danger btn-bold" onclick="adminGroup.removeGroup('.$detail['group_id'].')">'
                        .__('core::admin-group.button_remove').
                    '</a>'
                    ]])
                    <a href="{{route('core.admin-group.index')}}" class="btn btn-secondary btn-bold">
                        @lang('core::admin-group.button_cancel')
                    </a>
                </div>
            </div>
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-group.admin_group_name')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control{{ $errors->has('group_name') ? ' is-invalid' : '' }}"
                                   id="group_name" maxlength="100"
                                   name="group_name" type="text"
                                   value="{{ old('group_name', isset($detail['group_name']) ? $detail['group_name'] : null) }}"
                                   placeholder="@lang('core::admin-group.placeholder_name')" required>
                            @if ($errors->has('group_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('group_name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-action.edit.ADMIN_ACTION_DESCRIPTION')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control ss--word-break" type="text"
                                   id="group_description"
                                   name="group_description"
                                   value="{{ old('group_description', isset($detail['group_description']) ? $detail['group_description'] : null) }}"
                                   placeholder="@lang('core::admin-group.placeholder_description')">
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet kt-portlet--tabs">
                @include('core::admin-group.partial.tabs')
            </div>
        </form>
    @endif
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/core/admin-group/script.js?v='.time()) }}"></script>
@endsection
