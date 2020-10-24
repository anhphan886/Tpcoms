<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 12/12/2019
 * Time: 10:23 AM
 */

namespace Modules\Product\Repositories\Receipt;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Models\CustomerServiceTable;
use Modules\Product\Models\InvoiceMapTable;
use Modules\Product\Models\InvoiceTable;
use Modules\Product\Models\OrderStatusTable;
use Modules\Product\Models\OrderTable;
use Modules\Product\Models\PortalAdminTable;
use Modules\Product\Models\ReceiptDetailTable;
use Modules\Product\Models\ReceiptTable;
use Modules\Product\Repositories\CodeGenerator\CodeGeneratorRepositoryInterface;
use Carbon\Carbon;
use App\Mail\Receipt;
use Illuminate\Support\Facades\Log;
use Modules\Product\Models\ReceiptEmailLogTable;

class ReceiptRepository implements ReceiptRepositoryInterface
{
    protected $receipt;
    protected $staff;
    protected $receiptDetail;
    protected $order;
    protected $orderStatus;
    protected $customerService;
    protected $invoice;
    protected $invoiceMap;
    protected $codeGenerator;

    public function __construct(
        ReceiptTable $receipt,
        PortalAdminTable $staff,
        ReceiptDetailTable $receiptDetail,
        OrderTable $order,
        OrderStatusTable $orderStatus,
        CustomerServiceTable $customerService,
        InvoiceTable $invoice,
        InvoiceMapTable $invoiceMap,
        CodeGeneratorRepositoryInterface $codeGenerator
    )
    {
        $this->receipt = $receipt;
        $this->staff = $staff;
        $this->receiptDetail = $receiptDetail;
        $this->order = $order;
        $this->orderStatus = $orderStatus;
        $this->customerService = $customerService;
        $this->invoice = $invoice;
        $this->invoiceMap = $invoiceMap;
        $this->codeGenerator = $codeGenerator;
    }

