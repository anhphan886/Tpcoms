<?php

namespace Modules\Ticket\Repositories\TicketQueue;

interface TicketQueueRepositoryInterface
{
    /**
     * Lấy danh sách queue có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = []);

    /**
     * Lấy danh sách queue không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = []);

    /**
     * Lấy danh sách queue kèm theo danh sách ticket
     *
     * @return array
     */
    public function getListWithTicket();

    /**
     * Lấy danh sách nhân viên theo queue
     *
     * @param int $queueId
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getListStaffByQueue($queueId);
    /**
     * Thêm queue
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data);

    /**
     * chỉnh sữa queue
     *
     *@param array $data
     * @param int $ticket_queue_id
     * @return mixed
     */
    public function edit(array $data, $ticket_queue_id);

    /**
     * Lấy thông tin chi tiết Queue
     *
     * @param int $ticket_queue_id
     * @return mixed
     */
    public function getDetai($ticket_queue_id);

    /**
     * deleted queue
     *
     * @param int $ticket_queue_id
     * @return mixed
     */
    public  function  destroy($ticket_queue_id);
    public function getListAllStaffQueue();

}
