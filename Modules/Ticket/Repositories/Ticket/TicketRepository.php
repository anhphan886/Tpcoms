<?php

namespace Modules\Ticket\Repositories\Ticket;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\Http\Api\CustomerAccountApi;
use Modules\Customer\Http\Api\CustomerServiceApi;
use Modules\Customer\Http\Api\CustomerApi;
use Modules\Ticket\Http\Api\TicketApi;
use Modules\Ticket\Http\Api\TicketCommentApi;
use Modules\Ticket\Http\Api\TicketProcessHistoryApi;
use Modules\Ticket\Models\NotificationLogTable;
use Modules\Ticket\Models\NotificationTable;
use Modules\Ticket\Models\TicketProcessorTable;
use Modules\Ticket\Repositories\TicketProcessHistory\TicketProcessHistoryRepositoryInterface;
use Modules\Ticket\Repositories\TicketQueue\TicketQueueRepository;
use Modules\Product\Models\PortalAdminTable;
use Modules\Product\Models\CustomerTable;
use Modules\Ticket\Models\TicketTable;
use Modules\Product\Models\TicketEmailLogTable;
use Modules\Product\Models\CustomerServiceTable;
use App\Http\Controllers\TraitSendMail;
use Carbon\Carbon;
use PHPUnit\Exception;

class TicketRepository implements TicketRepositoryInterface
{
    /**
     * @var TicketApi
     */
    private $ticket;


    /**
     * @var TicketProcessorTable
     */
    private $ticketProcessor;

    /**
     * @var CustomerServiceApi
     */
    private $customerService;

    /**
     * @var CustomerAccountApi
     */
    private $customerAccount;

    /**
     * @var TicketCommentApi
     */
    private $ticketComment;

    /**
     * @var TicketProcessHistoryApi
     */
    private $ticketHistory;
    /**
     * @var TicketQueueRepository
     */

    private $customerApi;
    /**
     * @var TicketQueueRepository
     */

    use TraitSendMail;
    private $queue;
    private $staff;
    private $customer;
    private $email;
    private $csService;
    private $ticketTb;

    public function __construct(
        TicketApi $ticket,
        CustomerServiceApi $customerService,
        TicketProcessorTable $ticketProcessor,
        CustomerAccountApi $customerAccount,
        TicketCommentApi $ticketComment,
        TicketProcessHistoryApi $ticketHistory,
        TicketQueueRepository $queue,
        PortalAdminTable $staff,
        CustomerTable $customer,
        TicketEmailLogTable $email,
        CustomerServiceTable $csService,
        TicketTable $ticketTb,
        customerApi $customerApi
    )
    {
        $this->ticket = $ticket;
        $this->ticketProcessor = $ticketProcessor;
        $this->customerService = $customerService;
        $this->customerAccount = $customerAccount;
        $this->ticketComment = $ticketComment;
        $this->ticketHistory = $ticketHistory;
        $this->queue = $queue;
        $this->staff = $staff;
        $this->customer = $customer;
        $this->email = $email;
        $this->csService = $csService;
        $this->ticketTb = $ticketTb;
        $this->customerApi = $customerApi;
    }

