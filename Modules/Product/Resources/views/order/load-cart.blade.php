<style>
    table tbody tr td {vertical-align: middle!important;}
</style>
<div class="kt-portlet__body">
    <table class="table table-striped table-store table-responsive-md">
        <thead class="thead-dark">
        <tr>
            <th width="5%">STT</th>
            <th width="15%">Hình thức</th>
            <th width="15%">Dịch vụ / Giải pháp</th>
            <th width="30%">Gói</th>
            <th width="15%">Thời gian (Tháng)</th>
            <th width="10%">Tổng chi phí</th>
            <th width="10%">Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = 0; $temp = [];
        ?>
        @if($arrCart)
            @foreach($arrCart as $key => $cart)
                @if(isset($cart['value_sold_together']) && count($cart['value_sold_together']) > 0)
                    @foreach($cart['value_sold_together'] as $s => $t)
                        <?php $temp[] = $t;?>
                    @endforeach
                @endif
                @if(isset($cart['attribute_sold_together']) && count($cart['attribute_sold_together']) > 0)
                    @foreach($cart['attribute_sold_together'] as $s1 => $t1)
                        <?php $temp[] = $t1; ?>
                    @endforeach
                @endif

                <tr>
                    <td>{{$key + 1}}</td>
                    <td>Đăng ký mới</td>
                    <td>{{$arrProduct[$cart['product_id']]['product_name_vi']}}</td>
                    <td>
                        <div class="row">
                            <?php
                            $money = 0;
                            ?>
                            @if(isset($cart['order_id']) && isset($arrOrder[$cart['order_detail_id']]) && @$arrOrder[$cart['order_detail_id']]['order_type'] == 'default')
                                <div class="col-8">
                                    @foreach($cart['value'] as $idAttr => $value)
                                        @if($value)
                                            @if(isset($arrAttribute[$idAttr]))
                                                <p>{{$value . ' '. $arrAttribute[$idAttr]['product_attribute_name_vi']}}</p>
                                                @if($arrAttribute[$idAttr]['is_sold_together'] == 1)
                                                    <?php
                                                    $money += $arrAttribute[$idAttr]['price_month'] * $cart['month'];
                                                    ?>
                                                @endif
                                            @endif
                                        @else
                                            <p>{{'Không giới hạn '. $arrAttribute[$idAttr]['product_attribute_name_vi']}}</p>
                                        @endif

                                    @endforeach
                                </div>
                                <div class="col-4" style="display: flex;text-align: right">
                                    <p>{{number_format($arrOrder[$cart['order_detail_id']]['price'])}}</p>
                                </div>
                                <?php
                                $money += $arrOrder[$cart['order_detail_id']]['price'] * $cart['month'];
                                $total += $money;
                                ?>
                            @else
                                @foreach($cart['value'] as $idAttr => $value)
                                    @if(!in_array($idAttr, $temp))
                                            <div class="col-8">
                                                @if($value)
                                                    @if(isset($arrAttribute[$idAttr]))
                                                        <p>{{$value . ' '. $arrAttribute[$idAttr]['product_attribute_name_vi']}}</p>
                                                    @endif
                                                @else
                                                    <p>{{'Không giới hạn '. $arrAttribute[$idAttr]['product_attribute_name_vi']}}</p>
                                                @endif
                                            </div>
                                            <div class="col-4" style="text-align: right">
                                                @if(isset($arrAttribute[$idAttr]))
                                                    <p>{{number_format($arrAttribute[$idAttr]['price_month'])}}</p>
                                                @endif
                                            </div>
                                            @if(isset($arrAttribute[$idAttr]))
                                                <?php
                                                $money += $arrAttribute[$idAttr]['price_month'] * $value * $cart['month'];
                                                ?>
                                            @endif
                                        @endif
                                @endforeach
                                    @if(isset($cart['value_sold_together']) && count($cart['value_sold_together']) > 0)
                                        @foreach($cart['value_sold_together'] as $s => $t)
                                            @foreach($allAttribute as $aAttribute)
                                                @if($aAttribute['product_attribute_id'] == $t)
                                                    <div class="col-8">
                                                        <p>{{'1 '. $aAttribute['product_attribute_name_vi']}}</p>
                                                    </div>
                                                    <div class="col-4" style="text-align: right">
                                                        <p>{{number_format($aAttribute['price_month'])}}</p>
                                                    </div>
                                                    <?php
                                                    $money += intval($aAttribute['price_month']) * $cart['month'];
                                                    ?>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif
                                    @if(isset($cart['attribute_sold_together']) && count($cart['attribute_sold_together']) > 0)
                                        @foreach($cart['attribute_sold_together'] as $s1 => $t1)
                                            @foreach($allAttribute as $aAttribute)
                                                @if($aAttribute['product_attribute_id'] == $t1)
                                                    <div class="col-8">
                                                        <p>{{'1 '. $aAttribute['product_attribute_name_vi']}}</p>
                                                    </div>
                                                    <div class="col-4" style="text-align: right">
                                                        <p>{{number_format($aAttribute['price_month'])}}</p>
                                                    </div>
                                                    <?php
                                                    $money += intval($aAttribute['price_month']) * $cart['month'];
                                                    ?>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif
                                <?php
                                $total += $money;
                                ?>
                            @endif

                        </div>

                    </td>
                    <td>
                        <input onchange="orderItem.updateMonth('{{$key}}', this)" data-min="1" data-max="60" data-step="1" type="text" class="kt_touchspin" name="month[{{$key}}]" value="{{$cart['month']}}"/></td>
                    <td>

                        {{number_format($money)}}
                    </td>
                    <td class="text-center">
                        <button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hành động
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                            @if(isset($cart['order_id']) && isset($arrOrder[$cart['order_detail_id']]) && @$arrOrder[$cart['order_detail_id']]['order_type'] == 'default')
                            @else
                                <a onclick="orderItem.loadPopup('{{$key}}')" href="javascript:void(0)" class="dropdown-item">
                                    <i class="la la-edit"></i>
                                    <span class="kt-nav__link-text kt-margin-l-5">Sửa</span>
                                </a>
                            @endif

                            <a  onclick="orderItem.deleteCart('{{$key}}')" href="javascript:void(0)" class="dropdown-item">
                                <i class="la la-trash"></i>
                                <span class="kt-nav__link-text kt-margin-l-5">Xóa</span>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" align="center"> Chưa có dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
