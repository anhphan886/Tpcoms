<?php

namespace Modules\Ticket\Http\Api;

use MyCore\Api\ApiAbstract;

class TicketApi extends ApiAbstract
{
    /**
     * Lấy danh sách ticket có phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $filters = [])
    {
        return $this->baseClient('/ticket/list', $filters);
    }

    /**
     * Lấy danh sách ticket không phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getListAll(array $filters = [])
    {
        return $this->baseClient('/ticket/list-all', $filters);
    }

    /**
     * Lấy danh sách ticket và đếm số ticket có cùng trạng thái
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getTotalGroupByStatus(array $filters = [])
    {
        return $this->baseClient('/ticket/get-total-group-by-status', $filters);
    }

    /**
     * Lấy danh sách ticket kèm theo processors
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getTicketWithProcessor(array $filters = [])
    {
        return $this->baseClient('/ticket/list-ticket-not-assigned', $filters);
    }

    /**
     * Thêm ticket
     *
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function add(array $data)
    {
        return $this->baseClient('ticket/store', $data, false);
    }

    /**
     * Cập nhật ticket
     *
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function edit(array $data)
    {
//        dd($data);
        return $this->baseClient('ticket/update', $data, false);
    }

    /**
     * Lấy chi tiết ticket
     *
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getDetail(array $data)
    {
        return $this->baseClient('ticket/detail', $data);
    }
    public function getDetailByCustomerId(array $data)
    {
        return $this->baseClient('ticket/detail-by-service', $data);
    }

    /**
     * Update file
     *
     * @param $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function uploadFile($data)
    {
        return $this->baseClientUpload('filemanager/upload', $data);
    }

    /**
     * Lấy danh sách ticket status
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getTicketStatus(array $filters = [])
    {
        return $this->baseClient('ticket/ticket-status', $filters);
    }

    /**
     * Lấy danh sách ticket file
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getTicketFile(array $param = [])
    {
        return $this->baseClient('ticket/ticket-file', $param);
    }

}
