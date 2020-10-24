<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/14/2019
 * Time: 5:09 PM
 */

namespace Modules\Product\Repositories\Product;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Models\ProductAttributeGroupMapTable;
use Modules\Product\Models\ProductAttributeGroupTable;
use Modules\Product\Models\ProductAttributeMapTable;
use Modules\Product\Models\ProductAttributeTable;
use Modules\Product\Models\ProductCategoryTable;
use Modules\Product\Models\ProductTable;
use Modules\Product\Repositories\CodeGenerator\CodeGeneratorRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $attributeGroup;
    protected $attribute;
    protected $product;
    protected $code;
    protected $productAttributeMap;
    protected $productCategory;
    protected $productAttributeGroupMap;

    public function __construct(
        ProductAttributeGroupTable $attributeGroup,
        ProductAttributeTable $attribute,
        ProductTable $product,
        CodeGeneratorRepositoryInterface $code,
        ProductAttributeMapTable $productAttributeMap,
        ProductCategoryTable $productCategory,
        ProductAttributeGroupMapTable $productAttributeGroupMap
    ) {
        $this->attributeGroup = $attributeGroup;
        $this->attribute = $attribute;
        $this->product = $product;
        $this->code = $code;
        $this->productAttributeMap = $productAttributeMap;
        $this->productCategory = $productCategory;
        $this->productAttributeGroupMap = $productAttributeGroupMap;
    }

    /**
     * Danh sách
     * @param array $filters
     *
     * @return array
     */
    public function getList(array $filters = [])
    {
        $flag = 0;
        if (!isset($filters['keyword'])) {
            $filters['keyword'] = null;
            $flag = 1;
        }
        if (!isset($filters['product$product_category_id'])) {
            $filters['product$product_category_id'] = null;
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
     * Option nhóm thuộc tính bán kèm.
     *
     * @return mixed
     */
    public function optionSoldTogether()
    {
        return $this->attributeGroup->optionSoldTogether();
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
     * Get attribute option sold together.
     *
     * @param $attributeGroup
     * @param $arrayIdAttribute
     *
     * @return mixed
     */
    public function getOptionAttributeSoldTogether($attributeGroup, $arrayIdAttribute)
    {
        return $this->attribute->optionSoldTogether($attributeGroup, $arrayIdAttribute);
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

    public function getAttributeByGroup($id)
    {
        return $this->attribute->getAttributeByGroup($id);
    }

    public function getItemAttributeGroup($id)
    {
        return $this->attributeGroup->getItem($id);
    }

    /**
     * Thêm mới
     * @param array $data
     *
     * @return array
     */
    public function store(array $data = [])
    {
//        dd($data);
        try {
            DB::beginTransaction();
            //Thêm sản phẩm.
            $fields['product_category_id'] = intval($data['product_category_id']);
            $fields['product_code'] = getCode(CODE_PRODUCT, $this->product->getNumberForCode());
            $fields['product_name_vi'] = strip_tags($data['product_name_vi']);
            $fields['product_name_en'] = strip_tags($data['product_name_en']);
            $fields['product_alias_vi'] = str_slug(strip_tags($data['product_name_vi']));
            $fields['product_alias_en'] = str_slug(strip_tags($data['product_name_en']));
            $fields['price_month'] = 0;
            $fields['price_year'] = 0;
            $fields['parent_id'] = 0;
            $fields['is_template'] = 0;
            $fields['package'] = '';
            $fields['description_vi'] = strip_tags($data['description']);
            $fields['description_en'] = strip_tags($data['description']);
            $fields['is_deleted'] = 0;
            $fields['created_by'] = Auth::id();
            $fields['created_at'] = date('Y-m-d H:i:s');
            $fields['updated_by'] = Auth::id();
            $fields['is_actived'] = intval($data['is_active']);
            if (isset($data['avatar'])) {
                if ($data['avatar'] != '') {
                    $image = $this->transferTempFileToAdminFile($data['avatar'] );
                    $fields['avatar'] = $image;
                }
            }
            $id = $this->product->add($fields);

            //Thêm thuộc tính cho sản phẩm.
            if (isset($data['arrayAttribute'])) {
                if (count($data['arrayAttribute']) > 0) {
                    $temp = [];
                    foreach ($data['arrayAttribute'] as $item) {
                        $temp[] = [
                            'product_id' => $id,
                            'product_attribute_id' => $item['attribute_id'],
                            'min_value' => $item['min'],
                            'max_value' => $item['max'],
                            'min_unit' => $item['jump'],
                            'unit_price_month' => $item['price_month'],
                            'unit_price_year' => $item['price_year'],
                            'is_actived' => 1,
                            'created_by' => Auth::id(),
                            'modified_by' => Auth::id(),
                            'created_at' => date('Y-m-d H:i:s'),
                            'modified_at' => date('Y-m-d H:i:s'),
                        ];
                    }
                    $this->productAttributeMap->add($temp);
                }
            }
            //thêm thuộc tính bán kèm cho sản phẩm
            if(isset($data['arrayGroup'])){
                if(count($data['arrayGroup']) > 0) {
                    $temp = [];
                    foreach ($data['arrayGroup'] as $value) {
                        $temp[] = [
                        'product_id' => $id,
                        'product_attribute_group_id' => intval($value),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        ];
                    }
                }
                $this->productAttributeGroupMap->add($temp);
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
     * Update sản phẩm.
     * @param array $data
     *
     * @return array
     */
    public function update(array $data = [])
    {
        try {
            DB::beginTransaction();
            $productId = intval($data['product_id']);
            //Update sản phẩm.
            $fields['product_category_id'] = intval($data['product_category_id']);
            $fields['product_code'] = $this->code->generateCodeRandom('SP');
            $fields['product_name_vi'] = strip_tags($data['product_name_vi']);
            $fields['product_name_en'] = strip_tags($data['product_name_en']);
            $fields['product_alias_vi'] = str_slug(strip_tags($data['product_name_vi']));
            $fields['product_alias_en'] = str_slug(strip_tags($data['product_name_en']));
            $fields['price_month'] = 0;
            $fields['price_year'] = 0;
            $fields['parent_id'] = 0;
            $fields['is_template'] = 0;
            // $fields['price_by_attribute'] = strip_tags($data['price_by_attribute']);
            $fields['package'] = '';
            $fields['description_vi'] = strip_tags($data['description']);
            $fields['description_en'] = strip_tags($data['description']);
            $fields['is_deleted'] = 0;
            $fields['updated_by'] = Auth::id();
            $fields['is_actived'] = intval($data['is_active']);
            if (isset($data['avatar'])) {
                if ($data['avatar'] != '') {
                    $image = $this->transferTempFileToAdminFile($data['avatar'] );
                    $fields['avatar'] = $image;
                }
            }

            $this->product->edit($fields, $productId);

            //Xóa hết thuộc tính của sản phẩm.
            $this->productAttributeMap->removeAll($productId);

            //Thêm thuộc tính cho sản phẩm.
            if (isset($data['arrayAttribute'])) {
                if (count($data['arrayAttribute']) > 0) {
                    $temp = [];
                    foreach ($data['arrayAttribute'] as $item) {
                        $temp[] = [
                            'product_id' => $productId,
                            'product_attribute_id' => $item['attribute_id'],
                            'min_value' => $item['min'],
                            'max_value' => $item['max'],
                            'min_unit' => $item['jump'],
                            'unit_price_month' => $item['price_month'],
                            'unit_price_year' => $item['price_year'],
                            'is_actived' => 1,
                            'created_by' => Auth::id(),
                            'modified_by' => Auth::id(),
                            'created_at' => date('Y-m-d H:i:s'),
                            'modified_at' => date('Y-m-d H:i:s'),
                        ];
                    }
                    $this->productAttributeMap->add($temp);
                }

                //Xóa hết nhóm thuộc tính bán kèm của sản phẩm.
                $this->productAttributeGroupMap->removeAll($productId);

                //thêm thuộc tính bán kèm cho sản phẩm
                if(isset($data['arrayGroup'])){
                    if(count($data['arrayGroup']) > 0) {
                        $temp = [];
                        foreach ($data['arrayGroup'] as $value) {
                            $temp[] = [
                                'product_id' => $productId,
                                'product_attribute_group_id' => intval($value),
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ];
                        }
                    }
                    $this->productAttributeGroupMap->add($temp);
                }
            }

            DB::commit();
            return [
                'error'   => false,
                'message' => __('product::validation.product.edit_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e -> getMessage());
            return [
                'error'   => true,
                'message' => __('product::validation.product.edit_fail'),
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
     * Lấy thông tin của sản phẩm
     * @param $id
     *
     * @return mixed
     */
    public function getItem($id)
    {
        return $this->product->getItem($id);
    }

    /**
     * Lấy thông tin của sản phẩm với code
     * @param $id
     *
     * @return mixed
     */
    public function getItemByCode($code)
    {
        return $this->product->getItemByCode($code);
    }

    /**
     * Lấy danh sách thuộc tính của sản phẩm
     * @param $productId
     *
     * @return mixed
     */
    public function getProductAttributeMap($productId)
    {
        return $this->productAttributeMap->getProductAttributeMap($productId);
    }

    /**
     * Lấy danh sách nhóm thuộc tính bán kèm của sản phẩm
     * @param $productId
     *
     * @return mixed
     */
    public function getProductAttributeGroupMap($productId)
    {
        return $this->productAttributeGroupMap->getProductAttributeGroupMap($productId);
    }
    /**
     * Lấy danh sách thuộc tính bán kèm của nhóm thuộc tính
     * @param $productId
     *
     * @return mixed
     */
    public function getItemAttrGroup($productId)
    {
        return $this->productAttributeGroupMap->getItemAttrGroup($productId);
    }

    /**
     * Chuyển file từ temp sang folder chính.
     * @param $path
     * @param $imgName
     *
     * @return string
     */
    private function transferTempFileToAdminFile($imgName)
    {
        $old_path = TEMP_PATH . '/' . $imgName;
        $exists = Storage::disk('public')->exists($old_path);
        if ($exists == true) {
            $new_path = PRODUCT_UPLOADS_PATH . '/' . $imgName;
            Storage::disk('public')
                ->move($old_path, $new_path);
            return $new_path;
        }
        return '';
    }

    public function getAttrGroupWhereNotIn($attributeGroup, $arrayIdAttribute)
    {
        return $this->attributeGroup->getAttrGroupWhereNotIn($attributeGroup, $arrayIdAttribute);
    }
}
