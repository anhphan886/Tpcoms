<?php


namespace Modules\Product\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReceiptMapTable extends Model
{
    protected $table = 'receipt_map';
    protected $primaryKey = 'receipt_map_id';
    protected $fillable = [
        'receipt_id','receipt_map_id','customer_service_id',
        'updated_at','created_by','created_at','modified_by'
    ];
    public $timestamps = true;
        /**
     * Thêm thuộc tính receipt.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }


    /**
     * edit
     * @param array $data
     * @param       $id
     *
     * @return mixed
     */
    public function edit(array $data, $id)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }

}
