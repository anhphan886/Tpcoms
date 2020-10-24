<?php

namespace Modules\Core\Repositories\AdminGroup;

interface AdminGroupRepositoryInterface
{
    /**
     * Lấy danh sách nhóm quyền
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = []);

    /**
     * Thêm nhóm quyền
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data);

    /**
     * Lấy danh sách nhóm quyền cho select box
     *
     * @param array $filters
     * @return mixed
     */
    public function getListOption(array $filters = []);

    /**
     * Lấy toàn bộ danh sách không phân trang
     *
     * @param array $filters
     * @return array
     */
    public function getListAll(array $filters = []);

    /**
     * Lấy danh sách nhóm quyền con cho popup chọn nhóm quyền con
     *
     * @param array $listChildId
     * @return mixed
     */
    public function getListGroupChildForPopup(array $listChildId);

    /**
     * Lấy thông tin chi tiết nhóm quyền
     *
     * @param $group_id
     * @return mixed
     */
    public function getDetail($group_id);

    /**
     * Đánh dấu xóa nhóm quyền
     *
     * @param int $group_id
     * @return mixed
     */
    public function remove($group_id);

    /**
     * Lấy danh sách nhóm quyền con
     *
     * @param $group_id
     * @return mixed
     */
    public function getListChild($group_id);

    /**
     * Lấy danh sách nhóm quyền cha
     *
     * @param $group_id
     * @return mixed
     */
    public function getListParent($group_id);

    /**
     * Lấy danh sách user thuộc nhóm quyền
     *
     * @param $group_id
     * @return mixed
     */
    public function getListUser($group_id);

    /**
     * Chỉnh sửa nhóm quyền
     *
     * @param array $data
     * @param $group_id
     * @return mixed
     */
    public function edit(array $data, $group_id);

    public function getListRoleGroupUser($userId);

    /**
     * Lấy danh sách nhóm có quyền trong menu
     *
     * @param int $menu_id
     * @param array $listAction
     * @return mixed
     */
    public function getListGroupInMenu($menu_id, array $listAction);

    /**
     * Lấy danh sách nhóm quyền
     *
     * @param array $listGroupId
     * @param $menu_id
     * @return array
     */
    public function getListGroupAndAction(array $listGroupId, $menu_id);

    /**
     * Phân user vào nhóm quyền
     *
     * @param array $data
     * @return array
     */
    public function addUserInToGroup(array $data);
}
