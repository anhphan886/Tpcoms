<?php

namespace Modules\Ticket\Http\Api;

use MyCore\Api\ApiAbstract;

class TicketQueueApi extends ApiAbstract
{
    /**
     * Lấy danh sách queue có phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $filters = [])
    {
        return $this->baseClient('/ticket/queue/list', $filters);
    }

    /**
     * Lấy danh sách queue không phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getListAll(array $filters = [])
    {
        return $this->baseClient('/ticket/queue/list-all', $filters);
    }

    /**
     * Lấy danh sách queue kèm theo ticket
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getListWithTicket(array $filters = [])
    {
        return $this->baseClient('/ticket/queue/list-with-ticket', $filters);
    }

    /**
     * Lấy danh sách nhân viên theo queue
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getListStaffByQueue(array $filters = [])
    {
        return $this->baseClient('ticket/queue/get-staff-by-queue', $filters);
    }
}
