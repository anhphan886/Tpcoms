<?php

namespace Modules\Core\Repositories\AdminMenuCategory;

interface AdminMenuCategoryRepositoryInterface
{
    /**
     * Lấy danh sách menu category có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = []);

    /**
     * Lấy danh sách menu category có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = []);

    /**
     * Thêm nhóm menu
     *
     * @param array $data
     * @return array
     */
    public function add(array $data);

    /**
     * Lấy thông tin chi tiết
     *
     * @param int $id
     * @return mixed
     */
    public function getDetail($id);

    /**
     * Chỉnh sửa nhóm menu
     *
     * @param array $data
     * @return array
     */
    public function edit(array $data);

    /**
     * Đánh dấu xóa nhóm menu
     *
     * @param int $id
     * @return mixed
     */
    public function remove($id);
}
