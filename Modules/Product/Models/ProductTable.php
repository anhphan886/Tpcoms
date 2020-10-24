<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use MyCore\Models\Traits\ListTableTrait;

class ProductTable extends BaseModel
{
    use ListTableTrait;
    protected $table = 'product';
    protected $primaryKey = 'product_id';

    protected $fillable
        = [
            'product_id', 'product_category_id', 'product_code',
            'product_name_vi', 'product_name_en', 'product_alias_vi',
            'product_alias_en', 'price_month', 'price_year', 'parent_id',
            'is_template', 'package', 'description_vi', 'description_en',
            'is_deleted', 'is_actived', 'created_by', 'created_at',
            'updated_by', 'updated_at', 'price_by_attribute', 'is_feature',
            'avatar', 'price_day'
        ];

    public function getListCore(&$filters)
    {
        if (isset($filters['product$is_template'])) {
            if ($filters['product$is_template'] == 1) {
                $select = $this->select(
                    'product.product_id',
                    'product.product_code',
                    'product.product_name_vi',
                    'product.product_name_en',
                    'product.price_month',
                    'product.price_year',
                    'product.parent_id',
                    'product.is_template',
                    'product.package',
                    'product.description_vi',
                    'product.description_en',
                    'product.is_deleted',
                    'product.created_by',
                    'product.created_at',
                    'product.updated_at',
                    'product.updated_by',
                    'product.is_actived',
                    'a1.full_name as create_full_name',
                    'a2.full_name as update_full_name'
                )
                    ->join(
                        'admin as a1',
                        'a1.id',
                        '=',
                        'product.created_by'
                    )
                    ->join(
                        'admin as a2',
                        'a2.id',
                        '=',
                        'product.updated_by'
                    );
                if (isset($filters['keyword'])) {
                    $select->where(function ($query) use ($filters) {
                        if (App::getLocale() == 'vi') {
                            $query->where(
                                DB::raw('upper(portal_product.product_name_vi)'),
                                'like',
                                '%' . strtoupper($filters['keyword']) . '%'
                            );
                        } else {
                            $query->where(
                                DB::raw('upper(portal_product.product_name_en)'),
                                'like',
                                '%' . strtoupper($filters['keyword']) . '%'
                            );
                        }
                        $query->orWhere(
                            DB::raw('upper(portal_product.product_code)'),
                            'like',
                            '%' . strtoupper($filters['keyword']) . '%'
                        );
                    });
                    unset($filters['keyword']);
                }
                $select->where('product.is_deleted', 0);
                return $select->orderBy('product.updated_at','desc');
            }
        } else {
            $select = $this->select(
                'product.product_id',
                'product.product_category_id',
                'product_categories.category_name_vi',
                'product_categories.category_name_en',
                'product.product_code',
                'product.product_name_vi',
                'product.product_name_en',
                'product.price_month',
                'product.price_year',
                'product.parent_id',
                'product.is_template',
                'product.package',
                'product.description_vi',
                'product.description_en',
                'product.is_deleted',
                'product.created_by',
                'product.updated_by',
                'product.created_at',
                'product.updated_at',
                'product.updated_by',
                'product.is_actived',
                'a1.full_name as create_full_name',
                'a2.full_name as update_full_name'
            )
                ->join(
                    'product_categories',
                    'product_categories.product_category_id',
                    '=',
                    'product.product_category_id'
                )
                ->leftJoin(
                    'admin as a1',
                    'a1.id',
                    '=',
                    'product.created_by'
                )
                ->leftJoin(
                    'admin as a2',
                    'a2.id',
                    '=',
                    'product.updated_by'
                );

            if (isset($filters['keyword'])) {
                if ($filters['keyword'] != null && $filters['keyword'] != '') {
                    $select->where(function ($query) use ($filters) {
                        if (App::getLocale() == 'vi') {
                            $query->where(
                                DB::raw('upper(portal_product.product_name_vi)'), 'like',
                                '%' . strtoupper($filters['keyword']) . '%'
                            );
                        } else {
                            $query->where(
                                DB::raw('upper(portal_product.product_name_en)'), 'like',
                                '%' . strtoupper($filters['keyword']) . '%'
                            );
                        }

                        $query->orWhere(
                            DB::raw('upper(portal_product.product_code)'), 'like',
                            '%' . strtoupper($filters['keyword']) . '%'
                        );
                    });
                }
                unset($filters['keyword']);
            }
            $select->where('product_categories.is_deleted', 0)
                ->where('product.is_deleted', 0);
            return $select->orderBy('product.updated_at','desc');
        }

    }

