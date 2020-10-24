
    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label">Tài khoản</label>
        <div class="col-lg-9 col-xl-9">
            <input type="text" class="form-control" id="user_account" name="user_account"
                   hidden value="{{$item['email']}}">
            <label class="col-form-label">{{$item['email']}}</label>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label">@lang('core::user.reset-password.AUTO_GENERATE_PWD')</label>
        <div class="col-lg-9 col-xl-9">
            <div class="col-lg-12 col-xl-12 col-form-label row">
                <span class="kt-switch kt-switch--success">
                                <label>
                                    <input type="checkbox" onchange="Add.autoGeneratePassword(this)">
                                    <span></span>
                                </label>
                            </span>
            </div>
            {{--<div class="kt-input-icon kt-input-icon--right mt-3">--}}
                {{--<input type="password" class="form-control" id="password" name="password"--}}
                       {{--placeholder="@lang('core::user.reset-password.PLACEHOLDER_PASSWORD')">--}}
                {{--<a href="javascript:void(0)" onclick="list.show_password('#password')"--}}
                   {{--class="kt-input-icon__icon kt-input-icon__icon--right">--}}
                {{--<span class="kt-input-icon__icon kt-input-icon__icon--right">--}}
                    {{--<span><i class="la la-eye"></i></span>--}}
                 {{--</span>--}}
                {{--</a>--}}
            {{--</div>--}}

            <div class="append-password">
                <div class="kt-input-icon kt-input-icon--right mt-3">
                    <input type="password" class="form-control" id="password2" name="password2"
                           placeholder="@lang('core::user.reset-password.PLACEHOLDER_PASSWORD')">
                    <span></span>
                    <a href="javascript:void(0)" onclick="list.show_password('#password2')"
                       class="kt-input-icon__icon kt-input-icon__icon--right">
                <span class="kt-input-icon__icon kt-input-icon__icon--right">
                    <span><i class="la la-eye"></i></span>
                 </span>
                    </a>
                </div>
                {{--<div class="kt-input-icon kt-input-icon--right mt-3">--}}
                    {{--<input type="password" class="form-control" id="confirm_password2" name="confirm_password2"--}}
                           {{--placeholder="Xác nhận mật khẩu">--}}
                    {{--<span></span>--}}
                    {{--<a href="javascript:void(0)" onclick="list.show_password('#confirm_password2')"--}}
                       {{--class="kt-input-icon__icon kt-input-icon__icon--right">--}}
                {{--<span class="kt-input-icon__icon kt-input-icon__icon--right">--}}
                    {{--<span><i class="la la-eye"></i></span>--}}
                 {{--</span>--}}
                    {{--</a>--}}
                {{--</div>--}}
            </div>

        </div>
    </div>
    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label">@lang('core::user.reset-password.REQUIRE_CHANGE_PWD_NEXT_LOGIN')</label>
        <div class="col-lg-9 col-xl-9">
            <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                <input type="checkbox" checked id="is_activateds" name="is_activateds" onclick="Add.isChangePass(this)">
                <span></span>
            </label>
        </div>
    </div>
