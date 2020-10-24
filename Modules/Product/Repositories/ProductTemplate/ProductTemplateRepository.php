<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/14/2019
 * Time: 5:09 PM
 */

namespace Modules\Product\Repositories\ProductTemplate;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\ProductAttributeGroupTable;
use Modules\Product\Models\ProductAttributeMapTable;
use Modules\Product\Models\ProductAttributeTable;
use Modules\Product\Models\ProductCategoryTable;
use Modules\Product\Models\ProductTable;
use Modules\Product\Models\ProductTemplateAttributeMapTable;
use Modules\Product\Repositories\CodeGenerator\CodeGeneratorRepositoryInterface;

class ProductTemplateRepository implements ProductTemplateRepositoryInterface
{
    protected $attributeGroup;
    protected $attribute;
    protected $product;
    protected $code;
    protected $productAttributeMap;
    protected $productTemplateAttributeMap;
    protected $productCategory;

    public function __construct(
        ProductAttributeGroupTable $attributeGroup,
        ProductAttributeTable $attribute,
        ProductTable $product,
        CodeGeneratorRepositoryInterface $code,
        ProductAttributeMapTable $productAttributeMap,
        ProductCategoryTable $productCategory,
    ProductTemplateAttributeMapTable $attributeMapTable
    ) {
        $this->attributeGroup = $attributeGroup;
        $this->attribute = $attribute;
        $this->product = $product;
        $this->code = $code;
        $this->productAttributeMap = $productAttributeMap;
        $this->productCategory = $productCategory;
        $this->productTemplateAttributeMap = $attributeMapTable;
    }

    public function getList(array $filters = [])
    {
        $flag = 0;
        if (!isset($filters['keyword'])) {
            $filters['keyword'] = null;
            $flag = 1;
        }
        if (!isset($filters['product$parent_id'])) {
            $filters['product$parent_id'] = null;
            $flag = 1;
        }
        if (!isset($filters['product$is_actived'])) {
            $filters['product$is_actived'] = '';
            $flag = 1;
        }
        if (!isset($filters['page'])) {
            $filters['page'] = 0;
        }
        if ($flag == 0) {
            $filters['sort_product$product_id'] = 'desc';
        }
        $filters['product$is_template'] = 1;
        $list = $this->product->getList($filters);
        return [
            'filter' => $filters,
            'list' => $list
        ];
    }

    /**
     * Option nhóm thuộc tính.
     *
     * @return mixed
     */
    public function getAttributeGroupOption()
    {
        return $this->attributeGroup->optionUnSoldTogether();
    }

    /**
     * Get attribute option.
     *
     * @param $attributeGroup
     * @param $arrayIdAttribute
     *
     * @return mixed
     */
    public function getAttributeOption($attributeGroup, $arrayIdAttribute)
    {
        return $this->attribute->option($attributeGroup, $arrayIdAttribute);
    }

    /**
     * Get detail attribute
     *
     * @param $id
     *
     * @return mixed
     */
    public function getItemAttribute($id)
    {
        return $this->attribute->getItem($id);
    }

