<?php


namespace Modules\Product\Models;

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
    protected $fillable = [
        'customer_service_id', 'customer_id', 'product_id', 'payment_type', 'quantity', 'vdc_name', 'price', 'amount', 'actived_date', 'expired_date',
        'type', 'status', 'note', 'service_content', 'service_type', 'customer_contract_id', 'created_at', 'created_by', 'updated_at',
        'updated_by', 'staff_id', 'charg_date', 'last_billing'
    ];
    public $timestamps = false;

    public function insertItem($data)
    {
        return $this->insertGetId($data);
    }

    public function getListService()
    {
        $select = $this->select(
            'customer_service.customer_service_id',
            'customer_service.payment_type',
            'customer_service.quantity',
            'customer_service.price',
            'customer_service.amount',
            'customer_service.type',
            'customer_service.status'
        )
            ->join(
                'customer',
                'customer.customer_id',
                '=',
                'customer_service.customer_id'
            );
        return $select;
    }

    public function getListServiceId($id)
    {
        $select = $this->select(
            'customer_service.customer_service_id',
            'customer_service.payment_type',
            'customer_service.quantity',
            'customer_service.price',
            'customer_service.amount',
            'customer_service.type',
            'customer_service.status',
            'customer.customer_id',
            'order.order_id'
        )
            ->join('customer', 'customer.customer_id', '=', 'customer_service.customer_id')
            ->join('order', 'order.customer_id', '=', 'customer.customer_id');
        return $select->where('customer.customer_id', $id)->groupBy('customer_service.customer_service_id')->get();
    }

    public function getListServiceCode($code)
    {
        $select = $this->select(
            'customer_service.customer_service_id',
            'customer_service.payment_type',
            'customer_service.quantity',
            'customer_service.price',
            'customer_service.amount',
            'customer_service.type',
            'customer_service.status',
            'customer.customer_id',
            'order.order_code'
        )
            ->join('customer', 'customer.customer_id', '=', 'customer_service.customer_id')
            ->join('order', 'order.customer_id', '=', 'customer.customer_id');
        return $select->where('order.order_code', $code)->get();
    }

    public function updateLastBilling($customer_service_id, $date){
        return $this->where($this->primaryKey, $customer_service_id)->update([
            $this->table.'.last_billing' => $date
        ]);
    }

    public function getListCore(&$filter)
    {
        $select = $this->select(
            $this->table . '.customer_service_id',
            $this->table . '.payment_type',
            $this->table . '.quantity',
            $this->table . '.actived_date',
            $this->table . '.expired_date',
            $this->table . '.type',
            $this->table . '.status',
            $this->table . '.price',
            $this->table . '.amount',
            $this->table . '.stop_payment_at',
            $this->table . '.stop_payment',
            'customer.customer_id',
            'product.product_name_vi',
            'product.product_name_en',
            'customer.customer_name',
            'customer.company_name'
        )
            ->join('product','product.product_id', '=', 'customer_service.product_id')
            ->join('customer','customer.customer_id', '=', 'customer_service.customer_id')
            ->where('product.is_deleted', 0)
            ->where('product.is_actived', 1);

            if(isset($filter['keyword_product$product_name_vi'])){
                $select->where(DB::raw('upper(portal_product.product_name_vi)'),'like','%'.strtoupper($filter['keyword_product$product_name_vi']).'%');
                unset($filter['keyword_product$product_name_'.getValueByLang('')]);
            }

            if (isset($filter['id'])) {
                $select->where(
                    'customer.customer_id','=', $filter['id']
                )->groupBy('customer_service.customer_service_id');

                unset($filter['id']);
            }

            if (isset($filter['contract_id'])) {
                $select->where($this->table . '.customer_contract_id', $filter['contract_id']);
                unset($filter['contract_id']);
            }

            if (isset($filter['keyword_customer_service$stop_payment'])) {
                $select->where($this->table . '.stop_payment', $filter['keyword_customer_service$stop_payment']);
                unset($filter['keyword_customer_service$stop_payment']);
            }

            if(isset($filter['keyword_customer_service$status'])) {
                $select->where($this->table.'.status', '=', $filter['keyword_customer_service$status']);
                unset($filter['keyword_customer_service$status']);
            }
        return $select->orderBy($this->table.'.updated_at','desc');
    }

    /**
     * function getDetail dịch vụ
     *
     * @param int $customer_service_id
     * @return mixed
     */
    public function getDetail($customer_service_id)
    {
        return $this->leftJoin('product', function ($join) {
            $join->on('product.product_id', '=', 'customer_service.product_id')
                ->where('product.is_deleted', 0);
        })
            ->leftJoin('customer', function ($join) {
                $join->on('customer.customer_id', '=', 'customer_service.customer_id')
                    ->where('customer.is_deleted', 0);
            })
            ->leftJoin('admin', function ($join) {
                $join->on('admin.id', '=', 'customer_service.staff_id')
                    ->where('admin.is_deleted', 0);
            })
            ->where($this->table . '.' . $this->primaryKey, $customer_service_id)
            ->select(
                $this->table . '.customer_service_id',
                $this->table . '.customer_id',
                $this->table . '.payment_type',
                $this->table . '.quantity',
                $this->table . '.price',
                $this->table . '.amount',
                $this->table . '.actived_date',
                $this->table . '.expired_date',
                $this->table . '.type',
                $this->table . '.status',
                $this->table . '.customer_contract_id',
                $this->table . '.note',
                $this->table . '.created_at',
                $this->table . '.created_by',
                $this->table . '.updated_at',
                $this->table . '.updated_by',
                $this->table . '.service_content',
                $this->table . '.staff_id',
                $this->table.'.charg_date',
                $this->table.'.last_billing',
                $this->table.'.stop_payment',
                $this->table.'.stop_payment_at',
                'product.product_id',
                'product.product_name_vi',
                'product.product_name_en',
                'customer.customer_name',
                'customer.customer_email',
                'customer.company_name',
                'admin.full_name',
                'admin.id',
                'admin.is_actived'
            )
            ->first()->toArray();
    }

    /**
     * function update content dịch vụ
     *
     * @param int $customer_service_id
     * @param int $data
     * @return mixed
     */
    public function updateService(array $data, $customer_service_id)
    {
//        dd($data, $customer_service_id);
        return $this->where($this->primaryKey, $customer_service_id)->update($data);

    }

    public function getCustomerServiceByReceiptId($receiptId)
    {
        $select = $this->select(
            'receipt.receipt_id',
            'product.product_code',
            'product.product_name_vi',
            'product.product_name_en',
            'customer_service.amount'
        )->leftJoin('receipt_map',
            'receipt_map.' . $this->primaryKey,
            '=',
            $this->table . '.' . $this->primaryKey)
            ->leftJoin(
                'receipt',
                'receipt.receipt_id',
                '=',
                'receipt_map.receipt_id'
            )
            ->leftJoin(
                'product',
                'product.product_id',
                '=',
                'customer_service.product_id'
            )
            ->where('receipt.receipt_id', $receiptId)
            ->get();
        return $select;
    }

    public function getBillingListByContract($contractId){
        $select = $this->select(
            $this->fillable
        )->where($this->table.'.type','=', 'real')
        ->where($this->table.'.customer_contract_id' , $contractId)
        ->whereIn($this->table.'.status', ['spending'])
        ->whereNotNull($this->table.'.charg_date')
        ->get()->toArray();
        return $select;
    }
    public function servicePaymentMiss($date){
        $selected = $this->select(
            $this->table . '.customer_service_id',
            $this->table . '.payment_type',
            $this->table . '.quantity',
            $this->table . '.actived_date',
            $this->table . '.expired_date',
            $this->table . '.type',
            $this->table . '.status',
            $this->table . '.blocked_at',
            $this->table . '.product_id',
            $this->table . '.customer_id',
            'customer.block_service_time',
            'receipt.pay_expired'
        )
        ->leftJoin('customer','customer.customer_id', '=',$this->table.'.customer_id')
        ->join('receipt', 'receipt.customer_contract_id', $this->table.'.customer_contract_id')
        ->where($this->table.'.type', 'real')
        ->where($this->table.'.status','spending')
        ->whereNull($this->table.'.blocked_at')
        ->whereNotNull('customer.block_service_time')
        ->where('customer.block_service_time' ,'>', 0)
        ->whereNotNull('receipt.pay_expired')
        ->whereDate('receipt.pay_expired', '<', $date)
        ->get()->toArray();
        $blockToday = array_filter($selected, function($service) use($date){
            return (Carbon::parse($service['pay_expired'])->diffInDays($date) + 1 == $service['block_service_time']);
        });
        return $blockToday;
    }
    public function blockService($date){
        $selected = $this->select(
            $this->table . '.customer_service_id',
            $this->table . '.payment_type',
            $this->table . '.quantity',
            $this->table . '.actived_date',
            $this->table . '.expired_date',
            $this->table . '.type',
            $this->table . '.status',
            $this->table . '.blocked_at',
            $this->table . '.product_id',
            $this->table . '.customer_id',
            'customer.block_service_time'
        )
        ->leftJoin('customer','customer.customer_id', '=',$this->table.'.customer_id')
        ->where($this->table.'.type', 'real')
        ->where($this->table.'.status','spending')
        ->whereNotNull($this->table.'.expired_date')
        ->whereNull($this->table.'.blocked_at')
        ->whereDate($this->table.'.expired_date' , '<' , $date)
        ->whereNotNull('customer.block_service_time')
        ->where('customer.block_service_time' ,'>', 0)
        ->get()->toArray();
        $blockToday = array_filter($selected, function($service) use($date){
            return (Carbon::parse($service['expired_date'])->diffInDays($date) == $service['block_service_time']);
        });
        return $blockToday;
    }


    /**
     * Lấy danh sách dịch vụ không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = [])
    {
        if (isset($filters['customer_id'])) {
            $select = $this->getListCore($filters);
            $select->where($this->table.'.customer_id', $filters['customer_id'])
                    ->where('product.is_template', 0);
            unset($filters['perpage'], $filters['page'], $filters['customer_id']);
            if ($filters) {
                // filter list
                foreach ($filters as $key => $val) {
                    if (trim($val) == ''||trim($val) == null) {
                        continue;
                    }
                    if (strpos($key, 'keyword_') !== false) {
                        $select->where(str_replace('$', '.', str_replace('keyword_', '', $key)), 'like', '%' . $val . '%');
                    } elseif (strpos($key, 'sort_') !== false) {
                        $select->orderBy(str_replace('$', '.', str_replace('sort_', '', $key)), $val);
                    } else {
                        $select->where(str_replace('$', '.', $key), $val);
                    }
                }
            }
//            dd(count($select->get()));
            return $select->get();
        }

        return null;
    }
}
