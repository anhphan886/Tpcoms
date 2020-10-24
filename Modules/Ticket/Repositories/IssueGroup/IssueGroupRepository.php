<?php

namespace Modules\Ticket\Repositories\IssueGroup;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Repositories\CodeGenerator\CodeGeneratorRepositoryInterface;
use Modules\Ticket\Models\TicketIssueGroupTable;

class IssueGroupRepository implements IssueGroupRepositoryInterface
{
    /**
     * @var TicketIssueGroupTable
     */
    protected $issueGroup;
    protected $core;

    public function __construct(
        TicketIssueGroupTable $issueGroup,
        CodeGeneratorRepositoryInterface $code
    ) {
        $this->issueGroup = $issueGroup;
        $this->code = $code;
    }

    /**
     * Lấy danh sách nhóm vấn đề có phân trang
     *
     * @param array $filters
     * @return array|mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $filters = [])
    {
        if (isset($filters['keyword_ticket_issue_group$date_created'])){
            $filters['keyword_ticket_issue_group$date_created'] =
                str_replace('/', '-', $filters['keyword_ticket_issue_group$date_created']);
            $filters['keyword_ticket_issue_group$date_created'] =
                date('Y-m-d', strtotime($filters['keyword_ticket_issue_group$date_created']));
        }
        $data = $this->issueGroup->getList($filters);
//        dd($data);
        return [
            'data' => $data,
            'filter' => $filters
        ];
    }

    /**
     * Lấy danh sách nhóm vấn đề không phân trang
     *
     * @param array $filters
     * @return mixed|null
     * @throws \MyCore\Api\ApiException
     */
    public function getListAll(array $filters = [])
    {
        $result = $this->issueGroup->getListAll($filters);

        return $result;
    }

    /**
     * Thêm nhóm vấn đề
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        try {
            $dataIssueGroup = [
                'issue_group_name_vi' => strip_tags($data['issue_group_name_vi']),
                'issue_group_name_en' => strip_tags($data['issue_group_name_en']),
                'queue_id' => $data['queue_id'],
                'date_created' => date('Y-m-d H:i:s'),
                'date_modified' => date('Y-m-d H:i:s'),
                'created_by' => Auth::id(),
                'modified_by' => Auth::id(),
                'is_deleted' => 0,
            ];
            $result = $this->issueGroup->addItem($dataIssueGroup);
            return [
                'error' => 0,
                'message' => __('ticket::issue-group.info.create_success'),
                'data' => $result
            ];
        } catch (\Exception $e) {
            return [
//                'aaaa' => $e->getMessage(),
                'error' => 1,
                'message' => $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * get detail nhóm vấn đề
     *
     * @param int $portal_ticket_issue_group_id
     * @return mixed
     */
    public function getDetail($portal_ticket_issue_group_id)
    {
        return $this->issueGroup->getDetail($portal_ticket_issue_group_id);
    }

    /**
     * update nhóm vấn đề
     *
     * @param array $data
     * @param int $portal_ticket_issue_group_id
     * @return mixed
     **/
    public function update(array $data, $portal_ticket_issue_group_id)
    {
        try {
            $dataIssueGroup = [
//                'issue_group_name_vi' => strip_tags($data['issue_group_name_vi']),
//                'issue_group_name_en' => strip_tags($data['issue_group_name_en']),
                'queue_id' => $data['queue_id'],
                'date_modified' => date('Y-m-d H:i:s'),
                'modified_by' => Auth::id(),
                'is_deleted' => 0,
            ];
            $result = $this->issueGroup->updateIssueGroup($dataIssueGroup, $portal_ticket_issue_group_id);

            return [
              'error' => 0,
              'message' => __('ticket::issue-group.info.update_success'),
              'data' => $result,
            ];
        } catch (\Exception $e) {
            return [
                'aaaa' => $e->getMessage(),
              'portal_ticket_issue_group_id'  => $portal_ticket_issue_group_id,
              'error' => 1,
              'message' => __('ticket::issue-group.info.update_failed'),
            ];
        }
    }

    /**
     * deleted nhóm vấn đề
     *
     * @param int $portal_ticket_issue_group_id
     * @return mixed
     **/
    public function destroy($portal_ticket_issue_group_id)
    {
        try {
            $dataIssueGroup = [
                'is_deleted' => 1,
            ];
           $result =$this->issueGroup->updateIssueGroup($dataIssueGroup, $portal_ticket_issue_group_id);

           return [
               'error' => 0,
               'message' => '',
               'data' => $result,
           ];
        } catch (\Exception $e){
            return [
                'error' => 1,
                'message' =>$e->getMessage(),
            ];
        }
    }
}
