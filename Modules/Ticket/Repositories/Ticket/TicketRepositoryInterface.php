<?php

namespace Modules\Ticket\Repositories\Ticket;

interface TicketRepositoryInterface
{
    /**
     * Lấy danh sách ticket có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = []);

    /**
     * Lấy danh sách ticket không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = []);

    /**
     * Lấy danh sách ticket chưa phân công
     *
     * @param array $filters
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function getTicketWithProcessor(array $filters = []);

    /**
     * Lấy danh sách ticket và đếm số ticket có cùng trạng thái
     *
     * @return array
     */
    public function getTotalGroupByStatus();

    /**
     * Lấy danh sách sản phẩm/dịch vụ không phân trang
     *
     * @param array $filters
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getListService(array $filters = []);

    /**
     * Lấy danh sách khách hàng không phân trang
     *
     * @param array $filters
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getListCustomer(array $filters = []);

    /**
     * Lấy chi tiết khách hàng theo account
     *
     * @param $customerAccountId
     * @return mixed
     */
    public function getDetailCustomer($customerAccountId);

    /**
     * Lấy chi tiết tài khoản khách hàng
     *
     * @param $customerAccountId
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getInfoCustomer($customerAccountId);

    /**
     * Thêm ticket
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data);

    /**
     * Cập nhật ticket
     *
     * @param array $data
     * @return mixed
     */
    public function edit(array $data);

    /**
     * Lấy chi tiết ticket
     *
     * @param $ticketId
     * @return mixed
     */
    public function getDetail($ticketId);

    /**
     * Upload file
     *
     * @param $data
     * @return mixed
     */
    public function uploadFile($data);

    /**
     * Thêm comment
     *
     * @param array $data
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function postComment(array $data);

    /**
     * Lấy danh sách ticket status
     *
     * @param array $filters
     * @return mixed
     */
    public function getTicketStatus(array $filters = []);

    /**
     * Lấy danh sách lịch sử ticket
     *
     * @param int $ticketId
     * @return mixed
     */
    public function getListHistory($ticketId);

    public  function  getTicketFile(array $param = []);
    /**
     * function get survey ticket
     */
    public function getSurvey($ticket_id);

    public function detailTicketCheckDate();

}
