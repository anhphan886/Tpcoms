<?php

namespace Modules\Ticket\Repositories\TicketProcessHistory;

interface TicketProcessHistoryRepositoryInterface
{
    /**
     * Lấy danh sách lịch sử ticket
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = []);
}
