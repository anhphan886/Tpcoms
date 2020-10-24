<?php


namespace Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use MyCore\Models\Traits\ListTableTrait;

class ReceiptTable extends Model
{
    use ListTableTrait;
    protected $table = 'receipt';
    protected $primaryKey = 'receipt_id';

    protected $fillable
        = [
            'receipt_id', 'receipt_no', 'order_id', 'amount', 'vat',
            'pay_expired', 'status', 'receipt_content', 'is_actived',
            'is_deleted', 'created_by', 'created_at', 'modified_by',
            'modified_at', 'customer_service_id'
        ];

    /**
     * Danh sách phiếu thu
     * @param $filters
     *
     * @return mixed
     */
    protected function getListCore(&$filters)
    {
        $select = $this->select(
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
            ->join('order', 'order.order_id', '=', 'receipt.order_id')
            ->leftJoin('customer', 'customer.customer_id', '=' , 'order.customer_id' );
        if (isset($filters['date'])) {
            $select->whereDate($this->table . '.created_at', $filters['date']);
            unset($filters['date']);
        }
        if (isset($filters['query']['search_receipt'])) {
            $keyword = $filters['query']['search_receipt'];
            $select->where(
                function ($query) use ($keyword){
                    $query->where($this->table . '.receipt_no', 'like', '%' . strtoupper($keyword). '%'
                    )->orWhere('customer.customer_name', 'like', '%' . strtoupper($keyword) . '%');
                }
            );
            unset($filters['query']['search_receipt']);
        }
        return $select->groupBy('receipt.receipt_id')->orderBy('receipt.receipt_id', 'desc');
    }
    /**
     * Tổng tiền, số lượng phiếu thu theo status.
     * @param $filters
     *
     * @return array
     */
    public function getAmountQuantity($filters)
    {
        $select = $this->select(
            DB::raw("SUM(portal_receipt.amount + portal_receipt.vat) as amount"),
            DB::raw("COUNT(portal_receipt.receipt_id) as quantity"),
            'receipt.status as status'
        )
            ->join('order', 'order.order_id', '=', 'receipt.order_id')
            ->where('receipt.status', $filters['status'])
            ->groupBy('receipt.status')
            ->whereBetween('receipt.created_at', $filters['date'])
            ->get()->toArray();
        if (count($select) > 0) {
            $select[0]['status'] = $this->getStatus($filters['status']);
        } else {
            $select = [
                [
                    'quantity' => 0,
                    'amount' => 0,
                    'status' => $this->getStatus($filters['status'])
                ]
            ];
        }
        return $select;
    }

    /**
     * Danh sách trạng thái.
     * @param $status
     *
     * @return string
     */
    private function getStatus($status)
    {
        switch ($status) {
            case 'paid':
                return "Đã thanh toán";
                break;
            case 'unpaid':
                return "Chưa thanh toán";
                break;
            case 'part-paid':
                return "Còn nợ";
                break;
            case 'refund':
                return "Hoàn tiền";
                break;
            case 'cancel':
                return "Đã hủy";
                break;
            default:
                break;
        }
    }

    /**
     * Các receipt theo status
     * @param $filters
     *
     * @return mixed
     */
    public function getAmountPartPaid($filters)
    {
        $select = $this->select(
            'receipt.receipt_id'
        )
            ->join('order', 'order.order_id', '=', 'receipt.order_id')
            ->where('receipt.status', $filters['status'])
            ->whereBetween('receipt.created_at', $filters['date'])
            ->get();
        return $select;
    }

    /**
     * Tổng tiền, số lượng phiếu thu theo status.
     * @param $filters
     *
     * @return array
     */
    public function getAmountGroupByPaymentType($filters)
    {
        $select = $this->select(
            DB::raw("SUM(portal_receipt_detail.amount) as amount"),
            'receipt_detail.payment_type'
        )
            ->join('order', 'order.order_id', '=', 'receipt.order_id')
            ->join('receipt_detail', 'receipt_detail.receipt_id', '=', 'receipt.receipt_id')
            ->groupBy('receipt_detail.payment_type')
            ->whereBetween('receipt_detail.created_at', $filters['date'])
            ->get();
        return $select;
    }

    /**
     * Các receipt theo status
     * @param $filters
     *
     * @return mixed
     */
    public function getPartPaidDebtChart($filters)
    {
        $select = $this->select(
            'receipt.receipt_id',
            'receipt.receipt_no',
            'receipt.amount',
            'order.customer_id'
        )
            ->join('order', 'order.order_id', '=', 'receipt.order_id')
            ->join('customer', 'customer.customer_id', '=', 'order.customer_id')
            ->whereBetween('receipt.created_at', $filters['date']);
        if (isset($filters['array_status'])) {
            $select->whereIn('receipt.status', ['part-paid', 'unpaid']);
            unset($filters['array_status']);
        } else {
            $select->where('receipt.status', $filters['status']);
        }
        if (isset($filters['segment_id']) && $filters['segment_id'] != null) {
            $select->where('customer.segment_id', $filters['segment_id']);
        }
        return $select->get();
    }

    /**
     * Đếm số lượng phiếu thu được tạo trong ngày
     * @param $filters
     *
     * @return mixed
     */
    public function getCount($filters)
    {
        $select = $this->join(
                'order',
                'order.order_id',
                '=',
                $this->table . '.order_id'
            )
            ->where($this->table . '.is_deleted', 0)
            ->whereDate($this->table . '.created_at', $filters['date']);
        return $select->count();
    }

    /**
     * Đếm số lượng phiếu thu được tạo trong ngày
     * @param $filters
     *
     * @return mixed
     */
    public function getReceiptExpired($dateTime)
    {
        $select = $this->select(
            $this->table . '.receipt_id',
            $this->table . '.receipt_no',
            $this->table . '.order_id',
            $this->table . '.amount',
            $this->table . '.vat',
            $this->table . '.pay_expired',
            $this->table . '.status',
            $this->table . '.receipt_content',
            $this->table . '.pay_expired',
            'order.order_code',
            'customer.customer_id',
            'customer.customer_no',
            'customer.customer_name',
            'customer.customer_phone',
            'customer.customer_email'
        )
            ->join(
            'order',
            'order.order_id',
            '=',
            $this->table . '.order_id'
        )->join(
            'customer',
            'customer.customer_id',
            '=',
            'order.customer_id'
        )
            ->where($this->table . '.is_deleted', 0)
            ->whereDate($this->table . '.pay_expired', $dateTime);
        return $select->get();
    }

}
