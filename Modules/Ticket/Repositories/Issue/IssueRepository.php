<?php

namespace Modules\Ticket\Repositories\Issue;

use Illuminate\Support\Facades\Auth;
use Modules\Ticket\Models\TicketIssueLevelTable;
use Modules\Ticket\Models\TicketIssueTable;

class IssueRepository implements IssueRepositoryInterface
{
    /**
     * @var TicketIssueTable
     */
    private $issue;

    /**
     * @var TicketIssueLevelTable
     */
    private $issueLevel;

    public function __construct(TicketIssueTable $issue, TicketIssueLevelTable $issueLevel)
    {
        $this->issue = $issue;
        $this->issueLevel = $issueLevel;
    }

    /**
     * Lấy danh sách vấn đề có chia trang
     *
     * @param array $filters
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $filters = [])
    {
        if (isset($filters['keyword_ticket_issue$date_created'])){
            $filters['keyword_ticket_issue$date_created'] =
                str_replace('/', '-', $filters['keyword_ticket_issue$date_created']);
            $filters['keyword_ticket_issue$date_created'] =
                date('Y-m-d', strtotime($filters['keyword_ticket_issue$date_created']));
        }
        $data = $this->issue->getList($filters);
        return [
            'data' => $data,
            'filter' => $filters
        ];
    }

    /**
     * Lấy danh sách vấn đề không chia trang
     *
     * @param array $filters
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->issue->getListAll($filters);

        return $result;
    }

    /**
     * Lấy chi tiết vấn đề
     *
     * @param array $filters
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getDetail($portal_ticket_issue_id)
    {
        $result = $this->issue->getDetail($portal_ticket_issue_id);

        return $result;
    }

    /**
     * Lấy danh sách cấp độ sự cố
     *
     * @return mixed
     */
    public function getListLevel()
    {
        return $this->issueLevel->getListAll();
    }

    /**
     * Thêm vấn đề
     *
     * @param array $data
     * @return array
     */
    public function add(array $data)
    {
        try {
            $dataIssue = [
                'issue_name_vi' => strip_tags($data['issue_name_vi']),
                'issue_name_en' => strip_tags($data['issue_name_en']),
                'portal_ticket_issue_group_id' => $data['portal_ticket_issue_group_id'],
                'portal_ticket_issue_level_id' => $data['portal_ticket_issue_level_id'],
                'process_time' => $data['process_time'],
                'crictical_time2' => $data['crictical_time2'],
                'crictical_time3' => $data['crictical_time3'],
                'crictical_time4' => $data['crictical_time4'],
                'queue_id' => $data['queue_id'],
                'date_created' => date('Y-m-d H:i:s'),
                'date_modified' => date('Y-m-d H:i:s'),
                'created_by' => Auth::id(),
                'modified_by' => Auth::id(),
                'is_deleted' => 0,
            ];

            $result = $this->issue->add($dataIssue);

            return [
                'error' => 0,
                'message' => __('ticket::issue.info.create_success'),
                'data' => $result
            ];
        } catch (\Exception $e) {
            return [
                'aaa' => $e->getMessage(),
                'error' => 1,
                'message' => __('ticket::issue.info.create_failed'),
                'data' => null
            ];
        }
    }

    /**
     * update vấn đề
     * @param int $portal_ticket_issue_id
     * @param array $data
     * @return mixed
     */
    public  function update(array $data, $portal_ticket_issue_id)
    {
        try {
            $dataIssue = [
//                'issue_name_vi' => strip_tags($data['issue_name_vi']),
//                'issue_name_en' => strip_tags($data['issue_name_en']),
//                'portal_ticket_issue_group_id' => $data['portal_ticket_issue_group_id'],
                'portal_ticket_issue_level_id' => $data['portal_ticket_issue_level_id'],
                'process_time' => $data['process_time'],
                'crictical_time2' => $data['crictical_time2'],
                'crictical_time3' => $data['crictical_time3'],
                'crictical_time4' => $data['crictical_time4'],
                'queue_id' => $data['queue_id'],
                'date_modified' => date('Y-m-d H:i:s'),
//                'modified_by' => Auth::id(),
                'is_deleted' => 0,
            ];

            $result = $this->issue->updateIssue($dataIssue, $portal_ticket_issue_id);

            return [
                'error'  =>0,
                'message' => __('ticket::issue.info.update_success'),
                'data' => $result,
            ];
        } catch (\Exception $e) {
            return [
              'error' => 1,
              'message' =>   __('ticket::issue.info.update_failed'),
              'data' => null,
            ];
        }
    }

    /**
     * deleted nhóm vấn đề
     *
     * @param array $portal_ticket_issue_id
     * @return mixed
     */
    public function destroy($portal_ticket_issue_id)
    {
        try {
            $dataIssue = [
              'is_deleted' => 1,
              'portal_ticket_issue_group_id' => 0,
            ];
            $result = $this->issue->updateIssue($dataIssue, $portal_ticket_issue_id);

            return [
                'error' =>0,
                'message' => '',
                'data' => $result,
            ];
        } catch (\Exception $e) {
            return [
              'error' => 1,
              'message' =>$e->getMessage(),
            ];
        }
    }

}
