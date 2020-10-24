<?php

namespace Modules\Ticket\Http\Api;

use MyCore\Api\ApiAbstract;

class TicketCommentApi extends ApiAbstract
{
    /**
     * Thêm comment
     *
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function postComment(array $data)
    {
        return $this->baseClient('ticket/comment/store', $data, false);
    }
}
