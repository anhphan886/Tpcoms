<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use MyCore\Models\Traits\ListTableTrait;
use Illuminate\Support\Facades\DB;

class ProductCategoryTable extends Model
{
    use ListTableTrait;
    protected $table = 'product_categories';
    protected $primaryKey = 'product_category_id';

    protected $fillable
        = [
            'product_category_id', 'category_name_vi', 'category_name_en',
            'is_deleted', 'created_by', 'modified_by', 'created_at',
            'modified_at'
        ];

    /**
     * Get list
     *
     * @param $filters
     *
     * @return mixed
     */
    public function getListCore(&$filters)
    {
        $select = $this->select(
            'product_categories.product_category_id',
            'product_categories.category_name_vi',
            'product_categories.category_name_en',
            'category_name_en',
            'product_categories.is_deleted',
            'product_categories.created_at',
            'product_categories.modified_at',
            'ad1.full_name as create_full_name',
            'ad2.full_name as update_full_name'
        )
            ->where('product_categories.is_deleted', 0)
            ->join(
                'admin as ad1',
                'ad1.id',
                '=',
                'product_categories.created_by'
            )
            ->join(
                'admin as ad2',
                'ad2.id',
                '=',
                'product_categories.modified_by'
            );
        if (isset($filters['keyword'])) {
            if ($filters['keyword'] != null && $filters['keyword'] != '') {
                if (App::getLocale() == 'vi') {
                    $select->where(
                        DB::raw('upper(portal_product_categories.category_name_vi)'), 'like',
                        '%' . strtoupper($filters['keyword']) . '%'
                    );
                } else {
                    $select->where(
                        DB::raw('upper(portal_product_categories.category_name_en)'), 'like',
                        '%' . strtoupper($filters['keyword']) . '%'
                    );
                }
            }

            unset($filters['keyword']);
        }
        return $select->orderBy('product_categories.modified_at', 'desc');
    }

    /**
     * Thêm nhóm sản phẩm.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    /**
     * get option.
     *
     * @return mixed
     */
    public function option()
    {
        $select = $this->select(
            'product_category_id',
            'category_name_vi',
            'category_name_en'
        )
            ->where('is_deleted', 0)
            ->get();
        return $select;
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

    /**
     * Get item
     * @param $id
     *
     * @return mixed
     */
    public function getItem($id)
    {
        return $this->where($this->primaryKey, $id)->first();
    }
}
