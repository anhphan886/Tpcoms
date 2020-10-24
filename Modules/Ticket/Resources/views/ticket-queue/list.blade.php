<div class ="row">
    <div class="col-lg-6"><h3>@lang('ticket::queue.index.list_queue')</h3> </div>
</div>
<hr>
<div class="form-group">
    <div class="kt-section__content">
        <div class="row">
            <div class="col-12">
                <div class="table_responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr >
                            <th>#</th>
                            <th>@lang('ticket::queue.table.queue_name')</th>
                            <th>@lang('ticket::queue.table.description')</th>
                            <th>@lang('ticket::queue.table.email_address')</th>
                            <th>@lang('ticket::queue.table.created_by')</th>
                            <th>@lang('ticket::queue.table.date_created')</th>
                            <th>@lang('ticket::queue.table.modified_by')</th>
                            <th>@lang('ticket::queue.table.date_modified')</th>
                            <th>@lang('ticket::queue.table.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($LIST) && $LIST->count()>0)
                            <?php $tmp = ($LIST->currentPage()*$LIST->perPage()) - $LIST->perPage() + 1 ?>
                            @foreach($LIST as $key => $item)
                                <tr>
{{--                                    <td>{{ ($page-1)*10 + $key+1}}</td>--}}
                                    <td>{{$tmp++}}</td>
                                    <td class="content_record"><p>{{ $item['queue_name']}}</p></td>
                                    <td class="content_record"><p>{{$item['description']}}</p></td>
                                    <td>{{$item['email_address']}}</td>
                                    <td>{{$item['created_by']}}</td>
                                    <td>{{date('d/m/Y H:i:s', strtotime($item['date_created']))}}</td>
                                    <td>{{$item['modified_by']}}</td>
                                    <td>{{date('d/m/Y H:i:s', strtotime($item['date_modified']))}}</td>
                                    <td>
                                        <div class="kt-portlet__head-toolbar">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Hành động
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                    @include('helpers.button', ['button' => [
                                                                'route' => 'ticket.queue.edit',
                                                                 'html' => '<a href="'.route('ticket.queue.edit', ['id' => $item['ticket_queue_id']]).'" class="dropdown-item">'
                                                                 .'<i class="la la-edit"></i>'
                                                                 .'<span class="kt-nav__link-text kt-margin-l-5">'.__('ticket::queue.index.edit').'</span>'.
                                                            '</a>'
                                                        ]])
                                                    @if ($item['queue_process_id'] == null && $item['queue_id'] == null )
                                                        @include('helpers.button', ['button' => [
                                                                  'route' => 'ticket.queue.destroy',
                                                                  'html' => '<a href="javascript:void(0)" onclick="objQueue.remove('.$item['ticket_queue_id'].')" class="dropdown-item">'
                                                                  .'<i class="la la-trash"></i>'
                                                                  .'<span class="kt-nav__link-text kt-margin-l-5">'.__('ticket::issue-group.input.button_remove').'</span>'.
                                                                  '</a>'
                                                                  ]])
                                                    @endif
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
        </div>
    </div>
</div>
{{ $LIST->links('helpers.paging') }}
