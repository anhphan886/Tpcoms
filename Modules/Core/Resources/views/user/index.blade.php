@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">@lang('core::user.index.MANAGEMENT_ACCOUNT')</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            @include('helpers.button', ['button' => [
                'route' => 'core.user.create',
                'html' => '<a href="'.route('core.user.create').'" class="btn btn-label-brand btn-bold">'
                .__('core::user.index.CREATE_ACCOUNT').
            '</a>'
            ]])
        </div>
    </div>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-filter" action="{{route('core.user.index')}}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3">
                                <input type="text" name="keyword_users$email" class="form-control"
                                       placeholder="Tên tài khoản" value="{{$filter['keyword_users$email']??''}}">
                            </div>
                            <div class="col-lg-3">
                                <input type="text" name="keyword_users$full_name" class="form-control"
                                       placeholder="Họ và tên" value="{{$filter['keyword_users$full_name']??''}}">
                            </div>
                            <div class="col-lg-3">
                                <select type="text" name="users$is_actived"
                                        class="form-control --select2 ss--width-100">
                                    <option value="">@lang('core::user.index.STATUS')</option>
                                    @if(isset($filter['users$is_actived']))
                                        <option value="1" {{($filter['users$is_actived']=='1'?'selected':'')}}>TRUE
                                        </option>
                                        <option value="0" {{($filter['users$is_actived']=='0'?'selected':'')}}>FALSE
                                        </option>
                                    @else
                                        <option value="1">@lang('core::user.index.TRUE')</option>
                                        <option value="0">@lang('core::user.index.FALSE')</option>
                                    @endif

                                </select>
                            </div>
                            <div class="col-lg-3">
                                <a class="btn btn-secondary" href="{{route('core.user.index')}}">
                                    @lang('core::user.index.REMOVE')
                                </a>
                                <button class="btn btn-primary"
                                        style="">@lang('core::user.index.SEARCH')
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="kt-section">
                        @include('core::user.list')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script src="{{asset('static/backend/js/core/user/add.js?v='.time())}}" type="text/javascript"></script>
@endsection