    /**
     * Hủy phiếu thu
     * @param $id
     *
     * @return array
     */
    public function cancelReceipt($id)
    {
        try {
            DB::beginTransaction();

            $this->receipt->edit(['status' => 'cancel'], intval($id));

            DB::commit();
            return [
                'error'   => 0,
                'message' => '',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error'   => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Lấy chi tiết hóa đơn
     * @param $id
     *
     * @return mixed
     */
    public function getItem($id)
    {
        $select = $this->receipt->getItem($id);
        return $select;
    }

    public function getListReceiptId($filter)
    {
        $select = $this->receipt->getListDataTable($filter);
//        dd($select);
        return $select;
    }

    /**
     * Lấy chi tiết hóa đơn theo mã receipt.
     * @param $id
     *
     * @return mixed
     */
    public function getItemByCode($code)
    {
        $select = $this->receipt->getItemByCode($code);
        return $select;
    }

    /**
     * Get option staff
     * @return mixed
     */
    public function getOptionStaff()
    {
        $select = $this->staff->getOption();
        return $select;
    }

    /**
     * Lấy chi tiết của phiếu thu.
     * @param $receiptId
     *
     * @return mixed
     */
    public function getReceiptDetail($receiptId)
    {
        $select = $this->receiptDetail->getReceiptDetail($receiptId);
        return $select;
    }

    /**
     * Tính tổng tiền đã thanh toán của phiếu thu
     * @param $receiptId
     *
     * @return mixed
     */
    public function amountReceipt($receiptId)
    {
        return $this->receiptDetail->amountReceipt($receiptId);
    }

    public function storeReceiptDetail(array $data)
    {
        try {
            DB::beginTransaction();
            $receiptId = intval($data['receipt_id']);
            $amount = str_replace(',', '', strip_tags($data['amount']));

            $receipt = $this->receipt->getInfo($receiptId);

            //Tiền phiếu thu đã trả.
            $amountReceipt = $this->amountReceipt($receiptId);
            //Tổng tiền phiếu thu trừ tiền phiếu thu đã trả trừ lần này thanh toán
            $amountReceipt = ($receipt['amount'] + $receipt['vat']) - $amountReceipt - $amount;

            if ($amountReceipt >= 0)
            {
                $dataInsert['receipt_id'] = $receiptId;
                $dataInsert['receipt_date'] = date('Y-m-d H:i:s');
                $dataInsert['receipt_by'] = strip_tags($data['receipt_by']);
                $dataInsert['payment_type'] = strip_tags($data['payment_type']);
                $dataInsert['amount'] = $amount;
                $dataInsert['payer'] = strip_tags($data['payer']);
                $dataInsert['note'] = strip_tags($data['description']);
                $dataInsert['is_deleted'] = 0;
                $dataInsert['created_by'] = Auth::id();
                $dataInsert['created_at'] = date('Y-m-d H:i:s');
//                $dataInsert['modified_at'] = date('Y-m-d H:i:s');
//                $dataInsert['modified_by'] = Auth::id();
                $dataInsert['link_file'] = '';
                if (isset($data['image_avatar'])) {
                    if ($data['image_avatar'] != '') {
                        $image = $this->transferTempFileToAdminFile($data['image_avatar'] );
                        $dataInsert['link_file'] = $image;
                    }
                }

                $this->receiptDetail->add($dataInsert);
                //Tính số tiền của phiếu thu đã trả
                $amountReceipt = intval($this->amountReceipt(intval($data['receipt_id'])));

                if (($receipt['amount'] + $receipt['vat']) == $amountReceipt) {
                    //Nếu đã thanh toán hết -> cập nhật lại trạng thái phiếu thu.
                    $editData = [
                        'status' => 'paid',
                        'paided_at' => date('Y-m-d H:i:s')
                    ];
                    $this->receipt->edit($editData,$receiptId);
                } elseif (($receipt['amount'] + $receipt['vat'] )> $amountReceipt) {
                    //Nếu tiền đã trả bằng 0 thì status phiếu thu = chưa thanh toán
                    if ($amountReceipt == 0) {
                        $this->receipt->edit(['status' => 'unpaid'],$receiptId);
                    } else {
                        $this->receipt->edit(['status' => 'part-paid'],$receiptId);
                    }
                }
                //Update order nếu đã trả đủ tiền

                ///Tiền tất cả phiểu thu(đã thanh toán) của hóa đơn.
                $amountReceiptOrder = $this->receipt->amountReceiptOrder($receipt['order_id']);
                //Tổng tiền của hóa đơn.
                $order = $this->order->getItem($receipt['order_id']);

                //Nếu hóa đơn đã thanh toán hết.
                if (intval($amountReceiptOrder) >= intval($order['amount'])) {
                    //Cập nhật status hóa đơn.
                    $this->order->edit(['order_status_id' => 4], $receipt['order_id']);
                }
                if ($receipt['customer_email'] != null && $receipt['customer_email'] != '') {
                    ///Gửi mail mỗi lần thanh toán
                    //Số tiền đã thanh toán của phiếu thu.
                    $amountReceipt = intval($this->amountReceipt(intval($data['receipt_id'])));
                    //Thông tin phiếu thu
                    $receipt = $this->receipt->getItem($receiptId);

                    $host = request()->getSchemeAndHttpHost();
                    $arrReceiptDetail[$receiptId] = $amountReceipt;

                    $admin = new PortalAdminTable();
                    $receiptBy = $admin->getItem(strip_tags($data['receipt_by']));

                    $dataEmail = [
                        'type' => 'receipt',
                        'receipt_id' => $receipt['receipt_id'],
                        'receipt_no' => $receipt['receipt_no'],
                        'amount' => $receipt['amount'],
                        'vat' => $receipt['vat'],
                        'status' => $receipt['status'],
                        'pay_expired' => $receipt['pay_expired'],
                        'receipt_content' => $receipt['receipt_content'],
                        'debt' => ($receipt['amount'] + $receipt['vat']) - $amountReceipt,
                        'pay_now' => $amount,
                        'payer' => strip_tags($data['payer']),
                        'receipt_by' => $receiptBy['full_name'],
                        'host' => $host,
                        'note' => strip_tags($data['description'])
                    ];
                    $view = view('admin::mail.remind-receipt', [
                            'data' => $dataEmail,
                            'receiptDetail' => $arrReceiptDetail
                        ]
                    )->render();

                    $data2 = [
                        'obj_id' => $receipt['receipt_id'],
                        'obj_code' => $receipt['receipt_no'],
                        'from_address' => env('MAIL_FROM_ADDRESS'),
                        'to_address' => $receipt['customer_email'],
                        'subject' => '[' . $receipt['receipt_no'] . '][' . $receipt['receipt_content'] . '] ',
                        'body_html' => $view,
                        'date_created' => Carbon::now(),
                        'date_modified' => Carbon::now(),
                        'is_sent' => 0,
                        'obj_type' => 'receipt_expired',
                        'pay_expired' => $receipt['pay_expired'],
                    ];
                    $receiptEmailLog = new ReceiptEmailLogTable();
                    $receiptEmailLog->add($data2);

//                    Mail::to($receipt['customer_email'])->send(new Receipt($dataEmail));
                }
                DB::commit();
                return [
                    'error' => false,
                    'message' => __('product::validation.receipt.receipt_success'),
                ];
            } else {
                return [
                    'error' => true,
                    'message' => __('product::validation.receipt.amount_money_equal'),
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => 1,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Chuyển file từ temp sang folder chính.
     * @param $path
     * @param $imgName
     *
     * @return string
     */
    private function transferTempFileToAdminFile($imgName)
    {
        $old_path = TEMP_PATH . '/' . $imgName;
        $exists = Storage::disk('public')->exists($old_path);

        if ($exists == true) {
            $new_path = CUSTOMER_UPLOADS_PATH . '/' . $imgName;
            Storage::disk('public')
                ->move($old_path, $new_path);
            return $new_path;
        }
        return '';
    }

    /**
     * Get detail order
     * @param $id
     *
     * @return mixed
     */
    public function getDetailOrder($id)
    {
        $select = $this->order->getItem($id);
        return $select;
    }

    /**
     * Get option order status
     * @return mixed
     */
    public function getOptionOrderStatus()
    {
        $select = $this->orderStatus->option();
        return $select;
    }

    /**
     * Get customer service by receipt.
     * @param $receiptId
     *
     * @return mixed
     */
    public function getCustomerServiceByReceiptId($receiptId)
    {
//        $select = $this->customerService->getCustomerServiceByReceiptId($receiptId);
        $select = $this->receipt->getListOrderDetail($receiptId);
        return $select;
    }

    /**
     * fucntion update thời hạn thanh toán phiếu thu
     * @param array $data
     * @param int $receipt_id
     * @return mixed
     */
    public  function updateTimeReceipt(array $data, $receipt_id){
        try {
            $receipt = $this->receipt->getDetailReceiptByID($receipt_id);
            if (isset($data['pay_expired'])){
                $data['pay_expired'] = str_replace('/', '-', $data['pay_expired']);
                $data['pay_expired'] = date('Y-m-d', strtotime($data['pay_expired']));
            }
            $receipt_data = [
                'pay_expired' => $data['pay_expired'],
            ];
            if ($receipt['created_at'] > $receipt_data['pay_expired']) {
                return [
                    'error'   => true,
                    'message' => 'Vui lòng chọn hạn thanh toán phải lớn hơn ngày tạo phiếu thu',
                ];
            } else {
                $result = $this->receipt->updateTimeReceipt($receipt_data, $receipt_id );

                return [
                    'error'   => false,
                    'message' =>  __('product::validation.receipt.edit_Success'),
                    'data' => $result
                ];
            }

        } catch (\Exception $e) {
            return [
                'error'   => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function listAmountReceipt($receiptId)
    {
        $result = $this->receiptDetail->listAmountReceipt($receiptId);

        return $result;
    }
}
