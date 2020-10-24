<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use MyCore\Models\Traits\ListTableTrait;
use Illuminate\Support\Facades\DB;

class ProductAttributeTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'product_attribute';
    protected $primaryKey = 'product_attribute_id';

    protected $fillable
        = [
            'product_attribute_id', 'product_attribute_group_id', 'unit_name',
            'product_attribute_name_vi', 'product_attribute_name_en',
            'price_month', 'price_year', 'vmware_params', 'is_deleted',
            'created_by', 'modified_by', 'created_at', 'modified_at',
            'product_attribute_code', 'is_actived', 'updated_at', 'description', 'price_day'
        ];

    public function getListCore(&$filters)
    {
        $select = $this->select(
            'product_attribute_id',
            'unit_name',
            'product_attribute_name_vi',
            'product_attribute_name_en',
            'product_attribute_group_name_vi',
            'product_attribute_group_name_en',
            'product_attribute_code',
            'product_attribute.is_actived',
            'ad1.full_name as create_full_name',
            'ad2.full_name as update_full_name',
            'product_attribute.created_at',
            'product_attribute.modified_at'
        )
            ->join(
                'product_attribute_group',
                'product_attribute_group.product_attribute_group_id',
                '=',
                'product_attribute.product_attribute_group_id'
            )
            ->join(
                'admin as ad1',
                'ad1.id',
                '=',
                'product_attribute.created_by'
            )
            ->join(
                'admin as ad2',
                'ad2.id',
                '=',
                'product_attribute.modified_by'
            )
            ->where('product_attribute_group.is_deleted', 0)
            ->where('product_attribute.is_deleted', 0);
        if (isset($filters['keyword'])) {
            if ($filters['keyword'] != null && $filters['keyword'] != '') {
                if (App::getLocale() == 'vi') {
                    $select->where(
                        DB::raw('upper(product_attribute_name_vi)'), 'like',
                        '%' . strtoupper($filters['keyword']) . '%'
                    )
                        ->orWhere(
                        DB::raw('upper(product_attribute_code)')  , 'like',
                            '%' . strtoupper($filters['keyword']) . '%'
                        );
                } else {
                    $select->where(
                            DB::raw('upper(product_attribute_name_en)'), 'like',
                            '%' . strtoupper($filters['keyword']) . '%'
                    )
                        ->orWhere(
                            DB::raw('upper(product_attribute_code)'), 'like',
                            '%' . strtoupper($filters['keyword']) . '%'
                        );
                }
            }

            unset($filters['keyword']);
        }

        if ($filters['product_attribute$is_actived'] != 10) {
            $select->where('product_attribute.is_actived', $filters['product_attribute$is_actived']);
        }
        unset($filters['product_attribute$is_actived']);
        return $select->orderBy('product_attribute.updated_at', 'desc');
    }

    public function getListIn($arrId){
        $oSelect = $this->from($this->table.' as a')
            ->join(
                'product_attribute_group as pag',
                'pag.product_attribute_group_id',
                '=',
                'a.product_attribute_group_id'
            )
            ->where('a.is_deleted', 0)
            ->where('a.is_actived', 1)
            ->where('pag.is_deleted', 0)
            ->whereIn('product_attribute_id', $arrId)
            ->get();

        return $this->getResultToArray($oSelect);
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

    public function option($groupId, $array)
    {
        $select = $this->select(
            $this->table . '.product_attribute_id',
            $this->table . '.product_attribute_group_id',
            $this->table . '.product_attribute_code',
            $this->table . '.unit_name',
            $this->table . '.product_attribute_name_vi',
            $this->table . '.product_attribute_name_en',
            $this->table . '.price_day',
            $this->table . '.price_month'
        )
            ->join(
                'product_attribute_group',
                'product_attribute_group.product_attribute_group_id',
                $this->table . '.product_attribute_group_id'
            )
            ->whereNotIn('product_attribute_id', $array)
            ->where($this->table . '.is_deleted', 0)
            ->where('product_attribute_group.is_sold_together', 0);

        if ($groupId != 0) {
            $select->where(
                $this->table . '.product_attribute_group_id', $groupId
            );
        }

        return $this->getResultToArray($select->get());
    }

    /**
     * Option thuộc tính bán kèm.
     * @param $groupId
     * @param $array
     *
     * @return mixed
     */
    public function optionSoldTogether($groupId, $array)
    {
        $select = $this->select(
            'product_attribute_id',
            'unit_name',
            'product_attribute.product_attribute_group_id',
            'product_attribute_name_vi',
            'product_attribute_name_en',
            'product_attribute_code',
            'product_attribute.is_actived',
            'product_attribute.is_deleted',
            'product_attribute_group.is_sold_together'
        )
            ->join(
                'product_attribute_group',
                'product_attribute_group.product_attribute_group_id',
                '=',
                'product_attribute.product_attribute_group_id'
            )
            ->where('product_attribute_group.is_sold_together',1)
            ->where('product_attribute.is_deleted', 0)
            ->whereNotIn('product_attribute_id', $array);
        if ($groupId != 0) {
            $select->where('product_attribute_group.product_attribute_group_id', $groupId);
            return $select->get();
        }
    }

    /**
     * Get item
     * @param $id
     *
     * @return mixed
     */
    public function getItem($id)
    {
        $select = $this->select(
            'product_attribute_id', 'product_attribute_group_id', 'unit_name',
            'product_attribute_name_vi', 'product_attribute_name_en',
            'price_month', 'price_year', 'vmware_params', 'is_deleted',
            'created_by', 'modified_by', 'created_at', 'modified_at',
            'product_attribute_code', 'is_actived', 'updated_at', 'description', 'price_day'
        )
            ->where('product_attribute_id', $id)
            ->first();
        return $select;
    }

    /**
     * Get item
     * @param $id
     *
     * @return mixed
     */
    public function getItemByCode($code)
    {
        $select = $this->select(
            'product_attribute_id', 'product_attribute_group_id', 'unit_name',
            'product_attribute_name_vi', 'product_attribute_name_en',
            'price_month', 'price_year', 'vmware_params', 'is_deleted',
            'created_by', 'modified_by', 'created_at', 'modified_at',
            'product_attribute_code', 'is_actived', 'updated_at', 'description', 'price_day'
        )
            ->where('product_attribute_code', $code)
            ->first();
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
//     * function get detail service theo customer_service_id
//     * @param int $customer_service_id
//     * @return mixed
//    */
    public function getDetailAttribute($customer_service_id)
    {
        return $this->leftJoin('customer_service_detail as csd', function($join){
            $join->on('csd.product_attribute_id', '=', 'product_attribute.product_attribute_id' );
        })
            ->leftJoin('customer_service', function ($join){
                $join->on('customer_service.customer_service_id', '=', 'csd.customer_service_id');
            })
            ->where('product_attribute.is_deleted', 0)
            ->where('csd.customer_service_id',$customer_service_id)
            ->where('csd.is_deleted', 0)
            ->select (
                'product_attribute.product_attribute_id',
                'product_attribute.unit_name',
                'product_attribute.product_attribute_name_vi',
                'product_attribute.product_attribute_name_en',
                'csd.value'
            )->get();
    }

    /**
     * Lấy thuộc tính theo nhóm thuộc tính
     *
     * @param $groupId
     * @return mixed
     */
    public function getAttributeByGroup($groupId)
    {
        return $this
            ->select(
                'product_attribute_id',
                'product_attribute_name_vi',
                'unit_name'
            )
            ->where('product_attribute_group_id', $groupId)
            ->get();
    }

    /**
     * Option tất cả thuộc tính.
     * @param $groupId
     * @param $array
     *
     * @return array
     */
    public function optionAll($groupId, $array)
    {
        $select = $this->select(
            $this->table . '.product_attribute_id',
            $this->table . '.product_attribute_group_id',
            $this->table . '.product_attribute_code',
            $this->table . '.unit_name',
            $this->table . '.product_attribute_name_vi',
            $this->table . '.product_attribute_name_en',
            $this->table . '.price_day',
            $this->table . '.price_month'
        )
            ->join(
                'product_attribute_group',
                'product_attribute_group.product_attribute_group_id',
                $this->table . '.product_attribute_group_id'
            )
            ->whereNotIn('product_attribute_id', $array)
            ->where($this->table . '.is_deleted', 0);
        if ($groupId != 0) {
            $select->where(
                $this->table . '.product_attribute_group_id', $groupId
            );
        }

        return $this->getResultToArray($select->get());
    }

    public function getAttOfOrder($orderCode)
    {
        $select = $this->join(
            'order_attribute_detail',
            'order_attribute_detail.product_attribute_id',
            '=',
            $this->table . '.product_attribute_id'
        )
            ->join(
                'order_detail',
                'order_detail.order_detail_id',
                '=',
                'order_attribute_detail.order_detail_id'
            )
            ->join(
                'order',
                'order.order_id',
                '=',
                'order_detail.order_id'
            )
            ->where('order.order_code', $orderCode)
            ->get();
        return $select;
    }
}
