<?php

namespace Modules\Core\Repositories\AdminGroup;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\AdminActionTable;
use Modules\Core\Models\AdminGroupMenuTable;
use Modules\Core\Models\AdminGroupTable;
use Modules\Core\Models\AdminGroupActionTable;
use Modules\Core\Models\AdminHasGroupTable;

class AdminGroupRepository implements AdminGroupRepositoryInterface
{
    /**
     * @var AdminGroupTable
     */
    protected $adminGroup;

    /**
     * @var AdminGroupActionTable
     */
    protected $adminGroupAction;

    /**
     * @var AdminHasGroupTable
     */
    protected $adminHasGroup;

    /**
     * @var AdminActionTable
     */
    protected $adminAction;

    /**
     * @var AdminGroupMenuTable
     */
    protected $adminGroupMenu;

    public function __construct(
        AdminGroupTable $adminGroup,
        AdminGroupActionTable $adminGroupAction,
        AdminHasGroupTable $adminHasGroup,
        AdminActionTable $adminAction,
        AdminGroupMenuTable $adminGroupMenu
    ) {
        $this->adminGroup = $adminGroup;
        $this->adminGroupAction = $adminGroupAction;
        $this->adminHasGroup = $adminHasGroup;
        $this->adminAction = $adminAction;
        $this->adminGroupMenu = $adminGroupMenu;
    }

