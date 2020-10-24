<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/18/2019
 * Time: 9:46 AM
 */

namespace Modules\Product\Repositories\Order;


interface OrderRepositoryInterface
{
    public function getList(array $data = []);

    public function optionProvince(array $data = []);

    public function optionDistrict(array $data = []);

    public function status(array $data = []);

    public function optionProduct(array $data = []);

    public function optionCreateBy(array $data = []);

    public function create();

    public function edit($code);

    public function loadPromotionCartEdit($id);

    public function loadPopupCreateOrder($id);

    public function loadProduct($id);

    public function loadCart($sessionId);

    public function doOder($params);

    public function addPromotion($data);

    public function detail(array $data = []);

    public function getListInvoice($data);

    public function getItemByCode($code);

    public function approveOrder($orderId, $option, $value);

    public function approveAdjustOrder($orderId, $type);

    public function payOrder($orderId);

    public function getListOrderDetail($code);

    public function getDetail($code);

    public function add(array $data);

    public function allAttribute($id, $arr);

    public function getListByProductId($productId);

    public function getAttributeGroupBK($productId);

    public function countOrder($id);

    public function loadPopupCreateOrderAdjust(array $data = []);

    public function adjustService(array $data = []);

    public function submitCreateOrderAdjust(array $data = []);

    public function getCustomerService(array $filters = []);

    public function getPackageOrderAdjust(array $data = []);

    /**
     * Lấy danh sách sản phẩm/dịch vụ không phân trang
     *
     * @param array $filters
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getListService(array $filters = []);

    /**
     * Lấy chi tiết khách hàng theo account
     *
     * @param int $customerId
     * @return mixed|null
     * @throws \MyCore\Api\ApiException
     */
    public function getDetailCustomer($customerId);
}
