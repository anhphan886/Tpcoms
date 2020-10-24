<?php

namespace Modules\Core\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class AdminGroupMenuTable extends Model
{
    protected $table = 'admin_group_menu';
    protected $primaryKey = 'group_menu_id';
    protected $fillable = [
        'group_menu_id',
        'group_id',
        'menu_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    /**
     * Lấy danh sách nhóm quyền menu
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->join('admin_group as adgr', function ($join) {
            $join->on('adgr.group_id', '=', $this->table.'.group_id')
                ->where('adgr.is_deleted', 0)
                ->where('adgr.is_actived', 1);
        })
            ->join('admin_menu as admn', function ($join) {
                $join->on('admn.menu_id', '=', $this->table.'.menu_id')
                    ->where('admn.is_actived', 1);
            });

        if (count($filters) > 0) {
            foreach ($filters as $column => $value) {
                $result->where($this->table.'.'.$column, $value);
            }
        }

        $result->select(
            'adgr.group_name',
            'adgr.group_description',
            'admn.menu_name',
            'admn.menu_position',
            $this->table.'.group_id',
            $this->table.'.menu_id'
        )->orderBy($this->table.'.updated_at', 'desc');

        return $result->get();
    }

    /**
     * Thêm nhiều quan hệ nhóm quyền menu
     *
     * @param array $data
     */
    public function addMultipleRecords(array $data)
    {
        $this->insert($data);
    }

    /**
     * Xóa quan hệ nhóm quyền và menu
     *
     * @param int|array $condition
     * @return mixed
     */
    public function remove($condition)
    {
        if (is_array($condition)) {
            return $this->where($condition)->delete();
        } else {
            return $this->where($this->primaryKey, $condition)->delete();
        }
    }
}
