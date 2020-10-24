<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/13/2019
 * Time: 12:09 PM
 */

namespace Modules\Product\Repositories\AttributeGroup;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\ProductAttributeGroupTable;
use Modules\Product\Repositories\AttributeGroup\AttributeGroupRepositoryInterface;
use Modules\Product\Repositories\CodeGenerator\CodeGeneratorRepositoryInterface;
use Modules\Product\Models\ProductAttributeTable;

class AttributeGroupRepository implements AttributeGroupRepositoryInterface
{
    protected $attributeGroup;
    protected $code;

    public function __construct(
        ProductAttributeGroupTable $attributeGroup,
        CodeGeneratorRepositoryInterface $code
    ) {
        $this->attributeGroup = $attributeGroup;
        $this->code = $code;
    }
    public function getList(array $filters = [])
    {
        if (!isset($filters['keyword'])) {
            $filters['keyword'] = null;
        }
        if (!isset($filters['page'])) {
            $filters['page'] = 0;
        }
        $list = $this->attributeGroup->getList($filters);
        return [
            'filter' => $filters,
            'list' => $list
        ];
    }

    public function store(array $data = [])
    {
//        dd($data);
        try {
            DB::beginTransaction();

            $dataInsert['product_attribute_group_name_vi'] = strip_tags($data['product_attribute_group_name_vi']);
            $dataInsert['product_attribute_group_name_en'] = strip_tags($data['product_attribute_group_name_en']);
            $dataInsert['positions'] = intval($data['positions']);
            $dataInsert['created_by'] = Auth::id();
            $dataInsert['created_at'] = date('Y-m-d H:i:s');
            $dataInsert['modified_at'] = date('Y-m-d H:i:s');
            $dataInsert['updated_at'] = date('Y-m-d H:i:s');
            $dataInsert['modified_by'] = Auth::id();
            $dataInsert['is_sold_together'] = isset($data['is_sold_together']) ? 1 : 0;
            $dataInsert['quantity_attribute'] = intval($data['quantity_attribute']);

            $this->attributeGroup->add($dataInsert);

            DB::commit();
            return [
                'error' => false,
                'message' => __('product::validation.product.add_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => 1,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $this->attributeGroup->edit(['is_deleted' => 1], $id);

            DB::commit();
            return [
                'error'   => 0,
                'message' => 'Xoá thành công',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error'   => 1,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getItem($id)
    {
        return $this->attributeGroup->getItem($id);
    }

    public function update(array $data = [])
    {
        try {
            DB::beginTransaction();

            $dataInsert['product_attribute_group_name_vi'] = strip_tags($data['product_attribute_group_name_vi']);
            $dataInsert['product_attribute_group_name_en'] = strip_tags($data['product_attribute_group_name_en']);
            $dataInsert['positions'] = intval($data['positions']);
            $dataInsert['modified_at'] = date('Y-m-d H:i:s');
            $dataInsert['updated_at'] = date('Y-m-d H:i:s');
            $dataInsert['modified_by'] = Auth::id();
            $dataInsert['is_sold_together'] = isset($data['is_sold_together']) ? 1 : 0;
            $dataInsert['quantity_attribute'] = intval($data['quantity_attribute']);

            $this->attributeGroup->edit($dataInsert, $data['product_attribute_group_id']);

            DB::commit();
            return [
                'error' => false,
                'message' => __('product::validation.product.edit_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => 1,
                'message' => __('product::validation.product.edit_fail'),
            ];
        }
    }
}
