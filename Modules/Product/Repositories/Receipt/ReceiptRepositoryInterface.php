<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 12/12/2019
 * Time: 10:23 AM
 */

namespace Modules\Product\Repositories\Receipt;


interface ReceiptRepositoryInterface
{
    public function cancelReceipt($id);

    public function getItem($id);

    public function getItemByCode($code);

    public function getOptionStaff();

    public function getReceiptDetail($receiptId);

    public function getListReceiptId($id);

    public function amountReceipt($receiptId);

    public function storeReceiptDetail(array $data);

    public function getDetailOrder($id);

    public function getOptionOrderStatus();

    public function getCustomerServiceByReceiptId($receiptId);
    /**
     * fucntion update thời hạn thanh toán phiếu thu
     * @param array $data
     * @param int $receipt_id
     * @return mixed
     */
    public  function updateTimeReceipt(array $data, $receipt_id);

    public function listAmountReceipt($receiptId);
}
