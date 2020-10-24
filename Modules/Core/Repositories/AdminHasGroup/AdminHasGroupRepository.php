<?php

namespace Modules\Core\Repositories\AdminHasGroup;

use Modules\Core\Models\AdminHasGroupTable;

class AdminHasGroupRepository implements AdminHasGroupRepositoryInterface
{
    /**
     * @var AdminHasGroupTable
     */
    protected $adminHasGroup;

    public function __construct(AdminHasGroupTable $adminHasGroup)
    {
        $this->adminHasGroup = $adminHasGroup;
    }

    /**
     * Phân nhóm quyền nhiều user
     *
     * @param array $data
     */
    public function addMultipleRecords(array $data)
    {
        $this->adminHasGroup->addMultipleRecords($data);
    }

    public function removeByUser($userId)
    {
        return $this->adminHasGroup->removeByUser($userId);
    }
}
