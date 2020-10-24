<?php

namespace Modules\Core\Repositories\AdminAction;

interface AdminActionRepositoryInterface
{
    /**
     * Lấy danh sách action phân trang
     *
     * @return mixed
     */
    public function getList();

    /**
     * Lấy toàn bộ danh sách route của action để phân quyền
     *
     * @return array
     */
    public function getAllRoute();

    /**
     * Lấy danh sác
     *
     * @param array $filters
     * @return array
     */
    public function getListAll(array $filters = []);

    /**
     * Xử lý danh sách quyền cho việ hiển thị danh sách
     *
     * @return array
     */
    public function handleListAction();

    /**
     * Lấy danh sách quyền cho popup
     *
     * @param array $listActionId
     * @return mixed
     */
    public function getListActionForPopup(array $listActionId);

    /**
     * Lấy thông tin chi tiết quyền truy cập
     *
     * @param int $action_id
     * @return array
     */
    public function getDetail($action_id);

    /**
     * Lấy danh sách quyền cho select box
     *
     * @return array
     */
    public function getListOption();

    /**
     * Lấy tên chức năng theo route
     *
     * @param string $routeName
     * @return string
     */
    public function getNameByRoute($routeName);
}
