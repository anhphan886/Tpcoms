@extends('layout')
@section('title')
    @parent
    {{--    {{ $title }}--}}
@endsection
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">@lang('wiki::wiki.index.suadanhmuc')</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <div class="btn-group">
                <button type="submit" class="btn btn-primary" onclick="category.edit()">
                    @lang('wiki::wiki.index.capnhat')
                </button>
                <a class="btn btn-default btn-bold" href="{{route('wiki.category')}}">
                    @lang('wiki::wiki.index.quaylaitrangtruoc')
                </a>
            </div>
        </div>
    </div>

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-padding-0" id="kt_content">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <label>@lang('wiki::wiki.index.tendanhmuctienganh')</label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="name_en" id="name_en" class="form-control" value="{{$detail['name_en']}}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <label>@lang('wiki::wiki.index.tendanhmuctiengviet')</label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="name_vi" id="name_vi" class="form-control" value="{{$detail['name_vi']}}">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <input type="text" id="id" style="display: none" class="form-control" value="{{$detail['id']}}">
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/wiki/knowledge-base.js?v='.time()) }}"></script>
@endsection
