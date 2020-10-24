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
    <form action="{{ route('ticket.issue.update') }}" method="POST" id="form-submit-queue">
        {{ csrf_field() }}
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('ticket::queue.index.edit_queue')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <button type="button" class="btn btn-info btn-bold" onclick="objQueue.save(1)">
                    @lang('ticket::queue.input.button_save')
                </button>
                <a href="{{route('ticket.queue.index')}}" class="btn btn-secondary btn-bold">
                    @lang('ticket::queue.input.button_Cancel')
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
                                <label class="col-form-label">@lang('ticket::queue.table.queue_name')</label>
                                <input type="text" id="queue_name" name="queue_name" class="form-control"
                                       value="{{$detail['queue_name']}}">
                                <input type="hidden" id="ticket_queue_id" name="ticket_queue_id" class="form-control"
                                       value="{{$detail['ticket_queue_id']}}">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">@lang('ticket::queue.table.description')</label>
                                <textarea id="description" rows="5" name="description" class="form-control">{{$detail['description']}}</textarea>
{{--                                <input type="text" id="description" name="description" class="form-control"--}}
{{--                                       value="{{$detail['description']}}">--}}
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">@lang('ticket::queue.index.email-reply')</label>
                                <input type="text" id="email_address" name="email_address" class="form-control"
                                       value="{{$detail['email_address']}}">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('ticket::queue.index.operator')
                                </label>
                                <div>
                                    <select class="form-control ss-select-2" id="ss-select-2" name="staff_operator[]"
                                            multiple="multiple">
                                        <optgroup>
                                            @if (isset($listAdmin))
                                                @foreach( $listAdmin as $item)
{{--                                                    @if ( $operator != null)--}}
                                                        <option value="{{$item['id']}}" {{in_array($item['id'], $operator) ? 'selected' : '' }} >
                                                            {{ $item['full_name'] }}
                                                        </option>
{{--                                                    @endif--}}
                                                @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">
                                    @lang('ticket::queue.index.processor')
                                </label>
                                <div>
                                    <select class="form-control ss-select-2" id="ss-select-3" name="staff_processor[]"
                                            multiple="multiple">
                                        <optgroup>
                                            @if (isset($listAdmin))
                                                @foreach( $listAdmin as $item)
                                                    <option value="{{$item['id']}}" {{in_array($item['id'], $processor) ? 'selected' : '' }} >
                                                        {{ $item['full_name'] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
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
    <script src="{{asset('static/backend/js/ticket/queue/script.js?v='.time())}}" type="text/javascript"></script>
    <script>
        // Initialization
        jQuery(document).ready(function () {
            $('select').select2();
        });
    </script>
@endsection
