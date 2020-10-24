<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class AdminHasGroupTable extends Model
{
    protected $table = 'admin_has_group';
    protected $primaryKey = 'admin_has_group_id';
    protected $fillable = [
        'admin_has_group_id',
        'admin_id',
        'group_id',
        'created_by',
        'updated_by',
        'created_by',
        'updated_by',
    ];

    /**
     * Phân nhóm quyền nhiều user
     *
     * @param array $data
     * @return void
     */
    public function addMultipleRecords(array $data)
    {
        $this->insert($data);
    }

    /**
     * Xóa nhóm quyền user
     *
     * @param array|int $condition
     * @return void
     */
    public function remove($condition)
    {
        if (is_array($condition)) {
            return $this->where($condition)->delete();
        } else {
            return $this->where($this->primaryKey, $condition)->delete();
        }
    }

    public function removeByUser($userId)
    {
        return $this->where('admin_id', $userId)->delete();
    }
}
