<form id="form-reset-password">
<div id="modal-reset-password">
    <div class="modal fade" id="kt_modal_reset_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Đổi mật khẩu tài khoản
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="kt-scroll ps ps--active-y" data-scroll="true" style="overflow: hidden;">

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="hidden-password">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('core::user.reset-password.BUTTON_CANCEL')
                    </button>
                    <button type="submit"
                            id="btn-add-group-child-to-list"
                            class="btn btn-primary"
                            onclick="Add.createPasswordNew()">
                        @lang('core::user.reset-password.BUTTON_CREATE_NEW_PWD')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
