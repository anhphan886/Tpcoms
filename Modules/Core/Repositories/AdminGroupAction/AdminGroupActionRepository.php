<?php

namespace Modules\Core\Repositories\AdminGroupAction;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\AdminActionTable;
use Modules\Core\Models\AdminGroupActionTable;

class AdminGroupActionRepository implements AdminGroupActionRepositoryInterface
{
    /**
     * @var AdminGroupActionTable
     */
    protected $adminGroupAction;

    protected $adminAction;

    public function __construct(
        AdminGroupActionTable $adminGroupAction,
        AdminActionTable $adminAction
    ) {
        $this->adminGroupAction = $adminGroupAction;
        $this->adminAction = $adminAction;
    }

    /**
     * Lấy danh sách phân quyền cho nhóm quyền theo group_id
     *
     * @param int $group_id
     * @return array
     */
    public function getListActionByGroup($group_id)
    {
        $list = $this->adminGroupAction->getListActionByGroup($group_id)->toArray();

        return $list;
    }

    /**
     * Cập nhật quyền cho nhóm quyền
     *
     * @param array $data
     * @return array
     */
    public function edit(array $data)
    {
        try {
            DB::beginTransaction();
            $action_id = $data['action_id'];

            $dataAction = [
                'action_name' => strip_tags($data['action_name']),
                'description' => strip_tags($data['description'])
            ];

            $this->adminAction->edit($dataAction, $action_id);

            $this->removeGroupAction($action_id);
            $this->addGroupAction($data, $action_id);

            DB::commit();

            return [
                'error' => 0,
                'message' => __('core::admin-action.edit.UPDATED')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => 1,
                'message' => __('core::admin-action.edit.UPDATE_FAILED')
            ];
        }
    }

    /**
     * Thêm phân quyền nhóm
     *
     * @param array $data
     * @param int $action_id
     * @return void
     */
    private function addGroupAction(array $data, $action_id)
    {
        $dataAction = [];
        if (isset($data['group_id']) && count($data['group_id']) > 0) {
            foreach ($data['group_id'] as $group_id) {
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
     * Xóa phân quyền nhóm
     *
     * @param int $action_id
     * @return void
     */
    private function removeGroupAction($action_id)
    {
        $this->adminGroupAction->remove([
            ['action_id', '=', $action_id]
        ]);
    }

    /**
     * Lấy danh sách nhóm quyền theo action
     *
     * @param $action_id
     * @return array
     */
    public function getListGroupByAction($action_id)
    {
        return $this->adminGroupAction->getListGroupByAction($action_id)->toArray();
    }
}
