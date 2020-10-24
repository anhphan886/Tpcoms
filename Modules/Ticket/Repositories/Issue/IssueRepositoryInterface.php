<?php

namespace Modules\Ticket\Repositories\Issue;

interface IssueRepositoryInterface
{
    /**
     * Lấy danh sách vấn đề có chia trang
     *
     * @param array $filters
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $filters = []);

    /**
     * Lấy danh sách vấn đề không chia trang
     *
     * @param array $filters
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getListAll(array $filters = []);

    /**
     * Lấy chi tiết vấn đề
     *
     * @param array $filters
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getDetail($portal_ticket_issue_id);

    /**
     * Lấy danh sách cấp độ sự cố
     *
     * @return mixed
     */
    public function getListLevel();

    /**
     * Thêm vấn đề
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data);

    /**
     * update vấn đề
     * @param int $portal_ticket_issue_id
     * @param array $data
     * @return mixed
     */
    public  function update(array $data, $portal_ticket_issue_id);

    /**
     * deleted nhóm vấn đề
     *
     * @param array $portal_ticket_issue_id
     * @return mixed
     */
    public function destroy($portal_ticket_issue_id);
}
