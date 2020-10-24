<?php

namespace Modules\Ticket\Http\Api;

use MyCore\Api\ApiAbstract;

class IssueApi extends ApiAbstract
{
    /**
     * Lấy danh sách vấn đề có phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $filters = [])
    {
        return $this->baseClient('ticket/issue/list', $filters);
    }

    /**
     * Lấy danh sách vấn đề không phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getListAll(array $filters = [])
    {
        return $this->baseClient('ticket/issue/list-all', $filters);
    }

    /**
     * Lấy chi tiết vấn đề
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getDetail(array $filters = [])
    {
        return $this->baseClient('ticket/issue/detail', $filters);
    }
}
