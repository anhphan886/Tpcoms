@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    @if (isset($detail))
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <div class="kt-subheader__main col-12 col-md-6">
                    <div class="kt-subheader__main">
                        <h3 class="kt-subheader__title">
                            @lang('ticket::ticket.index.update_ticket')
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
                <div class="kt-subheader__toolbar col-12 col-md-6 text-align-right">
                    <button type="button" class="btn btn-info btn-bold" onclick="objTicket.save()">
                        @lang('ticket::ticket.input.button_save_continue')
                    </button>
                    <button type="button" class="btn btn-info btn-bold" onclick="objTicket.save(1)">
                        @lang('ticket::ticket.input.button_save_quit')
                    </button>
                    <a href="{{ route('ticket.index') }}" class="btn btn-bold btn-secondary">@lang('ticket::ticket.input.button_cancel')</a>
                </div>

            </div>

            <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
                <div class="kt-portlet kt-portlet--tabs">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                @lang('ticket::ticket.index.title') : <span class="custome-text-hy">{{ $detail['ticket_title'] }}</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <form action="{{ route('ticket.update') }}" method="POST" id="form-submit">
                    {{ csrf_field() }}
                    <input type="hidden" name="ticket_id" id="ticket_id" value="{{ $detail['ticket_id'] }}">
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
                                <div class="col-12 col-md-6">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">@lang('ticket::ticket.index.ticket_customer'):</label>
                                        <div class="col-lg-8">
                                            <input type="hidden" name="order_id" id="order_id" value="{{$detail['order_id']}}">
                                            <div class="input-group">
                                                <select name="customer_account_id"  disabled id="customer_account_id" class="form-control select-2">
                                                    <option value="">@lang('ticket::ticket.input.select_placeholder_customer'):</option>
                                                    @if (isset($listCustomer) && count($listCustomer) > 0)
                                                        @foreach ($listCustomer as $item)
                                                            <option value="{{ $item['customer_id'] }}"
                                                                    {{ $detail['customer_id'] == $item['customer_id'] ? 'selected' : '' }}>
                                                                {{ $detail['customer_name'] }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-text info-bar" id="info-customer">
                                                <p>{{ $detail['customer_no'] }} - {{ $detail['customer_name'] }}</p>
                                                <p>{{ $detail['customer_phone'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if( isset($detail['order_code']) && $detail['order_code'] != null )
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Đơn hàng</label>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" readonly name="order_code" id="order_code"
                                                           value="{{$detail['order_code']}}">
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
                                                    <select name="{{$detail['type'] == 'staff_deploy' ? '' : 'customer_service_id'}}" id="{{$detail['type'] == 'staff_deploy' ? '' : 'customer_service_id'}}" class="form-control select-2" {{ $detail['type'] == 'staff_deploy'?'disabled':''}}>
                                                        <option value="">@lang('ticket::ticket.input.select_placeholder_service')</option>
                                                        @if (isset($listService) && count($listService) > 0)
                                                            @foreach ($listService as $item)
                                                                <option value="{{ $item['customer_service_id'] }}"
                                                                    {{ $detail['customer_service_id'] == $item['customer_service_id'] ? 'selected' : '' }}>
                                                                    {{ $item[getValueByLang('product_name_')] }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <pre><div class="form-text info-bar" id="info-service">
                                            </div></pre>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_group_issue'):</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" disabled value="{{ subString($detail[getValueByLang('issue_group_name_')]) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_issue')</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" disabled value="{{ subString($detail[getValueByLang('issue_name_')]) }}">
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
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label  class="col-form-label" for="ticket_title">@lang('ticket::ticket.index.ticket_date_issue'):</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control" disabled value=" {{date('d/m/Y H:i:s', strtotime($detail['date_issue'])) }}">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-form-label ">@lang('ticket::ticket.index.ticket_date_estimated'):</label>
                                        <div>
                                            <div class="input-group date">
                                                <input type="text"  class="form-control" readonly   name="date_estimated" id="kt_datepicker_2"
                                                       value="@if ($detail['date_estimated'] == '0000-00-00 00:00' || $detail['date_estimated'] == null){{date('d/m/Y H:i', strtotime($detail['date_expected'])) }}@else{{date('d/m/Y H:i', strtotime($detail['date_estimated'])) }}@endif">
                                                <div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar-check-o"></i>
														</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="ticket_title">@lang('ticket::ticket.index.date_expected'):</label>
                                        <div class="input-group">
                                            <input type="text" disabled class="form-control" value="{{date('d/m/Y H:i', strtotime($detail['date_expected'])) }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="ticket_title">@lang('ticket::ticket.index.ticket_status'):</label>
                                        <div class="input-group">
                                            <select class="form-control select-2" name="ticket_status_value" id="ticket_status_value">
                                                @if (isset($listStatus))
                                                    @foreach ($listStatus as $stt)
                                                        <option value="{{ $stt['ticket_status_value'] }}"
                                                        {{ $detail['ticket_status_value'] == $stt['ticket_status_value'] ? 'selected' : '' }}>
                                                            {{ $stt['ticket_status_name'] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="description">@lang('ticket::ticket.index.ticket_note'):</label>
                                        <textarea name="description" id="description" class="form-control" rows="10">{{ $detail['description'] }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group ">
                                        <label class="col-lg-5 col-form-label">@lang('ticket::ticket.index.kh_create'):</label>
                                        <div class="col-lg-12">
                                            <input type="text" disabled class="form-control" value="{{ $detail['customer_name'] }}">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_created_by'):</label>
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
                                        <label class="col-lg-3 col-form-label form-control-label">@lang('ticket::ticket.index.ticket_queue'):</label>
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <select name="queue_process_id" id="queue_process_id" class="form-control select-2">
                                                    <option value="">@lang('ticket::ticket.input.select_placeholder_queue'):</option>
                                                    @if (isset($listQueue) && count($listQueue) > 0)
                                                        @foreach ($listQueue as $item)
                                                            <option value="{{ $item['ticket_queue_id'] }}"
                                                            {{ $detail['queue_process_id'] == $item['ticket_queue_id'] ? 'selected' : '' }}>
                                                                {{ $item['queue_name'] }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-text"></div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_operate_by'):</label>
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <select name="operate_by" id="operate_by" class="form-control select-2">
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
                                                <select name="process_by_list[]" id="process_by_list"
                                                        class="form-control select-2" multiple
                                                        title="@lang('ticket::ticket.input.select_placeholder_staff')">
                                                    @if ($listProcessor != null)
                                                        @foreach ($listProcessor as $item)
                                                            <option value="{{ $item['id'] }}" {{in_array($item['id'], $processors) ? 'selected' : '' }}>
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
                </form>
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

        <div id="popup-modal"></div>
    @endif
@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/ticket/script.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('static/backend/js/ticket/uploadFileTicket.js?v='.time()) }}"></script>
    <script type="text/javascript">
        objTicket.init(`{{ getValueByLang('') }}`);
        objTicket.getIssueGroup();
        objTicket.selectQueueByIssue();
        objTicket.getInfoCustomer();
        objTicket.changeQueue();
        objTicket.checkDateEstimated();
        objTicket.getServices();
        objDropzone.init();

        $(document).ready(function () {
            var arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }

            $('#kt_datepicker_2').datetimepicker({
                rtl: KTUtil.isRTL(),
                format: 'dd/mm/yyyy h:i',
                // pickerPosition: 'bottom-left',
                todayHighlight: true,
                autoclose: true,
                arrows: true,
            });
        });
    </script>
@endsection
