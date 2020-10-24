<?php


namespace Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class NotificationCategoryTable extends Model
{
    protected $table = 'notification_categories';
    protected $primaryKey = 'notification_category_id';

    protected $fillable
        = [
            'notification_category_id', 'notification_category_name',
            'is_deleted', 'created_at', 'updated_at'
        ];
}
