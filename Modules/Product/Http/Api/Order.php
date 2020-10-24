<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/18/2019
 * Time: 9:48 AM
 */

namespace Modules\Product\Http\Api;

use MyCore\Api\ApiAbstract;

class Order extends ApiAbstract
{
    /**
     * Danh sách đơn hàng
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $data = [])
    {
        return $this->baseClient('/order/list-order', $data,false);
    }

    /**
     * Chi tiết đơn hàng
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function detail(array $data = [])
    {
        return $this->baseClient('/order/order-detail', $data);
    }

    /**
     * Option trạng thái đơn hàng
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function status(array $data = [])
    {
        return $this->baseClient('/order/order-status', $data);
    }

    /**
     * Option sản phẩm / dịch vụ.
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function optionProduct(array $data = [])
    {
        return $this->baseClient('/option-product', $data);
    }

    /**
     * Option người tạo
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function optionCreateBy(array $data = [])
    {
        return $this->baseClient('/option-create-by', $data);
    }

    public function getMoneyVoucher(array $data=[])
    {
        return $this->baseClient('/cart/money-voucher',$data);
    }

    public function createVoucherLog(array $data=[])
    {
        return $this->baseClient('/cart/create-voucher-log',$data);
    }

    public function deleteVoucherLog(array $data=[])
    {
        return $this->baseClient('/cart/delete-voucher-log',$data);
    }
}
//
