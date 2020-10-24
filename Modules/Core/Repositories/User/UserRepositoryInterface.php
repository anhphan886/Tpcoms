<?php

namespace Modules\Core\Repositories\User;

/**
 * User Repository interface
 *
 * @author isc-daidp
 * @since Feb 23, 2018
 */
interface UserRepositoryInterface
{
    public function getList(array $filters = []);

    public function remove($id);

    public function store(array $data);

    public function getDetail($id);

    public function edit(array $data, $id);

    /**
     * Lấy danh sách admin không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = []);

    /**
     * Lấy danh sách quyền truy cập người dùng
     *
     * @param int $admin_id
     * @return mixed
     */
    public function getListActionById($admin_id);


    /**
     * Chỉnh sửa trạng thái my store user
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function changeStatus(array $data, $id);

    public function updatePassword(array $data, $id);

    public function getListGroupChildForPopup(array $listChildId);

    /**
     * Lấy danh sách user cho popup
     *
     * @param array $listUserId
     * @return mixed
     */
    public function getListUserForPopup(array $listUserId);

    /**
     * Lấy danh sách menu theo admin id
     *
     * @param int $admin_id
     * @return mixed
     */
    public function getListMenuByAdminId($admin_id);

    public function getUserToken($token);

    public function getUserByEmail($email);

    public function forgetPassword($data);
}
