<div class="modal fade" id="kt_modal_reset_password_success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    @lang('core::user.reset-password.TITLE_RESET_PASSWORD_SUCCESS')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="kt-scroll ps ps--active-y" data-scroll="true" style="overflow: hidden;">
                    <form id="form-reset-password-success">
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">@lang('core::user.reset-password.USER_ACCOUNT')</label>
                            <div class="col-lg-9 col-xl-9">
                                <label class="col-form-label" id="phone">{{$email}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">@lang('core::user.reset-password.FULL_NAME')</label>
                            <div class="col-lg-9 col-xl-9">
                                <label class="col-form-label" id="fullname">{{$full_name}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">@lang('core::user.reset-password.PASSWORD')</label>
                            <div class="col-lg-9 col-xl-9">
                                <div class="kt-input-icon kt-input-icon--right">
                                    <input style="background: rgba(0,0,0,0);border: none;padding-left: 0;"
                                           class="form-control" type="password" id="password-label" name="password-label" value="{{$password}}"
                                    >
                                    <a href="javascript:void(0)" onclick="Add.show_password('#password-label')" class="kt-input-icon__icon kt-input-icon__icon--right">
                <span  class="kt-input-icon__icon kt-input-icon__icon--right">
                    <span><i class="la la-eye"></i></span>
                 </span>
                                    </a>
                                </div>
                                <div class="kt-input-icon kt-input-icon--right">
                                    <a href="javascript:void(0)" onclick="Add.copyToClipboard()" class="col-form-label">@lang('core::user.reset-password.CLICK_TO_COPY_PASSWORD')</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                        id="btn-add-group-child-to-list"
                        class="btn btn-primary"
                        data-dismiss="modal" aria-label="Close"
                        onclick="Add.reload()">
                    @lang('core::user.reset-password.BUTTON_FINISHED')
                </button>
            </div>
        </div>
    </div>
</div>
