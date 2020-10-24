<?php

namespace Modules\Ticket\Http\Api;

use MyCore\Api\ApiAbstract;

class IssueGroupApi extends ApiAbstract
{
    /**
     * Lấy danh sách nhóm vấn đề có phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $filters = [])
    {
        return $this->baseClient('ticket/issue-group/list', $filters);
    }

    /**
     * Lấy danh sách nhóm vấn đề không phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getListAll(array $filters = [])
    {
        return $this->baseClient('ticket/issue-group/list-all', $filters);
    }
}