    /**
     * Lấy danh sách ticket có phân trang
     *
     * @param array $filters
     * @return array|mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $filters = [])
    {
        if (!isset($filters['keyword_portal_ticket$ticket_code'])) {
            $filters['keyword_portal_ticket$ticket_code'] = null;
        }
        if (!isset($filters['keyword_portal_ticket$ticket_title'])) {
            $filters['keyword_portal_ticket$ticket_title'] = null;
        }
        if (!isset($filters['portal_ticket$issue_id'])) {
            $filters['portal_ticket$issue_id'] = null;
        }
        if (!isset($filters['portal_ticket$queue_process_id'])) {
            $filters['portal_ticket$queue_process_id'] = null;
        }
//        if (!isset($filters['process_by'])) {
//            $filters['process_by'] = Auth::id();
//        }

        $result = $this->ticket->getList($filters);

        if (isset($result['Items']) && count($result['Items']) > 0) {
            $items = $result['Items'];
            $pageInfo = $result['PageInfo'];
            $result = new LengthAwarePaginator(
                $items,
                $pageInfo['total'],
                $pageInfo['itemPerPage'],
                $pageInfo['currentPage'],
                ['path' => url()->current()]
            );
        } else {
            $result = null;
        }

        return [
            'data' => $result,
            'filter' => $filters
        ];
    }

    /**
     * Lấy danh sách ticket chưa phân công
     *
     * @param array $filters
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function getTicketWithProcessor(array $filters = [])
    {
        if (!isset($filters['portal_ticket$queue_process_id'])) {
            $filters['portal_ticket$queue_process_id'] = null;
        }
        if (!isset($filters['page'])) {
            $filters['page'] = 1;
        }
        $result = $this->ticket->getTicketWithProcessor($filters);

        if (isset($result['Items']) && count($result['Items']) > 0) {
            $items = $result['Items'];
            $pageInfo = $result['PageInfo'];
            $result = new LengthAwarePaginator(
                $items,
                $pageInfo['total'],
                $pageInfo['itemPerPage'],
                $pageInfo['currentPage'],
                ['path' => url()->current()]
            );
        } else {
            $result = null;
        }

        return [
            'data' => $result,
            'filter' => $filters
        ];
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
//        $filters['process_by'] = Auth::id();
//        $filters['is_admin'] = Auth::user()->is_admin;

        $result = $this->ticket->getListAll($filters);

        if (count($result) > 0) {
            return $result;
        }
        return null;
    }

    /**
     * Lấy danh sách ticket và đếm số ticket có cùng trạng thái
     *
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function getTotalGroupByStatus()
    {
        $result = $this->ticket->getTotalGroupByStatus(['author' => Auth::id()]);

        if (count($result) > 0) {
            return $result;
        }

        return null;
    }

    /**
     * Lấy danh sách sản phẩm/dịch vụ không phân trang
     *
     * @param array $filters
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getListService(array $filters = [])
    {
        $result = $this->customerService->getListAll($filters);

        if (count($result) > 0) {
            return $result;
        }

        return null;
    }

    /**
     * Lấy danh sách khách hàng không phân trang
     *
     * @param array $filters
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getListCustomer(array $filters = [])
    {
        $result = $this->customerApi->getListAll($filters);

        if (count($result) > 0) {
            return $result;
        }

        return null;
    }

    /**
     * Lấy chi tiết khách hàng theo account
     *
     * @param int $customerId
     * @return mixed|null
     * @throws \MyCore\Api\ApiException
     */
    public function getDetailCustomer($customerId)
    {
        $result = $this->customerApi->getDetail(['customer_id' => $customerId]);
        if (count($result) > 0) {
            return $result;
        }

        return null;
    }

