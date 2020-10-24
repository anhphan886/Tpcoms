<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use MyCore\Models\Traits\ListTableTrait;

class ProductAttributeGroupMapTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'product_attribute_group_map';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable
        = [
            'id', 'product_id', 'product_attribute_group_id', 'created_at', 'updated_at',
        ];

    public function getGroupSoldTogether($productId)
    {
        $select = $this->select(
            $this->table . '.product_id',
            $this->table . '.product_attribute_group_id',
            'product.product_name_vi',
            'product.product_name_vi',
            'pag.product_attribute_group_name_vi',
            'pag.positions',
            'pag.is_deleted',
            'pag.is_sold_together',
            'pag.quantity_attribute'
        )
            ->join('product', 'product.product_id', '=', $this->table . '.product_id')
            ->join('product_attribute_group as pag', 'pag.product_attribute_group_id', '=', $this->table . '.product_attribute_group_id')
            ->where($this->table . '.product_id', $productId)
            ->where('pag.is_deleted', 0)
            ->get();
        return $this->getResultToArray($select);
    }

    public function getListByProductId($productId){
        $oSelect = $this->select(
            'product_attribute.*',
            'product_attribute_group.is_sold_together',
            'product_attribute_group.quantity_attribute'
        )
            ->join(
                'product_attribute_group',
                'product_attribute_group.product_attribute_group_id',
                '=',
                'product_attribute_group_map.product_attribute_group_id'
            )->join(
                'product_attribute',
                'product_attribute.product_attribute_group_id',
                '=',
                'product_attribute_group.product_attribute_group_id'
            )->join(
                'product',
                'product.product_id',
                '=',
                'product_attribute_group_map.product_id'
            )
            ->where('product_attribute_group.is_deleted', 0)
            ->where('product_attribute.is_deleted', 0)
            ->where('product_attribute.is_actived', 1)
            ->where('product.product_id', $productId)
            ->get();
        return $this->getResultToArray($oSelect);
    }

    public function add(array $data)
    {
        $this->insert($data);
    }

    public function getProductAttributeGroupMap($productId)
    {
        $select = $this->select(
            'product_attribute_group_map.product_id',
            'product_attribute_group_map.product_attribute_group_id',
            'product_attribute_group_map.created_at',
            'product_attribute_group_map.updated_at',
            'product_attribute_group.product_attribute_group_id',
            'product_attribute_group.is_sold_together',
            'product_attribute_group.product_attribute_group_name_vi',
            'product_attribute_group.is_sold_together',
            'product_attribute_group.is_deleted'
        )
            ->join(
                'product_attribute_group',
                'product_attribute_group.product_attribute_group_id',
                '=',
                'product_attribute_group_map.product_attribute_group_id'
            )
            ->where('product_attribute_group.is_deleted', 0)
            ->where('product_attribute_group_map.product_id', $productId)
            ->get();
        return $select;
    }

    public function getItemAttrGroup($productId)
    {
        $select = $this->select(
            'product_attribute.*'
        )
            ->join(
                'product_attribute_group',
                'product_attribute_group.product_attribute_group_id',
                '=',
                'product_attribute_group_map.product_attribute_group_id'
            )->join(
                'product_attribute',
                'product_attribute.product_attribute_group_id',
                '=',
                'product_attribute_group.product_attribute_group_id'
            )
            ->where('product_attribute_group.is_deleted', 0)
            ->where('product_attribute_group_map.product_id', $productId)
            ->get();
        return $select;
    }

    public function removeAll($productId)
    {
        $this->where('product_id', $productId)->delete();
    }
}
