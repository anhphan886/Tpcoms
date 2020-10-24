<?php

namespace Modules\Core\Repositories\AdminMenu;

interface AdminMenuRepositoryInterface
{
    /**
     * Lấy danh sách menu có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = []);
    /**
     * Lấy danh sách menu không phân trang
     *
     * @param array $filters
     * @return array
     */
    public function getListAll(array $filters = []);

    /**
     * Lấy thông tin chi tiết menu
     *
     * @param int $id
     * @return mixed
     */
    public function getDetail($id);

    /**
     * Lấy danh sách menu cho select box
     *
     * @return array
     */
    public function getOption();

    /**
     * Thêm mới menu
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data);

    /**
     * Cập nhật thông tin quyền menu
     *
     * @param array $data
     * @return mixed
     */
    public function edit(array $data);

    /**
     * Đóng menu
     *
     * @param int $menu_id
     * @return mixed
     */
    public function remove($menu_id);

    /**
     * Lấy danh sách menu cho popup
     *
     * @param array $listMenuId
     * @return mixed
     */
    public function getListMenuForPopup(array $listMenuId);

    /**
     * Lấy danh sách menu theo nhóm quyền
     *
     * @param $group_id
     * @return array
     */
    public function getListMenuByGroup($group_id);

    /**
     * Lấy menu id theo route
     *
     * @param string $menu_route
     * @return array
     */
    public function getMenuIdByRoute($menu_route);
}
