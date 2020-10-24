<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class AdminGroupTable extends Model
{
    use ListTableTrait;

    protected $table = 'admin_group';
    protected $primaryKey = 'group_id';
    protected $fillable = [
        'group_id',
        'group_name',
        'group_description',
        'is_actived',
        'is_deleted',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
    public $timestamps = false;

    protected function getListCore()
    {
        $result = $this->where('is_deleted', 0)
            ->select(
                'group_id',
                'group_name',
                'group_description',
                'created_at',
                'updated_at'
            );

        return $result;
    }

    /**
     * Thêm nhóm quyền
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    /**
     * Thêm nhiều nhóm
     *
     * @param array $data
     * @return void
     */
    public function addMultipleRecords(array $data)
    {
        $this->insert($data);
    }

    /**
     * Lấy danh sách nhóm quyền cho select box
     *
     * @param array $filters
     * @return mixed
     */
    public function getListOption(array $filters = [])
    {
        $result = $this->where('is_deleted', 0);

        if ($filters != []) {
            foreach ($filters as $column => $value) {
                $result->where($column, $value);
            }
        }
        $result->select(
            'group_id',
            'group_name'
        );

        return $result->get();
    }

    /**
     * Lấy toàn bộ danh sách không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->where('is_deleted', 0);

        if (count($filters) > 0) {
            foreach ($filters as $column => $value) {
                if ($column == 'notin') {
                    $result->whereNotIn('group_id', $value);
                } elseif ($column == 'in') {
                    $result->whereIn('group_id', $value);
                } else {
                    $result->where($column, $value);
                }
            }
        }

        $result->select(
            'group_id',
            'group_name',
            'group_description',
            'created_at',
            'updated_at'
        );

        return $result->get();
    }

    /**
     * Lấy thông tin chi tiết nhóm quyền
     *
     * @param int $group_id
     * @return mixed
     */
    public function getDetail($group_id)
    {
        $result = $this->where($this->primaryKey, $group_id)
            ->where('is_deleted', 0)
            ->where('is_actived', 1)
            ->select(
                'group_id',
                'group_name',
                'group_description',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at'
            )
            ->first();

        return $result;
    }

    /**
     * Đánh dấu xóa nhóm quyền
     *
     * @param int $group_id
     * @return mixed
     */
    public function remove($group_id)
    {
        return $this->where($this->primaryKey, $group_id)->update(['is_deleted' => 1]);
    }

    /**
     * Lấy danh sách nhóm quyền con
     *
     * @param int $group_id
     * @return mixed
     */
    public function getListChild($group_id)
    {
        $result = $this->join('admin_group_map as adgrmp', 'adgrmp.group_parent_id', '=', $this->table.'.group_id')
            ->join('admin_group as adgrchd', 'adgrchd.group_id', '=', 'adgrmp.group_child_id')
            ->where($this->table.'.group_id', $group_id)
            ->where($this->table.'.is_deleted', 0)
            ->where($this->table.'.is_actived', 1)
            ->select(
                'adgrchd.group_id',
                'adgrchd.group_name',
                'adgrchd.group_description',
                'adgrchd.created_by',
                'adgrchd.updated_by',
                'adgrchd.created_at',
                'adgrchd.updated_at'
            )
            ->get();

        return $result;
    }

    /**
     * Lấy danh sách nhóm quyền con
     *
     * @param int $group_id
     * @return mixed
     */
    public function getListParent($group_id)
    {
        $result = $this->join('admin_group_map as adgrmp', 'adgrmp.group_child_id', '=', $this->table.'.group_id')
            ->join('admin_group as adgrpr', 'adgrpr.group_id', '=', 'adgrmp.group_parent_id')
            ->where($this->table.'.group_id', $group_id)
            ->where($this->table.'.is_deleted', 0)
            ->where($this->table.'.is_actived', 1)
            ->select(
                'adgrpr.group_id',
                'adgrpr.group_name',
                'adgrpr.group_description',
                'adgrpr.created_by',
                'adgrpr.updated_by',
                'adgrpr.created_at',
                'adgrpr.updated_at'
            )
            ->get();

        return $result;
    }

    /**
     * Lấy danh sách user thuộc nhóm quyền
     *
     * @param int $group_id
     * @return mixed
     */
    public function getListUser($group_id)
    {
        $result = $this->join('admin_has_group as adhsgr', 'adhsgr.group_id', '=', $this->table.'.group_id')
            ->join('admin as ad', function ($join) {
                $join->on('ad.id', '=', 'adhsgr.admin_id')
                    ->where('ad.is_actived', 1)
                    ->where('ad.is_deleted', 0);
            })
            ->where($this->table.'.group_id', $group_id)
            ->where($this->table.'.is_deleted', 0)
            ->where($this->table.'.is_actived', 1)
            ->select(
                'ad.id',
                'ad.full_name',
                'ad.email'
            )
            ->get();

        return $result;
    }

    /**
     * Chỉnh sửa nhóm quyền
     *
     * @param array $data
     * @param int $group_id
     * @return mixed
     */
    public function edit(array $data, $group_id)
    {
        $result = $this->where($this->primaryKey, $group_id)->update($data);

        return $result;
    }

    /**
     * Lấy danh sách nhóm quyền thuộc user
     *
     * @param int $userId
     * @return mixed
     */
    public function getListRoleGroupUser($userId)
    {
        $result = $this->join('admin_has_group as adhsgr', 'adhsgr.group_id', '=', $this->table.'.group_id')
            ->join('admin as ad', function ($join) {
                $join->on('ad.id', '=', 'adhsgr.admin_id')
                    ->where('ad.is_deleted', 0);
            })
            ->where('ad.id', $userId)
            ->where($this->table.'.is_deleted', 0)
            ->where($this->table.'.is_actived', 1)
            ->select(
                'adhsgr.group_id',
                $this->table.'.group_name'
            )
            ->get();

        return $result;
    }

    /**
     * Lấy danh sách nhóm có quyền trong menu
     *
     * @param int $menu_id
     * @return mixed
     */
    public function getListGroupInMenu($menu_id)
    {
        $result = $this->join('admin_group_action as adgrac', 'adgrac.group_id', '=', $this->table.'.group_id')
            ->join('admin_action as adac', function ($join) use ($menu_id) {
                $join->on('adac.action_id', '=', 'adgrac.action_id')
                    ->where('adac.menu_id', $menu_id);
            })
            ->groupBy($this->table.'.group_id', $this->table.'.group_name')
            ->select($this->table.'.group_id', $this->table.'.group_name')
            ->get();

        return $result;
    }
}
