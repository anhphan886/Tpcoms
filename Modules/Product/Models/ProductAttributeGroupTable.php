<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use MyCore\Models\Traits\ListTableTrait;
use Illuminate\Support\Facades\DB;

class ProductAttributeGroupTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'product_attribute_group';
    protected $primaryKey = 'product_attribute_group_id';

    protected $fillable
        = [
            'product_attribute_group_id',
            'product_attribute_group_name_vi',
            'product_attribute_group_name_en',
            'positions',
            'is_deleted',
            'created_by',
            'modified_by',
            'created_at',
            'modified_at',
            'updated_at',
            'is_sold_together',
            'quantity_attribute',
        ];

    public function getListOrder(){
        $oSelect = $this->where('is_deleted', 0)
                ->where('is_sold_together', 0)
                ->orderBy('positions', 'asc')
                ->get();

        return $this->getResultToArray($oSelect);
    }

    public function getListCore(&$filters)
    {
        $select = $this->select(
            'product_attribute_group_id',
            'product_attribute_group_name_vi',
            'product_attribute_group_name_en',
            'product_attribute_group.is_deleted',
            'product_attribute_group.created_by',
            'product_attribute_group.modified_by',
            'product_attribute_group.created_at',
            'product_attribute_group.modified_at',
            'product_attribute_group.updated_at',
            'product_attribute_group.positions',
            'ad1.full_name as create_full_name',
            'ad2.full_name as update_full_name'
        )
            ->join(
                'admin as ad1',
                'ad1.id',
                '=',
                'product_attribute_group.created_by'
            )
            ->join(
                'admin as ad2',
                'ad2.id',
                '=',
                'product_attribute_group.modified_by'
            )
            ->where('product_attribute_group.is_deleted', 0);
        if (isset($filters['keyword'])) {
            if ($filters['keyword'] != null && $filters['keyword'] != '') {
                if (App::getLocale() == 'vi') {
                    $select->where(
                        DB::raw('upper(product_attribute_group_name_vi)'), 'like',
                        '%' . strtoupper($filters['keyword']) . '%'
                    );
                } else {
                    $select->where(
                        DB::raw('upper(product_attribute_group_name_en)'), 'like',
                        '%' . strtoupper($filters['keyword']) . '%'
                    );
                }
            }
            unset($filters['keyword']);
        }
        return $select->orderBy('updated_at', 'desc');
    }

    /**
     * Thêm thuộc tính sản phẩm.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    public function option()
    {
        $select = $this->select(
            'product_attribute_group_id',
            'product_attribute_group_name_vi',
            'product_attribute_group_name_en'
            )
            ->where('is_deleted', 0)
            ->get();
        return $select;
    }

    public function optionSoldTogether()
    {
        $select = $this->select(
            'product_attribute_group_id',
            'product_attribute_group_name_vi',
            'product_attribute_group_name_en'
        )
            ->where('is_deleted', 0)
            ->where('is_sold_together',1)
            ->get();
        return $select;
    }

    public function getAttrGroupWhereNotIn($groupId, $array)
    {
//        dd($array);
        $select = $this->select(
            'product_attribute_group_id',
            'product_attribute_group_name_vi',
            'product_attribute_group_name_en',
            'positions',
            'is_deleted',
            'created_by',
            'modified_by',
            'created_at',
            'modified_at',
            'updated_at',
            'is_sold_together',
            'quantity_attribute'
        )
            ->where('is_deleted', 0)
            ->where('is_sold_together', 1)
            ->whereNotIn('product_attribute_group_id',$array)
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

    public function optionUnSoldTogether()
    {
        $select = $this->select(
            'product_attribute_group_id',
            'product_attribute_group_name_vi',
            'product_attribute_group_name_en'
        )
            ->where('is_deleted', 0)
            ->where('is_sold_together', 0)
            ->get();
        return $select;
    }
}
