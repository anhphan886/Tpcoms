@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <form action="{{ route('ticket.store') }}" method="POST" id="form-submit">
        {{ csrf_field() }}
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('ticket::ticket.index.ticket_create')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                @if(isset($param['order_id']) && $param['order_id'] != null)
                    <button type="button" class="btn btn-info btn-bold" onclick="objTicket.save2()">
                        @lang('ticket::ticket.index.save')
                    </button>
                    <a href="{{ route('product.order') }}" class="btn btn-bold btn-secondary">@lang('ticket::ticket.input.button_cancel')</a>
                @else
                    <button type="button" class="btn btn-info btn-bold" onclick="objTicket.save()">
                        @lang('ticket::ticket.input.button_save_create')
                    </button>
                    <button type="button" class="btn btn-info btn-bold" onclick="objTicket.save(1)">
                        @lang('ticket::ticket.input.button_save_quit')
                    </button>
                    <a href="{{ route('ticket.index') }}" class="btn btn-bold btn-secondary">@lang('ticket::ticket.input.button_cancel')</a>
                @endif
            </div>
        </div>
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
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
                                <label class="col-lg-4 col-form-label">@lang('ticket::ticket.index.ticket_customer')</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <select name="customer_id" id="customer_id" class="form-control select-2">
                                            <option value="">@lang('ticket::ticket.input.select_placeholder_customer')</option>
                                            @if(isset($param['customer_id']) && $param['customer_id'] != null)
                                                @if (isset($listCustomer) && count($listCustomer) > 0)
                                                    @foreach ($listCustomer as $item)
                                                        <option value="{{ $item['customer_id'] }}" {{$item['customer_id']==$param['customer_id'] ? "selected" : ""}} >
                                                            {{ $item['customer_name'] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @else
                                                @if (isset($listCustomer) && count($listCustomer) > 0)
                                                    @foreach ($listCustomer as $item)
                                                        <option value="{{ $item['customer_id'] }}">
                                                            {{ $item['customer_name'] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-text info-bar" id="info-customer" style="display: none;"></div>
                                </div>
                            </div>

                            @if( isset($param['order_name']) && $param['order_name'] != null )
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Đơn hàng</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" readonly name="order_code" id="order_code"
                                                   value="{{$param['order_name']}}">
                                                    <a href="{{route('product.order.detail', ['id' => $param['order_name']])}}" target="_blank" class="input-group-text">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                        </div>
                                        <input type="hidden" name="customer_service_id" id="customer_service_id" value="">
                                        <div class="form-text"></div>
                                    </div>
                                </div>
                            @else
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">@lang('ticket::ticket.index.ticket_service')</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <select name="customer_service_id" id="customer_service_id" class="form-control select-2">
                                                <option value="">@lang('ticket::ticket.input.select_placeholder_service')</option>
                                                @if (isset($listService) && count($listService) > 0)
                                                    @foreach ($listService as $item)
                                                        <option value="{{ $item['product_id'] }}">
                                                            {{ $item[getValueByLang('product_name_')] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-text"></div>
                                    </div>
                                    <input type="hidden" name="order_code" id="order_code" value="">
                                </div>
                            @endif

                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_group_issue')</label>
                                <div class="col-lg-9 input-group">
                                    <select  name="ticket_issue_group_id" id="ticket_issue_group_id" class="form-control select-2">
                                        <option value="">@lang('ticket::ticket.input.select_placeholder_group_issue')</option>
                                        @if(isset($param['customer_id']) && $param['customer_id'] != null)
                                            @if (isset($listIssueGroup) && count($listIssueGroup) > 0)
                                                @foreach ($listIssueGroup as $item)
                                                    <option value="{{ $item['portal_ticket_issue_group_id'] }}" {{ $item['issue_group_name_vi'] == 'Kỹ thuật' ? "selected" : "" }}>
                                                        {{ $item[getValueByLang('issue_group_name_')] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @else
                                            @if (isset($listIssueGroup) && count($listIssueGroup) > 0)
                                                @foreach ($listIssueGroup as $item)
                                                    <option value="{{ $item['portal_ticket_issue_group_id'] }}">
                                                        {{ $item[getValueByLang('issue_group_name_')] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endif

                                    </select>
                                    <div class="form-text"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_issue')</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <select  name="issue_id" id="issue_id" class="form-control select-2">
                                            <option value="">@lang('ticket::ticket.input.select_placeholder_issue')</option>
                                            @if(isset($param['customer_id']) && $param['customer_id'] != null)
                                                @if (isset($listIssue) && count($listIssue) > 0)
                                                    @foreach ($listIssue as $item)
                                                        <option value="{{ $item['portal_ticket_issue_id'] }} "  {{ $item['issue_name_vi'] == 'Hỗ trợ tư vấn kỹ thuật' ? "selected" : "" }}>
                                                            {{ $item[getValueByLang('issue_name_')] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endif
                                        </select>
                                        <input type="hidden" name="issue_level" id="issue_level" value="0">
                                    </div>
                                    <div class="form-text"></div>
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
                                <label for="ticket_title">@lang('ticket::ticket.index.ticket_title')</label>
                                @if( isset($param['order_id']) && $param['order_id'] != null )
                                    <input type="text" class="form-control" name="ticket_title" id="ticket_title" value="Hỗ trợ tư vấn kỹ thuật cho đơn hàng {{$param['order_name']}}">
                                @else
                                    <input type="text" class="form-control" name="ticket_title" id="ticket_title">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description">@lang('ticket::ticket.index.ticket_note')</label>
                                <textarea name="description" id="description" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group ">
                                <label class="col-lg-3 col-form-label form-control-label">@lang('ticket::ticket.index.ticket_queue')</label>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <select name="queue_process_id" id="queue_process_id" class="form-control select-2">
                                            <option value="">@lang('ticket::ticket.input.select_placeholder_queue')</option>
                                            @if( isset($param['order_id']) && $param['order_id'] != null )
                                                @if (isset($listQueue) && count($listQueue) > 0)
                                                    @foreach ($listQueue as $item)
                                                        <option value="{{ $item['ticket_queue_id'] }}" {{ $item['queue_name'] == 'Kỹ thuật' ? "selected" : "" }}>
                                                            {{ $item['queue_name'] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @else
                                                @if (isset($listQueue) && count($listQueue) > 0)
                                                    @foreach ($listQueue as $item)
                                                        <option value="{{ $item['ticket_queue_id'] }}">{{ $item['queue_name'] }}</option>
                                                    @endforeach
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-text"></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_operate_by')</label>
                                <div class="col-lg-12">
                                    <select name="operate_by" id="operate_by" class="form-control select-2">
                                        <option value="">@lang('ticket::ticket.input.select_placeholder_staff')</option>
                                        @if (isset($param['order_id']))
                                            @if (isset($listStaffQueue) && count($listStaffQueue) > 0 )
                                                    @foreach ($listStaffQueue as $item)
                                                        @if($item['role'] == 'operator' && $item['queue_name'] == 'Kỹ thuật' )
                                                        <option value="{{$item['staff_id']}}" > {{$item['full_name']}}</option>
                                                        @endif
                                                    @endforeach
                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-lg-3 col-form-label">@lang('ticket::ticket.index.ticket_processor')</label>
                                <div class="col-lg-12">
                                    <select name="process_by_list[]" id="process_by_list"
                                            class="form-control select-2" multiple>
                                        @if (isset($param['order_id']))
                                            @if (isset($listStaffQueue) && count($listStaffQueue) > 0 )
                                                @foreach ($listStaffQueue as $item)
                                                    @if($item['role'] == 'processor' && $item['queue_name'] == 'Kỹ thuật' )
                                                        <option value="{{$item['staff_id']}}" > {{$item['full_name']}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label col-lg-3 ">@lang('ticket::ticket.index.comment_file')</label>
                                <div class="col-lg-12 ">
                                    <div class="kt-dropzone dropzone m-dropzone--primary dropzone-custome" id="uploadFileTicket">
                                        <div class="kt-dropzone__msg dz-message needsclick">
                                            <h3 class="kt-dropzone__msg-title">@lang('ticket::ticket.info.dropzone')</h3>
                                            <span class="kt-dropzone__msg-desc">Hổ trợ các files word, excel, hình ảnh dưới 1MB</span><br>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(isset($param['order_id']) && $param['order_id'] != null )
            <input type="hidden" id="order_id" name="order_id" value="{{$param['order_id']}}">
        @endif

        @if(isset($param['customer_id']) && $param['customer_id'] != null )
            <input type="hidden" id="customer_id" name="customer_id" value="{{$param['customer_id']}}">
        @endif

        @if(isset($param['order_id']) && $param['order_id'] != null )
            <input type="hidden" id="type" name="type" value="staff_consult">
        @else
            <input type="hidden" name="type" value="staff_support" />
        @endif
    </form>
    <div id="popup-modal"></div>


@endsection
@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/ticket/script.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('static/backend/js/ticket/uploadFileTicket.js?v='.time()) }}"></script>
    <script type="text/javascript">
        objTicket.init(`{{ getValueByLang('') }}`);
        objDropzone.init();
        objTicket.getIssueGroup();
        objTicket.selectQueueByIssue();
        objTicket.getInfoCustomer();
        objTicket.changeQueue();
        objTicket.checkDateEstimated();
        objTicket.getServices();
    </script>
@endsection
