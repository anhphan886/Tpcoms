<?php

namespace Modules\Core\Repositories\AdminGroupMenu;

interface AdminGroupMenuRepositoryInterface
{
    /**
     * Lấy danh sách quan hệ nhóm quyền và menu
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = []);
}
