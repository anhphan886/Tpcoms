@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">@lang('ticket::ticket.index.ticket')</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            @include('helpers.button', ['button' => [
                'route' => 'ticket.create',
                'html' => '<a href="'.route('ticket.create').'" class="btn btn-label-brand btn-bold">'
                .__('ticket::ticket.input.button_add').
            '</a>'
            ]])
        </div>
    </div>
    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-filter" action="{{route('ticket.index')}}">
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <input type="text" class="form-control"
                                   name="keyword_portal_ticket$ticket_code"
                                   placeholder="@lang('ticket::ticket.input.input_placeholder_ticket_code')"
                                   value="{{ $filter['keyword_portal_ticket$ticket_code'] ?? null }}">
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="text" class="form-control"
                                   name="keyword_portal_ticket$ticket_title"
                                   placeholder="@lang('ticket::ticket.input.input_placeholder_ticket_title')"
                                   value="{{ $filter['keyword_portal_ticket$ticket_title'] ?? null }}">
                        </div>
                        <div class="form-group col-lg-3">
                            <select class="form-control kt-select2"  id="issue" name="portal_ticket$issue_id">
                                <option value="">@lang('ticket::ticket.input.select_placeholder_issue')</option>
                                @if (isset($listIssue) && count($listIssue) > 0)
                                    @foreach ($listIssue as $item)
                                        <option value="{{ $item['portal_ticket_issue_id'] }}"
                                                @if (isset($filter['portal_ticket$issue_id'])
                                                && $filter['portal_ticket$issue_id'] == $item['portal_ticket_issue_id'])
                                                selected
                                                @endif>
                                            {{ subString($item[getValueByLang('issue_name_')]) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <select class="form-control kt-select2"  id="queue" name="portal_ticket$queue_process_id">
                                <option value="">@lang('ticket::ticket.input.select_placeholder_queue')</option>
                                @if (isset($listQueue) && count($listQueue) > 0)
                                    @foreach ($listQueue as $item)
                                        <option value="{{ $item['ticket_queue_id'] }}"
                                                @if (isset($filter['portal_ticket$queue_process_id'])
                                                && $filter['portal_ticket$queue_process_id'] == $item['ticket_queue_id'])
                                                selected
                                                @endif>
                                            {{ subString($item['queue_name'])  }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-lg-3">
                            <select class="form-control kt-select2" id="status" name="portal_ticket$ticket_status_value">
                                <option value="">@lang('ticket::ticket.input.select_placeholder_status')</option>
                                @if (isset($listStatus) && count($listStatus) > 0)
                                    @foreach ($listStatus as $item)
                                        <option value="{{ $item['ticket_status_value'] }}"
                                                @if (isset($filter['portal_ticket$ticket_status_value'])
                                                && $filter['portal_ticket$ticket_status_value'] == $item['ticket_status_value'])
                                                selected
                                            @endif>
                                            {{ $item['ticket_status_name'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-lg-3">
                            <select class="form-control kt-select2" id="date_expected" name="date_expected">
                                <option value="" selected>Chọn trạng thái</option>
                                <option value="1" @if(isset($filter['date_expected'])
                                && $filter['date_expected'] == 1) selected
                                    @endif>Quá hạn</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-3 text-align-right-mobile">
                            <a class="btn btn-secondary btn-hover-brand" href="{{route('ticket.index')}}">
                                @lang('core::admin-group.button_remove')
                            </a>
                            <button type="submit" class="btn btn-primary btn-hover-brand">
                                @lang('core::admin-group.button_search')
                            </button>
                        </div>
                    </div>
                    <div class="kt-section">
                        @include('ticket::ticket.list')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script>
        $(document).ready(function () {
            $('#issue').select2({});
            $('#queue').select2({});
            $('#status').select2({});
            $('#date_expected').select2({});
        });
    </script>
@endsection
