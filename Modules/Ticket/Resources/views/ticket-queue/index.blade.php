@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">@lang('ticket::queue.index.queue')</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">
            </div>
        </div>
        <div class="kt-subheader__toolbar">
            @include('helpers.button', ['button' => [
                'route' => 'ticket.queue.create',
                'html' => '<a href="'.route('ticket.queue.create').'" class="btn btn-label-brand btn-bold">'
                .__('ticket::queue.input.button-add').
            '</a>'
            ]])
        </div>

    </div>

    <!--begin: Datatable -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__body">
                <form id="form-filter" action="{{route('ticket.queue.index')}}">
                    @include('ticket::ticket-queue.partial.search-table')
                    <div class="kt-section">
                        @include('ticket::ticket-queue.list')
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="popup-queue"> </div>
@endsection
@section('after_script')
    <script src="{{asset('static/backend/js/ticket/queue/script.js?v='.time())}}" type="text/javascript"></script>
    <script>
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
            $('#kt_datepicker_2').datepicker({
                format: 'dd/mm/yyyy',
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                templates: arrows
            });
        });
    </script>
@endsection
