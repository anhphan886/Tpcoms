<?php


namespace Modules\Product\Models;


use Illuminate\Database\Eloquent\Model;

class OrderAttributeDetailTable extends BaseModel
{
    protected $table = 'order_attribute_detail';
    protected $primaryKey = 'order_attribute_detail_id';
    protected $STATUS_APPROVE = 2;

    public function getListItem($orderDetailId){
        return $this->whereIn('order_detail_id', $orderDetailId)->get()->toArray();
    }

    public function insertItem($data){
        return $this->insertGetId($data);
    }

    public function getAttributeByDetail($arrId){
        $oSelect = $this->from($this->table.' as oad')
            ->join('product_attribute as attr', 'attr.product_attribute_id', '=', 'oad.product_attribute_id')
            ->where('attr.is_deleted', 0)
            ->where('attr.is_actived', 1)
            ->whereIn('order_detail_id', $arrId)->get();

        return $this->getResultToArray($oSelect);
    }
    public function getAttrByDetail($detailId){
        return $this->where($this->table.'.order_detail_id','=', $detailId)->get()->toArray();
    }
    /**
     * Xóa với order_detail_id
     * @param $order_detail_id
     */
    public function deleteByOrderDetail($order_detail_id)
    {
        $this->where('order_detail_id', $order_detail_id)->delete();
    }
}
