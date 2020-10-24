<?php


namespace Modules\Admin\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use MyCore\Models\Traits\ListTableTrait;

class CustomerServiceTable extends Model
{
    use ListTableTrait;
    protected $table = 'customer_service';
    protected $primaryKey = 'customer_service_id';
    public $timestamps = false;

    protected $fillable = [
        'customer_service_id',
        'customer_id',
        'product_id',
        'payment_type',
        'actived_date',
        'expired_date',
        'status',
        'note',
        'created_at',
        'created_by',
        'modified_at',
        'blocked_at',
        'modified_by',
        'service_content',
        'customer_contract_id'
    ];

    public function getServiceExpired($filters)
    {
        $select = $this->join('product','product.product_id', '=', 'customer_service.product_id')
            ->join('customer','customer.customer_id', '=', 'customer_service.customer_id')
            ->where('customer.is_deleted', 0)
            ->where('product.is_deleted', 0)
            ->where('product.is_actived', 1)
            ->whereBetween('expired_date' ,[$filters['date'], $filters['expired_date']]);
        return $select->count();
    }

    /**
     * Danh sách
     * @param $filters
     *
     * @return mixed
     */
    public function getListCore(&$filters)
    {
        $nameLang = 'product.product_name_vi as name';
        if (App::getLocale() != 'vi') {
            $nameLang = 'product.product_name_en as name';
        }

        $select = $this->select(
            $this->table . '.customer_service_id',
            $this->table . '.payment_type',
            $this->table . '.quantity',
            $this->table . '.actived_date',
            $this->table . '.expired_date',
            $this->table . '.type',
            $this->table . '.status',
            'product.product_name_vi',
            $nameLang,
            'customer.customer_name'
        )
            ->join(
                'product', 'product.product_id', '=',
                'customer_service.product_id'
            )
            ->join(
                'customer', 'customer.customer_id', '=',
                'customer_service.customer_id'
            );
        if (isset($filters['query'])) {
            //Keyword theo loại.
            $keyword = '';
            if (isset($filters['query']['search_expire_not_canceled'])) {
                $keyword = $filters['query']['search_expire_not_canceled'];
            } elseif (isset($filters['query']['search_expire_to_day'])) {
                $keyword = $filters['query']['search_expire_to_day'];
            } elseif (isset($filters['query']['search_expire_7_day'])) {
                $keyword = $filters['query']['search_expire_7_day'];
            } elseif (isset($filters['query']['search_expire_30_day'])) {
                $keyword = $filters['query']['search_expire_30_day'];
            }

            $select->where(function ($query) use ($keyword) {
                if (App::getLocale() == 'vi') {
                    $query->where(
                        'product.product_name_vi', 'like', '%' . $keyword . '%'
                    );
                } else {
                    $query->where(
                        'product.product_name_en', 'like', '%' . $keyword . '%'
                    );
                }
                $query->orWhere(
                    'customer.customer_name', 'like', '%' . $keyword . '%'
                );
            });
        }

        if (isset($filters['type'])) {
            if ($filters['type'] == 'expire_not_canceled') {
                $select->where($this->table . '.expired_date', '<', $filters['date'])
                    ->where($this->table . '.status', '<>', 'cancel');
            }
            if ($filters['type'] == 'expire_to_day') {
                $select->where($this->table . '.expired_date', '=', $filters['date']);
            }
            if ($filters['type'] == 'expire_to_day') {
                $select->where($this->table . '.expired_date', '=', $filters['date']);
            }
            if ($filters['type'] == 'expire_day') {
                $select->whereBetween($this->table . '.expired_date', $filters['date']);
            }
            unset($filters['type']);
        }

        unset($filters['query']);
        unset($filters['date']);

        return $select->orderBy($this->table . '.customer_service_id', 'DESC');
    }

    /**
     * Tính tỉ lệ
     * @param $filters
     *
     * @return mixed
     */
    public function getByRatio($filters)
    {
        $select = $this->select(
            $this->table . '.' . $filters['type'],
            DB::raw("COUNT(portal_" . $this->table. ".product_id) as quantity")
        )
            ->join(
                'product', 'product.product_id', '=',
                'customer_service.product_id'
            )
            ->join(
                'customer', 'customer.customer_id', '=',
                'customer_service.customer_id'
            )
            ->orderBy('quantity', 'desc')
            ->groupBy($this->table . '.' . $filters['type'])
            ->whereBetween($this->table . '.actived_date', $filters['date']);

        if (isset($filters['type_real']) && $filters['type_real'] == 'real') {
            $select->where($this->table.'.type', '=' ,$filters['type_real']);

            unset($filters['type_real']);
        }

        return $select->get();
    }

    public function getTopServiceAll($date)
    {
        $nameLang = 'product.product_name_vi as name';
        if (App::getLocale() != 'vi') {
            $nameLang = 'product.product_name_en as name';
        }
        $select = $this->select(
            DB::raw("SUM(portal_customer_service.amount) as amount"),
            DB::raw("COUNT(portal_customer_service.product_id) as used"),
            $nameLang
        )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'customer_service.customer_id'
            )
            ->join(
                'product',
                'product.product_id',
                '=',
                'customer_service.product_id'
            )
            ->orderBy('used', 'desc')
            ->groupBy('customer_service.product_id')
            ->whereBetween( $this->table . '.actived_date', $date);

        return $select->get();
    }

}
