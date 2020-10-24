<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/17/2019
 * Time: 7:45 PM
 */

namespace Modules\Product\Repositories\ProductCategory;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\ProductCategoryTable;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface
{
    protected $productCategory;

    public function __construct(
        ProductCategoryTable $productCategory
    ) {
        $this->productCategory = $productCategory;
    }
    public function getList(array $filters = [])
    {
        if (!isset($filters['keyword'])) {
            $filters['keyword'] = null;
        }
        if (!isset($filters['page'])) {
            $filters['page'] = 0;
        }
        $list = $this->productCategory->getList($filters);
        return [
            'filter' => $filters,
            'list' => $list
        ];
    }

    /**
     * Thêm
     * @param array $data
     *
     * @return array
     */
    public function store(array $data = [])
    {
        try {
            DB::beginTransaction();
            $dataInsert['category_name_vi'] = strip_tags($data['category_name_vi']);
            $dataInsert['category_name_en'] = strip_tags($data['category_name_en']);
            $dataInsert['is_deleted'] = 0;
            $dataInsert['created_by'] = Auth::id();
            $dataInsert['created_at'] = date('Y-m-d H:i:s');
            $dataInsert['modified_at'] = date('Y-m-d H:i:s');
            $dataInsert['updated_at'] = date('Y-m-d H:i:s');
            $dataInsert['modified_by'] = Auth::id();
            $this->productCategory->add($dataInsert);

            DB::commit();
            return [
                'error' => false,
                'message' => __('product::validation.product.add_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => 1,
                'message' => __('product::validation.product.add_fail'),
            ];
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $this->productCategory->edit(['is_deleted' => 1], $id);

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
        return $this->productCategory->getItem($id);
    }

    /**
     * Thêm
     * @param array $data
     *
     * @return array
     */
    public function update(array $data = [])
    {
        try {
            DB::beginTransaction();

            $dataInsert['category_name_vi'] = strip_tags($data['category_name_vi']);
            $dataInsert['category_name_en'] = strip_tags($data['category_name_en']);
            $dataInsert['modified_at'] = date('Y-m-d H:i:s');
            $dataInsert['updated_at'] = date('Y-m-d H:i:s');
            $dataInsert['modified_by'] = Auth::id();
            $this->productCategory->edit($dataInsert, $data['product_category_id']);

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
