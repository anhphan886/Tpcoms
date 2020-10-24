@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('after_style')
    <link href="{{ asset('static/backend/css/dashboard/index.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div id="m-dashbroad">
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    Cấu hình chung
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <button type="button" id="save" class="btn btn-info btn-bold" onclick="config.save()">
                    @lang('product::product-template.create.save')
                </button>
            </div>
        </div>
        <!--begin: Datatable -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <form id="form">
                        <div class="form-group">
                            <label class="col-form-label">Thời gian nhắc trước hạn thanh toán phiếu thu (Ngày)</label>
                        </div>
                        <div id="dev-input-config">
                            @foreach($configRemindReceipt['array_value'] as $key => $value)
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <input
                                                name="receipt"
                                                type="text"
                                                class="form-control receipt"
                                                placeholder="Số ngày"
                                                style="text-align: center; "
                                                value="{{$value}}">
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="col-lg-9">
                                        <button
                                                type="button"
                                                class="btn btn-danger"
                                                onclick="config.removeInput(this)">
                                            Xóa
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-brand" onclick="config.addInputConfigRemindReceipt()">
                                <i class="fa flaticon2-plus"></i> Thêm thời gian
                            </button>
                        </div>
                        @foreach ($allConfig as $item)
                            @if($item->id == 1)
                                @continue
                            @endif
                            <div class="form-group">
                                <label class="col-form-label">{{$item->name}}</label>
                            </div>
                            <div id="dev-input-config">
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <input name="{{$item->key}}" type="text" class="form-control all-config"
                                                    placeholder="{{$item->name}}"
                                                    style="text-align: center;"
                                                    value="{{$item->value}}">
                                        </div>
                                        <div class="col-lg-9">
                                            <button
                                                    type="button"
                                                    class="btn btn-danger"
                                                    onclick="config.putValue('{{$item->key}}', '{{$item->value}}')">
                                                    <i class="fa fa-undo"></i>
                                            </button>
                                        </div>
                                    </div>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="language" value="{{\Illuminate\Support\Facades\App::getLocale()}}">
@endsection
@section('after_script')
    <script type="text/template" id="tpl-input-config-receipt">
        <div class="form-group row">
            <div class="col-lg-3">
                <input
                        name="receipt"
                        type="text"
                        class="form-control receipt"
                        placeholder="Số ngày"
                        style="text-align: center; "
                        value="1">
                <span class="text-danger"></span>
            </div>
            <div class="col-lg-9">
                <button
                        type="button"
                        class="btn btn-danger"
                        onclick="config.removeInput(this)">
                    Xóa
                </button>
            </div>
        </div>
    </script>
    <script src="{{asset('static/backend/js/general/numeric.js?v='.time())}}"
            type="text/javascript"></script>
    <script src="{{asset('static/backend/js/admin/config/script.js?v='.time())}}"
            type="text/javascript"></script>
@endsection
