<?php

namespace Modules\Core\Repositories\AdminGroupAction;

interface AdminGroupActionRepositoryInterface
{
    /**
     * Lấy danh sách phân quyền cho nhóm quyền theo group_id
     *
     * @param int $group_id
     * @return array
     */
    public function getListActionByGroup($group_id);

    /**
     * Cập nhật quyền cho nhóm quyền
     *
     * @param array $data
     * @return array
     */
    public function edit(array $data);

    /**
     * Lấy danh sách nhóm quyền theo action
     *
     * @param $action_id
     * @return array
     */
    public function getListGroupByAction($action_id);
}
