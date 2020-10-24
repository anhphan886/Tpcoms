@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    @if (isset($detail))
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        @lang('ticket::ticket.index.detail_ticket')
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">
                    </div>
                </div>

                <h3 class="kt-subheader__title">
                    Ticket No: {{ $detail['ticket_code'] }}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
{{--                    <span class="kt-subheader__desc" id="kt_subheader_total">--}}
{{--                        {{ $detail['ticket_title'] }}--}}
{{--                    </span>--}}
                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                @include('helpers.button', ['button' => [
                    'route' => 'ticket.edit',
                    'html' => '<a href="'.route('ticket.edit', ['id' => $detail['ticket_id']]).'" class="btn btn-label-brand btn-bold">'
                    .__('ticket::ticket.input.button_edit').
                '</a>'
                ]])
                <a href="{{ route('ticket.index') }}" class="btn btn-bold btn-secondary">@lang('ticket::ticket.input.button_cancel')</a>
            </div>
        </div>
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
<!-- tungntn -->
            <div class="kt-portlet kt-portlet--tabs">

                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            @lang('ticket::ticket.index.title') : <span class="custome-text-hy">{{ $detail['ticket_title'] }}</span>
                        </h3>
                    </div>
                </div>
            </div>
<!-- !tungnt -->
            <div class="kt-portlet kt-portlet--tabs">

                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            @lang('ticket::ticket.index.ticket_description'):
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">@lang('ticket::ticket.index.ticket_customer'):</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" disabled value="{{ $detail['customer_no'] }} - {{ $detail['customer_name'] }}">
                                        <input type="hidden" name="order_id" id="order_id" value="{{$detail['order_id']}}}}">
                                    </div>
                                </div>
                            </div>
                            @if( isset($detail['order_code']) && $detail['order_code'] != null )
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Đơn hàng</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" disabled name="order_code" id="order_code"
                                                   value="{{$detail['order_code']}}">
                                            <a href="{{route('product.order.detail', ['id' => $detail['order_code']])}}" target="_blank" class="input-group-text">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                        <input type="hidden" name="customer_service_id" id="customer_service_id" value="">
                                        <div class="form-text"></div>
                                    </div>
                                </div>
                            @else
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">@lang('ticket::ticket.index.ticket_service'):</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <input type="text" disabled class="form-control" value="{{ $detail[getValueByLang('product_name_')] }}">
                                            <input type="hidden" value="{{ $detail['customer_service_id'] }}" id="customer_service_id">
                                            @if(isset($detail['customer_service_id']))
                                                <a href="{{route('product.service.show', ['id' => $detail['customer_service_id']])}}" target="_blank" class="input-group-text">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endif
                                        </div>
                                        <p>Thông tin dịch vụ</p>
                                        <pre><div class="form-text info-bar" id="attribute-service"></div></pre>
{{--                                        <p>Nội dung dịch vụ</p>--}}
{{--                                        <pre><div class="form-text info-bar" id="info-service"></div></pre>--}}

                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-6">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_group_issue'):</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control kh-input-p" disabled value="{{ subString($detail[getValueByLang('issue_group_name_')]) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_issue'):</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control kh-input-p" disabled value="{{ subString($detail[getValueByLang('issue_name_')]) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="fa fa-plus"></i> @lang('ticket::ticket.index.ticket_info'):
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label" for="ticket_title">@lang('ticket::ticket.index.ticket_date_issue'):</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" disabled value=" {{date('d/m/Y H:i:s', strtotime($detail['date_issue'])) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" col-lg-12 col-form-label" for="ticket_title">@lang('ticket::ticket.index.ticket_date_estimated'):</label>
                                <div class="input-group">
                                    <input type="text" disabled class="form-control"
                                   value="@if ($detail['date_estimated'] == '0000-00-00 00:00:00' || $detail['date_estimated'] == null){{date('d/m/Y H:i:s', strtotime($detail['date_expected'])) }}@else{{date('d/m/Y H:i:s', strtotime($detail['date_estimated'])) }}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="ticket_title">@lang('ticket::ticket.index.date_expected'):</label>
                                <div class="input-group">
                                    <input type="text" disabled class="form-control" value="{{date('d/m/Y H:i:s', strtotime($detail['date_expected'])) }}">
                                </div>
                            </div>
                            @if( $detail['ticket_status_name'] == 'Hoàn tất')
                                <div class="form-group">
                                    <label class="col-form-label" for="ticket_title">@lang('ticket::ticket.index.time_ticket'):</label>
                                    <div class="input-group">
                                        <input type="text" disabled class="form-control" value="{{date('d/m/Y H:i:s', strtotime($detail['date_finished']))}}">
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="col-form-label" for="ticket_title">@lang('ticket::ticket.index.ticket_status'):</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" disabled value="{{ $detail['ticket_status_name'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="description">@lang('ticket::ticket.index.ticket_note'):</label>
                                <textarea name="description" disabled class="form-control" rows="10">{{ $detail['description'] }}</textarea>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group ">
                                <label class="col-lg-5 col-form-label">@lang('ticket::ticket.index.kh_create'):</label>
                                <div class="col-lg-12">
                                    <input type="text" disabled class="form-control" value="{{ $detail['customer_name'] }}">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-lg-5 col-form-label">@lang('ticket::ticket.index.ticket_created_by'):</label>
                                <div class="col-lg-12">
                                    <input type="text" disabled class="form-control"
                                           @if($detail['type'] == 'staff_consult')
                                           value="{{ $detail['modified_by_name'] }}"
                                               @else
                                            value="{{ $detail['created_by_name'] }}"
                                           @endif>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-lg-5 col-form-label">@lang('ticket::ticket.index.tk_kh_create'):</label>
                                <div class="col-lg-12">
                                    <input type="text" disabled class="form-control"
                                           @if( $detail['type'] == 'staff_deploy')
                                           @else
                                            value="{{ $detail['account_name'] }}"
                                           @endif>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_queue'):</label>
                                <div class="col-lg-12">
                                    <input type="text" disabled class="form-control" value="{{ $detail['queue_name'] }}">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_operate_by'):</label>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <select disabled class="form-control">
                                            <option value="">@lang('ticket::ticket.input.select_placeholder_staff')</option>
                                            @if ($listOperator != null)
                                                @foreach ($listOperator as $item)
                                                    <option value="{{ $item['id'] }}" {{ $item['id'] == $detail['operate_by'] ? 'selected' : '' }}>
                                                        {{ $item['full_name'] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_processor'):</label>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <select class="form-control select-2" multiple disabled>
                                            <option value="0">@lang('ticket::ticket.input.select_placeholder_staff')</option>
                                            @if ($listProcessor != null)
                                                @foreach ($listProcessor as $item)
                                                    <option value="{{ $item['id'] }}" {{ in_array($item['id'], $processors) ? 'selected' : '' }}>
                                                        {{ $item['full_name'] }}
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
            </div>

            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="fa fa-plus"></i> @lang('ticket::ticket.index.ticket_file'):
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    @if (isset($ticketFile))
                        @foreach ($ticketFile as $item)
                        <div class="row">
                                <div class="col-12">
                                    <a href="{{ $item['link_file'] }}" target="_blank" download>{{ $item['file_name'] }}</a>
                                    <hr>
                                </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="kt-portlet kt-portlet--tabs">
                @include('ticket::ticket.partial.tabs')
            </div>
        </div>
    @endif
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/ticket/script.js?v='.time()) }}"></script>
    <script type="text/javascript">
        objTicket.init()
    </script>
@endsection
