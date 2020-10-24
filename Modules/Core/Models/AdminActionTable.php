<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class AdminActionTable extends Model
{
    use ListTableTrait;

    protected $table = 'admin_action';
    protected $primaryKey = 'action_id';
    protected $fillable = [
        'action_id',
        'action_group_name_id',
        'action_name',
        'action_name_default',
        'description',
        'route',
        'is_menu',
        'is_actived',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

    /**
     * Lấy danh sách action không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    protected function getListCore(array $filters = [])
    {
        $result = $this->join('admin_action_group_name as adgn', function ($join) {
            $join->on('adgn.action_group_name_id', '=', $this->table.'.action_group_name_id');
        })
            ->where($this->table.'.is_actived', 1)
            ->where($this->table.'.is_deleted', 0)
            ->select(
                $this->table.'.action_id',
                $this->table.'.action_name',
                $this->table.'.action_name_default',
                $this->table.'.description',
                $this->table.'.route as action_route',
                $this->table.'.action_group_name_id',
                $this->table.'.is_menu',
                'adgn.action_group_name'
            );

        return $result->orderBy($this->table.'.updated_at', 'desc');
    }

    /**
     * Lấy toàn bộ danh sách quyền không phân trang
     *
     * @param array $filters
     * @return AdminActionTable
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->leftJoin('admin_action_group_name as adgn', function ($join) {
            $join->on('adgn.action_group_name_id', '=', $this->table.'.action_group_name_id');
        })
            ->where($this->table.'.is_actived', 1)
            ->where($this->table.'.is_deleted', 0);

        if (count($filters) > 0) {
            foreach ($filters as $column => $value) {
                if ($column == 'notin') {
                    $result->whereNotIn('action_id', $value);
                } elseif ($column == 'in') {
                    $result->whereIn('action_id', $value);
                } elseif (strpos($column, 'sort_') !== false) {
                    $result->orderBy(
                        str_replace('$', '.', str_replace('sort_', '', $column)),
                        $value
                    );
                } else {
                    $result->where($column, $value);
                }
            }
        }

        $result->select(
            $this->table.'.action_id',
            $this->table.'.action_name',
            $this->table.'.action_name_default',
            $this->table.'.description',
            $this->table.'.route as action_route',
            $this->table.'.action_group_name_id',
            $this->table.'.is_menu',
            'adgn.action_group_name'
        );

        return $result->get();
    }

    /**
     * Lấy danh sách toàn bộ các route được phân quyền
     *
     * @return array
     */
    public function getAllRoute()
    {
        $list = $result = $this->join('admin_action_group_name as adgn', function ($join) {
            $join->on('adgn.action_group_name_id', '=', $this->table.'.action_group_name_id');
        })
            ->where($this->table.'.is_actived', 1)
            ->where($this->table.'.is_deleted', 0)
            ->select(
                $this->table.'.action_id',
                $this->table.'.action_name',
                $this->table.'.action_name_default',
                $this->table.'.description',
                $this->table.'.route as action_route',
                $this->table.'.action_group_name_id',
                $this->table.'.is_menu',
                'adgn.action_group_name'
            )
            ->orderBy($this->table.'.action_group_name_id', 'ASC')
            ->get()
            ->toArray();

        $result = [];
        foreach ($list as $item) {
            $result[] = $item['action_route'];
        }

        return $result;
    }

    /**
     * Lấy danh sách quyền theo menu
     *
     * @param int $action_group_name_id
     * @return mixed
     */
    public function getActionByMenu($action_group_name_id)
    {
        $result = $this->where('action_group_name_id', $action_group_name_id)
            ->where('is_deleted', 0)
            ->where('is_actived', 1)
            ->get();

        return $result;
    }

    /**
     * Lấy danh sách nhóm có quyền theo action_group_name_id
     *
     * @param $listGroupId
     * @param $action_group_name_id
     * @return mixed
     */
    public function getListGroupHasAction($listGroupId, $action_group_name_id)
    {
        $result = $this->join('admin_action_group_name as adgn', function ($join) use ($action_group_name_id) {
            $join->on('adgn.action_group_name_id', '=', $this->table.'.action_group_name_id')
                ->where($this->table.'.action_group_name_id', $action_group_name_id);
        })
            ->join('admin_group_action as adgrac', function ($join) {
                $join->on('adgrac.action_id', '=', $this->table.'.action_id');
            })
            ->join('admin_group as adgr', function ($join) use ($listGroupId) {
                $join->on('adgr.group_id', '=', 'adgrac.group_id')
                    ->whereIn('adgrac.group_id', $listGroupId);
            })
            ->select(
                'adgr.group_id',
                'adgn.action_group_name_id',
                $this->table.'.action_id',
                $this->table.'.action_name'
            )
            ->get();

        return $result;
    }

    /**
     * Lấy thông tin chi tiết quyền truy cập
     *
     * @param int $action_id
     * @return mixed
     */
    public function getDetail($action_id)
    {
        $result = $this->join(
            'admin_action_group_name as adgn',
            'adgn.action_group_name_id',
            '=',
            $this->table.'.action_group_name_id'
        )
            ->where($this->table.'.'.$this->primaryKey, $action_id)
            ->where($this->table.'.is_actived', 1)
            ->where($this->table.'.is_deleted', 0)
            ->select(
                $this->table.'.action_id',
                $this->table.'.action_group_name_id',
                $this->table.'.action_name',
                $this->table.'.action_name_default',
                $this->table.'.description',
                $this->table.'.route',
                $this->table.'.is_menu',
                $this->table.'.is_actived',
                $this->table.'.is_deleted',
                $this->table.'.created_at',
                $this->table.'.updated_at',
                'adgn.action_group_name'
            )
            ->first();

        return $result;
    }

    /**
     * Cập nhật thông tin quyền truy cập
     *
     * @param array $data
     * @param $action_id
     * @return mixed
     */
    public function edit(array $data, $action_id)
    {
        $result = $this->where($this->primaryKey, $action_id)
            ->update($data);

        return $result;
    }

    /**
     * Lấy danh sách quyền cho select box
     *
     * @return mixed
     */
    public function getListOption()
    {
        $result = $this->where('is_menu', 1)
            ->select('action_id', 'action_name', 'route as action_route')
            ->orderBy('action_group_name_id', 'ASC')
            ->get();

        return $result;
    }

    /**
     * Lấy tên chức năng theo route
     *
     * @param string $routeName
     * @return mixed
     */
    public function getNameByRoute($routeName)
    {
        $result = $this->where('route', $routeName)
            ->where('is_deleted', 0)
            ->select('action_name')
            ->first();

        return $result;
    }
}
