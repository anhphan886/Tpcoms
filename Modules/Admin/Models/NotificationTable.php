<?php


namespace Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class NotificationTable extends Model
{
    protected $table = 'notification';
    protected $primaryKey = 'notification_id';

    protected $fillable
        = [
            'notification_id', 'notification_category_id', 'object_id',
            'content', 'created_by', 'is_deleted', 'created_at',
            'updated_at', 'title', 'object_code', 'object_datetime'
        ];

    /**
     * Lấy dòng cuối cùng của bảng.
     *
     * @return mixed
     */
    public function getLastRecord()
    {
        $select = $this->orderBy('created_at', 'desc')->first();
        return $select;
    }

    /**
     * Thêm nhiều.
     *
     * @param array $data
     */
    public function addInsert(array $data)
    {
        $this->insert($data);
    }

    /**
     * Danh sách noti
     * @return mixed
     */
    public function getNotification($category)
    {
        $select = $this->select(
            $this->table . '.*',
            'notification_log.notification_log_id'
        )
            ->leftJoin(
            'notification_log',
            'notification_log.notification_id',
            '=',
            $this->table . '.' . $this->primaryKey
        )
            ->whereNull('notification_log.notification_log_id')
            ->where($this->table . '.notification_category_id', $category);
        return $select->get();
    }

    public function getNotificationByCategory($object_id, $category)
    {
        $select = $this->select(
            $this->table . '.*'
        )
            ->where('object_id', $object_id)
            ->where($this->table . '.notification_category_id', $category);;
        return $select->first();
    }
}
