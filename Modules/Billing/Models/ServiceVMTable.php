<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceVMTable extends Model{
    protected $table = 'service_vm';
    protected $primaryKey = 'vm_id';
    protected $fillable = ['vm_id','customer_service_id','name','deleted_at','created_at'];
    public $timestamps = false;

    public function getVM($customer_service_id, $isDeleted){
        if(empty($isDeleted)){
            $selected = $this->select($this->fillable)
            ->where($this->table.'.customer_service_id', $customer_service_id)
            ->get()
            ->toArray();
        }else if($isDeleted){
            $selected = $this->select($this->fillable)
            ->where($this->table.'.customer_service_id', $customer_service_id)
            ->whereNotNull($this->table.'.deleted_at')
            ->get()
            ->toArray();
        }else{
            $selected = $this->select($this->fillable)
            ->where($this->table.'.customer_service_id', $customer_service_id)
            ->whereNull($this->table.'.deleted_at')
            ->get()
            ->toArray();
        }
        return $selected;
    }
}
