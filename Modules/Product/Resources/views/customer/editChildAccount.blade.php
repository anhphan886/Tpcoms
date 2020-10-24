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
    <form id="form-edit" method="POST">
        <div class="kt-subheader kt-grid__item" id="kt_subheader">

            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    @lang('product::childAccount.index.detail')
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

                </div>
                <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <button type="button" onclick="Add.editChildAccuont()" class="btn btn-info btn-bold">
                    @lang('product::childAccount.input.button_save')
                </button>
                <button type="button" onclick="Add.editChildAccuont(1)" class="btn btn-info btn-bold">
                    @lang('product::childAccount.input.save_and_exit')
                </button>

                <div>
                      <a href="#" class="btn background-orange kh-df-btn" data-toggle="dropdown" aria-expanded="false">
                        @lang('core::user.detail.CHOOSE_ACTION')<i class="flaticon-more-1 ml-2"></i>
                      </a>
                    <div class=" dropdown-menu dropdown-menu-right" x-placement="top-end"
                         style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(262px, 11px, 0px);">
                        <ul class="kt-nav ">
                            <li class="kt-nav__item ">
                                @include('helpers.button', ['button' => [
                                        'route' => 'product.customer.show-reset-password',
                                         'html' => '<a  href="javascript:void(0)"  onclick="resetPass.onlyReset(' . $detail['customer_account_id'] .')" class="kt-nav__link">'
                                         .'<i class="la la-edit"></i>'
                                         .'<span class="kt-nav__link-text kt-margin-l-5">'.__('core::user.detail.RESET_PASSWORD').'</span>'.
                                    '</a>'
                                ]])
                            </li>
                        </ul>
                    </div>
{{--                    <a href="{{route('customer.user.index')}}" class="btn btn-secondary">--}}
{{--                        @lang('core::user.create.CANCEL')--}}
{{--                    </a>--}}
                </div>

                <a href="{{route('product.customer.detail', $detail['customer_id'])}}" class="btn btn-secondary btn-bold">
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
                            {{--                                        <div class="kt-form__body">--}}

                            <div class="kt-section kt-section--first">
                                <div class="kt-section__body kh-margin-left">
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.name') <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" class="form-control form-group "
                                                   id="account_name"
                                                   name="account_name"
                                                   placeholder="" value="{{$detail['account_name']}}">
                                            <input type="hidden" id="customer_account_id"
                                                   value="{{$detail['customer_account_id']}}"
                                                    name="customer_account_id">
                                            <input type="hidden" id="customer_id"
                                                    value="{{$detail['customer_id']}}"
                                                    name="customer_id">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.type')</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select type="text" name="account_type" id ="account_type"
                                                    class="form-control --select2 ss--width-100 form-group ">
                                                @if (isset($accountType))
                                                    @foreach ($accountType as $key=>$value)
                                                        <option value="{{$key}}" {{$detail['account_type'] == $key ? "selected" :""}}>{{$value}}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.email')</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" class="form-control form-group "
                                                   id="email"
                                                   name="email"
                                                   placeholder="" value="{{$detail['account_email']}}" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.phone_number')<span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" class="form-control form-group "
                                                   id="account_phone"
                                                   name="account_phone"
                                                   placeholder="" value="{{$detail['account_phone']}}">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.cmnd') <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" class="form-control form-group "
                                                   id="account_id_num"
                                                   name="account_id_num"
                                                   placeholder="" value="{{$detail['account_id_num']}}" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.address') <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" class="form-control form-group "
                                                   id="address"
                                                   name="address"
                                                   placeholder="" value="{{$detail['address']}}">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.province')<span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6 width-100">
                                            <select type="text" name="province_id" id="province_id" class="form-control form-group --select2 " >
                                                    @if (isset($province))
                                                        @foreach ( $province as $value )
                                                            <option value="{{$value['provinceid']}}" {{$detail['province_id'] == $value['provinceid'] ? "selected" :""}}>
                                                                {{$value['type']}} {{$value['name']}}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            @lang('product::childAccount.index.status')
                                        </label>
                                        <div class="col-lg-9 col-xl-6">
                                            <label class="kt-switch kt-switch--success">
                                                <input type="checkbox" onchange="Add.change_status('{{$detail['is_active']}}', this)"
                                                       {{$detail['is_active']==1?'checked':''}} name="is_active" id="is_active">
                                                <span></span>
                                            </label>
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
    @include('product::customer.modal.modal-reset-password')
    @include('product::customer.modal.modal-reset-password-success')
@endsection
@section('after_script')
    <script type="text/javascript"
            src="{{ asset('static/backend/js/product/customer/child-account.js?v='.time()) }}"></script>
    <script type="text/template" id="tpl-auto-password">
        <div class="kt-input-icon kt-input-icon--right mt-3">
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="@lang('user::store-user.reset-password.PLACEHOLDER_PASSWORD')">
            <a href="javascript:void(0)" onclick="list.show_password('#password')"
               class="kt-input-icon__icon kt-input-icon__icon--right">
                <span class="kt-input-icon__icon kt-input-icon__icon--right">
                    <span><i class="la la-eye"></i></span>
                 </span>
            </a>
        </div>
    </script>
@endsection

