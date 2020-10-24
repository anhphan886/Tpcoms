<?php


namespace Modules\Product\Models;


use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class CustomerServiceDetailTable extends Model
{
    use ListTableTrait;
    protected $table = 'customer_service_detail';
    protected $primaryKey = 'customer_service_detail_id';
    protected $fillable = [
        'customer_service_detail_id',
        'customer_service_id',
        'product_attribute_id',
        'value',
        'is_deleted',
        'updated_by',
        'updated_at'
    ];

    public function insertItem($data){
        return $this->insertGetId($data);
    }
    public function updateItemValue($data, $customer_service_id, $product_attribute_id){
        return $this->where($this->table.'.product_attribute_id', $product_attribute_id)
        ->where($this->table.'.customer_service_id', $customer_service_id)
        ->update($data);
    }
    public function  getDetail($customer_service_detail_id){
        return $this->select($this->fillable)
        ->where($this->table.'.customer_service_detail_id', $customer_service_detail_id)
        ->where($this->table.'.is_deleted', '0')
        ->get()
        ->toArray();
    }
    public function getDetailByCustomerService($customer_service_id){
        return $this->select($this->fillable)
        ->where($this->table.'.customer_service_id', $customer_service_id)
        ->where($this->table.'.is_deleted', '0')
        ->get()
        ->toArray();
    }
    public function deleteItem($customer_service_detail_id){
        return $this->where($this->table.'.customer_service_detail_id', $customer_service_detail_id)
        ->update(['is_deleted' => 1]);
    }

    public function deleteItemCustomer($customer_service_id, $product_attribute_id){
        return $this->where($this->table.'.product_attribute_id', $product_attribute_id)
        ->where($this->table.'.customer_service_id', $customer_service_id)
        ->update(['is_deleted' => 1]);
    }
}
