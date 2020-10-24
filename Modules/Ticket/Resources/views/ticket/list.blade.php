<div class="kt-section__content">
    <form id="form-filter" action="{{route('core.admin-group.index')}}">
        <div class="row">
            <div class="col-12">
                <div class="table_responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>@lang('ticket::ticket.table.ticket_no')</th>
                            <th>@lang('ticket::ticket.table.ticket_title')</th>
                            <th>@lang('ticket::ticket.table.ticket_issue')</th>
                            <th>@lang('ticket::ticket.table.ticket_queue')</th>
                            <th >@lang('ticket::ticket.table.ticket_status')</th>
                            <th>@lang('ticket::ticket.table.ticket_created_at')</th>
                            <th>@lang('ticket::ticket.table.ticket_updated_at')</th>
                            <th>@lang('ticket::ticket.table.ticket_action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($list) && $list->count() >0)
                            @foreach ($list as $no => $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('ticket.show', ['id' => $item['ticket_id']]) }}">{{ $item['ticket_code'] }}</a>
                                    </td>
                                    <td class="content_record"><p>{{ $item['ticket_title'] }}</p></td>
                                    <td class="content_record"><p>{{ $item[getValueByLang('issue_name_')] }}</p></td>
                                    <td class="content_record"><p>{{ $item['queue_name'] }}</p></td>
                                    <td class="text-right">
                                        @switch ($item['ticket_status_value'])
                                            @case (1)
                                            <span class="kt-badge kt-badge--inline kt-badge--primary">{{ $item['ticket_status_name'] }}</span>
                                            @break
                                            @case (2)
                                            <span class="kt-badge kt-badge--inline kt-badge--warning">{{ $item['ticket_status_name'] }}</span>
                                            @break
                                            @case (3)
                                            <span class="kt-badge kt-badge--inline kt-badge--success">{{ $item['ticket_status_name'] }}</span>
                                            @break
                                            @case (4)
                                            <span class="kt-badge kt-badge--inline kt-badge--dark">{{ $item['ticket_status_name'] }}</span>
                                            @break
                                            @case (5)
                                            <span class="kt-badge kt-badge--inline kt-badge--danger">{{ $item['ticket_status_name'] }}</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td>
                                        {{  date('d/m/Y H:i:s', strtotime($item['date_created'])) }}
                                    </td>
                                    <td>
                                        {{  date('d/m/Y H:i:s', strtotime($item['date_modified'])) }}
                                    </td>
                                    <td>
                                        <div class="kt-portlet__head-toolbar">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    @lang('ticket::issue.table.action')
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                    @include('helpers.button', ['button' => [
                                                                 'route' => 'core.admin-group.edit',
                                                                 'html' =>  '<a href="'.route('ticket.edit', ['id' => $item['ticket_id']]).'"  class="dropdown-item">'
                                                                 .'<i class="la la-edit"></i>'
                                                                 .'<span class="kt-nav__link-text kt-margin-l-5">'.__('ticket::queue.index.edit').'</span>'.
                                                            '</a>'
                                                        ]])
                                                </div>
                                            </div>
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
        @if (isset($list) && $list->count() > 0)
            {{ $list->appends($filter)->links('helpers.paging') }}
        @else
            @php
                $listOption = [10, 20, 30, 50, 100, ];
                $selected = (isset($_GET['perpage'])) ? $_GET['perpage'] : 10;
                $frm = isset($frm) ? $frm : 'form-filter';
                $displaySelect = isset($display) ? $display : true;
            @endphp
            <div class="kt-pagination kt-pagination--brand kt-pagination--circle">
                <div class="kt-pagination__toolbar">
                    @if ($displaySelect)
                        <select class="form-control kt-font-brand"
                                name="perpage" onchange="filterDisplay('{{ $frm }}')" style="width: 60px">
                            @foreach ($listOption as $option)
                                <option value="{{ $option }}" {{ $selected == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    @endif
                    <span class="m-datatable__pager-detail">Hiển thị {{ 0 }} - {{ 0 }} của {{ 0 }}</span>
                </div>
            </div>
        @endif
    </form>
</div>