    /**
     * Lấy chi tiết tài khoản khách hàng
     *
     * @param int $customerId
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getInfoCustomer($customerId)
    {
        $result = $this->customerApi->getDetail(['customer_id' => $customerId]);

        if (count($result) > 0) {
            return $result;
        }

        return null;
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
        try {
            $data['crictical_level'] = 1;
            $data['platform'] = 'web';
            $data['created_by'] = Auth::id();
            $data['modified_by'] = Auth::id();
            $data['date_issue'] = Carbon::now()->format('Y-m-d H:i:s');
            if(isset($data['type'])){
                if ($data['type']== STAFF_DEPLOY ) {
                    $data['type'] = STAFF_DEPLOY ;
                } elseif ($data['type']== STAFF_CONSULT) {
                    $data['type'] = STAFF_CONSULT;
                } else {
                    $data['type'] = STAFF_SUPPORT;
                }
            }
            $dataComment = [];
            if (isset($data['upload_file']) && count($data['upload_file']) > 0) {
                foreach ($data['upload_file'] as $path) {
                    $dataComment[] = [
                        'path' => $path,
                    ];
                }
            }
            $data['ticket_file'] = $dataComment;
            $result = $this->ticket->add($data);

            if (count($result)) {
                $ticketNew = $this->getDetail($result['ticket_id']);
                $this->sendMail([
                    'customer_service_id'
                ], $ticketNew, 1);

                return [
                    'error' => 0,
                    'message' => __('ticket::ticket.info.create_success'),
                    'data' => $result
                ];
            }
        } catch (\Exception $e) {
            return [
                'aaa' => $e->getMessage(),
                dd($e),
                'error' => 1,
//            'message' => __('ticket::ticket.info.create_failed'),
                'message' => 'error api',
                'data' => null
            ];
        }
    }

    public function sendMailPostComment($comment)
    {
        $idTicket = $comment['ticket_id'];
        $ticketNew = $this->getDetail($idTicket);
        $userTicket = $this->customer->detailAcc($ticketNew['ticket_detail']['customer_id'])->toArray();
        $sendToCus = $userTicket['customer_email'];
        $listMail = $this->ticketTb->mailExport($idTicket, $comment);
        $this->email->add([
            'ticket_id' => $idTicket,
            'ticket_code' => $ticketNew['ticket_detail']['ticket_code'],
            'from_address' => 'admin@gmail.com',
            'to_address' => $sendToCus,
            'subject' => '[' . $ticketNew['ticket_detail']['ticket_code'] . '][' . $ticketNew['ticket_detail']['ticket_status_name'] . '] ' . $ticketNew['ticket_detail']['ticket_title'],
            'body_html' => $listMail['user_mail'],
            'date_created' => Carbon::now(),
            'date_modified' => Carbon::now(),
            'is_sent' => 0
        ]);
    }

    public function sendMail($keyChange, $ticketNew, $create = 0, $ticketOld = [])
    {
        $mailCusTrigger = [
            'customer_service_id',
            'ticket_status_value',
            'description'
        ];
        $mailStaffTrigger = [
            'customer_service_id',
            'ticket_status_value',
            'description',
            'queue_process_id',
            'type'
        ];
        $csCheck = array_intersect($keyChange, $mailCusTrigger);
        $csCheck = array_values($csCheck);
        $staffCheck = array_intersect($keyChange, $mailStaffTrigger);
        $staffCheck = array_values($staffCheck);
        $sendTo = [];
        $sendToCus = null;
        $userTicket = [];
        if (count($ticketNew['ticket_processors']) > 0) {
            // send to proccessor
            // $sendTo[] =
            foreach ($ticketNew['ticket_processors'] as $value) {
                $proId = $value['ticket_processor_id'];
                $processBy = $this->ticketProcessor->getDetail($proId)['process_by'];
                $sendTo[] = $this->staff->getEmailById($processBy);
            }
        } else {
            // send to queue
            $queueId = $ticketNew['ticket_detail']['queue_process_id'];
            $detailQueue = $this->queue->getDetai($queueId);
            $sendTo[] = $detailQueue['email_address'];
        }
        if (count($csCheck) > 0) {
            $userTicket = $this->customer->detailAcc($ticketNew['ticket_detail']['customer_account_id']);
            $sendToCus = $userTicket['customer_email'];
        }
        if (count($staffCheck) > 0) {
            if (in_array('queue_process_id', $keyChange)) {
                if (in_array('ticket_processor_id', $keyChange)) {
                    //  get previous proccessor mail
                    foreach ($ticketOld['ticket_processors'] as $value) {
                        $proId = $value['ticket_processor_id'];
                        $processBy = $this->ticketProcessor->getDetail($proId)['process_by'];
                        $sendTo[] = $this->staff->getEmailById($processBy);
                    }
                } else {
                    // get previous queue mail
                    $queueId = $ticketOld['ticket_detail']['queue_process_id'];
                    $detailQueue = $this->queue->getDetai($queueId);
                    $sendTo[] = $detailQueue['email_address'];
                }
            }
        }
        $listMail = $this->ticketTb->mailExport($ticketNew['ticket_detail']['ticket_id']);
        if (isset($sendToCus) && ($ticketNew['ticket_detail']['type'] != STAFF_DEPLOY || $ticketNew['ticket_detail']['ticket_status_value'] == STATUS_TICKET_DONE)) {
            // create email log for customer
            $this->email->add([
                'ticket_id' => $ticketNew['ticket_detail']['ticket_id'],
                'ticket_code' => $ticketNew['ticket_detail']['ticket_code'],
                'from_address' => 'admin@gmail.com',
                'to_address' => $sendToCus,
                'subject' => '[' . $ticketNew['ticket_detail']['ticket_code'] . '][' . $ticketNew['ticket_detail']['ticket_status_name'] . '] ' . $ticketNew['ticket_detail']['ticket_title'],
                'body_html' => $listMail['user_mail'],
                'date_created' => Carbon::now(),
                'date_modified' => Carbon::now(),
                'is_sent' => 0
            ]);
        }
        if (count($sendTo) != 0) {
            // create mail log for staff
            foreach ($sendTo as $toEmail) {
                $this->email->add([
                    'ticket_id' => $ticketNew['ticket_detail']['ticket_id'],
                    'ticket_code' => $ticketNew['ticket_detail']['ticket_code'],
                    'from_address' => 'admin@gmail.com',
                    'to_address' => $toEmail,
                    'subject' => '[' . $ticketNew['ticket_detail']['ticket_code'] . '][' . $ticketNew['ticket_detail']['ticket_status_name'] . '] ' . $ticketNew['ticket_detail']['ticket_title'],
                    'body_html' => $listMail['employee_mail'],
                    'date_created' => Carbon::now(),
                    'date_modified' => Carbon::now(),
                    'is_sent' => 0
                ]);
            }
        }
    }

    /**
     * Cập nhật ticket
     *
     * @param array $data
     * @return array|mixed
     * @throws \MyCore\Api\ApiException
     */
    public function edit(array $data)
    {
        if (isset($data['date_estimated'])) {
            $data['date_estimated'] = str_replace('/', '-', $data['date_estimated']);
            $data['date_estimated'] = date('Y-m-d  H:i', strtotime($data['date_estimated']));
        }

        $ticketOld = $this->getDetail($data['ticket_id']);

        //Notify khi update ticket.
        $notificationTable = new NotificationTable();
        $ticketNotify = $notificationTable->getNotificationByCategory($data['ticket_id'], 1);
        $dataNotifyLog = [];
        if (isset($data['operate_by']) && $data['operate_by'] != $ticketOld['ticket_detail']['operate_by']) {
            //Nếu thay đổi nhân viên chủ trì thì gửi notify.
            //Log nhân viên chủ trì.
            $dataNotifyLog[] = [
                'notification_id' => $ticketNotify['notification_id'],
                'user_id' => $data['operate_by'],
                'date_created' => date('Y-m-d H:i:s'),
                'is_read' => 0,
                'is_deleted' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),

            ];
        }
        $process_by_list = $data['process_by_list'] ?? [];
        //Xóa các nhân viên xử lý không bị thay đổi, chỉ gửi notify cho các nhân viên mới.
        if (isset($ticketOld['ticket_processors'])) {
            foreach ($ticketOld['ticket_processors'] as $item) {
                foreach ($process_by_list as $key => $value) {
                    if ($item['process_by'] == $value) {
                        unset($process_by_list[$key]);
                    }
                }
            }
        }