    public function getListProduct(){
        $oSelect = $this->from($this->table.' as p')
        ->join(
            'product_categories as pc',
            'pc.product_category_id',
            '=',
            'p.product_category_id'
        )
        ->where('pc.is_deleted', 0)
        ->where('p.is_deleted', 0)
        ->where('p.is_actived', 1)
        ->get();

        return $this->getResultToArray($oSelect);
    }

    public function getListInProduct($arrId){
        $oSelect = $this->from($this->table.' as p')
            ->whereIn('product_id', $arrId)
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

    /**
     * Get option.
     * @return mixed
     */
    public function option()
    {
        $select = $this->select(
            'product.product_id',
            'product.product_category_id',
            'product_categories.category_name_vi',
            'product_categories.category_name_en',
            'product.product_code',
            'product.product_name_vi',
            'product.product_name_en'
        )
            ->join(
                'product_categories',
                'product_categories.product_category_id',
                '=',
                'product.product_category_id'
            )
            ->where('product.is_template', 0)
            ->where('product.is_deleted', 0)
            ->where('product_categories.is_deleted', 0)
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
        return $this->select($this->fillable)->where($this->primaryKey, $id)->first();
    }

    /**
     * Get item by code
     * @param $id
     *
     * @return mixed
     */
    public function getItemByCode($code)
    {
        return $this->select($this->fillable)->where('product_code', $code)->first();
    }

    public function getServiceRevenue($filters)
    {
        $select = $this->select(
            'product.product_id',
            'product.product_name_vi',
            DB::raw('SUM(portal_order_detail.amount) AS amount')
        )
            ->leftJoin(
                'order_detail', 'order_detail.product_id', '=',
                $this->table . '.' . $this->primaryKey
            )
            ->leftJoin('order', 'order.order_id', '=', 'order_detail.order_id')
            ->leftJoin('customer', 'customer.customer_id', '=', 'order.customer_id')
            ->leftJoin('receipt', 'receipt.order_id', '=', 'order.order_id')
//            ->leftJoin('receipt_detail', 'receipt_detail.receipt_id', '=', 'receipt.receipt_id')
            ->where('product.is_template', 0)
            ->where('product.is_deleted', 0)
            ->where('product.is_actived', 1)
            ->where('receipt.status', 'paid')
            ->groupBy('product.product_id')
            ->orderByRaw('SUM(portal_order_detail.amount) DESC');
        if (isset($filters['segment_id']) && $filters['segment_id'] != null) {
            $select->where('customer.segment_id', $filters['segment_id']);
        }
        if (isset($filters['date']) && $filters['date'] != null) {
            $select->whereBetween('receipt.paided_at', $filters['date']);
        }
        if (isset($filters['product_id']) && $filters['product_id'] != null) {
            $select->where('product.product_id', $filters['product_id']);
        }
        if (isset($filters['display_customer']) && $filters['display_customer'] != null) {
            $select->limit($filters['display_customer']);
        }
        return $select->get();
    }

    /**
     * Thông tin sản phẩm.
     * @param $id
     *
     * @return array
     */
    public function getProduct($id){
        $oSelect = $this->from($this->table.' as p')
            ->leftJoin(
                'product_categories as pc',
                'pc.product_category_id',
                '=',
                'p.product_category_id'
            )
//            ->where('pc.is_deleted', 0)
            ->where('p.is_deleted', 0)
            ->where('p.product_id', $id)
            ->first();
        return $this->getResultToArray($oSelect);
    }
    public function getCategoryId($id){
        $product = $this->select(['product_category_id', 'parent_id'])->where($this->table.'.'.$this->primaryKey, $id)->first();
        $cate_id = $product['product_category_id'];
        if(!$cate_id){
            $parent = $this->select(['product_category_id', 'parent_id'])->where($this->table.'.'.$this->primaryKey, $product['parent_id'])->first();
            $cate_id = $parent['product_category_id'];
        }
        return $cate_id;
    }
}
