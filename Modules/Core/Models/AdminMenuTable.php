<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class AdminMenuTable extends Model
{
    use ListTableTrait;

    protected $table = 'admin_menu';
    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'menu_id',
        'menu_name',
        'menu_route',
        'description',
        'menu_icon',
        'menu_image',
        'menu_position',
        'menu_category_id',
        'is_actived',
        'date_created',
        'date_modified'
    ];
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';

    protected function getListCore(array $filter = [])
    {
        $result = $this->leftJoin('admin_menu_category as admncat', function ($join) {
            $join->on('admncat.menu_category_id', '=', $this->table.'.menu_category_id');
        })
            ->where($this->table.'.is_actived', 1)
            ->select(
                $this->table.'.menu_id',
                $this->table.'.menu_name',
                $this->table.'.menu_route',
                $this->table.'.description',
                $this->table.'.menu_icon',
                $this->table.'.menu_image',
                $this->table.'.menu_position',
                $this->table.'.menu_category_id',
                'admncat.menu_category_name'
            );

        return $result->orderBy('date_modified', 'desc');
    }

    /**
     * Lấy danh sách menu không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->leftJoin('admin_menu_category as admncat', function ($join) {
            $join->on('admncat.menu_category_id', '=', $this->table.'.menu_category_id');
        })
        ->where($this->table.'.is_actived', 1);

        if ($filters != []) {
            foreach ($filters as $column => $value) {
                if ($column == 'notin') {
                    $result->whereNotIn('menu_id', $value);
                } elseif ($column == 'in') {
                    $result->whereIn('menu_id', $value);
                } else {
                    $result->where($this->table.'.'.$column, $value);
                }
            }
        }

        $result->select(
            $this->table.'.menu_id',
            $this->table.'.menu_name',
            $this->table.'.menu_route',
            $this->table.'.description',
            $this->table.'.menu_icon',
            $this->table.'.menu_image',
            $this->table.'.menu_position',
            $this->table.'.menu_category_id',
            'admncat.menu_category_name'
        )
        ->orderBy($this->table.'.menu_position', 'ASC');

        return $result->get();
    }

    /**
     * Lấy thông tin chi tiết menu
     *
     * @param int $id
     * @return mixed
     */
    public function getDetail($id)
    {
        $result = $this->where($this->primaryKey, $id)
            ->where('is_actived', 1)
            ->select(
                'menu_id',
                'menu_name',
                'menu_route',
                'menu_position',
                'menu_icon',
                'menu_category_id',
                'description'
            )
            ->first();

        return $result;
    }

    /**
     * Lấy danh sách menu cho select box
     *
     * @return array
     */
    public function getOption()
    {
        $select = $this->where('is_actived', 1)->get();
        $array = [];
        foreach ($select as $item) {
            $array[$item['menu_id']] = $item['menu_name'];
        }
        return $array;
    }

    /**
     * Thêm menu
     *
     * @param array $data
     * @return int
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    /**
     * Cập nhật thông tin quyền menu
     *
     * @param array $data
     * @param array|int $condition
     * @return mixed
     */
    public function edit(array $data, $condition)
    {
        if (is_array($condition)) {
            return $this->where($condition)->update($data);
        }

        return $this->where($this->primaryKey, $condition)->update($data);
    }

    /**
     * Đóng menu
     *
     * @param $menu_id
     * @return mixed
     */
    public function remove($menu_id)
    {
        return $this->where($this->primaryKey, $menu_id)->update(['is_actived' => 0]);
    }

    /**
     * Lấy menu id theo route
     *
     * @param string $menu_route
     * @return mixed
     */
    public function getMenuIdByRoute($menu_route)
    {
        return $this->where('menu_route', $menu_route)->where('is_actived', 1)->get();
    }
}
