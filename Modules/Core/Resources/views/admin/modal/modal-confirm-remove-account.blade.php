<div id="modal-confirm-remove-account">
    <div class="modal fade" id="kt_modal_confirm-remove-account" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @lang('core::user.remove.TITLE_REMOVE_ACCOUNT')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="kt-scroll ps ps--active-y" data-scroll="true" style="overflow: hidden;">
                        <p>
                            @lang('core::user.remove.REMOVE_ACCOUNT_DES')
                        </p>
                        <input id="user_id" hidden>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            onclick="remove.click()">
                        @lang('core::user.remove.BUTTON_CONFIRM')
                    </button>
                    <button type="button" data-dismiss="modal"
                            class="btn btn-primary">
                        @lang('core::user.remove.BUTTON_CANCEL')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>