    /**
     * Lấy danh sách nhóm quyền
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = [])
    {
        if (!isset($filters['sort_admin_group$group_name'])) {
            $filters['sort_admin_group$group_name'] = null;
        }

        if (!isset($filters['sort_admin_group$group_description'])) {
            $filters['sort_admin_group$group_description'] = null;
        }

        if (!isset($filters['keyword_admin_group$group_name'])) {
            $filters['keyword_admin_group$group_name'] = null;
        }

        $check = $filters;
        $check = array_filter($check);

        if (count($check) == 0) {
            $filters['sort_admin_group$group_id'] = 'desc';
        }

        $listAdminGroup = $this->adminGroup->getList($filters);

        return [
            'filter' => $filters,
            'listAdminGroup' => $listAdminGroup
        ];
    }

    /**
     * Thêm nhóm quyền
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        try {
            DB::beginTransaction();
            $dataGroup = [
                'group_name' => strip_tags($data['group_name']),
                'group_description' => strip_tags($data['group_description']),
                'is_actived' => 1,
                'is_deleted' => 0,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $group_id = $this->adminGroup->add($dataGroup);

            $this->addDataAction($data, $group_id);
            $this->addUserGroup($data, $group_id);
            $this->addGroupMenu($data, $group_id);

            DB::commit();

            return [
                'group_id' => $group_id,
                'error' => 0,
                'message' => __('core::admin-group.create_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => 1,
                'message' => __('core::admin-group.create_failed'),
            ];
        }
    }

    /**
     * Chỉnh sửa nhóm quyền
     *
     * @param array $data
     * @param $group_id
     * @return mixed
     */
    public function edit(array $data, $group_id)
    {
        try {
            DB::beginTransaction();
            $dataGroup = [
                'group_name' => strip_tags($data['group_name']),
                'group_description' => strip_tags($data['group_description']),
                'is_actived' => 1,
                'is_deleted' => 0,
                'updated_by' => Auth::id(),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->adminGroup->edit($dataGroup, $group_id);

            $this->removeDataAction($group_id);
            $this->addDataAction($data, $group_id);

            $this->removeGroupMenu($group_id);
            $this->addGroupMenu($data, $group_id);

            DB::commit();

            return [
                'group_id' => $group_id,
                'error' => 0,
                'message' => __('core::admin-group.edit_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'group_id' => $group_id,
                'error' => 1,
                'message' => __('core::admin-group.edit_failed'),
            ];
        }
    }

    /**
     * Phân user vào nhóm quyền
     *
     * @param array $data
     * @return array
     */
    public function addUserInToGroup(array $data)
    {
        try {
            $group_id = $data['group_id'];
            $this->removeUserGroup($group_id);
            $this->addUserGroup($data, $group_id);

            return [
                'group_id' => $group_id,
                'error' => 0,
                'message' => __('core::admin-group.edit_success'),
            ];
        } catch (\Exception $e) {
            return [
                'group_id' => $group_id,
                'error' => 1,
                'message' => __('core::admin-group.edit_failed'),
            ];
        }
    }

    /**
     * @param int $group_id
     */
    public function removeGroupMenu($group_id)
    {
        $this->adminGroupMenu->remove([
            ['group_id', '=', $group_id],
        ]);
    }

    /**
     * Thêm quan hệ nhóm quyền và menu
     *
     * @param array $data
     * @param int $group_id
     * @return void
     */
    public function addGroupMenu(array $data, $group_id)
    {
        $dataGroupMenu = [];
        if (isset($data['menu_id'])) {
            foreach ($data['menu_id'] as $menu_id) {
                $dataGroupMenu[] = [
                    'group_id' => $group_id,
                    'menu_id' => $menu_id,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        $this->adminGroupMenu->addMultipleRecords($dataGroupMenu);
    }

    /**
     * Xóa phân quyền truy cập và menu của group
     *
     * @param $group_id
     * @return void
     */
    private function removeDataAction($group_id)
    {
        $this->adminGroupAction->remove([
            ['group_id', '=', $group_id],
        ]);
    }

    /**
     * Phân quyền truy cập cho group
     *
     * @param array $data
     * @param int $group_id
     * @return void
     */
    private function addDataAction(array $data, $group_id)
    {
        $dataAction = [];
        if (isset($data['action_id'])) {
            foreach ($data['action_id'] as $action_id) {
                $dataAction[] = [
                    'group_id' => $group_id,
                    'action_id' => $action_id,
                    'is_deleted' => 0,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        
        $this->adminGroupAction->addMultipleRecords($dataAction);
    }

    /**
     * Xóa nhóm quyền của tài khoản
     *
     * @param int $group_id
     * @return void
     */
    private function removeUserGroup($group_id)
    {
        $this->adminHasGroup->remove([
            ['group_id', '=', $group_id],
        ]);
    }

    /**
     * Phân nhóm cho tài khoản
     *
     * @param array $data
     * @param int $group_id
     * @return void
     */
    private function addUserGroup(array $data, $group_id)
    {
        $dataUserGroup = [];
        if (isset($data['admin_id'])) {
            foreach ($data['admin_id'] as $admin_id) {
                $dataUserGroup[] = [
                    'admin_id' => $admin_id,
                    'group_id' => $group_id,
                    'is_deleted' => 0,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }

            $this->adminHasGroup->addMultipleRecords($dataUserGroup);
        }
    }

    /**
     * Lấy danh sách action nhóm quyền con
     *
     * @param $group_id
     * @return array
     */
    private function getActionChild($group_id)
    {
        $listGroupChild = $this->adminGroup->getListChild($group_id);
        $listGroupChildId = [];

        if ($listGroupChild->count() > 0) {
            foreach ($listGroupChild as $item) {
                $listGroupChildId[] = $item->group_id;
            }
        }

        $list = $this->adminGroupAction->getListActionByGroup($listGroupChildId);

        $group_action = [];

        if (count($list) > 0) {
            foreach ($list as $item) {
                $group_action[] = $item['action_id'];
            }
        }

        return $group_action;
    }

    /**
     * Lấy danh sách nhóm quyền cho select box
     *
     * @param array $filters
     * @return mixed
     */
    public function getListOption(array $filters = [])
    {
        $result = $this->adminGroup->getListOption($filters);

        return $result->toArray();
    }

    /**
     * Lấy danh sách nhóm quyền con cho popup chọn nhóm quyền con
     *
     * @param array $listChildId
     * @return mixed
     */
    public function getListGroupChildForPopup(array $listChildId)
    {
        $group_id_list = [];

        if (count($listChildId) > 0) {
            if (isset($listChildId['group_id_list'])) {
                if (isset($listChildId['group_id']) && $listChildId['group_id'] > 0) {
                    array_push($listChildId['group_id_list'], $listChildId['group_id']);
                    $listParent = $this->getListParent($listChildId['group_id']);
                    $listParent = $listParent->keyBy('group_id')->keys()->all();
                    $group_id_list = array_merge($listParent, $listChildId['group_id_list']);
                } else {
                    $group_id_list = $listChildId['group_id_list'];
                }
            } else {
                if (isset($listChildId['group_id']) && $listChildId['group_id'] > 0) {
                    $listParent = $this->getListParent($listChildId['group_id']);
                    $listParent = $listParent->keyBy('group_id')->keys()->all();
                    $group_id_list[] = $listChildId['group_id'];
                    $group_id_list = array_merge($listParent, $group_id_list);
                }
            }

            $listChild = $this->getListAll(['notin' => $group_id_list]);
        } else {
            $listChild = $this->getListAll();
        }

        return $listChild;
    }

    /**
     * Lấy toàn bộ danh sách không phân trang
     *
     * @param array $filters
     * @return array
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->adminGroup->getListAll($filters);

        return $result->toArray();
    }

    /**
     * Lấy thông tin chi tiết nhóm quyền
     *
     * @param $group_id
     * @return mixed
     */
    public function getDetail($group_id)
    {
        return $this->adminGroup->getDetail($group_id);
    }

    /**
     * Đánh dấu xóa nhóm quyền
     *
     * @param int $group_id
     * @return mixed
     */
    public function remove($group_id)
    {
        return $this->adminGroup->remove($group_id);
    }

    /**
     * Lấy danh sách nhóm quyền con
     *
     * @param $group_id
     * @return mixed
     */
    public function getListChild($group_id)
    {
        return $this->adminGroup->getListChild($group_id);
    }

    /**
     * Lấy danh sách nhóm quyền cha
     *
     * @param $group_id
     * @return mixed
     */
    public function getListParent($group_id)
    {
        return $this->adminGroup->getListParent($group_id);
    }

    /**
     * Lấy danh sách user thuộc nhóm quyền
     *
     * @param $group_id
     * @return mixed
     */
    public function getListUser($group_id)
    {
        return $this->adminGroup->getListUser($group_id)->toArray();
    }

    /**
     * Lấy danh sách nhóm quyền
     *
     * @param array $listGroupId
     * @param $menu_id
     * @return array
     */
    public function getListGroupAndAction(array $listGroupId, $menu_id)
    {
        $listGroup = $this->getListAll(['in' => $listGroupId]);
        $listActionMenu = $this->adminAction->getListGroupHasAction($listGroupId, $menu_id)->toArray();
        $result = [];

        if (count($listGroup) > 0) {
            foreach ($listGroup as $key => $item) {
                $action['action'] = [];
                $listAction = [];
                if (count($listActionMenu) > 0) {
                    foreach ($listActionMenu as $value) {
                        if ($item['group_id'] == $value['group_id']) {
                            $listAction[] = $value['action_id'];
                        }
                    }
                    $action['action'] = $listAction;
                }
                $item = array_merge($item, $action);
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * Lấy danh sách nhóm có quyền trong menu
     *
     * @param int $menu_id
     * @param array $listAction
     * @return mixed
     */
    public function getListGroupInMenu($menu_id, array $listAction)
    {
        $listGroup = $this->adminGroup->getListGroupInMenu($menu_id)->toArray();
        $listActionId = $this->getActionIdFromAction($listAction);

        $result = [];
        if (count($listGroup) > 0) {
            foreach ($listGroup as $item) {
                $action = $this->getListActionByGroup($item['group_id'], $listActionId);
                $result[] = [
                    'group_id' => $item['group_id'],
                    'group_name' => strip_tags($item['group_name']),
                    'list_action' => $action,
                ];
            }
        }

        return $result;
    }

    /**
     * Lấy danh sách action theo action list và group id
     *
     * @param $group_id
     * @param array $listActionId
     * @return array
     */
    private function getListActionByGroup($group_id, array $listActionId)
    {
        $listActionId = $this->adminGroupAction->getListActionByGroupAndListAction($group_id, $listActionId)
            ->keyBy('action_id')
            ->keys()
            ->all();

        return $listActionId;
    }

    private function getActionIdFromAction(array $listAction)
    {
        $result = [];
        if (count($listAction) > 0) {
            foreach ($listAction as $item) {
                $result[] = $item['action_id'];
            }
        }

        return $result;
    }

    public function getListRoleGroupUser($userId)
    {
        return $this->adminGroup->getListRoleGroupUser($userId);
    }
}
