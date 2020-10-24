<?php

namespace Modules\Core\Repositories\AdminAction;

use Modules\Core\Models\AdminActionTable;

class AdminActionRepository implements AdminActionRepositoryInterface
{
    /**
     * @var AdminActionTable
     */
    protected $adminAction;

    public function __construct(AdminActionTable $adminAction)
    {
        $this->adminAction = $adminAction;
    }

    /**
     * Lấy danh sách action
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = [])
    {
        if (!isset($filters['sort_admin_action$action_name'])) {
            $filters['sort_admin_action$action_name'] = null;
        }

        if (!isset($filters['sort_admin_action$description'])) {
            $filters['sort_admin_action$description'] = null;
        }

        if (!isset($filters['sort_admin_action$action_name_default'])) {
            $filters['sort_admin_action$action_name_default'] = null;
        }

        if (!isset($filters['sort_adgn$action_group_name'])) {
            $filters['sort_adgn$action_group_name'] = null;
        }

        if (!isset($filters['keyword_admin_action$action_name'])) {
            $filters['keyword_admin_action$action_name'] = null;
        }

        if (!isset($filters['keyword_admin_action$description'])) {
            $filters['keyword_admin_action$description'] = null;
        }

        if (!isset($filters['keyword_admin_action$action_name_default'])) {
            $filters['keyword_admin_action$action_name_default'] = null;
        }

        if (!isset($filters['keyword_adgn$action_group_name'])) {
            $filters['keyword_adgn$action_group_name'] = null;
        }

        $check = $filters;
        $check = array_filter($check);

        if (count($check) == 0) {
            $filters['sort_admin_action$action_id'] = 'desc';
        }

        $listAdminAction = $this->adminAction->getList($filters);

        return [
            'filter' => $filters,
            'listAdminAction' => $listAdminAction
        ];
    }

    /**
     * Lấy toàn bộ danh sách route của action để phân quyền
     *
     * @return array
     */
    public function getAllRoute()
    {
        $result = $this->adminAction->getAllRoute();

        return $result;
    }

    /**
     * Lấy toàn bộ danh sách quyền không phân trang
     *
     * @param array $filters
     * @return array
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->adminAction->getListAll($filters)->toArray();

        return $result;
    }

    /**
     * Xử lý danh sách quyền cho việ hiển thị danh sách
     *
     * @return array
     */
    public function handleListAction()
    {
        $list = $this->getListAll();
        $result = [];
        if (count($list) > 0) {
            foreach ($list as $item) {
                $result[$item['action_group_name']][] = $item;
            }
        }

        return $result;
    }

    /**
     * Lấy danh sách quyền cho popup
     *
     * @param array $listActionId
     * @return mixed
     */
    public function getListActionForPopup(array $listActionId)
    {
        $result = [];
        if (count($listActionId) > 0 && isset($listActionId['action_id_list'])) {
            $data = $this->adminAction->getListAll([
                'notin' => $listActionId['action_id_list'],
                'sort_adgn$action_group_name' => 'asc'
            ])->toArray();
        } else {
            $data = $this->adminAction->getListAll()->toArray();
        }

        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $result[$value['action_group_name_id']][] = $value;
            }
        }

        return $result;
    }

    /**
     * Lấy thông tin chi tiết quyền truy cập
     *
     * @param int $action_id
     * @return array
     */
    public function getDetail($action_id)
    {
        $result = $this->adminAction->getDetail($action_id);

        return $result;
    }

    /**
     * Lấy danh sách quyền cho select box
     *
     * @return array
     */
    public function getListOption()
    {
        $result = $this->adminAction->getListOption()->toArray();

        return $result;
    }

    /**
     * Lấy tên chức năng theo route
     *
     * @param string $routeName
     * @return string
     */
    public function getNameByRoute($routeName)
    {
        $data = $this->adminAction->getNameByRoute($routeName);
        $result = '';

        if ($data) {
            $result = $data->action_name;
        }

        return $result;
    }
}
