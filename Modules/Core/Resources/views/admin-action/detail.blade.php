@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    @if (isset($detail))
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('core::admin-action.index.DETAIL_ADMIN_GROUP_ACTION')
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
                    'route' => 'core.admin-action.edit',
                    'html' => '<a href="'.route('core.admin-action.edit', ['id' => $detail['action_id']]).'" class="btn btn-info btn-bold">'
                    .__('core::admin-action.input.BUTTON_EDIT').
                '</a>'
                ]])
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
                        <label class="form-control">{{ $detail['action_name'] }}</label>
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
                        <label class="form-control ss--word-break">{{ $detail['description'] }}</label>
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
                   <div class="table_responsive">
                       <table class="table table-striped" id="table-admin-group">
                           <thead>
                           <tr>
                               <th>@lang('core::admin-action.edit.ADMIN_GROUP_NAME')</th>
                               <th>@lang('core::admin-action.edit.ADMIN_GROUP_DESCRIPTION')</th>
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
    @endif
@endsection
