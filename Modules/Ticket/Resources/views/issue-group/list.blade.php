<div class ="row">
    <div class="col-lg-6"><h3>@lang('ticket::issue-group.index.list_issue')</h3> </div>
</div>
<hr>

<!------ content -->
<div class="form-group">
    <div class="kt-section__content">
        <div class="row">
            <div class="col-12">
                <div class="table_responsive">
                    <table class="table table-striped">
            <thead>
            <tr >
                <th>STT</th>
                <th>@lang('ticket::issue-group.table.issue_group_name')</th>
                <th>@lang('ticket::issue-group.table.queue')</th>
                <th>@lang('ticket::issue-group.table.date_created')</th>
                <th>@lang('ticket::issue-group.table.create_by')</th>
                <th>@lang('ticket::issue-group.table.date_updated')</th>
                <th>@lang('ticket::issue-group.table.update_by')</th>
                <th>@lang('ticket::issue-group.table.action')</th>
            </tr>
            </thead>
            <tbody>
        @if(isset($list) && $list->count()>0)
            @foreach($list as $key => $item)
            <tr>
                <td>{{ ($page-1)*10 + $key+1 }}</td>
                <td class="content_record"><p>{{$item[getValueByLang('issue_group_name_')]}}</p></td>
                <td>{{$item['queue_name']}}</td>
                <td>{{date('d/m/Y H:i:s', strtotime($item['date_created']))}}</td>
                <td>{{ $item['created_by']}}</td>
                <td>{{date('d/m/Y H:i:s', strtotime($item['date_modified']))}}</td>
                <td>{{$item['modified_by']}}</td>
                <td>
                    <div class="kt-portlet__head-toolbar">
                        <div class="btn-group" role="group">
                            <button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @lang('ticket::issue-group.table.action')
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                @include('helpers.button', ['button' => [
                                            'route' => 'ticket.issue-group.edit',
                                             'html' =>  '<a href="'.route('ticket.issue-group.edit', ['id' => $item['portal_ticket_issue_group_id']]).'"  class="dropdown-item">'
                                             .'<i class="la la-edit"></i>'
                                             .'<span class="kt-nav__link-text kt-margin-l-5">'.__('ticket::queue.index.edit').'</span>'.
                                        '</a>'
                                    ]])

                                @if (  $item['tkisgID'] != null || $item['is_system'] == 1 )
                                @else
                                    @include('helpers.button', ['button' => [
                                      'route' => 'ticket.issue-group.destroy',
                                      'html' => '<a href="javascript:void(0)" onclick="objIssueGroup.remove('.$item['portal_ticket_issue_group_id'].')" class="dropdown-item">'
                                      .'<i class="la la-trash"></i>'
                                      .'<span class="kt-nav__link-text kt-margin-l-5">'.__('ticket::issue-group.input.button_remove').'</span>'.
                                      '</a>'
                                      ]])
                                @endif
                            </div>

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
    </div>
</div>
{{{ $list->links('helpers.paging') }}}
