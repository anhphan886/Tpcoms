<?php


namespace Modules\Ticket\Models;


use Illuminate\Database\Eloquent\Model;

class NotificationLogTable extends Model
{
    protected $table = 'notification_log';
    protected $primaryKey = 'notification_log_id';

    protected $fillable
        = [
            'notification_log_id', 'notification_id', 'user_id', 'date_created',
            'date_read', 'is_read', 'date_deleted', 'is_deleted', 'created_at',
            'updated_at'
        ];

    /**
     * Thêm nhiều.
     *
     * @param array $data
     */
    public function addInsert(array $data)
    {
        $this->insert($data);
    }

    public function getLog($filter)
    {
        $select = $this->select(
            $this->table . '.notification_log_id',
            $this->table . '.notification_id',
            $this->table . '.user_id',
            $this->table . '.date_created',
            $this->table . '.date_read',
            $this->table . '.is_read',
            $this->table . '.date_deleted',
            $this->table . '.is_deleted',
            $this->table . '.created_at',
            $this->table . '.updated_at',
            'notification.notification_category_id',
            'notification.title',
            'notification.content',
            'notification.object_id'
        )
        ->join('notification', 'notification.notification_id', '=', $this->table . '.notification_id');
        if (isset($filter['user_id']) && isset($filter['is_admin'])) {
            if ($filter['is_admin'] != 1) {
                $select->where($this->table . '.user_id', $filter['user_id']);
            }
        }
        $select->where($this->table . '.is_deleted', 0);
        return $select->orderBy($this->table . '.date_created', 'desc')->get();
    }

    public function edit(array $data, $id)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }
}
