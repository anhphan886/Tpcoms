@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    @if (isset($detail))
        <form id="form-submit" method="POST" action="{{ route('core.admin-action.update') }}">
            {{ csrf_field() }}
            <input type="hidden" name="action_id" id="action_id" value="{{ $detail['action_id'] }}">
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        @lang('core::admin-action.index.EDIT_ADMIN_GROUP_ACTION')
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <span class="kt-subheader__desc" id="kt_subheader_total"> </span>
                    </div>
                    <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <button type="button" class="btn btn-info btn-bold"
                            id="btn-save-info"
                            onclick="adminAction.saveInfo()">
                        @lang('core::admin-action.input.BUTTON_SAVE')
                    </button>
                    <a href="{{route('core.admin-action.index')}}" class="btn btn-secondary btn-bold">
                        @lang('core::admin-action.input.BUTTON_CANCEL')
                    </a>
                </div>
            </div>
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-action.edit.ADMIN_ACTION_NAME')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control{{ $errors->has('action_name') ? ' is-invalid' : '' }}"
                                   id="action_name"
                                   name="action_name" type="text"
                                   value="{{ old('action_name', isset($detail['action_name']) ? $detail['action_name'] : null) }}"
                                   placeholder="@lang('core::admin-action.input.PLACEHOLDER_NAME')" required>
                            @if ($errors->has('action_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('action_name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-action.edit.ADMIN_ACTION_NAME_DEFAULT')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <label class="form-control">{{ $detail['action_name_default'] }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-action.edit.ADMIN_ACTION_DESCRIPTION')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control" type="text"
                                   id="description"
                                   name="description"
                                   value="{{ old('description', isset($detail['description']) ? $detail['description'] : null) }}"
                                   placeholder="@lang('core::admin-action.input.PLACEHOLDER_DESCRIPTION')">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">
                            @lang('core::admin-action.edit.ADMIN_ACTION_GROUP_NAME')
                        </label>
                        <div class="col-lg-9 col-xl-9">
                            <label class="form-control">{{ $detail['action_group_name'] }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <div class="kt-section">
                        @include('core::admin-action.partial.list-admin-group')
                    </div>
                </div>
            </div>
        </form>
        <div id="modal-list-group">
            <div class="modal fade" id="kt_modal_list_group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                @lang('core::admin-action.edit.ADD_ADMIN_GROUP')
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="kt-scroll ps ps--active-y" data-scroll="true" data-height="500" style="height: 500px; overflow: hidden;">
                                <div class="kt-section__content" id="popup-list-group"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                @lang('core::admin-action.input.BUTTON_CLOSE')
                            </button>
                            <button type="button"
                                    id="btn-add-group-child-to-list"
                                    class="btn btn-primary"
                                    onclick="adminAction.addGroupFromPopup()"
                            >
                                @lang('core::admin-action.input.BUTTON_ADD')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/core/admin-action/script.js?v='.time()) }}"></script>
    <script type="text/javascript">
        adminAction.start();
    </script>
@endsection
