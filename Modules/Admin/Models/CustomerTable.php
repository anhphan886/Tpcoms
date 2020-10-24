<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use MyCore\Models\Traits\ListTableTrait;


class CustomerTable extends Model
{
    use ListTableTrait;
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';

    protected $fillable
        = [
            'customer_id', 'customer_no', 'customer_type', 'customer_name',
            'customer_id_num', 'customer_address', 'customer_address_desc',
            'street_id', 'ward_id', 'district_id', 'province_id',
            'customer_phone', 'customer_phone2', 'customer_email',
            'customer_email2', 'customer_website', 'created_by', 'created_at',
            'modified_by', 'updated_at', 'status', 'is_deleted',
            'block_service_time'
        ];

    /**
     * Đếm số khách hàng được tạo trong khoảng thời gian.
     * @param $filters
     *
     * @return mixed
     */
    public function getCustomerCount($filters)
    {
        $select = $this->where('customer.is_deleted', 0)
            ->whereDate('customer.created_at', $filters['date']);
        return $select->count();
    }

    /**
     * Danh sách khách hàng.
     * @param $filters
     *
     * @return mixed
     */
    public function getListCore(&$filters)
    {
        $select = $this->select(
            'customer.customer_id',
            'customer.customer_no',
            'customer.customer_type',
            'customer.customer_name',
            'customer.customer_id_num',
            'customer.customer_address',
            'customer.customer_address_desc',
            'customer.street_id',
            'customer.ward_id',
            'customer.district_id',
            'customer.province_id',
            'customer.customer_phone',
            'customer.customer_phone2',
            'customer.customer_email',
            'customer.customer_email2',
            'customer.customer_website',
            'customer.created_by',
            'customer.created_at',
            'customer.modified_by',
            'customer.updated_at',
            'customer.status',
            'province.type as province_type',
            'province.name as province_name',
            'district.type as district_type',
            'district.name as district_name'
        )
            ->leftJoin(
                'province',
                'province.provinceid',
                '=',
                'customer.province_id'
            )
            ->leftJoin(
                'district',
                'district.districtid',
                '=',
                'customer.district_id'
            )
            ->where('customer.is_deleted', 0)
            ->whereDate('customer.created_at', $filters['date']);
        unset($filters['date']);
        if (isset($filters['query']['search_customer'])) {
            $keyword = $filters['query']['search_customer'];
            $select->where(
                function ($query) use ($keyword) {
                    $query->where(
                        'customer.customer_no', 'like',
                        '%' . $keyword . '%'
                    )->orWhere(
                        'customer.customer_name', 'like',
                        '%' . $keyword . '%'
                    )
                        ->orWhere(
                            'customer.customer_email', 'like',
                            '%' . $keyword . '%'
                        )
                        ->orWhere(
                            'customer.customer_phone', 'like',
                            '%' . $keyword . '%'
                        )
                        ->orWhere(
                            'customer.customer_phone2', 'like',
                            '%' . $keyword . '%'
                        );
                }
            );
            unset($filters['query']);
        }
        return $select->orderBy('customer.customer_id', 'desc');
    }

    /**
     * Tổng số khách hàng theo type.
     * @param $filters
     *
     * @return mixed
     */
    public function getCustomerByType($filters)
    {
        $select = $this->select(
            DB::raw("COUNT(portal_customer.customer_id) as quantity"),
            'customer.customer_type'
        )
            ->where('customer.is_deleted', 0)
            ->groupBy('customer.customer_type')
            ->whereBetween('customer.created_at', $filters['date'])
            ->get()->toArray();
        return $select;
    }

    /**
     * Tổng số khách hàng theo status
     * @param $filters
     *
     * @return mixed
     */
    public function getCustomerByStatus($filters)
    {
        $select = $this->select(
            DB::raw("COUNT(portal_customer.customer_id) as quantity"),
            'customer.status'
        )
            ->where('customer.is_deleted', 0)
            ->groupBy('customer.status')
            ->whereBetween('customer.created_at', $filters['date'])
            ->get()->toArray();
        return $select;
    }

    /**
     * @param $filters
     *
     * @return mixed
     */
    public function getCustomerChart($filters)
    {
        $select = $this->where('customer.is_deleted', 0)
            ->whereDate('customer.created_at', $filters['date']);
        if (isset($filters['type'])) {
            $select->where('customer.customer_type', $filters['type']);
        }
        return $select->get('customer.customer_id')->count();
    }

    /**
     * Option khách hàng.
     * @return mixed
     */
    public function getOption()
    {
        $select = $this->select(
            'customer.customer_id',
            'customer.customer_name'
        )
            ->where('is_deleted', 0)
            ->get();
        return $select;
    }

    /**
     * Lấy thông tin khách hàng bởi customer_id
     * @param $id
     *
     * @return mixed
     */
    public function getItem($id)
    {
        $select = $this->select(
            'customer.customer_id',
            'customer.customer_name'
        )
            ->where('is_deleted', 0)
            ->where('customer_id', $id)
            ->first();
        return $select;
    }
    public function updateBlockTime($time, $customer_id){
        return $this->where($this->primaryKey, $customer_id)
            ->update(['block_time_service' => $time]);
    }
    public function getCustomerRevenue($filters)
    {
        $select = $this->select(
            'customer.customer_id',
            'customer.customer_name',
            'customer.segment_id',
            DB::raw('SUM(portal_receipt_detail.amount) AS amount')

        )
            ->leftJoin(
                'order', 'order.customer_id', '=',
                $this->table . '.' . $this->primaryKey
            )
            ->leftJoin('receipt', 'receipt.order_id', '=', 'order.order_id')
            ->leftJoin(
                'receipt_detail', 'receipt_detail.receipt_id', '=',
                'receipt.receipt_id'
            )
            ->groupBy('customer.customer_id')
            ->orderByRaw('SUM(portal_receipt_detail.amount) DESC');
        if (isset($filters['customer_id']) && $filters['customer_id'] != null) {
            $select->where('customer.customer_id', $filters['customer_id']);
        }
        if (isset($filters['segment_id']) && $filters['segment_id'] != null) {
            $select->where('customer.segment_id', $filters['segment_id']);
        }
        if (isset($filters['date']) && $filters['date'] != null) {
            $select->whereBetween('receipt_detail.created_at', $filters['date']);
        }
        if (isset($filters['display_customer']) && $filters['display_customer'] != null) {
            $select->limit($filters['display_customer']);
        }
        $select->where('customer.is_deleted', 0);
        return $select->get();
    }
}