    /**
     * Thêm template.
     * @param array $data
     * @return array
     */
    public function store(array $data = [])
    {
        try {
            DB::beginTransaction();
            //Thêm template.
            $fields['product_code'] = getCode(CODE_TEMPLATE, $this->product->getNumberForCode());
            $fields['product_name_vi'] = strip_tags($data['product_name_vi']);
            $fields['product_name_en'] = strip_tags($data['product_name_en']);
            $fields['price_month'] = str_replace(',', '', strip_tags($data['price_month']));
            $fields['price_day'] = str_replace(',', '', strip_tags($data['price_day']));
            $fields['product_alias_vi'] = str_slug(strip_tags($data['product_name_vi']));
            $fields['product_alias_en'] = str_slug(strip_tags($data['product_name_en']));
            $fields['price_year'] = 0;
            $fields['parent_id'] = intval($data['parent_id']);
            $fields['is_template'] = 1;
            $fields['package'] = strip_tags($data['description']);
            $fields['description_vi'] = strip_tags($data['description']);
            $fields['description_en'] = strip_tags($data['description']);
            $fields['is_deleted'] = 0;
            $fields['created_by'] = Auth::id();
            $fields['created_at'] =  Carbon::now();
            $fields['updated_by'] = Auth::id();
            $fields['updated_at'] = Carbon::now();
            $fields['is_actived'] = intval($data['is_active']);
            $fields['is_feature'] = intval($data['is_feature']);
            $fields['price_by_attribute'] = intval($data['price_by_attribute']);

            $id = $this->product->add($fields);
            //Thêm thuộc tính cho sản phẩm.
            if (isset($data['arrayAttribute'])) {
                if (count($data['arrayAttribute']) > 0) {
                    $temp = [];
                    foreach ($data['arrayAttribute'] as $item) {
                        $value = (float) $item['default_value'];
                        $temp[] = [
                            'product_id' => $id,
                            'product_attribute_id' => $item['attribute_id'],
                            'is_unlimited' => intval($item['no_limit']) == 0 ? 0 : 1,
                            'value' => $value,
                            'is_actived' => 1,
                            'created_by' => Auth::id(),
                            'created_at' => Carbon::now(),
                            'updated_by' => Auth::id(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                    $this->productTemplateAttributeMap->add($temp);
                }
            }
            DB::commit();
            return [
                'error'   => false,
                'message' => __('product::validation.product.add_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error'   => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get product category option
     * @return mixed
     */
    public function getProductCategoryOption()
    {
        return $this->productCategory->option();
    }

    /**
     * Get option product
     * @return mixed
     */
    public function getProductOption()
    {
        return $this->product->option();
    }

    /**
     * Xóa
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $this->product->edit(['is_deleted' => 1], intval($id));

            DB::commit();
            return [
                'error'   => 0,
                'message' => 'Xoá thành công',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error'   => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Lấy danh sách thuộc tính của template
     * @param $productId
     *
     * @return mixed
     */
    public function getProductAttributeMap($productId)
    {
        return $this->productAttributeMap->getProductAttributeMap($productId);
    }

    /**
     * Lấy thông tin template.
     * @param $productId
     *
     * @return mixed
     */
    public function getItem($productId)
    {
        $result = $this->product->getItem($productId);
        return $result;
    }

    /**
     * Lấy thông tin template.
     * @param $productId
     *
     * @return mixed
     */
    public function getItemByCode($productCode)
    {
        $result = $this->product->getItemByCode($productCode);
        return $result;
    }

    /**
     * Get product template attribute map.
     * @param $productId
     *
     * @return mixed
     */
    public function getProductTemplateAttributeMap($productId)
    {
        $result = $this->productTemplateAttributeMap->getProductTemplateAttributeMap($productId);
        return $result;
    }

    /**
     * Thêm template.
     * @param array $data
     * @return array
     */
    public function update(array $data = [])
    {
        try {
            DB::beginTransaction();
            $productId = intval($data['product_id']);
            //Thêm sản phẩm.
            $fields['product_code'] = $this->code->generateCodeRandom('TL');
            $fields['product_name_vi'] = strip_tags($data['product_name_vi']);
            $fields['product_name_en'] = strip_tags($data['product_name_en']);
            $fields['product_alias_vi'] = str_slug(strip_tags($data['product_name_vi']));
            $fields['product_alias_en'] = str_slug(strip_tags($data['product_name_en']));
            $fields['price_month'] = str_replace(',', '', strip_tags($data['price_month']));
            $fields['price_day'] = str_replace(',', '', strip_tags($data['price_day']));
            $fields['price_year'] = 0;
            $fields['parent_id'] = intval($data['parent_id']);
            $fields['is_template'] = 1;
            $fields['package'] = strip_tags($data['description']);
            $fields['description_vi'] = strip_tags($data['description']);
            $fields['description_en'] = strip_tags($data['description']);
            $fields['is_deleted'] = 0;
            $fields['updated_by'] = Auth::id();
            $fields['updated_at'] = date('Y-m-d H:i:s');
            $fields['is_actived'] = intval($data['is_active']);
            $fields['is_feature'] = intval($data['is_feature']);
            $fields['price_by_attribute'] = intval($data['price_by_attribute']);

            $this->product->edit($fields, $productId);
            $this->productTemplateAttributeMap->removeByProduct($productId);
            //Thêm thuộc tính cho sản phẩm.
            if (isset($data['arrayAttribute'])) {
                if (count($data['arrayAttribute']) > 0) {
                    $temp = [];
                    foreach ($data['arrayAttribute'] as $item) {
                        $value = (float) $item['default_value'];

                        $temp[] = [
                            'product_id' => $productId,
                            'product_attribute_id' => $item['attribute_id'],
                            'is_unlimited' => intval($item['no_limit']) == 0 ? 0 : 1,
                            'value' => $value,
                            'is_actived' => 1,
                            'created_by' => Auth::id(),
                            'created_at' => Carbon::now(),
                            'updated_by' => Auth::id(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                    $this->productTemplateAttributeMap->add($temp);
                }
            }
            DB::commit();
            return [
                'error'   => false,
                'message' => __('product::validation.product_template.edit_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error'   => true,
                'message' => $e->getMessage(),
            ];
        }
    }
}
