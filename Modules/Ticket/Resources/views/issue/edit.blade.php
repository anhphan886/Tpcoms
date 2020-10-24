@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <form id="form-issue-submit" action="{{ route('ticket.issue.store') }}" method="POST" >
        {{ csrf_field() }}
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('ticket::issue.index.issue_edit')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <button type="button" class="btn btn-info btn-bold"  onclick="objIssue.save(1)">
                    @lang('ticket::issue.input.button_save')
                </button>

                <a href="{{route('ticket.issue.index')}}" class="btn btn-secondary btn-bold">
                    @lang('ticket::issue.input.button_cancel')
                </a>
            </div>
        </div>
        <!--begin: Datatable -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="col-form-label">@lang('ticket::issue.index.issue_group')</label>
                                <select class="form-control" disabled name="portal_ticket_issue_group_id" id="portal_ticket_issue_group_id">
                                    <option value="{{ $detail['portal_ticket_issue_group_id'] }}"> {{ $detail[getValueByLang('igname_')] }}</option>
{{--                                    @if (isset($listGroup) && $listGroup != null)--}}
{{--                                        @foreach ($listGroup as $item)--}}
{{--                                            <option value="{{ $item['portal_ticket_issue_group_id'] }}">--}}
{{--                                                {{ $item[getValueByLang('issue_group_name_')] }}--}}
{{--                                            </option>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">@lang('ticket::issue.index.issue_name_vi')</label>
                                <input type="text" disabled id="issue_name_vi" name="issue_name_vi" class="form-control" value="{{$detail['issue_name_vi']}}">
                                <input type="hidden" id="portal_ticket_issue_id" name="portal_ticket_issue_id" class="form-control" value="{{$detail['portal_ticket_issue_id']}}">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">@lang('ticket::issue.index.issue_name_en')</label>
                                <input type="text" disabled id="issue_name_en" name="issue_name_en" class="form-control"
                                     value="{{$detail['issue_name_en']}}">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">@lang('ticket::issue.index.queue')</label>
                                <select class="form-control"
                                        name="queue_id"
                                        id="queue_id">
{{--                                    <option value="{{$detail['ticket_queue_id']}}">{{ $detail['queue_name'] }}</option>--}}
                                    @if (isset($listQueue) && $listQueue != null)
                                        @foreach ($listQueue as $item)
                                            <option value="{{ $item['ticket_queue_id'] }}" {{$detail['ticket_queue_id'] == $item['ticket_queue_id'] ? "selected" :""}}>
                                                {{ $item['queue_name'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">@lang('ticket::issue.index.issue_level_id')</label>
                                <select class="form-control"
                                        name="portal_ticket_issue_level_id"
                                        id="portal_ticket_issue_level_id">
                                    <option value="{{$detail['portal_ticket_issue_level_id']}}">{{$detail['issue_level_value']}}</option>
                                    @if (isset($listLevel) && $listLevel != null)
                                        @foreach ($listLevel as $item)
                                            <option value="{{ $item['portal_ticket_issue_level_id'] }}">
                                                {{ $item['issue_level_value'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="form-group col-sm-6">
                                    <label for="process_time">@lang('ticket::issue.index.process_time')</label>
                                    <input type="text" name="process_time" id="process_time" class="form-control" value="{{$detail['process_time']}}">
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="crictical_time2">@lang('ticket::issue.index.crictical_time2')</label>
                                    <input type="text" name="crictical_time2" id="crictical_time2" class="form-control" value="{{$detail['crictical_time2']}}" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="crictical_time3">@lang('ticket::issue.index.crictical_time3')</label>
                                    <input type="text" name="crictical_time3" id="crictical_time3" class="form-control" value="{{$detail['crictical_time3']}}" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="crictical_time4">@lang('ticket::issue.index.crictical_time4')</label>
                                    <input type="text" name="crictical_time4" id="crictical_time4" class="form-control" value="{{$detail['crictical_time4']}}" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('after_script')
    <script src="{{asset('static/backend/js/ticket/issue/script.js?v='.time())}}" type="text/javascript"></script>
@endsection
