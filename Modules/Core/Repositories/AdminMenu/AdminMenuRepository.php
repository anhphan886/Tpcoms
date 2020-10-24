<?php

namespace Modules\Core\Repositories\AdminMenu;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\AdminGroupMenuTable;
use Modules\Core\Models\AdminMenuTable;

class AdminMenuRepository implements AdminMenuRepositoryInterface
{
    /**
     * @var AdminMenuTable
     */
    protected $adminMenu;

    /**
     * @var AdminGroupMenuTable
     */
    protected $adminGroupMenu;

    public function __construct(
        AdminMenuTable $adminMenu,
        AdminGroupMenuTable $adminGroupMenu
    ) {
        $this->adminMenu = $adminMenu;
        $this->adminGroupMenu = $adminGroupMenu;
    }

    /**
     * Lấy danh sách menu có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = [])
    {
        if (!isset($filters['sort_admin_menu$menu_name'])) {
            $filters['sort_admin_menu$menu_name'] = null;
        }

        if (!isset($filters['sort_admncat$menu_category_name'])) {
            $filters['sort_admncat$menu_category_name'] = null;
        }

        if (!isset($filters['sort_admin_menu$menu_position'])) {
            $filters['sort_admin_menu$menu_position'] = null;
        }

        if (!isset($filters['keyword_admin_menu$menu_name'])) {
            $filters['keyword_admin_menu$menu_name'] = null;
        }

        if (!isset($filters['keyword_admncat$menu_category_name'])) {
            $filters['keyword_admncat$menu_category_name'] = null;
        }

        $check = $filters;
        $check = array_filter($check);

        if (count($check) == 0) {
            $filters['sort_admin_menu$menu_id'] = 'desc';
        }

        $listAdminMenu = $this->adminMenu->getList($filters);

        return [
            'filter' => $filters,
            'listAdminMenu' => $listAdminMenu
        ];
    }

    /**
     * Lấy danh sách menu không phân trang
     *
     * @param array $filters
     * @return array
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->adminMenu->getListAll($filters)->toArray();

        return $result;
    }

    /**
     * Lấy thông tin chi tiết menu
     *
     * @param int $id
     * @return mixed
     */
    public function getDetail($id)
    {
        $result = $this->adminMenu->getDetail($id);

        return $result;
    }

    /**
     * Lấy danh sách menu cho select box
     *
     * @return array
     */
    public function getOption()
    {
        $result = $this->adminMenu->getOption();

        return $result;
    }

    /**
     * Thêm mới menu
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        try {
            DB::beginTransaction();
            $dataMenu = [
                'menu_name' => strip_tags($data['menu_name']),
                'menu_route' => strip_tags($data['menu_route']),
                'description' => $data['description'],
                'menu_position' => $data['menu_position'],
                'menu_icon' => '<i class="fa '.$data['menu_icon'].'"></i>',
                'menu_category_id' => $data['menu_category_id'],
            ];
            $menu_id = $this->adminMenu->add($dataMenu);

            if (isset($data['group_id'])) {
                $this->addGroupMenu($data['group_id'], $menu_id);
            }

            DB::commit();

            return [
                'error' => 0,
                'message' => __('core::admin-menu.create.SUCCESS'),
                'menu_id' => $menu_id
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => 1,
                'message' => __('core::admin-menu.create.FAILED'),
            ];
        }
    }

    /**
     * Cập nhật thông tin quyền menu
     *
     * @param array $data
     * @return mixed
     */
    public function edit(array $data)
    {
        try {
            DB::beginTransaction();
            $menu_id = $data['menu_id'];
            unset($data['menu_id']);

            $dataMenu = [
                'menu_name' => $data['menu_name'],
                'description' => $data['description'],
                'menu_position' => $data['menu_position'],
                'menu_icon' => '<i class="fa '.$data['menu_icon'].'"></i>',
                'menu_route' => $data['menu_route'],
                'menu_category_id' => $data['menu_category_id'],
            ];

            $this->adminMenu->edit($dataMenu, $menu_id);

            if (isset($data['group_id'])) {
                $this->removeGroupMenu($menu_id);
                $this->addGroupMenu($data['group_id'], $menu_id);
            }

            DB::commit();

            return [
                'error' => 0,
                'message' => __('core::admin-menu.edit.SUCCESS'),
                'menu_id' => $menu_id
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => 1,
                'message' => __('core::admin-menu.edit.FAILED'),
            ];
        }
    }

    /**
     * Đóng menu
     *
     * @param $menu_id
     * @return mixed
     */
    public function remove($menu_id)
    {
        return $this->adminMenu->remove($menu_id);
    }

    /**
     * Lấy danh sách menu cho popup
     *
     * @param array $listMenuId
     * @return mixed
     */
    public function getListMenuForPopup(array $listMenuId)
    {
        if (count($listMenuId) > 0 && isset($listMenuId['menu_id_list'])) {
            $result = $this->adminMenu->getListAll(['notin' => $listMenuId['menu_id_list']]);
        } else {
            $result = $this->adminMenu->getListAll();
        }

        return $result;
    }

    /**
     * Xóa quan hệ nhóm quyền và menu theo menu
     *
     * @param $menu_id
     */
    private function removeGroupMenu($menu_id)
    {
        $this->adminGroupMenu->remove([
            ['menu_id', '=', $menu_id]
        ]);
    }

    /**
     * @param array $list_group_id
     * @param int $menu_id
     * @return void
     */
    private function addGroupMenu(array $list_group_id, $menu_id)
    {
        $data = [];
        if (count($list_group_id) > 0) {
            foreach ($list_group_id as $group_id) {
                $data[] = [
                    'group_id' => $group_id,
                    'menu_id' => $menu_id,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }

            $this->adminGroupMenu->addMultipleRecords($data);
        }
    }

    /**
     * Lấy danh sách menu theo nhóm quyền
     *
     * @param $group_id
     * @return array
     */
    public function getListMenuByGroup($group_id)
    {
        $result = $this->adminGroupMenu->getListAll(['group_id' => $group_id])->toArray();

        return $result;
    }

    /**
     * Lấy menu id theo route
     *
     * @param string $menu_route
     * @return array
     */
    public function getMenuIdByRoute($menu_route)
    {
        $data = $this->adminMenu->getMenuIdByRoute($menu_route)->toArray();
        $result = [];
        if (count($data) > 0) {
            foreach ($data as $item) {
                $result[] = $item['menu_id'];
            }
        }

        return $result;
    }
}
