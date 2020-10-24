<?php

namespace Modules\Ticket\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Ticket\Http\Requests\Ticket\TicketStoreRequest;
use Modules\Ticket\Http\Requests\Ticket\TicketUpdateRequest;
use Modules\Ticket\Repositories\Issue\IssueRepositoryInterface;
use Modules\Ticket\Repositories\IssueGroup\IssueGroupRepositoryInterface;
use Modules\Ticket\Repositories\Ticket\TicketRepositoryInterface;
use Modules\Ticket\Repositories\TicketQueue\TicketQueueRepositoryInterface;
use Modules\Ticket\Models\TicketTable;

class TicketController extends Controller
{
    /**
     * @var TicketRepositoryInterface
     */
    private $ticket;

    /**
     * @var TicketQueueRepositoryInterface
     */
    private $ticketQueue;

    /**
     * @var IssueGroupRepositoryInterface
     */
    private $issueGroup;

    private $ticketT;

    /**
     * @var IssueRepositoryInterface
     */
    private $issue;

    private $enumType = [
        'staff_support' => 'Staff Support',
        'staff_deploy' => 'Staff Deploy',
        'cs_support' => 'Customer Support',
    ];

    public function __construct(
        TicketRepositoryInterface $ticket,
        TicketQueueRepositoryInterface $ticketQueue,
        IssueGroupRepositoryInterface $issueGroup,
        IssueRepositoryInterface $issue,
        TicketTable $ticketT
    )
    {
        $this->ticket = $ticket;
        $this->ticketQueue = $ticketQueue;
        $this->issueGroup = $issueGroup;
        $this->issue = $issue;
        $this->ticketT = $ticketT;
    }

    /**
     * Trang danh sách ticket
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \MyCore\Api\ApiException
     */
    public function index(Request $request)
    {
        $filter = $request->all();
        $filter['author'] = Auth::id();

        $listTicket = $this->ticket->getList($filter);
//        dd($filter);
        $listQueue = $this->ticketQueue->getListWithTicket();
        $listIssue = $this->issue->getListAll();
        $listStatus = $this->ticket->getTicketStatus();

        return view('ticket::ticket.index', [
            'list' => $listTicket['data'],
            'filter' => $listTicket['filter'],
            'listQueue' => $listQueue,
            'listIssue' => $listIssue,
            'listStatus' => $listStatus,
        ]);
    }

    /**
     * Trang dashboard của ticket
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \MyCore\Api\ApiException
     */
    public function dashboard(Request $request)
    {

        $filter = $request->all();
//        $filter['author'] = Auth::id();
        $listTicketNotAssigned = $this->ticket->getTicketWithProcessor($filter);
        $listTicket = $this->ticket->getListAll();
        $countTicket = $this->ticket->getTotalGroupByStatus();

        $listQueue = $this->ticketQueue->getListWithTicket();

        $perpage = isset($filter['perpage']) ? $filter['perpage'] : PAGING_ITEM_PER_PAGE;

        return view('ticket::ticket.dashboard', [
            'listTicket' => $listTicket,
            'listTicketNotAssigned' => $listTicketNotAssigned['data'],
            'countTicket' => $countTicket,
            'listQueue' => $listQueue,
            'filter' => $listTicketNotAssigned['filter'],
//            'page' => $page,
            'perpage' => $perpage,
        ]);
    }

