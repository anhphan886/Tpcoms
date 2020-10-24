<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/13/2019
 * Time: 12:09 PM
 */

namespace Modules\Product\Repositories\Attribute;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\ProductAttributeGroupTable;
use Modules\Product\Repositories\CodeGenerator\CodeGeneratorRepositoryInterface;
use Modules\Product\Models\ProductAttributeTable;

class AttributeRepository implements AttributeRepositoryInterface
{
    protected $attribute;
    protected $attributeGroup;
    protected $code;

    public function __construct(
        ProductAttributeTable $attribute,
        ProductAttributeGroupTable $attributeGroup,
        CodeGeneratorRepositoryInterface $code
    ) {
        $this->attribute = $attribute;
        $this->attributeGroup = $attributeGroup;
        $this->code = $code;
    }

    /**
     * Get list
     * @param array $filters
     *
     * @return array
     */
    public function getList(array $filters = [])
    {
        if (!isset($filters['keyword'])) {
            $filters['keyword'] = null;
        }
        if (!isset($filters['product_attribute$product_attribute_group_id'])) {
            $filters['product_attribute$product_attribute_group_id'] = null;
        }
        if (!isset($filters['product_attribute$is_actived'])) {
            $filters['product_attribute$is_actived'] = 10;
        }
        if (!isset($filters['page'])) {
            $filters['page'] = 0;
        }
        $list = $this->attribute->getList($filters);
        return [
            'filter' => $filters,
            'list' => $list
        ];
    }

    /**
     * Add
     * @param array $data
     *
     * @return array
     */
    public function store(array $data = [])
    {

        $dataInsert['product_attribute_code'] = getCode(
            CODE_ATTRIBUTE, $this->attribute->getNumberForCode()
        );
            $dataInsert['product_attribute_group_id'] = strip_tags($data['product_attribute_group_id']);
            $dataInsert['product_attribute_name_vi'] = strip_tags($data['product_attribute_name_vi']);
            $dataInsert['product_attribute_name_en'] = strip_tags($data['product_attribute_name_en']);
            $dataInsert['description'] = strip_tags($data['description']);
            $dataInsert['unit_name'] = strip_tags($data['unit_name']);
            $dataInsert['price_day'] = str_replace(",", "", strip_tags($data['price_day']));
            $dataInsert['price_month'] = str_replace(",", "", strip_tags($data['price_month']));
            $dataInsert['price_year'] = str_replace(",", "", strip_tags($data['price_year']));
            $dataInsert['vmware_params'] = strip_tags($data['vmware_params']);
            $dataInsert['is_actived'] = 1;
            $dataInsert['created_by'] = Auth::id();
            $dataInsert['created_at'] = date('Y-m-d H:i:s');
            $dataInsert['modified_at'] = date('Y-m-d H:i:s');
            $dataInsert['modified_at'] = date('Y-m-d H:i:s');
            $dataInsert['updated_at'] = date('Y-m-d H:i:s');
            $dataInsert['modified_by'] = Auth::id();
            $this->attribute->add($dataInsert);
            return [
                'error' => false,
                'message' => __('product::validation.product.add_success'),
            ];
    }

    /**
     * Attribute option
     * @return mixed
     */
    public function attributeOption()
    {
        return $this->attributeGroup->option();
    }

    /**
     * Remove
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        $this->attribute->edit(['is_deleted' => 1], $id);
        return [
            'error' => 0,
            'message' => 'Xoá thành công',
        ];
    }

    /**
     * Get item
     * @param $id
     *
     * @return mixed
     */
    public function getItem($id)
    {
        return $this->attribute->getItem($id);
    }

    /**
     * Get item by code
     * @param $id
     *
     * @return mixed
     */
    public function getItemByCode($code)
    {
        return $this->attribute->getItemByCode($code);
    }

    /**
     * Update
     * @param array $data
     *
     * @return array
     */
    public function update(array $data = [])
    {
        try {
            DB::beginTransaction();
            $dataInsert['product_attribute_group_id'] = strip_tags($data['product_attribute_group_id']);
            $dataInsert['product_attribute_name_vi'] = strip_tags($data['product_attribute_name_vi']);
            $dataInsert['product_attribute_name_en'] = strip_tags($data['product_attribute_name_en']);
            $dataInsert['description'] = strip_tags($data['description']);
            $dataInsert['unit_name'] = strip_tags($data['unit_name']);
            $dataInsert['price_day'] = str_replace(",", "", strip_tags($data['price_day']));
            $dataInsert['price_month'] = str_replace(",", "", strip_tags($data['price_month']));
            $dataInsert['price_year'] = str_replace(",", "", strip_tags($data['price_year']));
            $dataInsert['vmware_params'] = strip_tags($data['vmware_params']);
            $dataInsert['modified_at'] = date('Y-m-d H:i:s');
            $dataInsert['modified_by'] = Auth::id();
            $this->attribute->edit($dataInsert, $data['id']);
            DB::commit();

            return [
                'error' => false,
                'message' => __('product::validation.product.edit_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => true,
                'message' => __('product::validation.product.edit_fail'),
                ];
        }
    }

    /**
    //     * function get detail service theo customer_service_id
    //     * @param int $customer_service_id
    //     * @return mixed
    //    */
    public function getDetailAttribute($customer_service_id)
    {
        return $this->attribute->getDetailAttribute($customer_service_id);
    }

}
