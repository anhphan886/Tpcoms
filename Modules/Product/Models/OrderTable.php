<?php


namespace Modules\Product\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use MyCore\Models\Traits\ListTableTrait;


class OrderTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'order';
    protected $primaryKey = 'order_id';
    protected $STATUS_APPROVE = 2;
    protected $fillable = [
        'order_id','order_type','order_code','customer_id','staff_id',
        'total','discount','vat','amount',
        'voucher_type','voucher_code','cash_type','cash_money_value',
        'cash_percent_value','order_status_id','source','updated_at',
        'created_by','updated_by','created_at', 'is_adjust', 'customer_service_id'
    ];
    public function getDetailItem($orderId){
        return $this->select($this->fillable)->where('order_id', $orderId)->first();
    }

    public function getDetailItemByCode($code){
        return $this->where('order_code', $code)->first();
    }

    public function updateStatusItem($orderId, $status = 2){
        $this->where('order_id', $orderId)->update(['order_status_id' => $status]);
    }

    public function getListOrder($id){
        $select = $this->select(
            'order.order_id',
            'order.order_code',
            'order.total',
            'order.discount',
            'order.vat',
            'order.amount',
            'order.voucher_code',
            'order.order_status_id',
            'customer.customer_id',
            'order_status.order_status_name_vi',
            'order.is_adjust',
            'order.customer_service_id'
        )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id'
            )
            ->leftJoin(
                'order_status',
                'order_status.order_status_id',
                '=',
                'order.order_status_id'
            );
        return $select->where('order.customer_id', $id)->get();
    }

    public function getListCount(&$filter){
        $select = $this->select(
            'order.order_id',
            'order.order_code',
            'order.total',
            'order.discount',
            'order.vat',
            'order.amount',
            'order.voucher_code',
            'order.order_status_id',
            'customer.customer_id',
            'order_status.order_status_name_vi'
        )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id'
            )
            ->leftJoin(
                'order_status',
                'order_status.order_status_id',
                '=',
                'order.order_status_id'
            );
        return $select->where('order.customer_id', $filter['id']);
    }

    public function getListCore(&$filter)
    {
        $select = $this->select(
            'order.order_id',
            'order.order_code',
            'order.total',
            'order.discount',
            'order.vat',
            'order.amount',
            'order.voucher_code',
            'order.order_status_id',
            'customer.customer_id',
            'order_status.order_status_name_vi'
        )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id'
            )
            ->join(
                'order_status',
                'order_status.order_status_id',
                '=',
                'order.order_status_id'
            )
            ->where('order.customer_id', $filter['id']);
        unset($filter['id']);
        return $select->groupBy('order.order_id')->orderBy('order.order_id', 'desc');
    }

    /**
     * Get order by id.
     * @param $id
     *
     * @return mixed
     */
    public function getItem($id)
    {
        $select = $this->select(
            'order.order_code',
            'order.total',
            'order.vat',
            'order.discount',
            'order.amount',
            'order.voucher_code',
            'order_status.order_status_id',
            'order_status.order_status_name_vi',
            'order_status.order_status_name_en',
            'order.created_at',
            'order.updated_at',
            'customer.customer_name as create_full_name',
            'a2.full_name as update_full_name',
            'customer.customer_id',
            'customer.customer_no',
            'customer.customer_name'
        )
            ->leftJoin(
                'order_status',
                'order_status.order_status_id',
                '=',
                'order.order_status_id'
            )
            ->leftJoin(
                'customer_account as a1',
                'a1.customer_account_id',
                '=',
                'order.created_by'
            )
            ->leftJoin(
                'admin as a2',
                'a2.id',
                '=',
                'order.updated_by'
            )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id'
            )
        ->where('order_id', $id)->first();

        return $select;
    }

    /**
     * Chi tiết order by order_code
     * @param $id
     *
     * @return mixed
     */
    public function getItemByCode($code)
    {
        $select = $this->select(
            'order.order_id',
            'order.order_code',
            'order.total',
            'order.discount',
            'order.vat',
            'order.amount',
            'order.voucher_code',
            'order_status.order_status_id',
            'order_status.order_status_name_vi',
            'order_status.order_status_name_en',
            'order.created_at',
            'order.updated_at',
            'order.source',
            'order.order_content',
            'order.customer_id',
            'order.is_adjust',
            'order.customer_service_id',
            'voucher_type',
            'voucher_code',
            'staff_id',
            'cash_type',
            'cash_money_value',
            'cash_percent_value',
            'a1.account_name as create_full_name',
            'a2.full_name as update_full_name',
            'a3.full_name as staff_support',
            'customer.customer_no',
            'customer.customer_name'

        )
            ->leftJoin(
                'order_status',
                'order_status.order_status_id',
                '=',
                'order.order_status_id'
            )
            ->leftJoin(
                'customer_account as a1',
                'a1.customer_account_id',
                '=',
                'order.created_by'
            )
            ->leftJoin(
                'admin as a2',
                'a2.id',
                '=',
                'order.updated_by'
            )
            ->leftJoin(
                'admin as a3',
                'a3.id',
                '=',
                'order.staff_id'
            )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id'
            )
            ->where('order.order_code', $code)->first();
        return $select;
    }

        /**
     * Update
     * @param array $data
     * @param       $id
     * @return mixed
     */
    public function edit(array $data, $id)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }
    public function getListOrderDetail($code)
    {
        $select = $this
            ->leftJoin('order_detail',
                'order_detail.order_id',
                '=',
                'order.order_id'
            )
            ->leftJoin('product',
                'product.product_id',
                '=',
                'order_detail.product_id'
            )
            ->where('order_code',$code)
            ->select(
                'product.*',
                'order_detail.quantity as order_quantity',
                'order_detail.price as order_price',
                'order_detail.amount as order_amount',
                'order_detail.type as type',
                'order.order_id',
                'order_detail_id',
                'order_content',
                'order.order_code'
            )
            ->get();
        return $this->getResultToArray($select);

    }

    public function detail($code)
    {
        $select = $this->select(
            'order.order_id',
            'order.order_code',
            'order.order_status_id',
            'order_status.order_status_name_vi',
            'order_status.order_status_name_en',
            'order.created_at',
            'order.voucher_code',
            'order.total',
            'order.order_content',
            'order.discount',
            'order.vat',
            'order.amount',
            'order.created_at',
            'order.updated_at',
            'pa1.account_name as create_full_name',
            'pa2.full_name as update_full_name'
        )
            ->leftJoin(
                'order_status',
                'order_status.order_status_id',
                '=',
                'order.order_status_id'
            )
            ->leftJoin(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id'
            )
            ->leftJoin('customer_account as pa1',
                'pa1.customer_account_id',
                '=',
                'order.created_by'
            )
            ->leftJoin('admin as pa2',
                'pa2.id',
                '=',
                'order.updated_by'
            )
//            ->join('customer_account as pa2',
//                'pa2.customer_account_id',
//                '=',
//                'order.updated_by'
//            )

            ->where('order_status.is_deleted', 0)
            ->where('order.order_code', $code)
            ->first();
        return $select;
    }

    public function getAll($customer_id)
    {
        $ds = $this
            ->join(
                'order_status',
                'order_status.order_status_id',
                '=',
                'order.order_status_id'
            )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id')
            ->where('order_status.is_deleted', 0)
            ->where('customer.customer_id', $customer_id)
            ->get();

        return $ds;
    }

    /**
     * Xóa với order_id
     * @param $orderId
     */
    public function remove($orderId)
    {
        $this->where('order_id', $orderId)->delete();
    }
}
