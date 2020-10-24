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
            <h3 class="kt-subheader__title">@lang('wiki::wiki.index.danhmuc')</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
{{--            @include('helpers.button', ['button' => [--}}
{{--              'route' => 'wiki.category.create',--}}
{{--              'html' => '<a href="'.route('wiki.category.create').'" class="btn btn-label-brand btn-bold">'--}}
{{--              .__('wiki::wiki.index.tao').--}}
{{--          '</a>'--}}
{{--          ]])--}}
            <a href="{{route('wiki.category.create')}}" class="btn btn-label-brand btn-bold">{{__('wiki::wiki.index.tao')}}</a>
        </div>
    </div>

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-padding-0" id="kt_content">
        <div class="kt-portlet kt-portlet--mobile">
            <form method="GET"  autocomplete="off" id="form-filter">
                <div class="kt-portlet__body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3 form-group">
                                <input class="form-control "
                                       value="{{ !empty(request()->input('name_en'))
                                       ? request()->input('name_en')
                                       : '' }}"
                                       name="name_en" type="text"
                                       placeholder="@lang('wiki::wiki.index.tendanhmuctienganh')">
                            </div>
                            <div class="col-lg-3 form-group">
                                <input class="form-control "
                                       value="{{ !empty(request()->input('name_vi'))
                                       ? request()->input('name_vi')
                                       : '' }}"
                                       name="name_vi" type="text"
                                       placeholder="@lang('wiki::wiki.index.tendanhmuctiengviet')">
                            </div>
                            <div class="col-lg-3 text-align-right-mobile">
                                <a class="btn btn-secondary"
                                   href="{{route('wiki.category')}}">@lang('wiki::wiki.index.clear')</a>
                                <button class="btn btn-primary" >@lang('wiki::wiki.index.timkiem')</button>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="kt-section__content row">
                           <div class="col-12">
                               <table class="table table-striped table-order table-responsive-md">
                                   <thead>
                                   <tr>
                                       <th>@lang('wiki::wiki.index.tendanhmuctienganh')</th>
                                       <th>@lang('wiki::wiki.index.tendanhmuctiengviet')</th>
                                       <th>@lang('ticket::ticket.table.ticket_action')</th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                   @if ( isset($list) && $list->count()>0)
                                       @foreach($list as $value)
                                           <tr>
                                               <td>{{subString($value['name_en'])}}</td>
                                               <td>{{subString($value['name_vi'])}}</td>
                                               <td>
                                                   <div class="dropdown">
                                                       <button class="btn btn-secondary dropdown-toggle" type="button"
                                                               id="dropdownMenu" data-toggle="dropdown"
                                                               aria-haspopup="true"
                                                               aria-expanded="false">
                                                           @lang('wiki::wiki.index.hanhdong')
                                                       </button>
                                                       <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                                                           <a class="dropdown-item"
                                                              href="{{route('wiki.category.edit',['id' => $value['id']])}}">
                                                               <i class="la la-edit"></i>
                                                               @lang('wiki::wiki.index.chinhsua')
                                                           </a>
                                                           <a href="javascript:void(0)" onclick="category.delete('{{$value['id']}}')"
                                                              class="dropdown-item">
                                                               <i class="la la-trash"></i>
                                                               @lang('wiki::wiki.index.xoa')
                                                           </a>
                                                       </div>
                                                   </div>
                                               </td>
                                           </tr>
                                       @endforeach
                                   @else
                                       <tr >
                                           <td colspan="12" class="text-center">
                                               @lang('ticket::ticket.table.data_null')
                                           </td>
                                       </tr>
                                   @endif
                                   </tbody>
                               </table>
                           </div>
                        </div>
                        {{ $list->appends($filter)->links('helpers.paging') }}
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
@section('after_script')
    <script>
        console.log(document.domain);
        var xacnhanxoa = '@lang('wiki::wiki.index.xacnhanxoa')';
        var textCategory = '@lang('wiki::wiki.index.textCategory')';
        var xacnhan = '@lang('wiki::wiki.index.xacnhan')';
        var huy = '@lang('wiki::wiki.index.huy')';
    </script>
    <script type="text/javascript" src="{{ asset('static/backend/js/wiki/knowledge-base.js?v='.time()) }}"></script>
@endsection
