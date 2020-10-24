<?php

namespace Modules\Ticket\Repositories\IssueGroup;

interface IssueGroupRepositoryInterface
{
    /**
     * Lấy danh sách nhóm vấn đề có phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = []);

    /**
     * Lấy danh sách nhóm vấn đề không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = []);

    /**
     * Thêm nhóm vấn đề
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data);

    /**
     * get detail nhóm vấn đề
     *
     * @param int $portal_ticket_issue_group_id
     * @return mixed
     */
    public function getDetail($portal_ticket_issue_group_id);

    /**
     * update nhóm vấn đề
     *
     * @param array $data
     * @param int $portal_ticket_issue_group_id
     * @return mixed
     **/
    public function update(array $data, $portal_ticket_issue_group_id);

    /**
     * deleted nhóm vấn đề
     *
     * @param int $portal_ticket_issue_group_id
     * @return mixed
     **/
    public function destroy( $portal_ticket_issue_group_id);
}
