<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use MyCore\Models\Traits\ListTableTrait;

class ProductAttributeMapTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'product_attribute_map';
    protected $primaryKey = 'map_product_attribute_id';

    protected $fillable
        = [
            'map_product_attribute_id', 'product_id', 'product_attribute_id',
            'min_value', 'min_unit', 'unit_price_month', 'unit_price_year',
            'max_value', 'is_actived', 'created_by', 'modified_by',
            'created_at', 'modified_at', 'default_value', 'max_unit', 'jump'
        ];

    /**
     * get danh sach theo product id
     * @param productId $
     */
    public function getListByProductId($product_id)
    {
        $oSelect = $this
            ->from($this->table.' as map')
            ->join('product_attribute as attr', 'attr.product_attribute_id', '=', 'map.product_attribute_id')
            ->where('map.is_actived', 1)
            ->where('map.product_id', $product_id)
            ->get();
        return $this->getResultToArray($oSelect);
    }

    /**
     * Thêm thuộc tính cho sản phẩm.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        $this->insert($data);
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

    public function getProductAttributeMap($productId)
    {
        $select = $this->select(
            'product_attribute.product_attribute_id',
            'product_attribute.product_attribute_code',
            'product_attribute.product_attribute_name_vi',
            'product_attribute.product_attribute_name_en',
            'product_attribute.unit_name',
            'product_attribute_map.min_unit',
            'product_attribute_map.max_unit',
            'product_attribute_map.jump',
            'product_attribute_map.unit_price_month',
            'product_attribute_map.unit_price_year',
            'product_attribute_map.max_value',
            'product_attribute_map.min_value',
            'product_attribute.price_month',
            'product_attribute.price_day'
        )
            ->join(
                'product',
                'product.product_id',
                '=',
                'product_attribute_map.product_id'
            )
            ->join(
                'product_attribute',
                'product_attribute.product_attribute_id',
                '=',
                'product_attribute_map.product_attribute_id'
            )

            ->where('product.product_id', $productId);

        return $select->get();
    }

    public function removeAll($productId)
    {
        $this->where('product_id', $productId)->delete();
    }
}
