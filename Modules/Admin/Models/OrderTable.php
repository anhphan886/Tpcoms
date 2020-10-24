<?php


namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\BaseCoreModel;
use MyCore\Models\Traits\ListTableTrait;

class OrderTable extends BaseCoreModel
{
    use ListTableTrait;

    protected $table = 'order';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    protected $fillable
        = [
            'order_id', 'order_type', 'order_code', 'customer_id', 'staff_id',
            'total', 'discount', 'vat', 'amount', 'voucher_type',
            'voucher_code', 'cash_type', 'cash_money_value',
            'cash_percent_value', 'order_status_id', 'source', 'updated_at',
            'created_by', 'updated_by', 'created_at', 'is_adjust', 'customer_service_id'
        ];

    /**
     * Đếm số lượng đơn hàng trong ngày
     * @param $filters
     *
     * @return mixed
     */
    public function getOrdersCount($filters)
    {
        $select = $this->join(
                'order_status',
                'order_status.order_status_id',
                '=',
                'order.order_status_id'
            )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id'
            )
            ->where('order_status.is_deleted', 0)
            ->where('customer.is_deleted', 0)
            ->whereDate('order.created_at', $filters['date']);
        return $select->count();
    }

    /**
     * Danh sách đơn hàng,
     *
     * @param $filters
     *
     * @return mixed
     */
    public function getListCore(&$filters)
    {
        $select = $this->select(
            'order.order_id',
            'order.order_code',
            'customer.customer_name',
            'order.order_status_id',
            'order_status.order_status_name_vi',
            'order_status.order_status_name_en',
            'order.created_at',
            'order.voucher_code',
            'order.total',
            'order.discount',
            'order.amount',
            'order.created_at',
            'order.updated_at',
            'order.is_adjust',
            'customer.customer_name as create_full_name',
            'pa2.full_name as update_full_name'
        )
            ->join('order_status',
                'order_status.order_status_id',
                '=',
                'order.order_status_id')
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id')
            ->leftJoin('admin',
                'admin.id',
                '=',
                'order.staff_id')
            ->join('order_detail',
                'order_detail.order_id',
                '=',
                'order.order_id')
            ->leftJoin('admin as pa1',
                'pa1.id',
                '=',
                'order.staff_id'
            )
            ->leftJoin('admin as pa2',
                'pa2.id',
                '=',
                'order.updated_by'
            )
            ->where('order_status.is_deleted', 0)
            ->where('customer.is_deleted', 0)
            ->groupBy('order_detail.order_id')
            ->orderBy('order.order_id', 'desc')
            ->whereDate('order.created_at', $filters['date']);
        unset($filters['date']);
        if (isset($filters['query']['search_order'])) {
            $keyword = $filters['query']['search_order'];
            $select->where(
                function ($query) use ($keyword){
                    $query->where('order.order_code',
                        'like', '%' . $keyword . '%'
                    )->orWhere('customer.customer_name', 'like',
                        '%' . $keyword . '%');
                }
            );
        }
        return $select;
    }

    public function getOrderByMonthYear($month,$year)
    {
//        $select = $this->join('order_status',
//                'order_status.order_status_id',
//                '=',
//                'order.order_status_id')
//            ->join(
//                'customer',
//                'customer.customer_id',
//                '=',
//                'order.customer_id')
//            ->leftJoin('admin',
//                'admin.id',
//                '=',
//                'order.staff_id')
//            ->join('order_detail',
//                'order_detail.order_id',
//                '=',
//                'order.order_id')
//            ->leftJoin('admin as pa1',
//                'pa1.id',
//                '=',
//                'order.staff_id'
//            )
//            ->leftJoin('admin as pa2',
//                'pa2.id',
//                '=',
//                'order.updated_by'
//            )
//            ->where('order_status.is_deleted', 0)
//            ->where('customer.is_deleted', 0)
//            ->whereMonth('order.created_at', $month)->whereYear('order.created_at', '=', $year);
//
//        return $select->count();
        $select = $this->select(
            'order.order_id',
            'order.order_code',
            'customer.customer_name',
            'order.order_status_id',
            'order_status.order_status_name_vi',
            'order_status.order_status_name_en',
            'order.created_at',
            'order.voucher_code',
            'order.total',
            'order.discount',
            'order.amount',
            'order.created_at',
            'order.updated_at',
            'customer.customer_id'
        )
            ->leftJoin('order_detail',
                'order_detail.order_id',
                '=',
                'order.order_id')
            ->join('order_status',
                'order_status.order_status_id',
                '=',
                'order.order_status_id')
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id')
            ->leftJoin('admin',
                'admin.id',
                '=',
                'order.staff_id')
            ->where('order_status.is_deleted', 0)
            ->where('customer.is_deleted', 0)
            ->whereMonth('order.created_at', $month)->whereYear('order.created_at', '=', $year);;
        $select->groupBy('order.order_id');

        return count($select->get());
    }

    public function getOrderByDateMonth($date, $month,$year)
    {
        $day = $year . '-' . $month . '-' . $date;

        $select = $this->join('order_status',
            'order_status.order_status_id',
            '=',
            'order.order_status_id')
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id')
            ->leftJoin('admin',
                'admin.id',
                '=',
                'order.staff_id')
            ->leftJoin('order_detail',
                'order_detail.order_id',
                '=',
                'order.order_id')
            ->leftJoin('admin as pa1',
                'pa1.id',
                '=',
                'order.staff_id'
            )
            ->leftJoin('admin as pa2',
                'pa2.id',
                '=',
                'order.updated_by'
            )
            ->where('order_status.is_deleted', 0)
            ->where('customer.is_deleted', 0)
            ->whereDate('order.created_at', '=', $day)
            ->groupBy('order.order_id');

        return $select->get()->count();
    }

    public function getTopService($date)
    {
        $nameLang = 'product.product_name_vi as name';
        if (App::getLocale() != 'vi') {
            $nameLang = 'product.product_name_en as name';
        }

        $select = $this->select(
            DB::raw("SUM(portal_order_detail.amount) as amount"),
            DB::raw("count(*) as used"),
            $nameLang
        )
            ->join(
                'order_status',
                'order_status.order_status_id',
                '=',
                'order.order_status_id'
            )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id'
            )
            ->leftJoin(
                'admin',
                'admin.id',
                '=',
                'order.staff_id'
            )
            ->join(
                'order_detail',
                'order_detail.order_id',
                '=',
                'order.order_id'
            )
            ->join(
                'product',
                'product.product_id',
                '=',
                'order_detail.product_id'
            )
            ->where('order.order_status_id', 4)
            ->groupBy('order_detail.product_id')
            ->orderBy('used', 'desc')
            ->whereBetween('order.created_at', $date);
        return $select->take(10)->get();
    }

    public function getOrderByStatus($status, $dateTime)
    {


        $select = $this
            ->join('order_status',
            'order_status.order_status_id',
            '=',
            'order.order_status_id')
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id')
            ->where('order_status.is_deleted', 0)
            ->where('customer.is_deleted', 0)
            ->where('order.order_status_id', $status)
            ->whereBetween('order.created_at', $dateTime);
        return $select->count('order.order_id');
    }

    public function getTopServiceAll($date)
    {
        $nameLang = 'product.product_name_vi as name';
        if (App::getLocale() != 'vi') {
            $nameLang = 'product.product_name_en as name';
        }
        $select = $this->select(
            DB::raw("SUM(portal_order_detail.amount) as amount"),
            DB::raw("count(*) as used"),
            $nameLang
        )
            ->join(
                'order_status',
                'order_status.order_status_id',
                '=',
                'order.order_status_id'
            )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'order.customer_id'
            )
            ->join(
                'order_detail',
                'order_detail.order_id',
                '=',
                'order.order_id'
            )
            ->join(
                'product',
                'product.product_id',
                '=',
                'order_detail.product_id'
            )
            ->where('order.order_status_id', 4)
            ->groupBy('order_detail.product_id')
            ->orderBy('used', 'desc')
            ->whereBetween('order.created_at', $date);
        return $select->get();
    }
}
