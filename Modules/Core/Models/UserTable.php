<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class UserTable extends Model
{
    use ListTableTrait;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'email', 'password', 'remember_token', 'full_name', 'is_actived', 'updated_at', 'created_at'
    ];
    protected $hidden = [ 'password', 'remember_token', ];

    /**
     * Lấy danh sách user có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    protected function getListCore(array $filters = [])
    {
        $result = $this->select($this->fillable)->orderBy('updated_at', 'desc');

        return $result;
    }

    /**
     * Thêm tài khoản admin
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        $oUser = $this->create($data);
        return $oUser->id;
    }

    /**
     * Đánh dấu xóa tài khoản admin
     *
     * @param int $id
     * @return mixed
     */
    public function remove($id)
    {
        return $this->where($this->primaryKey, $id)->update(['is_deleted' => 1]);
    }

    /**
     * Lấy thông tin chi tiết
     *
     * @param int $id
     * @return mixed
     */
    public function getDetail($id)
    {
        return $this->where($this->primaryKey, $id)->first();
    }

    /**
     * Chỉnh sửa thông tin tài khoản admin
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function edit(array $data, $id)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }

    /**
     * Lấy danh sách quyền của tài khoản theo id
     *
     * @param int $admin_id
     * @return array
     */
    public function getListActionById($admin_id)
    {
        $result = $this->join('admin_has_group as adhsgr', 'adhsgr.admin_id', '=', $this->table.'.id')
            ->join('admin_group as adgr', 'adgr.group_id', '=', 'adhsgr.group_id')
            ->join('admin_group_action as adgrac', 'adgrac.group_id', '=', 'adgr.group_id')
            ->join('admin_action as adac', 'adac.action_id', '=', 'adgrac.action_id')
            ->where($this->table.'.is_deleted', 0)
            ->where($this->table.'.id', $admin_id)
            ->select('adac.route')
            ->get();

        return $result;
    }

    /**
     * Lấy danh sách admin không phân trang
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
                    $result->whereNotIn('id', $value);
                } elseif ($column == 'in') {
                    $result->whereIn('id', $value);
                } else {
                    $result->where($column, $value);
                }
            }
        }

        $result->select('id', 'full_name', 'email', 'updated_at');

        return $result->get();
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function changeStatus(array $data, $id)
    {
        return $this->where('id', $id)->update($data);
    }

    /**
     * Lấy danh sách menu theo admin id
     *
     * @param $admin_id
     * @return mixed
     */
    public function getListMenuByAdminId($admin_id)
    {
        $result = $this->join('admin_has_group as adhsgr', 'adhsgr.admin_id', '=', $this->table.'.id')
            ->join('admin_group as adgr', 'adgr.group_id', '=', 'adhsgr.group_id')
            ->join('admin_group_menu as adgrmn', 'adgrmn.group_id', '=', 'adgr.group_id')
            ->join('admin_menu as admn', function ($join) {
                $join->on('admn.menu_id', '=', 'adgrmn.menu_id')
                    ->where('admn.is_actived', 1);
            })
            ->where($this->table.'.id', $admin_id)
            ->distinct()
            ->select(
                'admn.menu_id',
                'admn.menu_name',
                'admn.description',
                'admn.menu_position',
                'admn.menu_route'
            )
            ->orderBy('admn.menu_position', 'ASC')
            ->get();

        return $result;
    }

    public function getUserByEmail($email)
    {
        $select = $this->where('email', $email)
            ->where('is_actived', 1)
            ->where('is_deleted', 0)
            ->first();
        return $select;
    }

    public function getUserToken($token)
    {
        return $this->where('remember_token', $token)->first();
    }
}
