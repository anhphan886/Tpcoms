<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use MyCore\Models\Traits\ListTableTrait;

class ProductTemplateAttributeMapTable extends Model
{
    use ListTableTrait;
    protected $table = 'product_template_attribute_map';
    protected $primaryKey = 'product_attribute_map_id';

    protected $fillable = [
            'product_attribute_map_id', 'product_id', 'product_attribute_id', 'value', 'is_actived',
            'created_by', 'modified_by', 'created_at', 'modified_at', 'is_unlimited'
        ];

    /**
     * Thêm thuộc tính sản phẩm.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->insert($data);
    }

    /**
     * Get product template attribute map.
     * @param $productId
     *
     * @return mixed
     */
    public function getProductTemplateAttributeMap($productId)
    {
        $select = $this->select(
            'product_attribute_map_id',
            'product_template_attribute_map.product_id',
            'product_template_attribute_map.product_attribute_id',
            'product_template_attribute_map.value',
            'product_template_attribute_map.is_unlimited',
            'product_attribute.product_attribute_code',
            'product_attribute.unit_name',
            'product_attribute.product_attribute_name_vi',
            'product_attribute.product_attribute_name_en',
            'product_attribute.price_month',
            'product_attribute.price_day',
            'product_attribute_group.product_attribute_group_id'
        )
            ->join(
                'product_attribute',
                'product_attribute.product_attribute_id',
                '=',
                'product_template_attribute_map.product_attribute_id'
            )
            ->join(
                'product_attribute_group',
                'product_attribute_group.product_attribute_group_id',
                '=',
                'product_attribute.product_attribute_group_id'
            )
            ->where('product_attribute.is_deleted', 0)
            ->where('product_attribute_group.is_deleted', 0)
            ->where('product_template_attribute_map.is_actived', 1)
            ->where('product_template_attribute_map.product_id', $productId)
            ->get();
        return $select;
    }

    /**
     * Xóa hết các attribute của template
     * @param $productId
     */
    public function removeByProduct($productId)
    {
        $this->where('product_id', $productId)->delete();
    }

    /**
     * get danh sach theo product id
     * @param $product_id
     * @return mixed
     */
    public function getListByProductId($product_id)
    {
        $oSelect = $this
            ->from($this->table.' as map')
            ->join('product_attribute as attr', 'attr.product_attribute_id', '=', 'map.product_attribute_id')
            ->where('map.is_actived', 1)
            ->where('map.product_id', $product_id)
            ->get()->toArray();
//        return $this->getResultToArray($oSelect);
        return $oSelect;
    }


}
