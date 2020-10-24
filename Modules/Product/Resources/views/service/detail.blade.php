@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
<div class="kt-subheader kt-grid__item" id="kt_subheader">
    <div class="kt-subheader__main">

        <h3 class="kt-subheader__title">
                    @lang('product::customer.service.detail_service')
        </h3>
        <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        <div class="kt-subheader__group" id="kt_subheader_search">
            <span class="kt-subheader__desc" id="kt_subheader_total"></span>

        </div>
        <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">
        </div>

    </div>
    <div class="kt-subheader__toolbar">
        <div class="kt-subheader__toolbar">
            @if(empty($detailVm))
                {{-- @include('helpers.button', ['button' => [
                    'route' => 'product.customer.add-childAccount',
                        'html' => '<a href="#" onclick="vcloud.create_vm(\''.$detail['customer_service_id'].'\')" class="btn btn-label-brand btn-bold"> Tạo VMs </a>'
                    ]]) --}}
            @endif
            @if($detail['status'] != 'cancel')
                @include('helpers.button', ['button' => [
                    'route' => 'product.customer.add-childAccount',
                    'html' => '<a href="'.route('product.service.edit',['id' => $detail['customer_service_id']]).'" class="btn btn-label-brand btn-bold">'
                    .__('ticket::queue.index.edit').
                '</a>'
                ]])
            @endif
        </div>
        <a href="{{ URL::previous() }}" class="btn btn-secondary btn-bold">
                @lang('ticket::issue.input.button_cancel')
        </a>
    </div>
