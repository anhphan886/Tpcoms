<?php

namespace Modules\Ticket\Http\Api;

use MyCore\Api\ApiAbstract;

class TicketProcessHistoryApi extends ApiAbstract
{
    /**
     * Lấy danh sách lịch sử ticket có phân trang
     *
     * @param array $filter
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $filter = [])
    {
        return $this->baseClient('ticket/history/list', $filter);
    }
}
