<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 1/16/2020
 * Time: 2:58 PM
 */

namespace Modules\Admin\Repositories\ReceiptEmail;


use App\Mail\Receipt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Admin\Models\ConfigTable;
use Modules\Admin\Models\ReceiptDetailTable;
use Modules\Admin\Models\ReceiptEmailLogTable;
use Modules\Admin\Models\ReceiptTable;
use Modules\Admin\Repositories\ReceiptEmail\ReceiptEmailRepositoryInterface;

class ReceiptEmailRepository implements ReceiptEmailRepositoryInterface
{
    protected $config;
    protected $receipt;
    protected $receiptDetail;
    protected $receiptEmailLog;

    public function __construct(
        ConfigTable $config,
        ReceiptTable $receipt,
        ReceiptDetailTable $receiptDetail,
        ReceiptEmailLogTable $receiptEmailLog
    )
    {
        $this->config = $config;
        $this->receipt = $receipt;
        $this->receiptDetail = $receiptDetail;
        $this->receiptEmailLog = $receiptEmailLog;
    }

    /**
     * Lưu email log để nhắc các receipt sắp hết hạn
     * @throws \Throwable
     */
    public function getReceiptPayExpired()
    {
        $config = $this->config->getItem(1);
        if ($config != null) {
            $arrConfig = explode(',', $config['value']);
            foreach ($arrConfig as $key => $value) {
                $expiredDay = Carbon::now()->addDays($value)->format('Y-m-d');

                $receipt = $this->receipt->getReceiptExpired($expiredDay);
                $arrReceiptId = [];
                foreach ($receipt as $item) {
                    $arrReceiptId[] = $item['receipt_id'];
                }
                //Số tiền đã trả của receipt.
                $receiptDetail = $this->receiptDetail->listAmountReceipt($arrReceiptId);
                $arrReceiptDetail = [];
                foreach ($receiptDetail as $item) {
                    $arrReceiptDetail[$item['receipt_id']] = $item['amount'];
                }

                //Các mail đã tồn tại.
                $emailExist = $this->receiptEmailLog->getEmailReceiptExpired($expiredDay);
                $tempReceipt = [];
                foreach ($emailExist as $item) {
                    $tempReceipt[] = $item['obj_id'];
                }
                $host = request()->getSchemeAndHttpHost();

                foreach ($receipt as $item) {
                    if ($item['customer_email'] != null
                        && $item['customer_email'] != ''
                        && !in_array($item['receipt_id'], $tempReceipt)
                    ) {
                        $view = view('admin::mail.remind-receipt', [
                                'data' => $item,
                                'host' => $host,
                                'receiptDetail' => $arrReceiptDetail]
                        )->render();
                        $data = [
                            'obj_id' => $item['receipt_id'],
                            'obj_code' => $item['receipt_no'],
                            'from_address' => env('MAIL_FROM_ADDRESS'),
                            'to_address' => $item['customer_email'],
                            'subject' => '[' . $item['receipt_no'] . '][' . $item['receipt_content'] . '] ',
                            'body_html' => $view,
                            'date_created' => Carbon::now(),
                            'date_modified' => Carbon::now(),
                            'is_sent' => 0,
                            'obj_type' => 'receipt_expired',
                            'pay_expired' => $item['pay_expired'],
                        ];

                        $this->receiptEmailLog->add($data);
                    }
                }
            }
        }
    }
}