    /**
     * Trang thêm ticket
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \MyCore\Api\ApiException
     */
    public function create(Request $request)
    {
        $param= $request->all();
        $listQueue = $this->ticketQueue->getListAll();
        $listIssueGroup = $this->issueGroup->getListAll();
        $listCustomer = $this->ticket->getListCustomer();
        $listIssue = $this->issue->getListAll();
        $listStaffQueue = $this->ticketQueue->getListAllStaffQueue();
//        $service = $this->ticket->getListService( ['customer_id' => $param['customer_id'] ]);

        return view('ticket::ticket.create.index', [
            'listQueue' => $listQueue,
            'listIssueGroup' => $listIssueGroup,
            'listCustomer' => $listCustomer,
            'enumType' => $this->enumType,
            'listIssue' => $listIssue,
            'param' => $param,
            'listStaffQueue' => $listStaffQueue,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param TicketStoreRequest $request
     * @return Response
     */
    public function store(TicketStoreRequest $request)
    {
        $data = $request->all();
        $result = $this->ticket->add($data);

        return $result;
    }

    /**
     * Trang chi tiết ticket
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \MyCore\Api\ApiException
     */
    public function show($id)
    {
        $detail = $this->ticket->getDetail($id);
        if (isset($detail['ticket_detail']) && $detail['ticket_detail'] != null) {
            $listQueue = $this->ticketQueue->getListAll();
            $listIssueGroup = $this->issueGroup->getListAll();
            $listStaff = $this->ticketQueue->getListStaffByQueue($detail['ticket_detail']['queue_process_id']);
            $processors = collect($detail['ticket_processors'])->keyBy('process_by')->toArray();
            $processors = array_keys($processors);
            $ticketHistory = $this->ticket->getListHistory($id);
            $param = [
                'ticket_id' => $id,
                'object_type' => 'ticket'
            ];
            $ticketFile = $this->ticket->getTicketFile($param);
            $survey = $this->ticket->getSurvey($id);

            return view('ticket::ticket.edit.detail', [
                'detail' => $detail['ticket_detail'],
                'listQueue' => $listQueue,
                'listIssueGroup' => $listIssueGroup,
                'listOperator' => $listStaff['operator'] ?? null,
                'listProcessor' => $listStaff['processor'] ?? null,
                'processors' => $processors,
                'listComment' => $detail['ticket_comment'],
                'listHistory' => $ticketHistory,
                'enumType' => $this->enumType,
                'ticketFile' => $ticketFile,
                'survey' => $survey,
            ]);
        } else {
            return redirect('error-404');
        }

    }

    /**
     * Trang chỉnh sửa ticket
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \MyCore\Api\ApiException
     */
    public function edit($id)
    {
        $detail = $this->ticket->getDetail($id);
//        dd($detail);
        $listQueue = $this->ticketQueue->getListAll();
        $listStaff = $this->ticketQueue->getListStaffByQueue($detail['ticket_detail']['queue_process_id']);
        $processors = collect($detail['ticket_processors'])->keyBy('process_by')->toArray();

        $processors = array_keys($processors);

        $listService = $this->ticket->getListService([
            'customer_id' => $detail['ticket_detail']['customer_id']
        ]);
        $listCustomer = $this->ticket->getListCustomer();
        $listStatus = $this->ticket->getTicketStatus();
        $ticketHistory = $this->ticket->getListHistory($id);
        $param = [
            'ticket_id' => $id,
            'object_type' => 'ticket'
        ];
        $ticketFile = $this->ticket->getTicketFile($param);
        $survey = $this->ticket->getSurvey($id);

        return view('ticket::ticket.edit.index', [
            'detail' => $detail['ticket_detail'],
            'listQueue' => $listQueue,
            'listOperator' => $listStaff['operator'] ?? null,
            'listProcessor' => $listStaff['processor'] ?? null,
            'processors' => $processors,
            'listService' => $listService,
            'listCustomer' => $listCustomer,
            'listComment' => $detail['ticket_comment'],
            'listStatus' => $listStatus,
            'listHistory' => $ticketHistory,
            'enumType' => $this->enumType,
            'ticketFile' => $ticketFile,
            'survey' => $survey,
        ]);
    }

    /**
     * Cập nhật ticket
     *
     * Update the specified resource in storage.
     * @param TicketUpdateRequest $request
     * @return Response
     */
    public function update(TicketUpdateRequest $request)
    {
        $data = $request->all();
        $result = $this->ticket->edit($data);

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Ajax lấy thông tin tài khoản khách hàng
     *
     * @param Request $request
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function getInfoCustomer(Request $request)
    {
        $data = $request->only(['customer_id']);
        $result = $this->ticket->getInfoCustomer($data['customer_id']);

        return [
            'error' => 0,
            'message' => 'Success',
            'data' => $result,
        ];
    }

    /**
     * Ajax lấy danh sách vấn đề theo id nhóm vấn đề
     *
     * @param Request $request
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function getListIssue(Request $request)
    {
        $data = $request->only(['ticket_issue_group_id']);
        $result = $this->issue->getListAll([
            'ticket_issue$portal_ticket_issue_group_id' => $data['ticket_issue_group_id'] ?? 0
        ]);

        return [
            'error' => 0,
            'message' => 'Success',
            'data' => $result,
        ];
    }

    /**
     * Ajax lấy thông tin vấn đề để chọn queue
     *
     * @param Request $request
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function selectQueue(Request $request)
    {
        $data = $request->only(['ticket_issue_id']);
        $result = $this->issue->getDetail($data);

        return [
            'error' => 0,
            'message' => 'Success',
            'data' => $result,
        ];
    }

    /**
     * Lấy danh sách dịch vụ theo khách hàng
     *
     * @param Request $request
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function getListServiceByCustomer(Request $request)
    {
        $data = $request->only(['customer_id']);
        $customer = $this->ticket->getDetailCustomer($data['customer_id']);

        $listService = $this->ticket->getListService([
            'customer_id' => $customer['customer_id']
        ]);

        return [
            'error' => 0,
            'message' => 'Success',
            'data' => $listService
        ];
    }

    /**
     * Ajax lấy danh sách nhân viên theo queue
     *
     * @param Request $request
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function getListStaffByQueue(Request $request)
    {
        $data = $request->only(['queue_id']);
        $result = $this->ticketQueue->getListStaffByQueue($data['queue_id']);

        return [
            'error' => 0,
            'message' => 'Success',
            'data' => $result,
        ];
    }

    /**
     * Upload hình ảnh
     *
     * @param Request $request
     * @return array
     */
    public function uploadImage(Request $request)
    {
        if ($request->file('upload_file') != null) {
            $tmp['upload_file'] = $request->file('upload_file');
            $file = $this->ticket->uploadFile($request->file('upload_file'));
            if (is_array($file)) {
                if (count($file) > 0) {
                    return [
                        "file" => $file,
                        "success" => "1",
                        'message' => ""
                    ];
                }

            }
        }

        return [
            'file' => null,
            'success' => '0',
            'message' => 'File not found',
        ];
    }

    /**
     * Thêm comment
     *
     * @param Request $request
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function postComment(Request $request)
    {
        $data = $request->all();
        $result = $this->ticket->postComment($data);

        return $result;
    }

    /**
     * lấy chi tiêt ticket, kiểm tra ticket quá thời gian xử lý
     */
    public function detailTicketCheckDate()
    {
         $data = $this->ticket->detailTicketCheckDate();
         return $data;
    }
}
