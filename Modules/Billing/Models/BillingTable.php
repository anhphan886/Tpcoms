<?php

namespace Modules\Billing\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BillingTable extends Model{
    protected $table = 'billing';
    protected $primaryKey = 'billing_id';
    protected $fillable = ['billing_id','contract_id','billing_date','total','created_at'];
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

    public function checkExist($date, $contract_id){
        return $this->where($this->table.'.contract_id', $contract_id)
            ->whereBetween($this->table.'.billing_date', [Carbon::parse($date)->startOfMonth(),Carbon::parse($date)->endOfMonth()])->exists();
    }
}
