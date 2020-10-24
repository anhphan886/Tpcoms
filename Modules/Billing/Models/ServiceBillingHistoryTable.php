<?php

namespace Modules\Billing\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ServiceBillingHistoryTable extends Model{
    protected $table = 'service_vm_history';
    protected $primaryKey = 'service_history_id';
    protected $fillable = [
        'service_history_id', 'vm_id', 'product_attribute_id', 'customer_service_id', 'from_value',
        'to_value', 'from_date', 'to_date', 'price', 'amount', 'created_at'
    ];
    public $timestamps = false;

    public function getBillingByService($customer_service_id, $date){
        return $this->select($this->fillable)
        ->where($this->table.'.customer_service_id', $customer_service_id)
        ->whereBetween($this->table.'.created_at',is_array($date)?$date:[Carbon::parse($date)->startOfDay(),Carbon::parse($date)->endOfDay()])
        ->get()
        ->toArray();
    }
    public function calcBillingByService($customer_service_id, $date){
        return $this->select($this->fillable)
        ->where($this->table.'.customer_service_id', $customer_service_id)
        ->whereBetween($this->table.'.billing_date',is_array($date)?$date:[Carbon::parse($date)->startOfDay(),Carbon::parse($date)->endOfDay()])
        ->sum('amount');
    }
    /**
     * Thêm dữ liệu.
     * @param $data
     *
     * @return mixed
     */
    public function insertItem($data)
    {
        return $this->insertGetId($data);
    }
}
