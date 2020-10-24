<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceVMAttributeTable extends Model{
    protected $table = 'service_vm_attribute';
    protected $primaryKey = 'vm_attribute_id';
    protected $fillable = ['vm_attribute_id','product_attribute_id','vm_id','value','price','last_billing','deleted_at','created_at'];
    public $timestamps = false;
    public function getAttributeByVMId($vm_id){
        return $this->select($this->fillable)->where($this->table.'.vm_id')->get()->toArray();
    }
    public function updateLastBilling($date){
        return $this->where($this->table.'.vm_id')->update(['last_billing' => $date]);
    }
}
