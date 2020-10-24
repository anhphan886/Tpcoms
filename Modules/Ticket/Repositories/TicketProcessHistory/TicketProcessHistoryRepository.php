<?php

namespace Modules\Ticket\Repositories\TicketProcessHistory;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Ticket\Http\Api\TicketProcessHistoryApi;

class TicketProcessHistoryRepository implements TicketProcessHistoryRepositoryInterface
{
    /**
     * @var TicketProcessHistoryApi
     */
    private $ticketHistory;

    public function __construct(TicketProcessHistoryApi $ticketHistory)
    {
        $this->ticketHistory = $ticketHistory;
    }

    /**
     * Lấy danh sách ịch sử ticket
     *
     * @param array $filters
     * @return LengthAwarePaginator|mixed|null
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $filters = [])
    {
        $result = $this->ticketHistory->getList($filters);

        if (isset($result['Items']) && count($result['Items']) > 0) {
            $items = $result['Items'];
            $pageInfo = $result['PageInfo'];

            return new LengthAwarePaginator(
                $items,
                $pageInfo['total'],
                $pageInfo['itemPerPage'],
                $pageInfo['currentPage'],
                ['path' => url()->current()]
            );
        }

        return null;
    }
}
