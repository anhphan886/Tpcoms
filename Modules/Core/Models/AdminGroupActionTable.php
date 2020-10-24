<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class AdminGroupActionTable extends Model
{
    protected $table = 'admin_group_action';
    protected $primaryKey = 'group_action_id';
    protected $fillable = [
        'group_id',
        'action_id',
        'is_deleted',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    /**
     * Lấy danh sách phân quyền cho nhóm quyền theo group_id
     *
     * @param array|int $group_id
     * @return mixed
     */
    public function getListActionByGroup($group_id)
    {
        $result = $this->join('admin_group as adgr', 'adgr.group_id', '=', $this->table.'.group_id')
            ->join('admin_action as adac', function ($join) {
                $join->on('adac.action_id', '=', $this->table.'.action_id')
                    ->where('adac.is_actived', 1)
                    ->where('adac.is_deleted', 0);
            })
            ->leftJoin('admin_action_group_name as adgn', function ($join) {
                $join->on('adgn.action_group_name_id', '=', 'adac.action_group_name_id');
            })
            ->where($this->table.'.is_deleted', 0);

        if (is_array($group_id)) {
            $result->whereIn($this->table.'.group_id', $group_id);
        } else {
            $result->where($this->table.'.group_id', $group_id);
        }

        $result->select(
            $this->table.'.group_id',
            $this->table.'.action_id',
            'adac.action_name',
            'adac.route as action_route',
            'adac.action_group_name_id',
            'adgr.group_name',
            'adgn.action_group_name'
        )->orderBy($this->table.'.updated_at', 'desc');

        return $result->get();
    }

    /**
     * Thêm nhiều phân quyền
     *
     * @param array $data
     * @return void
     */
    public function addMultipleRecords(array $data)
    {
        $this->insert($data);
    }

    /**
     * Xóa phân quyền
     *
     * @param array|int $condition
     * @return mixed
     */
    public function remove($condition)
    {
        if (is_array($condition)) {
            if (isset($condition['action_in'])) {
                return $this->whereIn('action_id', $condition['action_in'])
                    ->delete();
            } else {
                return $this->where($condition)->delete();
            }
        } else {
            return $this->where($this->primaryKey, $condition)->delete();
        }
    }

    /**
     * Lấy danh sách action theo action list và group id
     *
     * @param $group_id
     * @param array $listActionId
     * @return mixed
     */
    public function getListActionByGroupAndListAction($group_id, array $listActionId)
    {
        $result = $this->where($this->table.'.group_id', $group_id)
            ->whereIn($this->table.'.action_id', $listActionId)
            ->select($this->table.'.action_id')
            ->get();

        return $result;
    }

    /**
     * @param $action_id
     * @return mixed
     */
    public function getListGroupByAction($action_id)
    {
        $result = $this->join('admin_group as adgr', 'adgr.group_id', '=', $this->table.'.group_id')
            ->where($this->table.'.action_id', $action_id)
            ->select(
                $this->table.'.action_id',
                $this->table.'.group_id',
                'adgr.group_name',
                'adgr.group_description'
            )
            ->get();

        return $result;
    }
}
