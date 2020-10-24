<?php


namespace Modules\Product\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReceiptDetailTable extends Model
{
    public $timestamps = false;
    protected $table = 'receipt_detail';
    protected $primaryKey = 'receipt_detail_id';
    protected $fillable = [
        'receipt_detail_id','receipt_id','receipt_date','receipt_by',
        'payment_type','amount','payer','note',
        'is_deleted','created_by','created_at',
        'modified_by','modified_at', 'link_file'
    ];
    /**
     * Thêm thuộc tính receipt detail.
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
     * Lấy chi tiết receipt.
     * @param $receiptId
     *
     * @return mixed
     */
    public function getReceiptDetail($receiptId)
    {
        $select = $this->select(
            'receipt_detail.receipt_detail_id',
            'receipt_detail.receipt_id',
            'receipt_detail.receipt_date',
            'receipt_detail.receipt_by',
            'receipt_detail.payment_type',
            'receipt_detail.amount',
            'receipt_detail.payer',
            'receipt_detail.note',
            'receipt_detail.is_deleted',
            'receipt_detail.created_by',
            'receipt_detail.created_at',
            'receipt_detail.modified_by',
            'receipt_detail.modified_at',
            'receipt_detail.link_file',
            'a1.full_name'
        )->leftJoin(
            'admin as a1',
            'a1.id',
            '=',
            'receipt_detail.receipt_by'
        )
            ->where('receipt_id', $receiptId)
            ->get();
        return $select;
    }

    /**
     * Tổng tiền của 1 phiếu thu
     * @param $receiptId
     *
     * @return mixed
     *
     */
    public function amountReceipt($receiptId)
    {
        $select = $this->where('receipt_id', $receiptId)->sum('amount');
        return $select;
    }

    public function listAmountReceipt($receiptId)
    {
        $select = $this->select(
            'receipt_detail.receipt_id',
            DB::raw('SUM(portal_receipt_detail.amount) AS amount')
        )
            ->whereIn('receipt_detail.receipt_id', $receiptId)
            ->groupBy('receipt_detail.receipt_id');

        return $select->get();
    }

}