<div class="kt-portlet__footer">
    <div class="col-12">
        <div class="form-group row">
            <div class="col-12 col-lg-5 col-md-8 offset-lg-7 offset-md-4 ">
                <table class="table">
                    <thead>
                    <tr>
                        <td><strong>Giá chưa thuế :</strong></td>
                        <td>{{number_format($total)}} VNĐ</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <strong>Giảm giá :</strong>
                        </td>
                        <td>
                            @if(isset($arrPromotion) && $arrPromotion)
                                {{number_format($arrPromotion['total'])}} VNĐ <a href="javascript:void(0)" onclick="orderItem.loadPromotion()" class="btn btn-primary btn-sm btn-icon btn-circle"><i class="fa fa-plus"></i></a>
                            @else
                                0 VNĐ <a href="javascript:void(0)" onclick="orderItem.loadPromotion()" class="btn btn-primary btn-sm btn-icon btn-circle"><i class="fa fa-plus"></i></a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Giá sau khi giảm :</strong></td>
                        @if($total - @$arrPromotion['total'] > 0)
                            <td>{{number_format($total - @$arrPromotion['total'])}} VNĐ</td>
                        @else
                            <td>0 VNĐ</td>
                        @endif
                    </tr>
                    <tr>
                        <td><strong>Thuế :</strong></td>
                        @if((($total - @$arrPromotion['total'])/10) > 0)
                            <td><strong>{{number_format(($total - @$arrPromotion['total'])/10)}} VNĐ</strong></td>
                        @else
                            <td>0 VNĐ</td>
                        @endif
                    </tr>
                    <tr>
                        <td><strong>Tổng :</strong></td>
                        @if((($total - @$arrPromotion['total']) + (($total - @$arrPromotion['total'])/10)) > 0)
                            <td><strong>{{number_format(($total - @$arrPromotion['total']) + (($total - @$arrPromotion['total'])/10))}} VNĐ</strong></td>
                        @else
                            <td>0 VNĐ</td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 text-center">
        <a href="{{route('product.order')}}" class="btn btn-secondary">Hủy</a>
        @if($orderId)
            <a href="javascript:void(0)" onclick="orderItem.doOrder('{{$orderId}}')" class="btn btn-primary">Cập nhật đơn hàng</a>
        @else
            <a href="javascript:void(0)" onclick="orderItem.doOrder()" class="btn btn-primary">Tạo đơn hàng</a>
        @endif
    </div>
</div>
