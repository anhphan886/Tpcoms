<?php


namespace Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class OrderStatusTable extends Model
{
    protected $table = 'order_status';
    protected $primaryKey = 'order_status_id';

    protected $fillable
        = [
            'order_status_id', 'order_status_name_vi',
            'order_status_name_en', 'is_deleted'
        ];

    public function option()
    {
        $select = $this->select($this->fillable)
            ->where('is_deleted', 0)
            ->get();
        return $select;
    }
}
