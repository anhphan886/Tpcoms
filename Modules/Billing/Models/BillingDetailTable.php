<?php

namespace Modules\Billing\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BillingDetailTable extends Model{
    protected $table = 'billing_detail';
    protected $primaryKey = 'billing_detail_id';
    protected $fillable = ['billing_detail_id', 'customer_service_id','contract_id','billing_date','total','type','remain','created_at'];
    public $timestamps = false;
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
    public function updateItem($data, $id){
        return $this->where($this->primaryKey, $id)
            ->update($data);
    }

    public function checkExist($date, $customer_service_id){
        return $this->where($this->table.'.customer_service_id', $customer_service_id)
            ->whereBetween($this->table.'.billing_date', [Carbon::parse($date)->startOfMonth(),Carbon::parse($date)->endOfMonth()])->exists();
    }
    public function calcByCustomerDate($customer_service_id, $date){
        return $this->where($this->table.'.customer_service_id', $customer_service_id)
            ->whereBetween($this->table.'.billing_date', [Carbon::parse($date)->startOfMonth(),Carbon::parse($date)->endOfMonth()])
            ->where($this->table.'.type', 'charge')
            ->sum('total');
    }
    public function calcByContractDate($contract_id, $date){
        return $this->where($this->table.'.contract_id', $contract_id)
            ->whereBetween($this->table.'.billing_date', [Carbon::parse($date)->startOfMonth(),Carbon::parse($date)->endOfMonth()])
            ->where($this->table.'.type', 'charge')
            ->sum('total');
    }
}
