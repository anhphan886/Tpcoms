<div class="modal fade" id="create-order" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-lg nt_modal" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                @if(isset($arrCart))
                    <h5 class="modal-title">Cập nhật sản phẩm</h5>
                @else
                    <h5 class="modal-title">Thêm sản phẩm</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-center margin-top li-center">
                        <div id="btn-product" class="btn-group btn-group with-100" role="group">
                            @foreach($arrProduct as $product)
                                @if(isset($arrCart))
                                    <a href="javascript:void(0)" class="btn item-product btn-outline-brand @if($product['product_id'] == $id) active  @endif">{{$product['product_name_vi']}}</a>
                                @else
                                    <a onclick="orderItem.loadProduct('{{$product['product_id']}}', this)" href="javascript:void(0)" class="btn item-product btn-outline-brand @if($product['product_id'] == $id) active  @endif">{{$product['product_name_vi']}}</a>
                                @endif

                            @endforeach
                        </div>
                    </div>
                </div>
                <form class="kt-form" id="form-product" style="margin: 0 auto;">
                    <input type="hidden" name="sessionId" value="{{$sessionId}}">
                    <div class="kt-portlet__body">
                        <div class="form-group row" id="list-product">
                            @include('product::order.popup.load-product')
                        </div>
                    </div>
                    @if(isset($key))
                        <input type="hidden" value="{{$key}}" name="key">
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                @if(isset($arrCart))
                    <button onclick="orderItem.addCart()" type="button" class="btn btn-primary">Cập nhật đơn hàng</button>
                @else
                    <button onclick="orderItem.addCart()" type="button" class="btn btn-primary">Thêm vào đơn hàng</button>
                @endif
            </div>
        </div>
    </div>
</div>


<script>
    orderItem._initModal();
</script>
