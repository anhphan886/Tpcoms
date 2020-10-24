@extends('layout')
@section('header')
    @include('components.header', ['title' => 'Config'])
@endsection
@section('content')
    @if (isset($detail))
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('core::admin-group.detail_admin_group')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>
                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
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
                        <label class="form-control">{{ $detail['group_name'] }}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">
                        @lang('core::admin-action.edit.ADMIN_ACTION_DESCRIPTION')
                    </label>
                    <div class="col-lg-9 col-xl-9">
                        <label class="form-control ss--word-break">{{ $detail['group_description'] }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-left nav-tabs-line-primary"
                        role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#admin-list"
                               role="tab"
                               aria-selected="true">
                                @lang('core::admin-group.user_list')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#admin-group-action-menu"
                               role="tab"
                               aria-selected="true">
                                @lang('core::admin-group.admin_menu')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#admin-group-action"
                               role="tab"
                               aria-selected="true">
                                @lang('core::admin-group.admin_action')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="kt-form kt-form--label-right">
                <div class="kt-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="admin-list">
                            <div class="kt-section kt-margin-t-30">
                                <div class="kt-section__body">
                                    @include('core::admin-group.partial.list-admin-list-static')
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="admin-group-action-menu">
                            <div class="kt-section kt-margin-t-30">
                                <div class="kt-section__body">
                                    <table class="table table-striped" id="table-list-menu">
                                        <thead>
                                        <tr>
                                            <th>@lang('core::admin-group.admin_menu_name')</th>
                                            <th>@lang('core::admin-group.admin_menu_position')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (isset($list_menu) && count($list_menu) > 0)
                                            @foreach ($list_menu as $item)
                                                <tr class="menu-item">
                                                    <td>
                                                        <p>{{ $item['menu_name'] }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ $item['menu_position'] }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="admin-group-action">
                            <div class="kt-section kt-margin-t-30">
                                <div class="kt-section__body">
                                    <table class="table table-striped" id="table-list-action">
                                        <thead>
                                        <tr>
                                            <th>@lang('core::admin-group.admin_action_name')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (isset($list_action) && count($list_action) > 0)
                                            @foreach ($list_action as $item)
                                                <tr class="action-item">
                                                    <td>
                                                        <p>{{ $item['action_name'] }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot"></div>
            </div>
        </div>
    @endif
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/core/admin-group/script.js?v='.time()) }}"></script>
@endsection
