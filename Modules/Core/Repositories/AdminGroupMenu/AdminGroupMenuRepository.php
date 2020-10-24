<?php

namespace Modules\Core\Repositories\AdminGroupMenu;

use Modules\Core\Models\AdminGroupMenuTable;

class AdminGroupMenuRepository implements AdminGroupMenuRepositoryInterface
{
    protected $adminGroupMenu;

    public function __construct(AdminGroupMenuTable $adminGroupMenu)
    {
        $this->adminGroupMenu = $adminGroupMenu;
    }

    /**
     * Lấy danh sách quan hệ nhóm quyền và menu
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->adminGroupMenu->getListAll($filters)->toArray();

        return $result;
    }
}
