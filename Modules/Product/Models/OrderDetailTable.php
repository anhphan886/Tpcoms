<?php


namespace Modules\Product\Models;


use Illuminate\Database\Eloquent\Model;

class OrderDetailTable extends BaseModel
{
    protected $table = 'order_detail';
    protected $primaryKey = 'order_detail_id';
    protected $STATUS_APPROVE = 2;

    public function getListItem($orderId){
        return $this->where('order_id', $orderId)->get()->toArray();
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

    public function listOrderDetail($id){
        $oSelect = $this
            ->join('product',
                'product.product_id',
                '=',
                'order_detail.product_id'
            )
            ->where('order_id',$id)
            ->select(
                'product.*',
                'order_detail.quantity as order_quantity',
                'order_detail.price as order_price',
                'order_detail.amount as order_amount',
                'order_id',
                'order_detail_id'
            )
            ->get();
        return $this->getResultToArray($oSelect);
    }

    /**
     * Xóa với order_id
     * @param $orderId
     */
    public function removeByOrder($orderId)
    {
        $this->where('order_id', $orderId)->delete();
    }
    public function getOrderDetail($order_id){
        return $this->select($this->table.'.*')->where('order_id', $order_id)->get();
    }
}
