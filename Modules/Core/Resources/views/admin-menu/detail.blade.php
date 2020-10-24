@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    @if (isset($detail))
        <form>
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        @lang('core::admin-menu.index.SHOW_ADMIN_MENU')
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <span class="kt-subheader__desc" id="kt_subheader_total"> </span>
                    </div>
                    <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    @if (in_array('core.admin-menu.edit', request()->session()->get('user_route'))
                    || Auth::user()->is_admin)
                        <a href="{{ route('core.admin-menu.edit', ['id' => $detail['menu_id']]) }}" class="btn btn-info btn-bold">
                            @lang('core::admin-menu.input.BUTTON_EDIT')
                        </a>
                    @endif
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
                            <label class="form-control">{{ $detail['menu_name'] }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-menu.edit.ADMIN_MENU_DESCRIPTION')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <label class="form-control">{{ $detail['description'] }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-menu.edit.ADMIN_MENU_POSITION')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <label class="form-control">{{ $detail['menu_position'] }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-menu.create.ADMIN_MENU_ACTION')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control select2" disabled>
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
                            <select class="form-control select2" disabled>
                                <option value="0" {{ ($detail['menu_category_id'] == 0) ? ' selected' : ''}}>&nbsp;</option>
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
                                <div class="col-2">
                                    <div class="kt-demo-icon">
                                        <div class="kt-demo-icon__preview">
                                            {!! $detail['menu_icon'] !!}
                                        </div>
                                        <div class="kt-demo-icon__class"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <div class="kt-section">
                        <div class="table_responsive">
                            <table class="table table-striped" id="table-admin-group">
                                <thead>
                                <tr>
                                    <th>@lang('core::admin-menu.create.ADMIN_GROUP_NAME')</th>
                                    <th>@lang('core::admin-menu.create.ADMIN_GROUP_DESCRIPTION')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (isset($list_group) && count($list_group) > 0)
                                    @foreach ($list_group as $item)
                                        <tr class="group-item">
                                            <td>
                                                <p>{{ $item['group_name'] }}</p>
                                                <input type="hidden" name="group_id[]" value="{{ $item['group_id'] }}">
                                            </td>
                                            <td><p>{{ $item['group_description'] }}</p></td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    @endif
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/core/admin-menu/script.js?v='.time()) }}"></script>
@endsection
