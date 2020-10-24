<?php

namespace Modules\Core\Repositories\AdminMenuCategory;

use Modules\Core\Models\AdminMenuCategoryTable;
use Modules\Core\Models\AdminMenuTable;

class AdminMenuCategoryRepository implements AdminMenuCategoryRepositoryInterface
{
    /**
     * @var AdminMenuCategoryTable
     */
    protected $adminMenuCategory;

    /**
     * @var AdminMenuTable
     */
    protected $adminMenu;

    public function __construct(
        AdminMenuCategoryTable $adminMenuCategory,
        AdminMenuTable $adminMenu
    ) {
        $this->adminMenuCategory = $adminMenuCategory;
        $this->adminMenu = $adminMenu;
    }

    /**
     * Lấy danh sách menu category có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = [])
    {
        if (!isset($filters['keyword_admin_menu_category$menu_category_name'])) {
            $filters['keyword_admin_menu_category$menu_category_name'] = null;
        }

        if (!isset($filters['keyword_admin_menu_category$menu_category_position'])) {
            $filters['keyword_admin_menu_category$menu_category_position'] = null;
        }

        if (!isset($filters['sort_admin_menu_category$menu_category_name'])) {
            $filters['sort_admin_menu_category$menu_category_name'] = null;
        }

        if (!isset($filters['sort_admin_menu_category$menu_category_position'])) {
            $filters['sort_admin_menu_category$menu_category_position'] = null;
        }

        $check = $filters;
        $check = array_filter($check);

        if (count($check) == 0) {
            $filters['sort_admin_menu_category$menu_category_id'] = 'desc';
        }

        $data = $this->adminMenuCategory->getList($filters);

        return [
            'list' => $data,
            'filter' => $filters
        ];
    }

    /**
     * Lấy danh sách menu category có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->adminMenuCategory->getListAll($filters)->toArray();

        return $result;
    }

    /**
     * Thêm nhóm menu
     *
     * @param array $data
     * @return array
     */
    public function add(array $data)
    {
        try {
            $dataMenuCategory = [
                'menu_category_name' => strip_tags($data['menu_category_name']),
                'menu_category_position' => $data['menu_category_position'],
                'menu_category_icon' => '<i class="fa '.$data['menu_category_icon'].'"></i>',
            ];

            $menu_category_id = $this->adminMenuCategory->add($dataMenuCategory);

            return [
                'error' => 0,
                'message' => __('core::admin-menu-category.popup.CREATED'),
                'menu_category_id' => $menu_category_id
            ];
        } catch (\Exception $e) {
            return [
                'error' => 1,
                'message' => __('core::admin-menu-category.popup.CREATE_FAILED'),
                '_message' => $e->getMessage()
            ];
        }
    }
    /**
     * Lấy thông tin chi tiết
     *
     * @param int $id
     * @return mixed
     */
    public function getDetail($id)
    {
        $result = $this->adminMenuCategory->getDetail($id);

        return $result;
    }

    /**
     * Chỉnh sửa nhóm menu
     *
     * @param array $data
     * @return array
     */
    public function edit(array $data)
    {
        try {
            $dataMenuCategory = [
                'menu_category_name' => strip_tags($data['menu_category_name']),
                'menu_category_position' => $data['menu_category_position'],
                'menu_category_icon' => '<i class="fa '.$data['menu_category_icon'].'"></i>',
            ];

            $result = $this->adminMenuCategory->edit($dataMenuCategory, $data['menu_category_id']);

            if ($result) {
                return [
                    'error' => 0,
                    'message' => __('core::admin-menu-category.popup.UPDATED')
                ];
            } else {
                return [
                    'error' => 1,
                    'message' => __('core::admin-menu-category.popup.UPDATE_FAILED')
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => 1,
                'message' => __('core::admin-menu-category.popup.UPDATE_FAILED'),
                '_message' => $e->getMessage()
            ];
        }
    }

    /**
     * Đánh dấu xóa nhóm menu
     *
     * @param int $id
     * @return mixed
     */
    public function remove($id)
    {
        $this->changeMenuCategoryForMenu($id);

        return $this->adminMenuCategory->remove($id);
    }

    /**
     * Cập nhật nhóm menu cho menu khi xóa nhóm menu
     *
     * @param int $menuCategoryId
     * @return void
     */
    private function changeMenuCategoryForMenu($menuCategoryId)
    {
        $this->adminMenu->edit(['menu_category_id' => 0], [
            ['menu_category_id', '=', $menuCategoryId],
        ]);
    }
}
