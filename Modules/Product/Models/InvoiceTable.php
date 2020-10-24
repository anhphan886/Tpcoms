<?php


namespace Modules\Product\Models;


use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class InvoiceTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'invoice';
    protected $primaryKey = 'invoice_id';
    protected $STATUS_PAID = 'paid';

    public $timestamps = false;

    protected $fillable
        = ['invoice_id', 'invoice_no', 'net', 'vat', 'amount', 'status', 'reduce_percent',
           'invoice_by', 'invoice_at', 'invoice_number', 'created_at', 'billing_id',
           'created_by', 'updated_at', 'updated_by', 'customer_id'];

    public function updateStatusItem($orderId){
        $this->where('order_id', $orderId)->update(['status' => $this->STATUS_PAID]);
    }

    public function insertItem($data){
        return $this->insertGetId($data);
    }

    /**
     * Get list invoice
     *
     * @return mixed
     */
    protected function getListCore(&$filters)
    {
        $select = $this->select(
            'invoice.invoice_id',
            'invoice.invoice_no',
            'invoice.status',
            'invoice.amount',
            'invoice.vat',
            'invoice.invoice_by',
            'invoice.invoice_at',
            'invoice.invoice_number',
            'customer_service.customer_id',
            'ad1.full_name as create_full_name',
            'customer.customer_id',
            'customer.customer_name',
            'customer.customer_no',
            'receipt.status as receipt_status',
            'receipt.receipt_id',
            'receipt.receipt_no'

        )
            ->leftJoin('invoice_map', 'invoice_map.invoice_id','=','invoice.invoice_id')
            ->leftJoin('receipt', 'receipt.receipt_id','=','invoice_map.receipt_id')
            ->leftJoin('admin as ad1', 'ad1.id', '=', 'invoice.invoice_by')
            ->leftJoin('receipt_map', 'receipt_map.receipt_id','=','receipt.receipt_id')
            ->leftJoin(
                'customer_service',
                'receipt_map.customer_service_id',
                '=','receipt_map.customer_service_id'
            )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'invoice.customer_id'
            );
        if (isset($filters['invoice$invoice_no'])) {
            if ($filters['invoice$invoice_no'] != '') {
                $select->where(function ($query) use ($filters) {
                    $query->where(
                        'customer.customer_name', 'like', '%' . strtoupper($filters['invoice$invoice_no']) . '%'
                    )
                        ->orWhere(
                            'invoice.invoice_no', 'like', '%' . strtoupper($filters['invoice$invoice_no']) . '%'
                        );
                });
                unset($filters['invoice$invoice_no']);
            }
        }
        $select->groupBy('invoice.invoice_id')
            ->orderBy('invoice.updated_at', 'desc');
        return $select;
    }

    /**
     * Danh sách invoice theo khách hàng
     * @param $id
     *
     * @return mixed
     */
    public function getListInvoice($id){
        $select = $this->select(
            'invoice.invoice_no',
            'invoice.status',
            'invoice.amount',
            'invoice.invoice_by',
            'invoice.invoice_at',
            'customer_service.customer_id'
        )->leftJoin('invoice_map', 'invoice_map.invoice_id','=','invoice.invoice_id')
            ->leftJoin('receipt_map', 'receipt_map.receipt_id','=','invoice_map.receipt_id')
            ->leftJoin('receipt', 'receipt.receipt_id','=','receipt_map.receipt_id')
            ->leftJoin('customer_service','customer_service.customer_service_id','=','receipt_map.customer_service_id');
        return $select->where('customer_service.customer_id',$id)->get();
    }
    /**
     * Thêm mới
     *
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
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
     * edit
     * @param array $data
     * @param       $id
     *
     * @return mixed
     */
    public function updateInvoice(array $data, $invoice_id)
    {
        return $this->where($this->primaryKey, $invoice_id)->update($data);
    }
    /**
     * funciton get detail invoice by invoice_no
     * @param int $invoice_no
     * @return mixed
     */
    public function getDetail($invoice_no)
    {
        return $this->leftJoin('admin', function($join){
            $join->on('admin.id', '=', $this->table.'.invoice_by')
                ->where('admin.is_deleted', 0);
        })
            ->join('customer', function ($join){
                $join->on('customer.customer_id', '=', $this->table.'.customer_id')
                    ->where('customer.is_deleted', 0);
            })
            ->leftJoin('invoice_map', 'invoice_map.invoice_id', '=', 'invoice.invoice_id')
            ->leftJoin('receipt', 'receipt.receipt_id','=','invoice_map.receipt_id')
            ->leftJoin('customer_contract', 'customer_contract.customer_contract_id', '=', 'receipt.customer_contract_id')
            ->where($this->table.'.invoice_no', $invoice_no)
            ->select(
                $this->table.'.invoice_id',
                $this->table.'.invoice_no',
                $this->table.'.net',
                $this->table.'.vat',
                $this->table.'.amount',
                $this->table.'.status',
                $this->table.'.reduce_percent',
                $this->table.'.invoice_by',
                $this->table.'.invoice_at',
                $this->table.'.invoice_number',
                $this->table.'.created_at',
                $this->table.'.created_by',
                $this->table.'.updated_at',
                $this->table.'.updated_by',
                'admin.id',
                'admin.full_name',
                'customer.customer_name',
                'customer.customer_id',
                'receipt.status as receipt_status',
                'receipt.customer_contract_id',
                'customer_contract.contract_no',
                'receipt.receipt_id'
            )->first();
    }

    public function getItem($id)
    {
        $select = $this->select(
            $this->table.'.invoice_id',
            $this->table.'.invoice_no',
            $this->table.'.net',
            $this->table.'.vat',
            $this->table.'.amount',
            $this->table.'.status',
            $this->table.'.reduce_percent',
            $this->table.'.invoice_by',
            $this->table.'.invoice_at',
            $this->table.'.invoice_number',
            $this->table.'.created_at',
            $this->table.'.created_by',
            $this->table.'.updated_at',
            $this->table.'.updated_by',
            'customer.customer_id',
            'customer.customer_no',
            'customer.customer_name',
            'customer.customer_phone',
            'customer.customer_email'
        )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'invoice.customer_id'
            )
            ->where($this->table . '.invoice_id', $id)
            ->first();
        return $select;
    }
}
