<div id="m--star-dashbroad">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div
                    onclick="chart.scroll('#kt-content-1', 'order')"
                    class="m-portlet m--bg-brand m-portlet--bordered-semi m-portlet--full-height  m-portlet--head-sm tongtien ss--radius-10 pn-pointer">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text m--font-light">
                                @lang('admin::dashboard.order')
                                <small>@lang('admin::dashboard.of_day')</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget25">
                        <span class="m-widget25__price m--font-brand">{{$head['order']}}</span>
                        <span class="m-widget25__desc">
                        @lang('admin::dashboard.order')
                    </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div
                    onclick="chart.scroll('#kt-content-1', 'customer')"
                    class="m-portlet m--bg-brand m-portlet--bordered-semi m-portlet--full-height  m-portlet--head-sm dathanhtoan ss--radius-10 pn-pointer">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text m--font-light">
                                @lang('admin::dashboard.customer')
                                <small>@lang('admin::dashboard.of_day')</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget25">
                        <span class="m-widget25__price m--font-brand">{{$head['customer']}}</span>
                        <span class="m-widget25__desc">
                        @lang('admin::dashboard.customer')
                    </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div onclick="chart.scroll('#kt-content-2', '0')"
                 class="m-portlet m--bg-danger m-portlet--bordered-semi m-portlet--full-height  m-portlet--head-sm chuathanhtoan ss--radius-10 pn-pointer">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text m--font-light">
                                @lang('admin::dashboard.service')
                                <small>@lang('admin::dashboard.expired')</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget25">
                    <span class="m-widget25__price m--font-brand">
                        {{$head['service']}}
                    </span>
                        <span class="m-widget25__desc">@lang('admin::dashboard.service')</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div
                    onclick="chart.redirectTicket()"
                    class="m-portlet m--bg-warning m-portlet--bordered-semi m-portlet--full-height  m-portlet--head-sm sotienhuy ss--radius-10 pn-pointer">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text m--font-light">
                                @lang('admin::dashboard.ticket_support')
                                <small>
                                    @lang('admin::dashboard.of_day')
                                </small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget25">
                    <span class="m-widget25__price m--font-brand">
                       {{$head['ticket']}}
                    </span>
                        <span class="m-widget25__desc">@lang('admin::dashboard.ticket')</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div
                    onclick="chart.scroll('#kt-content-3', 'receipt')"
                    class="m-portlet m--bg-brand m-portlet--bordered-semi m-portlet--full-height  m-portlet--head-sm phieuthuduocxuat ss--radius-10 pn-pointer">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text m--font-light">
                                @lang('admin::dashboard.receipt_exported')
                                <small>@lang('admin::dashboard.of_day')</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget25">
                        <span class="m-widget25__price m--font-brand">{{$head['receipt']}}</span>
                        <span class="m-widget25__desc">
                        @lang('admin::dashboard.receipt')
                    </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div
                    onclick="chart.scroll('#kt-content-3', 'invoice')"
                    class="m-portlet m--bg-brand m-portlet--bordered-semi m-portlet--full-height  m-portlet--head-sm hoadoncanxuat ss--radius-10 pn-pointer">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text m--font-light">
                                @lang('admin::dashboard.invoice_need_exported')
                                <small>@lang('admin::dashboard.of_day')</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget25">
                        <span class="m-widget25__price m--font-brand">{{$head['invoice']}}</span>
                        <span class="m-widget25__desc">
                        @lang('admin::dashboard.invoice')
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>