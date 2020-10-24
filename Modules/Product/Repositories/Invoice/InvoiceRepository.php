<?php


namespace Modules\Product\Repositories\Invoice;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Admin\Exports\InvoiceExport;
use Modules\Product\Models\InvoiceTable;
use Modules\Product\Models\InvoiceExtendsTable;
use Modules\Product\Models\ReceiptTable;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    protected  $invoice;
    protected  $receipt;
    protected $invoice_extends;
    public function __construct(
        InvoiceTable $invoice,
        ReceiptTable $receipt,
        InvoiceExtendsTable $invoice_extends
    ) {
       $this->invoice = $invoice;
       $this->invoice_extends = $invoice_extends;
       $this->receipt = $receipt;
    }

    /**
     * function get detail invoice by invoice_no
     * @param int $invoice_no
     * @return mixed
    */
    public function getDetail($invoice_no)
    {
        return $this->invoice->getDetail($invoice_no);
    }
    public function getByInvoice($invoice_id){
        return $this->invoice_extends->getByInvoice($invoice_id);
    }
    public function updateInvoiceAmount($invoice_no){
        try{        
            $invoiceDetail = $this->invoice->getDetail($invoice_no);
            $netAmount = $this->calcInvoice($invoiceDetail['invoice_id']);
            $result = $this->receipt->updateReceiptByInvoice([
                'amount' => $netAmount / 1.1,
                'vat' => ($netAmount / 1.1) * 0.1
             ], $invoiceDetail['invoice_id']);
            if($result['error'] == 1){
                return $result;
            }
            $result = $this->invoice->updateInvoice([
                'amount' => $netAmount
            ], $invoiceDetail['invoice_id']);
            return [
                'error' => 0
            ];
        }catch(\Exception $e){
            return [
                'error' => 1
            ];
        }
    }
    public function insertInvoiceExtend($invoice_no, $price, $content){
        $invoiceDetail = $this->invoice->getDetail($invoice_no);
        $result = $this->updateInvoiceAmount($invoiceDetail['invoice_no']);
        if($result['error'] == 1){
            return [
                'error' => $result['error'],
                'message' => isset($result['message']) ? $result['message'] : 'Cập nhật hóa đơn thành công'
            ];
    
        }
        $inserted = [
            'invoice_extends_code' => getCode(CODE_INVOICE_EXTENDS, $this->invoice_extends->getNumberForCode()), 
            'invoice_id' => $invoiceDetail['invoice_id'],
            'price' => $price,
            'content' => $content,
            'created_at' => Carbon::now(),
            'created_by' => Auth::id(),
            'updated_at' => Carbon::now()            
        ];
        $id = $this->invoice_extends->insertItem($inserted);
        if($id){
            $result = $this->updateInvoiceAmount($invoice_no);
            return [
                'error' => $result['error'],
                'message' => isset($result['message']) ? $result['message'] : 'Cập nhật hóa đơn thành công'
            ];    
        }else{
            return [
                'error' => 1,
                'message' => 'Không thể thểm hóa đơn vào được',
            ];
        }
    }
    public function calcInvoice($invoice_id){
        $invoiceDetail = $this->invoice->getItem($invoice_id);
        $sum = $this->invoice_extends->getByInvoiceSum($invoice_id);
        $total = ($invoiceDetail['net'] + $invoiceDetail['vat']) * (100 - ($invoiceDetail['reduce_percent'] ?? 0)) / 100;
        $total = $total + $sum;
        return $total;
    }
    public function deleteInvoiceExtends($invoice_extends_code, $invoice_no){
        $result = $this->updateInvoiceAmount($invoice_no);
        if($result['error'] == 1){
            return [
                'error' => $result['error'],
                'message' => isset($result['message']) ? $result['message'] : 'Xóa phí hóa đơn thành công'
            ];
    
        }
        if($this->invoice_extends->removeItem($invoice_extends_code)){
            $result = $this->updateInvoiceAmount($invoice_no);
            return [
                'error' => $result['error'],
                'message' => isset($result['message']) ? $result['message'] : 'Xóa phí hóa đơn thành công'
            ];
        }else{
            return [
                'error' => 1,
                'message' => 'Xóa phí hóa đơn thất bại'
            ];
        }
    }
    /**
     * function get detail invoice by invoice_no
     * @param int $invoice_no
     * @return mixed
     */
    public function updateInvoice(array $data, $invoice_id)
    {
//        dd($data);
        if (isset($data['invoice_at'])){
            $data['invoice_at'] = str_replace('/', '-', $data['invoice_at']);
            $data['invoice_at'] = date('Y-m-d', strtotime($data['invoice_at']));
        }
        $invoiceDetail = $this->invoice->getItem($invoice_id);
        $netAmount = $this->calcInvoice($invoice_id);
        try {
            $dataInvoice = [
                'invoice_number' => $data['invoice_number'],
                'invoice_id' => $data['invoice_id'],
                'invoice_at' => $data['invoice_at'] ? Carbon::parse($data['invoice_at'])->format('Y-m-d') : '',
                'invoice_by' => $data['invoice_by'],
                'amount' => $netAmount,
                'reduce_percent' => $data['reduce_percent'],
                'status' => $data['status']
            ];
            if($data['reduce_percent'] != $invoiceDetail['reduce_percent']){
                $result = $this->updateInvoiceAmount($invoiceDetail['invoice_no']);
                if($result['error'] == 1){
                    return [
                        'error' => $result['error'],
                        'message' => isset($result['message']) ? $result['message'] : 'Cập nhật hóa đơn thành công'
                    ];
            
                }        
            }
//            dd($dataInvoice);
            $result = $this->invoice->updateInvoice($dataInvoice, $invoice_id);
            if($result && $data['reduce_percent'] != $invoiceDetail['reduce_percent']){
                $result = $this->updateInvoiceAmount($invoiceDetail['invoice_no']);
                if($result['error'] == 1){
                    return [
                        'error' => $result['error'],
                        'message' => isset($result['message']) ? $result['message'] : 'Cập nhật hóa đơn thành công'
                    ];
            
                }    
            }
            return [
                'error' =>0,
                'message' => __('product::invoice.info.update_success'),
                'data' => $result,
            ];

        } catch (\Exception $e) {
            return [
                'aaaaa' => $e->getMessage(),
                'invoice_id'  => $invoice_id,
                'error' => 1,
                'message' => __('product::invoice.info.update_faile'),
            ];
        }

    }
    public function getInfoInvoiceExtends($invoice_extends_code){
        $invoiceExtend = $this->invoice_extends->getDetailByCode($invoice_extends_code);
        $invoiceInfo = $this->invoice->getItem($invoiceExtend['invoice_id']);
        return [
            'invoice' => $invoiceInfo,
            'invoiceExtend' => $invoiceExtend
        ];
    }
    public function editInvoiceExtend($invoice_extends_code, $price, $content){
        $invoiceExtend = $this->invoice_extends->getDetailByCode($invoice_extends_code);
        $invoiceInfo = $this->invoice->getItem($invoiceExtend['invoice_id']);
        $result = $this->updateInvoiceAmount($invoiceInfo['invoice_no']);
        if($result['error'] == 1){
            return [
                'error' => $result['error'],
                'message' => isset($result['message']) ? $result['message'] : 'Cập nhật phí hóa đơn thành công'
            ];
    
        }
        if($this->invoice_extends->editItem([
            'price' => $price,
            'content' => $content
        ], $invoice_extends_code)){
            $result = $this->updateInvoiceAmount($invoiceInfo['invoice_no']);
            return [
                'error' => $result['error'],
                'message' => isset($result['message']) ? $result['message'] : 'Cập nhật phí hóa đơn thành công'
            ];
        }else{
            return [
                'error' => 1,
                'message' => 'Cập nhật phí hóa đơn thất bại'
            ];
        }
    }
    
}
