@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main col-12 col-md-6">
            <h3 class="kt-subheader__title">
                @lang('ticket::ticket.index.dashboard')
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar col-12 col-md-6 text-align-right">
            @include('helpers.button', ['button' => [
            'route' => 'ticket.create',
            'html' => '<a href="'.route('ticket.create').'" class="btn btn-label-brand btn-bold">'
            .__('ticket::ticket.input.button_add').
            '</a>'
            ]])
        </div>
    </div>
    <div class="kt-content kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-4">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    <a href="{{route('ticket.index')}}">
                                    @lang('ticket::ticket.index.ticket'): {{ (isset($listTicket)) ? count($listTicket) : 0 }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="kt-widget1">
                            <div class="kt-widget1__item">
                                <div class="col-12">
                                    <h3>
                                        <div class="progress progress-lg">
                                            <div class="progress-bar kt-bg-success"
                                                 role="progressbar"
                                                 style="width: {{ $countTicket['new_percent'] }}%;"
                                                 aria-valuenow="{{ $countTicket['new'] }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </h3>
                                </div>
                            </div>

                            <div class="kt-widget1__item">
                                <div class="col-12">
                                    <h3>
                                        <div class="progress progress-lg">
                                            <div class="progress-bar kt-bg-warning"
                                                 role="progressbar"
                                                 style="width: {{ $countTicket['in_process_percent'] }}%;"
                                                 aria-valuenow="{{ $countTicket['in_process'] }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </h3>
                                </div>
                            </div>

                            <div class="kt-widget1__item">
                                <div class="col-12">
                                    <h3>
                                        <div class="progress progress-lg">
                                            <div class="progress-bar kt-bg-danger"
                                                 role="progressbar"
                                                 style="width: {{ $countTicket['out_of_date_percent'] }}%;"
                                                 aria-valuenow="{{ $countTicket['out_of_date'] }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </h3>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-4">
                        <div class="kt-widget1">
                            <div class="kt-widget1__item">
                                <div class="kt-widget1__info">
                                    <h3 class="kt-widget1__title">
                                        <a style="color: #0abb87" href="{{ route('ticket.index', ['portal_ticket$ticket_status_value' => 1]) }}">
                                            @lang('ticket::ticket.index.status_new')
                                        </a>
                                    </h3>
                                </div>
                                <a href="{{ route('ticket.index', ['portal_ticket$ticket_status_value' => 1]) }}">
                                <span class="kt-widget1__number kt-font-success">{{ $countTicket['new'] }}</span>
                                </a>
                            </div>

                            <div class="kt-widget1__item">
                                <div class="kt-widget1__info">
                                    <h3 class="kt-widget1__title">
                                        <a style="color: #ffb822" href="{{ route('ticket.index', ['portal_ticket$ticket_status_value' => 2]) }}">
                                            @lang('ticket::ticket.index.status_in_process')
                                        </a>
                                    </h3>
                                </div>
                                <a href="{{ route('ticket.index', ['portal_ticket$ticket_status_value' => 2]) }}">
                                <span class="kt-widget1__number kt-font-warning">{{ $countTicket['in_process'] }}</span>
                                </a>
                            </div>

                            <div class="kt-widget1__item">
                                <div class="kt-widget1__info">
                                        <h3 class="kt-widget1__title">
                                            <a style="color: #fa4266" href="{{ route('ticket.index', ['date_expected' => 1]) }}">
                                              @lang('ticket::ticket.index.status_out_of_date')
                                            </a>
                                        </h3>

                                </div>
                                <a href="{{ route('ticket.index', ['date_expected' => 1]) }}">
                                    <span class="kt-widget1__number kt-font-danger">{{ $countTicket['out_of_date'] }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    @lang('ticket::ticket.index.personal'):
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget1">
                                <div class="kt-widget1__item">
                                    <div class="kt-widget1__info">
                                        <h3 class="kt-widget1__title kt-font-primary">@lang('ticket::ticket.index.my')</h3>
                                    </div>
                                    <a href="{{ route('ticket.index', ['process_by' => Auth::id()]) }}">
                                        <span style="color: #004fa3;" class="kt-widget1__number">{{ $countTicket['my_ticket']['mine'] }}</span>
                                    </a>
                                </div>
                                <div class="kt-widget1__item">
                                    <div class="kt-widget1__info">
                                            <h3 class="kt-widget1__title kt-font-success">@lang('ticket::ticket.index.status_in_process')</h3>
                                    </div>
                                    <a href="{{ route('ticket.index', ['process_by' => Auth::id(), 'in_process' => 2]) }}">
                                        <span style="color: #0abb87" class="kt-widget1__number">{{ $countTicket['my_ticket']['in_process'] }}</span>
                                    </a>
                                </div>
                                <div class="kt-widget1__item">
                                    <div class="kt-widget1__info">
                                        <h3 class="kt-widget1__title">@lang('ticket::ticket.index.total')</h3>
                                    </div>
                                    <a href="{{ route('ticket.index', ['process_by' => Auth::id()]) }}">
                                        <span class="kt-widget1__number">{{ $countTicket['my_ticket']['mine'] }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    @lang('ticket::ticket.index.queue'):
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-section">
                                <div class="kt-section__content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table_responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr class="table-active text-center kh-text-al">
                                            <th >@lang('ticket::ticket.table.queue_name')</th>
                                            <th >@lang('ticket::ticket.table.queue_status_new')</th>
                                            <th >@lang('ticket::ticket.table.queue_status_in_process')</th>
                                            <th>@lang('ticket::ticket.table.queue_status_finish')</th>
                                        </tr>
                                        </thead>
                                        <tbody class="kh-text-al">
                                        @if (isset($listQueue) && count($listQueue) >0)
                                            @foreach ($listQueue as $no => $item)
                                                <tr>
                                                    <td class="text-center">{{subString($item['queue_name'])  }}</td>
                                                    <td class="text-center">
                                                        @php
                                                            $countNew = 0;
                                                        @endphp
                                                        @if (count($item['tickets']) > 0)
                                                            @foreach ($item['tickets'] as $key => $ticket)
                                                                @if ($ticket['ticket_status_value'] == 1)
                                                                    @php
                                                                        $countNew++;
                                                                        unset($item['tickets'][$key]);
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <a href="{{ route('ticket.index', [
                                                            'portal_ticket$ticket_status_value' => 1,
                                                            'portal_ticket$queue_process_id' => $item['ticket_queue_id'],
                                                            ]) }}">
                                                            <span class="text-primary">{{ $countNew }}</span>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $countInProcess = 0;
                                                        @endphp
                                                        @if (count($item['tickets']) > 0)
                                                            @foreach ($item['tickets'] as $key => $ticket)
                                                                @if ($ticket['ticket_status_value'] == 2)
                                                                    @php
                                                                        $countInProcess++;
                                                                        unset($item['tickets'][$key]);
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <a href="{{ route('ticket.index', [
                                                            'portal_ticket$ticket_status_value' => 2,
                                                            'portal_ticket$queue_process_id' => $item['ticket_queue_id'],
                                                            ]) }}">
                                                            <span class="text-warning">{{ $countInProcess }}</span>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $countFinsh = 0;
                                                        @endphp
                                                        @if (count($item['tickets']) > 0)
                                                            @foreach ($item['tickets'] as $key => $ticket)
                                                                @if ($ticket['ticket_status_value'] == 3)
                                                                    @php
                                                                        $countFinsh++;
                                                                        unset($item['tickets'][$key]);
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <a href="{{ route('ticket.index', [
                                                            'portal_ticket$ticket_status_value' =>3,
                                                            'portal_ticket$queue_process_id' => $item['ticket_queue_id'],
                                                            ]) }}">
                                                            <span class="text-success">{{ $countFinsh }}</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    @lang('ticket::ticket.table.data_null')
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet kt-portlet--tabs">
            <form action="" method="GET" id="form-filter">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            @lang('ticket::ticket.index.new_ticket'):
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <select class="form-control" name="portal_ticket$queue_process_id" id="queue_process_id">
                                    <option value="">@lang('ticket::ticket.input.select_placeholder_queue')</option>
                                    @if (isset($listQueue) && count($listQueue) > 0)
                                        @foreach ($listQueue as $item)
                                            <option value="{{ $item['ticket_queue_id'] }}"
                                                    @if (isset($filter['portal_ticket$queue_process_id'])
                                                    && $filter['portal_ticket$queue_process_id'] == $item['ticket_queue_id'])
                                                    selected
                                                @endif>
                                                {{subString($item['queue_name'])}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-12">
                            <div class="kt-section">
                                <div class="kt-section__content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table_responsive">
                                    <table class="table table-striped">
                                        <thead class="kh-text-al">
                                        <tr>
                                            <th>STT</th>
                                            <th>@lang('ticket::ticket.table.ticket_no')</th>
                                            <th>@lang('ticket::ticket.table.ticket_title')</th>
                                            <th>@lang('ticket::ticket.table.ticket_issue')</th>
                                            <th>@lang('ticket::ticket.table.ticket_queue')</th>
                                            <th>@lang('ticket::ticket.table.ticket_time')</th>
                                            <th>@lang('ticket::ticket.table.ticket_level')</th>
                                            <th>@lang('ticket::ticket.table.ticket_assign')</th>
                                        </tr>
                                        </thead>
                                        <tbody class="kh-text-al">
                                        @if (isset($listTicketNotAssigned) && $listTicketNotAssigned->count() >0)
                                            @foreach ($listTicketNotAssigned as $no => $item)
                                                <tr>
                                                    <td> {{($filter['page'] - 1) * $perpage + $no + 1}}</td>
                                                    <td>
                                                        <a href="{{ route('ticket.show', ['id' => $item['ticket_id']]) }}">{{ $item['ticket_code'] }}</a>
                                                    </td>
                                                    <td>{{ subString($item['ticket_title']) }}</td>
                                                    <td>{{subString($item[getValueByLang('issue_name_')])  }}</td>
                                                    <td>{{ subString($item['queue_name']) }}</td>
                                                    <td>
                                                        {{ date('d/m/Y H:i:s', strtotime($item['date_issue'])) }}
                                                    </td>
                                                    <td>{{ $item['issue_level'] }}</td>
                                                    <td>
                                                        @include('helpers.button', ['button' => [
                                                        'route' => 'core.admin-group.edit',
                                                        'html' => '<a href="'.route('ticket.edit', ['id' => $item['ticket_id']]).'">'
                                                        .'<i class="fa fa-edit"></i></a>'
                                                        ]])
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="12" class="text-center">
                                                    @lang('ticket::ticket.table.data_null')
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (isset($listTicketNotAssigned) && $listTicketNotAssigned->count() > 0)
                                    {{ $listTicketNotAssigned->appends($filter)->links('helpers.paging') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/ticket/script.js?v='.time()) }}"></script>
    <script type="text/javascript">
        objTicket.init()
    </script>
@endsection
