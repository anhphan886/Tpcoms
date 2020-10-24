<?php


namespace Modules\Admin\Models;


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
     * Chi tiết phiếu thu.
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
     * Tổng tiền của array phiếu thu
     * @param $receiptId
     *
     * @return mixed
     *
     */
    public function amountReceipt($arrayId)
    {
        $select = $this->whereIn('receipt_id', $arrayId)->sum('amount');
        return $select;
    }

    /**
     * Tính tổng số tiền đã trả của phiếu thu theo date và status
     * @param $filters
     *
     * @return mixed
     */
    public function getMoneyPaidPaid($filters)
    {
        $select = $this->select(
            'receipt_detail.receipt_id',
            'customer.customer_id',
            DB::raw("SUM(portal_receipt_detail.amount) as amount")
        )
            ->join('receipt', 'receipt.receipt_id', '=', 'receipt_detail.receipt_id')
            ->join('order', 'order.order_id', '=', 'receipt.order_id')
            ->join('customer', 'customer.customer_id', '=', 'order.customer_id')
            ->whereBetween('receipt.created_at', $filters['date'])
            ->where('receipt.status', $filters['status'])
            ->groupBy('receipt.receipt_id')
            ->get()->toArray();
        return $select;
    }

    /**
     * Tổng tiền của array phiếu thu
     * @param $receiptId
     *
     * @return mixed
     *
     */
    public function amountReceiptOne($id)
    {
        $select = $this->where('receipt_id', $id)->sum('amount');
        return $select;
    }

    /**
     * Tổng tiền đã trả của phiếu thu trong năm - tháng.
     * @param $month
     * @param $year
     *
     * @return mixed
     */
    public function sumTotalMoney($month, $year)
    {
        $select = $this->select(DB::raw("SUM(portal_receipt_detail.amount) as amount"))
            ->join('receipt', 'receipt.receipt_id', '=', 'receipt_detail.receipt_id')
            ->whereMonth('receipt.created_at', $month)
            ->whereYear('receipt.created_at', '=', $year);
        return $select->first();
    }

    public function sumTotalMoneyByDay($startTime, $endTime)
    {
        $select = $this->select(
            DB::raw("DATE(portal_receipt_detail.receipt_date) as receipt_date"),
            DB::raw("SUM(portal_receipt_detail.amount) as amount")
        )
            ->join('receipt', 'receipt.receipt_id', '=', 'receipt_detail.receipt_id')
            ->whereBetween('receipt.created_at', [$startTime, $endTime])
            ->groupBy(DB::raw('Date(portal_receipt_detail.receipt_date)'))
            ->orderBy(DB::raw('Date(portal_receipt_detail.receipt_date)'), 'DESC');
        return $select->get();
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
