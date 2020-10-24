<?php


namespace Modules\Product\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use MyCore\Models\Traits\ListTableTrait;

class ReceiptTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'receipt';
    protected $primaryKey = 'receipt_id';
    protected $fillable = [
        'receipt_id', 'receipt_no', 'customer_contract_id', 'order_id', 'amount',
        'pay_expired', 'status', 'receipt_content', 'is_actived', 'vat',
        'is_deleted', 'created_by', 'created_at', 'modified_by', 'modified_at', 'paided_at'
    ];
    public $timestamps = false;

    /**
     * Thêm thuộc tính receipt.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }
    public function updateReceiptByInvoice($data, $invoice_id){
        $receiptDetail = $this->select([$this->table.'.status', $this->table.'.receipt_id'])
            ->join('invoice_map', 'invoice_map.receipt_id', '=', $this->table.'.receipt_id')
            ->join('invoice', 'invoice.invoice_id', '=', 'invoice_map.invoice_id')
            ->where('invoice.invoice_id', $invoice_id)
            ->first();
        if($receiptDetail['status'] == 'unpaid'){
            $result = $this->where('receipt_id', $receiptDetail['receipt_id'])->update($data);
            return ['error' => 0, 'message' => 'Cập nhật thành công'];
        }else{
            return ['error' => 1, 'message' => 'Phiếu thu đã được thanh toán, không thể cập nhật phần trăm tiền phải trả'];
        }
    }
    protected function getListCore(&$filters)
    {
        $ds = $this->select(
            'receipt.receipt_id',
            'receipt.receipt_no',
            'receipt.pay_expired',
            'receipt.status',
            'receipt.amount',
            'receipt.vat',
            'receipt.receipt_content',
            'receipt.is_actived',
            'receipt.is_deleted',
            'receipt.created_by',
            'receipt.created_at',
            'receipt.modified_by',
            'receipt.modified_at',
            'customer.customer_name'
        )
            ->leftJoin('receipt_map', 'receipt_map.receipt_id', '=', 'receipt.receipt_id')
            ->leftJoin(
                'customer_service',
                'customer_service.customer_service_id',
                '=',
                'receipt_map.customer_service_id'
            )
//            ->join('order', 'order.order_id', '=', 'receipt.order_id')
//            ->leftJoin('customer', 'customer.customer_id', '=' , 'order.customer_id' );
            ->leftJoin('order', 'order.order_id', '=', 'receipt.order_id')
            ->leftJoin('customer', 'customer.customer_id', '=' , 'customer_service.customer_id' );
        if (isset($filters['receipt$receipt_no']) && $filters['receipt$receipt_no']) {
            $ds->where('receipt.receipt_no', 'like', '%' . strtoupper($filters['receipt$receipt_no']) . '%');
            unset($filters['receipt$receipt_no']);
        }

        if (isset($filters['id']) && $filters['id']) {

            $ds->where('customer.customer_id', '=', $filters['id']);
            unset($filters['id']);
        }

        if (isset($filters['customer$customer_id']) && $filters['customer$customer_id']) {

            $ds->where('customer.customer_id', $filters['customer$customer_id']);
            unset($filters['customer$customer_id']);
        }

        if (isset($filters['debt']) && $filters['debt']) {
            $ds->whereIn('receipt.status', ['part-paid', 'unpaid']);
            unset($filters['debt']);
        }

        if (isset($filters['receipt$pay_expired']) && $filters['receipt$pay_expired']) {

           if ($filters['receipt$pay_expired'] == 'out_of_day') {
               $ds->where($this->table.'.pay_expired', '<', date('Y-m-d H:i:m'))
                   ->where($this->table.'.status', '<>', 'paid')
                   ->where($this->table.'.status', '<>', 'cancel')
                   ->where($this->table.'.status', '<>', 'refund');
           }
           unset($filters['receipt$pay_expired']);
        }

        if (isset($filters['choose_day']) && $filters['choose_day']) {
            $arr_filter = explode(" - ", $filters['choose_day']);
            $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])->format('Y-m-d');
            $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])->format('Y-m-d');
            $ds->whereBetween(DB::RAW('DATE(portal_receipt.pay_expired)'), [$startTime . ' 00:00:00', $endTime . ' 23:59:59'])
                ->where($this->table.'.status', '<>', 'paid')
                ->where($this->table.'.status', '<>', 'cancel')
                ->where($this->table.'.status', '<>', 'refund');
            unset($filters['choose_day']);
        }

        if (isset($filters['out_of_day']) && $filters['out_of_day']) {
            $arr_filter = explode(" - ", $filters['out_of_day']);
            $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])->format('Y-m-d');
            $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])->format('Y-m-d');
            $ds->whereBetween(DB::RAW('DATE(portal_receipt.pay_expired)'), [$startTime . ' 00:00:00', $endTime . ' 23:59:59'])
                ->where($this->table.'.status', '<>', 'paid')
                ->where($this->table.'.status', '<>', 'cancel')
                ->where($this->table.'.status', '<>', 'refund');
            unset($filters['out_of_day']);
        }

        return $ds->groupBy('receipt.receipt_id')->orderBy('receipt.receipt_id', 'desc');
    }

    /**
     * edit
     * @param array $data
     * @param       $id
     *
     * @return mixed
     */
    public function edit(array $data, $id)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }

    /**
     * Get item
     * @param $id
     *
     * @return mixed
     */
    public function getItem($id)
    {
        $select = $this->select(
            'receipt.receipt_id',
            'receipt.receipt_no',
            'receipt_map.customer_service_id',
            'receipt.order_id',
            'receipt.amount',
            'receipt.vat',
            'receipt.pay_expired',
            'receipt.status',
            'receipt.receipt_content',
            'receipt.is_actived',
            'receipt.is_deleted',
            'receipt.created_by',
            'receipt.created_at',
            'receipt.modified_by',
            'receipt.modified_at',
            'customer.customer_name',
            'customer.customer_email'
        )
            ->join('receipt_map', 'receipt_map.receipt_id', '=', 'receipt.receipt_id')
            ->join('order', 'order.order_id', '=', 'receipt.order_id')
            ->join('customer', 'customer.customer_id', '=', 'order.customer_id')
            ->where($this->table . '.' . $this->primaryKey, $id)->first();
        return $select;
    }
    public function getInfo($id){
        return $this->select($this->fillable)->where($this->primaryKey, $id)->first();
    }
    public function getListReceiptId($id)
    {
        $select = $this->select(
            'receipt.receipt_id',
            'receipt.receipt_no',
            'receipt_map.customer_service_id',
            'receipt.order_id',
            'receipt.amount',
            'receipt.vat',
            'receipt.pay_expired',
            'receipt.status',
            'receipt.receipt_content',
            'receipt.is_actived',
            'receipt.is_deleted',
            'receipt.created_by',
            'receipt.created_at',
            'receipt.modified_by',
            'receipt.modified_at',
            'customer.customer_id'
        )
            ->leftJoin('receipt_map', 'receipt_map.receipt_id', '=', $this->table . '.' . $this->primaryKey)
            ->leftJoin('customer_service', 'customer_service.customer_service_id', '=', 'receipt_map.customer_service_id')
            ->leftJoin('customer', 'customer.customer_id', '=', 'customer_service.customer_id');
        return $select->where('customer.customer_id', $id)->get();

    }

    /**
     * Get item by code
     * @param $id
     *
     * @return mixed
     */
    public function getItemByCode($code)
    {
        $select = $this->select(
            'receipt.receipt_id',
            'receipt.receipt_no',
            'receipt.order_id',
            'receipt.amount',
            'receipt.vat',
            'receipt.pay_expired',
            'receipt.status',
            'receipt.receipt_content',
            'receipt.is_actived',
            'receipt.is_deleted',
            'receipt.created_by',
            'receipt.created_at',
            'receipt.modified_by',
            'receipt.modified_at',
            'a1.full_name as create_full_name',
            'a2.full_name as update_full_name'
        )
            ->leftJoin('order', 'order.order_id', '=', 'receipt.order_id')
            ->leftJoin(
                'admin as a1',
                'a1.id',
                '=',
                'receipt.created_by'
            )
            ->leftJoin(
                'admin as a2',
                'a2.id',
                '=',
                'receipt.modified_by'
            )
            ->where('receipt.receipt_no', $code)->first();
        return $select;
    }

    /**
     * Tính tiền tất cả phiểu thu(đã thanh toán) của hóa đơn
     * @param $orderId
     *
     * @return mixed
     */
    public function amountReceiptOrder($orderId)
    {
        $select = $this->where('receipt.order_id', $orderId)
            ->where('status', 'paid')
            ->sum(DB::raw('amount + vat'));
        return $select;
    }

    /**
     * Lấy danh sách receipt theo id hóa đơn
     * @param $orderId
     *
     * @return mixed
     */
    public function getReceiptByOrder($orderId)
    {
        $select = $this->where('receipt.order_id', $orderId)
//            ->where('status', 'paid')
            ->get();
        return $select;
    }

    /**
     * fucntion update thời hạn thanh toán phiếu thu
     * @param array $data
     * @param int $receipt_id
     * @return mixed
    */
    public  function updateTimeReceipt(array $data, $receipt_id)
    {
        $result = $this->where($this->primaryKey, $receipt_id)->update($data);
        return $result;
    }

    public function checkReceipt($date, $customer_contract_id){
        $date = Carbon::parse($date);
        return $this->where($this->table.'.customer_contract_id', '=', $customer_contract_id)
                    ->where($this->table.'.created_at', '>=',$date->startOfMonth())
                    ->where($this->table.'.created_at', '<=',$date->endOfMonth())
                    ->exists();
    }

    public function getDetailReceiptByID($id)
    {
        $select = $this->select(
            'receipt.receipt_id',
            'receipt.receipt_no',
            'receipt.order_id',
            'receipt.amount',
            'receipt.vat',
            'receipt.pay_expired',
            'receipt.status',
            'receipt.receipt_content',
            'receipt.is_actived',
            'receipt.is_deleted',
            'receipt.created_by',
            'receipt.created_at',
            'receipt.modified_by',
            'receipt.modified_at',
            'a1.full_name as create_full_name',
            'a2.full_name as update_full_name'
        )
            ->join('order', 'order.order_id', '=', 'receipt.order_id')
            ->leftJoin(
                'admin as a1',
                'a1.id',
                '=',
                'receipt.created_by'
            )
            ->leftJoin(
                'admin as a2',
                'a2.id',
                '=',
                'receipt.modified_by'
            )
            ->where('receipt.receipt_id', $id)->first();
        return $select;
    }

    public function getListOrderDetail($receiptId){
        $select = $this->select([
            'receipt.receipt_id',
            'product.product_code',
            'product.product_name_vi',
            'product.product_name_en',
            'od.amount',
            'od.order_id'
        ])->join('order_detail as od', 'od.order_id', $this->table.'.order_id')
            ->join(
                'product',
                'product.product_id',
                '=',
                'od.product_id'
            )
            ->where('receipt.receipt_id', $receiptId)
            ->get();
        return $select;
    }
}
