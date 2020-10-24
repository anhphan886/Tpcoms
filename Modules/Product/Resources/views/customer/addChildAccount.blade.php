@extends('layout')
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <style>
        .image-big {
            width: 170px !important;
            height: 170px !important;
        }
    </style>
    <form id="form-add" method="POST">
        <div class="kt-subheader kt-grid__item" id="kt_subheader">

            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('product::childAccount.index.add')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <button type="button" onclick="createChildAccount.createChildAccount()" class="btn btn-info btn-bold">
                    @lang('product::childAccount.input.button_save')
                </button>
                <button type="button" onclick="createChildAccount.createChildAccount(1)" class="btn btn-info btn-bold">
                    @lang('product::childAccount.input.save_and_exit')
                </button>

                <a href="{{route('product.customer.detail', ['id' => $customer_id]) }}" class="btn btn-secondary btn-bold">
                    @lang('product::childAccount.index.cancel')
                </a>
            </div>
        </div>
        <!--begin: Datatable -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="kt_apps_user_edit_tab_1" role="tabpanel">
                            <div class="kt-section kt-section--first">
                                <div class="kt-section__body kh-margin-left">
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.name') <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" class="form-control form-group "
                                                   id="account_name"
                                                   name="account_name"
                                                   placeholder="" value="">
                                            <input type="hidden" id="customer_id" name="customer_id" value="{{$customer_id}}">
                                            <input type="hidden"  name="is_active" id="is_active" value="1" checked>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.type')<span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select type="text" name="account_type" id ="account_type"
                                                    class="form-control  ss--width-100 form-group ">
                                                <option value="" selected> @lang('product::childAccount.index.choose_type')</option>
                                                @if (isset($accountType))
                                                    @foreach ($accountType as $key=>$value)
                                                        <option value="{{$key}}" >{{$value}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.email')<span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" class="form-control form-group "
                                                   id="email"
                                                   name="email"
                                                   placeholder="" value="" >
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.pass')<span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password" class="form-control form-group "
                                                   id="password"
                                                   name="password"
                                                   placeholder="" value="" >
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.confirm_pass')<span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password" class="form-control form-group "
                                                   id="password_confirm"
                                                   name="password_confirm"
                                                   placeholder="" value="" >
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                                @lang('product::childAccount.index.phone_number')<span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" class="form-control form-group "
                                                   id="account_phone"
                                                   name="account_phone"
                                                   placeholder="" value="">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.cmnd') <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" class="form-control form-group "
                                                   id="account_id_num"
                                                   name="account_id_num"
                                                   placeholder="" value="">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.address') <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" class="form-control form-group "
                                                   id="address"
                                                   name="address"
                                                   placeholder="" value="">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.province')<span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6 width-100">
                                            <select type="text" name="province_id" id="province_id" class="form-control form-group " >
                                                <option value="" selected>@lang('product::childAccount.index.choose')</option>
                                                @if (isset($province))
                                                    @foreach ( $province as $value )
                                                        <option value="{{$value['provinceid']}}" >
                                                            {{$value['type']}} {{$value['name']}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--                                        </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/add-childAccount.js?v='.time()) }}"></script>
{{--    <script type="text/template" id="tpl-auto-password">--}}
{{--        <div class="kt-input-icon kt-input-icon--right mt-3">--}}
{{--            <input type="password" class="form-control" id="password" name="password"--}}
{{--                   placeholder="@lang('user::store-user.reset-password.PLACEHOLDER_PASSWORD')">--}}
{{--            <a href="javascript:void(0)" onclick="list.show_password('#password')"--}}
{{--               class="kt-input-icon__icon kt-input-icon__icon--right">--}}
{{--                <span class="kt-input-icon__icon kt-input-icon__icon--right">--}}
{{--                    <span><i class="la la-eye"></i></span>--}}
{{--                 </span>--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </script>--}}
@endsection