</div>
<!--begin: Datatable -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-lg-6">

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="col-lg-3  color_black col-form-label">
                                @lang('product::customer.service.customer_name'):
                        </label>
                        <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                {{$detail['customer_name']}}
                        </label>
                        <input type="hidden" id="customer_service_id" name="customer_service_id" value="{{$detail['customer_service_id']}}">
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="col-lg-3 col-form-label color_black">
                                @lang('product::customer.service.product_name'):
                            </label>
                            <label class="col-md-6 col-form-label kt-margin-l-20">
                                {{$detail['product_name_'.getValueByLang('')]}}
                            </label>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="col-lg-3 col-form-label color_black">
                                @lang('product::customer.service.staff'):
                            </label>
                            <label class="col-md-6 col-form-label kt-margin-l-20">
                                @if ( $detail['full_name'] == null)
                                    @lang('product::customer.service.staff_null')
                                @else
                                    {{$detail['full_name']}}
                                @endif

                            </label>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="col-lg-3 col-form-label color_black">
                                @lang('product::customer.service.type'):
                            </label>
                            <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                @if ( $detail['type'] == 'trial')
                                    @lang('product::customer.service.trial')
                                @else
                                    @if ( $detail['payment_type'] == 'postpaid')
                                        @lang('product::customer.service.postpaid')

                                    @elseif ( $detail['payment_type'] == 'prepaid')
                                        @lang('product::customer.service.prepaid')

                                    @else
                                        @lang('product::customer.service.payuse')
                                    @endif
                                @endif
                            </label>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">

                            <label class="col-lg-3 col-form-label align-top color_black">
                                    @lang('product::customer.service.info_service'):
                            </label>
                            <label for="" class="col-sm-6 col-form-label kt-margin-l-20">
                                    @if(isset($detailAttribute))
                                        @foreach( $detailAttribute as $item)
                                            {{$item['product_attribute_name_vi']}}: {{$item['value']}} {{$item['unit_name']}}<br>
                                        @endforeach
                                    @endif
                            </label>

                            </div>

                        </div>

                        <div class="col-lg-6">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="col-lg-4 col-form-label color_black">
                                @lang('product::customer.service.status'):
                                </label>
                                <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                @if($detail['status'] == 'actived')
                                    @lang('product::customer.service.actived')

                                @elseif($detail['status'] == 'not_actived')
                                    @lang('product::customer.service.not_actived')
                                @elseif($detail['status'] == 'spending')
                                    @lang('product::customer.service.spending')
                                @elseif($detail['status'] == 'block')
                                    @lang('product::customer.service.block')
                                @else
                                    @lang('product::customer.service.cancel')
                                @endif
                                </label>
                            </div>
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="col-lg-4 col-form-label color_black">
                                    Trạng thái thanh toán:
                                </label>
                                <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                    @if($detail['stop_payment'] == 1)
                                        Đã  tạm dừng thanh toán
                                    @else
{{--                                        Đang thanh toán--}}
                                    @endif
                                </label>
                            </div>
                            @if($detail['stop_payment'] == 1)
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="col-lg-4 col-form-label color_black">
                                        Thời gian dừng thanh toán dịch vụ:
                                    </label>
                                    <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                        @if ( $detail['stop_payment_at'] != null && $detail['stop_payment_at'] != '0000-00-00 00:00:00')
                                            {{date("d/m/Y",strtotime($detail['stop_payment_at']))}}
                                        @endif
                                    </label>
                                </div>
                            @endif
                            @if ( $detail['type'] != 'trial')
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="col-lg-4 col-form-label color_black">
                                        @lang('product::customer.service.charg_date'):
                                    </label>
                                    <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                        @if ( $detail['charg_date'] != null && $detail['charg_date'] != '0000-00-00 00:00:00')
                                            {{date("d/m/Y",strtotime($detail['charg_date']))}}
                                        @endif
                                    </label>
                                </div>
                            @endif
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="col-lg-4 col-form-label color_black">
                                Thời gian sử dụng:
                                </label>
                                <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                @if($detail['payment_type'] == 'payuse')
                                        Không xác định
                                    @else
                                        @if ($detail['quantity'] == null)
                                            Chưa sử dụng
                                        @else
                                            {{$detail['quantity']}}
                                            {{$detail['type'] == 'trial' ? 'Ngày' : 'Tháng'}}
                                        @endif
                                @endif
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="col-lg-4 col-form-label color_black">
                                @lang('product::customer.service.actived_date'):
                                </label>
                                <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                    @if ( $detail['actived_date'] == null || $detail['actived_date'] == '0000-00-00')
                                    @else
                                        {{date("d/m/Y",strtotime($detail['actived_date']))}}
                                    @endif
                                </label>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="col-lg-4 col-form-label color_black">
                                @lang('product::customer.service.expired_date'):
                                </label>
                                <label for="" class="col-md-6 col-form-label kt-margin-l-20">
                                    @if($detail['payment_type'] == 'postpaid')
                                        @lang('product::customer.service.unknown')
                                    @elseif($detail['payment_type'] == 'payuse')
                                        @lang('product::customer.service.unknown')
                                    @elseif($detail['payment_type'] == 'prepaid')
                                        @if ( $detail['expired_date'] == null || $detail['expired_date'] == '0000-00-00' || $detail['status'] == 'not_actived')
                                        @else
                                            {{date("d/m/Y",strtotime($detail['expired_date']))}}
                                        @endif
                                    @endif
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="col-lg-4 col-form-label color_black">
                            @lang('product::customer.service.service_cotent'):
                            </label>
                            <textarea class="form-control textarea-h" disabled rows="12">{{$detail['service_content']}}</textarea>
                        </div>
                    </div>

                </div>

            </div>
            <style>
            .vm-container{
                height: 250px;
                width : 220px;
                background-color: white;
                border-radius: 2px;
                box-shadow: 0px 0px 1px 0px black;
                padding : 10px;
                font-family: Metropolis, "Avenir Next", "Helvetica Neue", Arial, sans-serif;
                font-size: 10px;
                color : #565656;
                user-select: none;
            }
            .vm-container:hover{
                box-shadow: 0px 0px 5px 0px grey;
            }
            .ex-maxwidth {
                width: 100%;
                margin : 0px;
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
            }
            .margin-100{
                margin : 10px;
            }
            .vm-machine-type {
                font-size: 14px;
            }
            .vm-text-bold {
                font-weight: bold;
            }
            .vm-text-tab{
                margin-left: 10px;
            }
            .margin-line-content{
                margin-top : 10px;
                margin-bottom: 10px;
            }
            .vm-icon-tiny {
                height: 15px;
                width: 15px;
                padding : 0px;
            }
            .vm-icon-tiny >svg {
                height: 100%;
                width: 100%;
            }
            .vm-attr-text{
                padding : 0;
                margin : 0;
                font-size: 9px;
            }
            .vm-attr-value{
                padding : 0;
                margin : 0;
                font-size: 11px;
            }
            .none-display{
                display :none!important;;
            }
            .block-display {
                display : block!important;;
            }
            </style>
            @if($detailVm != null)
            <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content">
                <div class="kt-portlet kt-portlet--tabs">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="vm-container">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-8 col-8">
                                            <div class="row">
                                                <p class="ex-maxwidth vm-machine-type">Virtual Machine</p>
                                                <p class="ex-maxwidth" id="vcloud-vm">{{$detailVm['vm']}}</p>
                                            <p class="ex-maxwidth vm-text-bold vm-text-tab" id="vcloud-os">{{$detailVm['os']}}</p>
                                            <p class="ex-maxwidth vm-text-bold vm-text-tab" style="color : {{$detailVm['status'] == "4"?"green":($detailVm['status']<"4" ? "orange": "red")}}" id="vcloud-status">{{VM_STATUS[$detailVm['status']]}}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-4">
                                            <div style="height: 50px; width : 50px;">
                                                <svg version="1.1" class="can-badge can-alert has-solid " viewBox="0 0 36 36" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" focusable="false" aria-hidden="true" role="img"><path d="M32.5,3H3.5A1.5,1.5,0,0,0,2,4.5v21A1.5,1.5,0,0,0,3.5,27h29A1.5,1.5,0,0,0,34,25.5V4.5A1.5,1.5,0,0,0,32.5,3ZM32,25H4V5H32Z" class="clr-i-outline clr-i-outline-path-1"></path><path d="M26,32H24.26a3.61,3.61,0,0,1-1.5-2.52V28.13H21.24V29.5A4.2,4.2,0,0,0,22.17,32H13.83a4.2,4.2,0,0,0,.93-2.52V28.13H13.24V29.5A3.61,3.61,0,0,1,11.74,32H9.94a1,1,0,1,0,0,2H26.06a.92.92,0,0,0,1-1A1,1,0,0,0,26,32Z" class="clr-i-outline clr-i-outline-path-3"></path><path d="M26,32H24.26a3.61,3.61,0,0,1-1.5-2.52V28.13H21.24V29.5A4.2,4.2,0,0,0,22.17,32H13.83a4.2,4.2,0,0,0,.93-2.52V28.13H13.24V29.5A3.61,3.61,0,0,1,11.74,32H9.94a1,1,0,1,0,0,2H26.06a.92.92,0,0,0,1-1A1,1,0,0,0,26,32Z" class="clr-i-outline--alerted clr-i-outline-path-1--alerted"></path><path d="M33.68,15.4H32V25H4V5H21.87L23,3H3.5A1.5,1.5,0,0,0,2,4.5v21A1.5,1.5,0,0,0,3.5,27h29A1.5,1.5,0,0,0,34,25.5V15.38Z" class="clr-i-outline--alerted clr-i-outline-path-2--alerted"></path><path d="M26,32H24.26a3.61,3.61,0,0,1-1.5-2.52V28.13H21.24V29.5A4.2,4.2,0,0,0,22.17,32H13.83a4.2,4.2,0,0,0,.93-2.52V28.13H13.24V29.5A3.61,3.61,0,0,1,11.74,32H9.94a1,1,0,1,0,0,2H26.06a.92.92,0,0,0,1-1A1,1,0,0,0,26,32Z" class="clr-i-outline--badged clr-i-outline-path-1--badged"></path><path d="M32,13.22V25H4V5H22.57a7.45,7.45,0,0,1,.55-2H3.5A1.5,1.5,0,0,0,2,4.5v21A1.5,1.5,0,0,0,3.5,27h29A1.5,1.5,0,0,0,34,25.5V12.34A7.45,7.45,0,0,1,32,13.22Z" class="clr-i-outline--badged clr-i-outline-path-3--badged"></path><path d="M26,32H24.26a3.61,3.61,0,0,1-1.5-2.52V28.13H13.24V29.5A3.61,3.61,0,0,1,11.74,32H9.94a1,1,0,1,0,0,2H26.06a.92.92,0,0,0,1-1A1,1,0,0,0,26,32Z" class="clr-i-solid clr-i-solid-path-1"></path><path d="M26,32H24.26a3.61,3.61,0,0,1-1.5-2.52V28.13H13.24V29.5A3.61,3.61,0,0,1,11.74,32H9.94a1,1,0,1,0,0,2H26.06a.92.92,0,0,0,1-1A1,1,0,0,0,26,32Z" class="clr-i-solid--alerted clr-i-solid-path-1--alerted"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row margin-line-content">
                                        <div class="col-lg-6 col-6">
                                            <div class="row">
                                                <div class="col-lg-4 col-4 vm-icon-tiny"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 469.333 469.333" style="enable-background:new 0 0 469.333 469.333;" xml:space="preserve"><g><g><g><path d="M338.208,67.125c-2-2-4.708-3.125-7.542-3.125h-256C68.771,64,64,68.771,64,74.667v320     c0,5.896,4.771,10.667,10.667,10.667h320c5.896,0,10.667-4.771,10.667-10.667v-256c0-2.833-1.125-5.542-3.125-7.542     L338.208,67.125z M384,384H85.333V85.333H326.25l57.75,57.75V384z"/><path d="M149.333,202.667c5.885,0,10.667,4.781,10.667,10.667c0,5.896,4.771,10.667,10.667,10.667s10.667-4.771,10.667-10.667     c0-17.646-14.354-32-32-32c-17.646,0-32,14.354-32,32V256c0,17.646,14.354,32,32,32c17.646,0,32-14.354,32-32     c0-5.896-4.771-10.667-10.667-10.667S160,250.104,160,256c0,5.885-4.781,10.667-10.667,10.667     c-5.885,0-10.667-4.781-10.667-10.667v-42.667C138.667,207.448,143.448,202.667,149.333,202.667z"/><path d="M234.667,181.333h-21.333c-5.896,0-10.667,4.771-10.667,10.667v85.333c0,5.896,4.771,10.667,10.667,10.667     c5.896,0,10.667-4.771,10.667-10.667v-32h10.667c17.646,0,32-14.354,32-32C266.667,195.687,252.312,181.333,234.667,181.333z      M234.667,224H224v-21.333h10.667c5.885,0,10.667,4.781,10.667,10.667C245.333,219.219,240.552,224,234.667,224z"/><path d="M309.333,256v-64c0-5.896-4.771-10.667-10.667-10.667S288,186.104,288,192v64c0,17.646,14.354,32,32,32     c17.646,0,32-14.354,32-32v-64c0-5.896-4.771-10.667-10.667-10.667s-10.667,4.771-10.667,10.667v64     c0,5.885-4.781,10.667-10.667,10.667C314.115,266.667,309.333,261.885,309.333,256z"/><path d="M458.667,106.667c5.896,0,10.667-4.771,10.667-10.667V42.667C469.333,19.135,450.198,0,426.667,0h-53.333     c-5.896,0-10.667,4.771-10.667,10.667c0,5.885-4.781,10.667-10.667,10.667c-5.885,0-10.667-4.781-10.667-10.667     C341.333,4.771,336.563,0,330.667,0h-288C19.135,0,0,19.135,0,42.667V96c0,5.896,4.771,10.667,10.667,10.667     c5.885,0,10.667,4.781,10.667,10.667c0,5.885-4.781,10.667-10.667,10.667C4.771,128,0,132.771,0,138.667v288     c0,23.531,19.135,42.667,42.667,42.667h384c23.531,0,42.667-19.135,42.667-42.667v-288c0-5.896-4.771-10.667-10.667-10.667     c-5.885,0-10.667-4.781-10.667-10.667C448,111.448,452.781,106.667,458.667,106.667z M448,87.156     c-12.417,4.406-21.333,16.271-21.333,30.177s8.917,25.771,21.333,30.177v279.156c0,11.76-9.573,21.333-21.333,21.333h-384     c-11.76,0-21.333-9.573-21.333-21.333V147.51c12.417-4.406,21.333-16.271,21.333-30.177S33.75,91.562,21.333,87.156v-44.49     c0-11.76,9.573-21.333,21.333-21.333h279.156C326.229,33.75,338.094,42.667,352,42.667s25.771-8.917,30.177-21.333h44.49     c11.76,0,21.333,9.573,21.333,21.333V87.156z"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></div>
                                                <div class="col-lg-8 col-8">
                                                    <div class="row">
                                                        <p class="col-lg-12 col-12 vm-attr-text">CPUs</p>
                                                    </div>
                                                    <div class="row">
                                                        <p class="col-lg-12 col-12 vm-attr-value vm-text-bold" id="vcloud-cpu">{{$detailVm['cpu']}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-6">
                                            <div class="row">
                                                <div class="col-lg-4 col-4 vm-icon-tiny">
                                                    <svg height="512" viewBox="0 0 60 61" width="512" xmlns="http://www.w3.org/2000/svg"><g id="Page-1" fill="none" fill-rule="evenodd"><g id="037---RAM" fill="rgb(0,0,0)" fill-rule="nonzero"><path id="Shape" d="m15.6455 58.92c-.5225144.0020781-1.0240806-.205269-1.3926-.5757l-7.61-7.6113c-.63501308-.6460083-.75233683-1.6398869-.2852-2.416.42121171-.7442075.29434609-1.6779755-.31015421-2.2828255-.60450031-.6048501-1.53819476-.7322557-2.28264579-.3114745-.77649712.4683058-1.77162213.3509684-2.4179-.2851l-.7715-.771c-.7663652-.7689157-.76681226-2.0127336-.001-2.7822l40.3532-40.3532c.7689076-.76686898 2.0133924-.76686898 2.7823 0l.7724.7725c.6352621.64687058.7517949 1.64184394.2832 2.418-.4194718.74445682-.291505 1.67720497.3129633 2.28118399s1.5373198.73119054 2.2814367.31111601c.7767885-.46695415 1.7710244-.34972157 2.4179.2851l7.61 7.6113c.7673106.7690817.7668632 2.0142699-.001 2.7828l-40.3508 40.352c-.3679645.3699285-.8688335.5769611-1.3906.5748zm-10.9199-15.4342c1.02620102-.0001433 2.010312.4079212 2.7353 1.1342 1.23944414 1.2426418 1.49900854 3.1589124.6348 4.6865l7.5723 7.6246 40.3066-40.353-7.6113-7.5654c-1.5184331.89885352-3.4530809.65360545-4.6992-.5957-1.2389172-1.2424584-1.4988311-3.15792333-.6358-4.6856l-.7324-.7861-40.3066 40.353.7724.7256c.59453569-.3522313 1.27285763-.5380885 1.9639-.5381z"/><path id="Shape" d="m20.4326 60.9722c-.5221858.0018999-1.0233753-.2054405-1.3916-.5757l-2.7353-2.7354c-.2599566-.2510745-.3642126-.6228779-.2726972-.9725073.0915155-.3496295.3645604-.6226744.7141899-.7141899.3496294-.0915154.7214328.0127406.9725073.2726972l2.7364 2.7358 8.8447-8.8911-2.7354-2.69c-.380397-.3921753-.3756228-1.01706.0107219-1.4033774.3863446-.3863173 1.0112297-.3910473 1.4033781-.0106226l2.7353 2.7353c.766869.7689076.766869 2.0133924 0 2.7823l-8.8916 8.8916c-.3678984.3700753-.8687756.5772553-1.3906.5752z"/><path id="Shape" d="m35.48 45.9253c-.5221858.0018999-1.0233753-.2054405-1.3916-.5757l-2.7354-2.7353c-.3777934-.3924746-.3719371-1.015136.0131714-1.4004352.3851086-.3852993 1.007767-.3914639 1.4004286-.0138648l2.7363 2.7358 22.5235-22.57-2.7354-2.6895c-.3820936-.3919029-.3781252-1.0181666.0089041-1.4051959s1.013293-.3909977 1.4051959-.0089041l2.7349 2.7358c.7672831.7690769.7668804 2.0142195-.0009 2.7828l-22.5691 22.5692c-.3677355.3699636-.8683689.5771682-1.39.5753z"/><path id="Shape" d="m23.8525 57.9541c-.2652627.0002851-.519701-.105161-.707-.293l-3.42-3.4194c-.3804247-.3921484-.3756947-1.0170335.0106226-1.4033781.3863174-.3863447 1.0112021-.3911189 1.4033774-.0107219l3.42 3.42c.2859208.2860071.3714284.7160737.2166588 1.0897007-.1547695.3736271-.5193447.6172534-.9237588.6172993z"/><path id="Shape" d="m27.2725 54.5347c-.2652974.0003117-.5197765-.1051364-.7071-.293l-3.42-3.42c-.3904653-.390631-.3903309-1.0238347.0003-1.4143.390631-.3904653 1.0238347-.390331 1.4143.0003l3.42 3.42c.2859794.2859849.3715389.7160737.2167859 1.0897354s-.5193461.6173187-.9237859.6173646z"/><path id="Shape" d="m38.8994 42.9072c-.2652527.0003337-.5196971-.105079-.707-.2929l-3.42-3.4195c-.3789722-.3923789-.3735524-1.0160848.0121814-1.4018186s1.0094397-.3911536 1.4018186-.0121814l3.42 3.4194c.2859079.2859943.3714219.7160366.216678 1.0896546-.1547439.3736179-.5192821.6172591-.923678.6173454z"/><path id="Shape" d="m42.3193 39.4878c-.2652627.0002851-.519701-.105161-.707-.293l-3.42-3.42c-.3804247-.3921484-.3756947-1.0170335.0106226-1.4033781.3863174-.3863447 1.0112021-.3911189 1.4033774-.0107219l3.42 3.42c.2859208.2860071.3714284.7160737.2166588 1.0897007-.1547695.3736271-.5193447.6172534-.9237588.6172993z"/><path id="Shape" d="m45.7393 36.0679c-.2652974.0003117-.5197765-.1051364-.7071-.293l-3.42-3.4194c-.3820936-.3919029-.3781252-1.0181666.0089041-1.4051959s1.013293-.3909977 1.4051959-.0089041l3.42 3.4194c.2859794.2859849.3715389.7160737.2167859 1.0897354s-.5193461.6173187-.9237859.6173646z"/><path id="Shape" d="m49.1582 32.6484c-.2652549.0003448-.5197034-.1050696-.707-.2929l-3.419-3.42c-.2590307-.2512868-.3625694-.6226481-.2709202-.9717074s.3642662-.621657.713332-.7132815c.3490657-.0916245.7204198.0119404.9716882.2709889l3.4189 3.42c.2859079.2859943.3714219.7160366.216678 1.0896546-.1547439.3736179-.5192821.6172591-.923678.6173454z"/><path id="Shape" d="m52.5781 29.2285c-.2652737.0003404-.5197324-.1051141-.707-.293l-3.42-3.42c-.2599566-.2510745-.3642126-.6228779-.2726972-.9725073.0915155-.3496295.3645604-.6226744.7141899-.7141899.3496294-.0915154.7214328.0127406.9725073.2726972l3.42 3.42c.2859208.2860071.3714284.7160737.2166588 1.0897007-.1547695.3736271-.5193447.6172534-.9237588.6172993z"/><path id="Shape" d="m55.998 25.8086c-.2652627.0002851-.519701-.105161-.707-.293l-3.42-3.4194c-.3820936-.3919029-.3781252-1.0181666.0089041-1.4051959s1.013293-.3909977 1.4051959-.0089041l3.42 3.42c.2859208.2860071.3714284.7160737.2166588 1.0897007-.1547695.3736271-.5193447.6172534-.9237588.6172993z"/><path id="Shape" d="m17.0127 50.7c-.5304359.0009613-1.0393696-.2095799-1.4141-.585l-6.7929-6.7932c-.78028121-.7814338-.78028121-2.0471662 0-2.8286l4.7412-4.7412c.7812395-.7802789 2.0468605-.7802789 2.8281 0l6.793 6.7929c.7802261.7814566.7802261 2.0471434 0 2.8286l-4.7412 4.7412c-.3746811.3755302-.8836209.5861818-1.4141.5853zm-2.0518-13.534-4.7409 4.7412 6.793 6.7935 4.7422-4.7422z"/><path id="Shape" d="m25.9043 41.8081c-.5302244.0008839-1.0390116-.2092369-1.4141-.584l-6.7929-6.7941c-.7802789-.7812395-.7802789-2.0468605 0-2.8281l4.7412-4.7413c.7812623-.7802238 2.0468377-.7802238 2.8281 0l6.793 6.793c.3751443.3749684.5859129.8836402.5859129 1.41405s-.2107686 1.0390816-.5859129 1.41405l-4.7412 4.7417c-.3748736.3751695-.8837401.5855749-1.4141.5847zm-2.0518-13.5332-4.7412 4.7412 6.793 6.7935 4.7412-4.7417v-.0005l.001-.001z"/><path id="Shape" d="m34.7959 32.917c-.5304359.0009613-1.0393696-.2095799-1.4141-.585l-6.7939-6.7929c-.7780933-.7818258-.7785402-2.0453241-.001-2.8277l4.7431-4.7422c.3734499-.3762183.8820026-.5872239 1.4121-.5859h.0019c.5307085-.0014456 1.0399276.2095377 1.4141.5859l6.793 6.7935c.3751443.3749684.5859129.8836402.5859129 1.41405s-.2107686 1.0390816-.5859129 1.41405l-4.7411 4.7412c-.3747304.3754201-.8836641.5859613-1.4141.585zm-2.0518-13.5337-4.7421 4.7412 6.7939 6.7935 4.7422-4.7422z"/><path id="Shape" d="m43.6865 24.0254c-.5301614.0007141-1.0388551-.2093829-1.414-.584l-6.7925-6.7939c-.7802904-.7812738-.7802904-2.0469262 0-2.8282l4.7412-4.7412c.3741724-.37636233.8833915-.58734561 1.4141-.5859h.0019c.5305731-.00124892 1.0395271.21013394 1.4131.5869l6.793 6.792c.3751443.3749684.5859129.8836402.5859129 1.41405s-.2107686 1.0390816-.5859129 1.41405l-4.7412 4.7417c-.375311.3754088-.8847624.5857608-1.4156.5845zm-2.0517-13.5332-4.7412 4.7412 6.7929 6.7935 4.7422-4.7417.001-.001z"/></g></g></svg></div>
                                                <div class="col-lg-8 col-8">
                                                    <div class="row">
                                                        <p class="col-lg-12 col-12 vm-attr-text">Memory</p>
                                                    </div>
                                                    <div class="row">
                                                        <p class="col-lg-12 col-12 vm-attr-value vm-text-bold" id="vcloud-memory">{{$detailVm['memory']}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="row margin-line-content">
                                    <div class="col-lg-6 col-6">
                                        <div class="row">
                                            <div class="col-lg-4 col-4 vm-icon-tiny"><!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  --><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g>	<g><g>	<path d="M405.333,0H106.667C83.146,0,64,19.135,64,42.667v426.667C64,492.865,83.146,512,106.667,512h298.667     C428.854,512,448,492.865,448,469.333V42.667C448,19.135,428.854,0,405.333,0z M426.667,469.333     c0,11.76-9.563,21.333-21.333,21.333H106.667c-11.771,0-21.333-9.573-21.333-21.333V42.667c0-11.76,9.563-21.333,21.333-21.333     h298.667c11.771,0,21.333,9.573,21.333,21.333V469.333z"/>	<path d="M256,64c-82.333,0-149.333,66.99-149.333,149.333c0,82.155,66.701,148.999,148.776,149.305     c9.9,22.931,19.691,45.771,24.995,58.602c2.313,5.552,5.479,10.354,9.396,14.26c8.313,8.323,19.25,12.479,30.167,12.479     s21.854-4.156,30.167-12.479c8.063-8.052,12.5-18.771,12.5-30.167c0-11.396-4.438-22.115-13-30.646l-30.302-26.583     c51.957-24.366,85.969-76.318,85.969-134.771C405.333,130.99,338.333,64,256,64z M335.083,390.25     c4.021,4.031,6.25,9.385,6.25,15.083c0,5.698-2.229,11.052-6.25,15.083c-8.333,8.313-21.854,8.323-30.188-0.01     c-1.958-1.958-3.5-4.365-4.75-7.333c-7.438-17.99-23.667-55.594-36.708-85.646L335.083,390.25z M301.594,332.514l-59.885-52.535     c-3.792-3.292-9.313-3.521-13.333-0.594c-4.042,2.948-5.479,8.302-3.479,12.885c0,0,9.621,22.043,21.112,48.557     C180.091,335.701,128,280.544,128,213.333c0-70.583,57.417-128,128-128s128,57.417,128,128     C384,266.622,351.02,313.62,301.594,332.514z"/>	<path d="M256,149.333c-35.292,0-64,28.708-64,64c0,35.292,28.708,64,64,64s64-28.708,64-64     C320,178.042,291.292,149.333,256,149.333z M256,256c-23.521,0-42.667-19.135-42.667-42.667s19.146-42.667,42.667-42.667     s42.667,19.135,42.667,42.667S279.521,256,256,256z"/>	<circle cx="149.333" cy="426.667" r="21.333"/></g>	</g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></div>
                                            <div class="col-lg-8 col-8">
                                                <div class="row">
                                                    <p class="col-lg-12 col-12 vm-attr-text">Hard disk</p>
                                                </div>
                                                <div class="row">
                                                <p class="col-lg-12 col-12 vm-attr-value vm-text-bold" id="vcloud-disk">{{
                                                    array_sum(array_map(function($e){
                                                        return $e['capacity'] /1024;
                                                    },$detailVm['disk']))
                                                    }} GB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-6">
                                        <div class="row">
                                            <div class="col-lg-4 col-4 vm-icon-tiny"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><g><circle cx="256" cy="256" r="21.333"/><circle cx="384" cy="256" r="21.333"/><circle cx="149.333" cy="256" r="21.333"/><path d="M25.75,256l109.792-109.792c4.167-4.167,4.167-10.917,0-15.083c-4.167-4.167-10.917-4.167-15.083,0L3.125,248.458     c-4.167,4.167-4.167,10.917,0,15.083l117.333,117.333c2.083,2.083,4.813,3.125,7.542,3.125s5.458-1.042,7.542-3.125     c4.167-4.167,4.167-10.917,0-15.083L25.75,256z"/><path d="M508.875,248.458L391.542,131.125c-4.167-4.167-10.917-4.167-15.083,0c-4.167,4.167-4.167,10.917,0,15.083L486.25,256     L376.458,365.792c-4.167,4.167-4.167,10.917,0,15.083c2.083,2.083,4.813,3.125,7.542,3.125c2.729,0,5.458-1.042,7.542-3.125     l117.333-117.333C513.042,259.375,513.042,252.625,508.875,248.458z"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></div>
                                            <div class="col-lg-8 col-8">
                                                <div class="row">
                                                    <p class="col-lg-12 col-12 vm-attr-text">Status</p>
                                                </div>
                                                <div class="row">
                                                <p class="col-lg-12 col-12 vm-attr-value vm-text-bold" id="vcloud-action">-</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @lang('ticket::issue-group.table.action')
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                            <div class="dropdown-item group-power-off" style="cursor: pointer" onclick="vcloud.action(vcloud.VM_STATUS.ACTION_POWER_ON)">
                                                <i class="la la-desktop"></i>
                                                <span class="kt-nav__link-text kt-margin-l-5">Mở máy</span>
                                            </div>

                                            <div class="dropdown-item  group-power-on" style="cursor: pointer" onclick="vcloud.action(vcloud.VM_STATUS.ACTION_POWER_OFF)">
                                                <i class="la la-power-off"></i>
                                                <span class="kt-nav__link-text kt-margin-l-5">Tắt máy</span>
                                            </div>
                                            <div class="dropdown-item  group-power-on" style="cursor: pointer" onclick="vcloud.action(vcloud.VM_STATUS.ACTION_REBOOT)">
                                                <i class="la la-rotate-right"></i>
                                                <span class="kt-nav__link-text kt-margin-l-5">Mở lại máy</span>
                                            </div>
                                            <div class="dropdown-item  group-power-on" style="cursor: pointer" onclick="vcloud.action(vcloud.VM_STATUS.ACTION_SHUTDOWN)">
                                                <i class="la la-plug"></i>
                                                <span class="kt-nav__link-text kt-margin-l-5">Rút điện</span>
                                            </div>
                                            <div class="dropdown-item  group-power-on" style="cursor: pointer" onclick="vcloud.action(vcloud.VM_STATUS.ACTION_SUSPEND)">
                                                <i class="la la-pause"></i>
                                                <span class="kt-nav__link-text kt-margin-l-5">Tạm dừng</span>
                                            </div>

                                            <div class="dropdown-divider group-power-on"></div>
                                            <div class="dropdown-item group-power-on" style="cursor: pointer" onclick="vcloud.remote()">
                                                <i class="la la-rss"></i>
                                                <span class="kt-nav__link-text kt-margin-l-5">Mở liên kết</span>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
@endsection

@section('after_script')
    <script type="text/javascript" src="{{ asset('static/backend/js/product/service/vcloud.js?v='.time()) }}"></script>
    <script>
        window.customer_service_id = `{{$detail['customer_service_id']}}`;
        window.loading = `<img height="20" width="20" style="position:absolute; left :0; border: 0;" src="data:image/gif;base64,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" />`;
        window.vm_data = @json($detailVm);
        $('.group-power-off').addClass(`{{$detailVm["status"] != "4" ? "block-display" :"none-display"}}`);
        $('.group-power-on').addClass(`{{$detailVm["status"] == "4" ? "block-display" :"none-display"}}`);
    </script>
@endsection
