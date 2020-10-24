<div class="modal fade nt_pop" id="kt_promotion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mã giảm giá</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills nav-fill" role="tablist">
                    <li class="nav-item">
                        <a onclick="$('#voucher_type').val('cash')" class="nav-link @if((isset($voucher_type) && $voucher_type =='cash') || !isset($voucher_type)) active @endif" data-toggle="tab" href="#kt_tabs_5_1">Giảm giá trực tiếp</a>
                    </li>
                    <li class="nav-item">
                        <a onclick="$('#voucher_type').val('code')" class="nav-link @if(isset($voucher_type) && $voucher_type =='code') active @endif" data-toggle="tab" href="#kt_tabs_5_2">Giảm giá theo mã</a>
                    </li>
                </ul>
                <form id="form-promotion" method="POST"  autocomplete="off">
                    <input type="hidden" name="sessionId" value="{{$sessionId}}">
                    <input type="hidden" value="{{isset($voucher_type) ? $voucher_type : 'cash'}}" name="voucher_type" id="voucher_type">
                    <div class="tab-content">
                        <div class="tab-pane {{!isset($voucher_type) || $voucher_type != 'code' ? 'active' : ''}}" id="kt_tabs_5_1" role="tabpanel">
                            <div class="form-group">
                                <div class="kt-radio-inline">
                                    <label class="kt-radio">
                                        <input @if((isset($cash_type) && $cash_type == 'money') || !isset($cash_type)) checked @endif type="radio" onchange="orderItem.changePromotion(this)" name="cash_type" value="money"> Tiền mặt (VNĐ)
                                        <span></span>
                                    </label>
                                    <label class="kt-radio">
                                        <input @if(isset($cash_type) && $cash_type =='percent') checked @endif type="radio" onchange="orderItem.changePromotion(this)" name="cash_type" value="percent"> Phần trăm (%)
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group value_type value_money" @if(isset($cash_type) && $cash_type == 'percent') style="display: none" @endif>
                                <input type="text" class="kt-money form-control"
                                       name="cash_money_value" value="{{@$cash_money_value}}"/>
                            </div>

                            <div class="form-group value_type value_percent" @if((isset($cash_type) && $cash_type == 'money') || !isset($cash_type)) style="display: none" @endif>
                                <input data-min="1" data-step="1" data-max="100" type="text" class="kt_touchspin"
                                       name="cash_percent_value" value="{{@$cash_percent_value}}"/>
                            </div>

                        </div>
                        <div class="tab-pane {{isset($voucher_type) && $voucher_type == 'code' ? 'active' : ''}}" id="kt_tabs_5_2" role="tabpanel">
                            <div class="form-group">
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                       name="voucher_code" style="text-transform: uppercase;" id="voucher_code"
                                       value="{{@$voucher_code}}"
                                       placeholder="Nhập mã giảm giá">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button onclick="orderItem.addPromotion()" type="submit" class="btn btn-primary">Xác nhận</button>
            </div>
        </div>
    </div>
</div>
