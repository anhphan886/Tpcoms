<div class="form-group">
    <div class="kt-section__content">
        <div class="table_responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>@lang('core::user.index.ACCOUNT')</th>
                    <th>@lang('core::user.index.FULL_NAME')</th>
                    <th>@lang('core::user.index.STATUS')</th>
                    <th>@lang('core::user.index.ACTION')</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($LIST) && $LIST->count() > 0)
                    @foreach($LIST as $item)
                        <tr>
                            <td>
                                <a href="{{route('core.user.edit', ['id' => $item['id']])}}"
                                   title="{{ $item['email'] }}">
                                    {{ subString($item['email']) }}
                                </a>
                            </td>
                            <td>
                                <p title="{{ $item['full_name'] }}">{{ subString($item['full_name']) }}</p>
                            </td>
                            <td>
                            <span class="kt-switch kt-switch--success">
                                <label>
                                    <input type="checkbox" name="" onchange="Add.change_status('{{$item['id']}}',this)"
                                           @if($item['is_actived'] == 1) checked @endif>
                                    <span></span>
                                </label>
                            </span>
                            </td>
                            <td data-field="Actions" class="kt-datatable__cell" style="width: 200px;">
                                <div class="kt-portlet__head-toolbar">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @lang('core::user.index.ACTION')
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                        <!-- @include('helpers.button', ['button' => [
                                                  'route' => 'core.user.show-reset-password',
                                                   'html' => '<a href="javascript:void(0)" onclick="list.resetPass('.$item['id'].')" class="dropdown-item">'
                                                   .'<i class="la la-refresh"></i>'
                                                   .'<span class="kt-nav__link-text kt-margin-l-5">'
                                                       .__('core::user.index.RESET_PASSWORD').
                                                   '</span>'.
                                              '</a>'
                                          ]]) -->
                                            @include('helpers.button', ['button' => [
                                                        'route' => 'core.user.edit',
                                                         'html' => '<a href="'.route('core.user.edit', ['id' => $item['id']]).'" class="dropdown-item">'
                                                         .'<i class="la la-edit"></i>'
                                                         .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::user.index.EDIT_ACCOUNT').'</span>'.
                                                    '</a>'
                                                ]])
                                            {{--                                        @include('helpers.button', ['button' => [--}}
                                            {{--                                                   'route' => 'core.user.destroy',--}}
                                            {{--                                                    'html' => '<a href="javascript:void(0)" onclick="list.remove('.$item['id'].')" class="dropdown-item">'--}}
                                            {{--                                                    .'<i class="la la-trash"></i>'--}}
                                            {{--                                                    .'<span class="kt-nav__link-text kt-margin-l-5">'--}}
                                            {{--                                                        .__('core::user.index.REMOVE').--}}
                                            {{--                                                    '</span>'.--}}
                                            {{--                                               '</a>'--}}
                                            {{--                                           ]])--}}

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
{{ $LIST->links('helpers.paging') }}
