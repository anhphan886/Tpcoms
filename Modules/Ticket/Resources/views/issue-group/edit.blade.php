@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <style>
        .image-big {
            width: 200px !important;
            height: 200px !important;
        }
    </style>
    <form id="form-submit-edit" action="{{ route('ticket.issue-group.update') }}" method="POST" >
        {{ csrf_field() }}
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('ticket::issue-group.index.issue_group_edit')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <button type="button" class="btn btn-info btn-bold"  onclick="objIssueGroup.edit()">
                    @lang('ticket::issue-group.input.button_save')
                </button>
                <a href="{{route('ticket.issue-group.index')}}" class="btn btn-secondary btn-bold">
                    @lang('ticket::issue-group.input.button_cancel')
                </a>
            </div>
        </div>
        <!--begin: Datatable -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('ticket::issue-group.index.issue_group_name_vi')
                                </label>
                                <input type="text" id="issue_group_name_vi" disabled name="issue_group_name_vi" class="form-control"
                                 value="{{isset($detail) ? $detail['issue_group_name_vi'] : ""}}">
                                <input type="hidden" id="portal_ticket_issue_group_id" name="portal_ticket_issue_group_id" class="form-control"
                                       value="{{isset($detail) ? $detail['portal_ticket_issue_group_id'] : "" }}">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('ticket::issue-group.index.issue_group_name_en')
                                </label>
                                <input type="text" id="issue_group_name_en" disabled name="issue_group_name_en" class="form-control"
                                       value="{{isset($detail) ? $detail['issue_group_name_en'] : ""}}">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">@lang('ticket::issue.index.queue')</label>
                                <select class="form-control" name="queue_id" id="queue_id">
{{--                                    <option value="{{$detail['queue_id']}}">{{$detail['queue_name']}}</option>--}}
                                    @if (isset($listQueue) && $listQueue != null)
                                        @foreach ($listQueue as $item)
                                            <option value="{{ $item['ticket_queue_id'] }}" {{$detail['queue_id'] == $item['ticket_queue_id'] ? "selected" :""}}>
                                                {{ $item['queue_name'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('after_script')
    <script src="{{asset('static/backend/js/ticket/issue-group/script.js?v='.time())}}" type="text/javascript"></script>
@endsection