        if (count($process_by_list) > 0) {
            foreach ($process_by_list as $key => $value) {
                //Nếu thay đổi nhân viên xử lý thì gửi notify.
                //Log nhân viên xử lý.
                $dataNotifyLog[] = [
                    'notification_id' => $ticketNotify['notification_id'],
                    'user_id' => $value,
                    'date_created' => date('Y-m-d H:i:s'),
                    'is_read' => 0,
                    'is_deleted' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),

                ];
            }
        }

        //Lưu log notify.
        $notificationLogTable = new NotificationLogTable();
        $notificationLogTable->addInsert($dataNotifyLog);

        ////
        $data['modified_by'] = Auth::id();
        $result = $this->ticket->edit($data);
        if ($result) {
            // email_attack_here
            $ticketNew = $this->getDetail($data['ticket_id']);
            $keyChange = [];
            foreach ($ticketOld['ticket_detail'] as $key => $value) {
                if ($ticketNew['ticket_detail'][$key] != $value) {
                    $keyChange[] = $key;
                }
            }
            $oldProcessors = $ticketOld['ticket_processors'];
            $newProcessors = $ticketNew['ticket_processors'];
            $getKey = function ($v) {
                return $v['ticket_processor_id'];
            };
            $oldProcessors = array_map($getKey, $oldProcessors);
            $newProcessors = array_map($getKey, $newProcessors);
            sort($oldProcessors);
            sort($newProcessors);
            if ($oldProcessors != $newProcessors) {
                $keyChange[] = 'ticket_processor_id';
            }
            if (count($keyChange) > 0) {
                $this->sendMail($keyChange, $ticketNew, 0, $ticketOld);
            }
            return [
                'error' => 0,
                'message' => __('ticket::ticket.info.update_success'),
                'data' => $result,
            ];
        }

        return [
            'error' => 1,
//            'message' => __('ticket::ticket.info.update_failed'),
            'data' => $result,
            'message' => 'error api'
        ];
    }

    /**
     * Lấy chi tiết ticket
     *
     * @param int $ticketId
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getDetail($ticketId)
    {
        $detail = $this->ticket->getDetail(['ticket_id' => $ticketId]);
        if (count($detail) > 0) {
            return $detail;
        }

        return null;
    }

    /**
     * Lấy chi tiết ticket
     *
     * @param int $ticketId
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getDetailByCustomerId($customer_service_id)
    {
        $detail = $this->ticket->getDetailByCustomerId(['customer_service_id' => $customer_service_id]);
        if (count($detail) > 0) {
            return $detail;
        }

        return null;
    }

    /**
     * Upload file
     *
     * @param $filter
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function uploadFile($filter)
    {
        $data = $this->ticket->uploadFile([
            'name' => 'upload_file',
            'contents' => fopen($filter->path(), 'r'),
            'filename' => $filter->getClientOriginalName(),
        ]);

        return $data;
    }

    /**
     * Thêm comment
     *
     * @param array $data
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function postComment(array $data)
    {
        $dataComment = [
            'ticket_id' => $data['ticket_id'],
            'comment_object_type' => 'staff',
            'comment_object_id' => Auth::id(),
            'comment_content' => strip_tags($data['comment_content']),
        ];
        if (isset($data['upload_file']) && count($data['upload_file']) > 0) {
            foreach ($data['upload_file'] as $path) {
                $dataComment['ticket_file'][] = [
                    'path' => $path,
                ];
            }
        }
        $result = $this->ticketComment->postComment($dataComment);
        $ticket = $this->getDetail($result['ticket_id']);
        $type = $ticket['ticket_detail']['type'];


        if (count($result) > 0){
            if($type != 'staff_deploy') {
                $this->sendMailPostComment($result);

            }
            return [
                'error' => 0,
                'message' => __('ticket::ticket.info.comment_success'),
                'data' => $result
            ];
        }

        return [
            'error' => 1,
            'message' => 'error api',
            'data' => null
        ];
    }

    /**
     * Lấy danh sách ticket status
     *
     * @param array $filters
     * @return mixed|null
     * @throws \MyCore\Api\ApiException
     */
    public function getTicketStatus(array $filters = [])
    {
        $result = $this->ticket->getTicketStatus($filters);

        if (count($result) > 0) {
            return $result;
        }

        return null;
    }

    /**
     * Lấy danh sách lịch sử ticket
     *
     * @param int $ticketId
     * @return mixed
     */
    public function getListHistory($ticketId)
    {
        $oTicketHistory = app(TicketProcessHistoryRepositoryInterface::class);
        $result = $oTicketHistory->getList(['portal_ticket_process_history$ticket_id' => $ticketId]);

        return $result;
    }

    public function getTicketFile(array $param = [])
    {
        return $this->ticket->getTicketFile($param);
    }

    /**
     * function get survey ticket
     */
    public function getSurvey($ticket_id)
    {
        return $this->ticketTb->getSurvey($ticket_id);
    }

    /**
     *get list ticket check date
     */
    public function detailTicketCheckDate()
    {
        $result = $this->ticketTb->detailTicketCheckDate();

        $result = array_filter($result, function($current){
            // dd($current['date_estimated']);
            $sample = $this->email->getByTicketId($current['ticket_id'], $current['date_estimated']);
            return count($sample->toArray()) == 0;
        });
        foreach ($result as $comment) {
            $idTicket = $comment['ticket_id'];
            $ticketNew = $this->getDetail($idTicket);
            $sendTo = [];
            $sendTo[] = $comment['queue_email'];
            if (isset($ticketNew['ticket_detail']['ticket_code']) && $ticketNew['ticket_detail']['ticket_code'] != null ) {
                foreach ($ticketNew['ticket_processors'] as $value) {
                    $proId = $value['ticket_processor_id'];
                    $processBy = $this->ticketProcessor->getDetail($proId)['process_by'];
                    $sendTo[] = $this->staff->getEmailById($processBy);
                }
                $listMail = $this->ticketTb->mailExport($idTicket);
                $dataInsert['ticket_id'] = $idTicket;
                $dataInsert['ticket_code'] = $ticketNew['ticket_detail']['ticket_code'];
                $dataInsert['from_address'] = 'admin@gmail.com';
                $dataInsert['cc_address'] = null;
                $dataInsert['sent_email'] = null;
                $dataInsert['subject'] = '[' . $ticketNew['ticket_detail']['ticket_code'] . '][QUÁ HẠN] ' . $ticketNew['ticket_detail']['ticket_title'];
                $dataInsert['body_html'] = $listMail['mail_warning'];
                $dataInsert['body'] = null;
                $dataInsert['file_attach'] = null;
                $dataInsert['sent_by'] = null;
                $dataInsert['date_created'] = Carbon::now();
                $dataInsert['date_modified'] = Carbon::now();
                $dataInsert['date_overtime'] = $comment['date_estimated'];
                $dataInsert['is_sent'] = 0;
                foreach($sendTo as $email){
                    $dataInsert['to_address'] = $email;
                    $this->email->add($dataInsert);
                }
            }
        }

        return [
            'error' => false,
            'message' => __('ticket::validation.ticket.add_success'),
        ];
    }
}
