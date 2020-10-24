<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class AdminMenuCategoryTable extends Model
{
    use ListTableTrait;

    protected $table = 'admin_menu_category';
    protected $primaryKey = 'menu_category_id';
    protected $fillable = [
        'menu_category_id',
        'menu_category_name',
        'menu_category_icon',
        'menu_category_image',
        'menu_category_position',
        'is_actived',
    ];

    /**
     * Lấy danh sách menu category có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    protected function getListCore(array $filters = [])
    {
        $result = $this->where($this->table.'.is_actived', 1)
            ->select(
                $this->table.'.menu_category_id',
                $this->table.'.menu_category_name',
                $this->table.'.menu_category_icon',
                $this->table.'.menu_category_image',
                $this->table.'.menu_category_position'
            );

        return $result;
    }

    /**
     * Lấy danh sách menu category không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->getListCore($filters)->get();
        
        return $result;
    }

    /**
     * Lấy thông tin chi tiết
     *
     * @param int $id
     * @return mixed
     */
    public function getDetail($id)
    {
        $result = $this->getListCore()
            ->where($this->table.'.'.$this->primaryKey, $id)
            ->where($this->table.'.is_actived', 1)
            ->first();

        return $result;
    }

    /**
     * Thêm menu category
     *
     * @param array $data
     * @return int
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    /**
     * Cập nhật menu category
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
     * Đóng menu category
     *
     * @param int $id
     * @return mixed
     */
    public function remove($id)
    {
        return $this->where($this->primaryKey, $id)->update(['is_actived' => 0]);
    }

    /**
     * Menu table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function child()
    {
        return $this->hasMany(
            'Modules\Core\Models\AdminMenuTable',
            'menu_category_id'
        );
    }

    /**
     * Menu Category table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(
            'Modules\Core\Models\AdminMenuCategoryTable',
            'menu_category_id'
        );
    }
}
