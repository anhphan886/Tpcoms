
    <div class="form-group row">
        <label class="col-xl-5 col-lg-5 col-form-label"> @lang('product::childAccount.index.user')</label>
        <div class="col-lg-7 col-xl-7">
            <input type="text" class="form-control" id="user_account" name="user_account"
                   hidden value="{{$detail['account_email']}}">
            <label class="col-form-label">{{$detail['account_email']}}</label>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-xl-5 col-lg-5 col-form-label">@lang('core::user.reset-password.AUTO_GENERATE_PWD')</label>
        <div class="col-lg-7 col-xl-7">
            <div class="col-lg-12 col-xl-12 col-form-label row">
                <span class="kt-switch kt-switch--success">
                                <label>
                                    <input type="checkbox" onchange="Add.autoGeneratePassword(this)">
                                    <span></span>
                                </label>
                            </span>
            </div>
            <div class="kt-input-icon kt-input-icon--right mt-3">
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="@lang('core::user.reset-password.PLACEHOLDER_PASSWORD')">
                <a href="javascript:void(0)" onclick="resetPass.show_password('#password')"
                   class="kt-input-icon__icon kt-input-icon__icon--right">
                <span class="kt-input-icon__icon kt-input-icon__icon--right">
                    <span><i class="la la-eye"></i></span>
                 </span>
                </a>
            </div>
            </div>

        </div>
    </div>
