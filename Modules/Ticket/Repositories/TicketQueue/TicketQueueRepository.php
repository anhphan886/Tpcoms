<?php

namespace Modules\Ticket\Repositories\TicketQueue;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Ticket\Http\Api\TicketQueueApi;
use Illuminate\Support\Facades\Auth;
use Modules\Ticket\Models\TicketQueueTable;
use Modules\Ticket\Models\TiketStaffQueueTable;
use Illuminate\Support\Facades\Hash;

class TicketQueueRepository implements TicketQueueRepositoryInterface
{
    private $ticketQueue;

    private $queueStaff;
    /**
     * @var TicketQueueApi
     */
    private $ticketQueueApi;

    public function __construct(
        TicketQueueTable $ticketQueue,
        TicketQueueApi $ticketQueueApi,
        TiketStaffQueueTable $queueStaff
    )
    {
        $this->ticketQueue = $ticketQueue;
        $this->ticketQueueApi = $ticketQueueApi;
        $this->queueStaff = $queueStaff;
    }

    /**
     * Lấy danh sách queue có phân trang
     *
     * @param array $fi lters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $filters = [])
    {
        if (isset($filters['keyword_ticket_queue$date_created'])){
            $filters['keyword_ticket_queue$date_created'] =
                str_replace('/', '-', $filters['keyword_ticket_queue$date_created']);
            $filters['keyword_ticket_queue$date_created'] =
                date('Y-m-d', strtotime($filters['keyword_ticket_queue$date_created']));
        }

        $result = $this->ticketQueue->getList($filters);

        return $result;
    }

    /**
     * Lấy danh sách queue không phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getListAll(array $filters = [])
    {
        return $this->ticketQueue->getListAll($filters);

//        if (!$result['Result']['ErrorCode']) {
//            return $result['Result']['Data'];
//        }
//
//        return null;
    }

    /**
     * Lấy danh sách queue kèm theo danh sách ticket
     *
     * @return array
     * @throws \MyCore\Api\ApiException
     */
    public function getListWithTicket()
    {
        $result = $this->ticketQueueApi->getListWithTicket();
        if ($result) {
            return $result;
        }

        return null;
    }

    /**
     * Lấy danh sách nhân viên theo queue
     *
     * @param int $queueId
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getListStaffByQueue($queueId)
    {
        $result = $this->ticketQueueApi->getListStaffByQueue(['queue_id' => $queueId]);

        if ($result) {
            $data = $result;
            $rs = [];
            if (count($data) > 0) {
                foreach ($data as $item) {
                    $rs[$item['role']][] = $item;
                }
            }

            return $rs;
        }

        return null;
    }

    /**
     * Thêm queue
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
//        dd($data);
        try {
            DB::beginTransaction();
            $dataQueue = [
                'queue_name' => strip_tags($data['queue_name']),
                'description' => strip_tags($data['description']),
                'email_address' => strip_tags($data['email_address']),
                'email_password' => Hash::make($data['email_password']),
                'date_created' => date('Y-m-d H:i:s'),
                'date_modified' => date('Y-m-d H:i:s'),
                'created_by' => Auth::id(),
                'modified_by' => Auth::id(),
                'is_deleted' => 0,
            ];
            $result = $this->ticketQueue->add($dataQueue);

            if (isset($data['staff_operator'])) {
                foreach ($data['staff_operator'] as $staff => $staff_operator ) {
                    $dataStaff = [
                        'staff_id' =>$staff_operator,
                        'queue_id' => $result,
                        'role' => 'operator'
                    ];
                    $rs = $this->queueStaff->addStaff($dataStaff);
                }
            };
            if (isset($data['staff_processor'])) {
                foreach ($data['staff_processor'] as $staff => $staff_processor ) {
                    $dataStaff = [
                        'staff_id' =>$staff_processor,
                        'queue_id' => $result,
                        'role' => 'processor'
                    ];
                    $rs = $this->queueStaff->addStaff($dataStaff);
                }
            };
            DB::commit();
            return [
                'error' => false,
                'message' => __('ticket::queue.info.create_success'),
                'data' => $result
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => true,
//                'message' => __('ticket::queue.info.create_failed'),
                'message' => $e->getMessage(),
                'data' => null,
            ];
        }
    }

    /**
     * chỉnh sữa queue
     *
     *@param array $data
     * @param int $ticket_queue_id
     * @return mixed
    */
    public function edit(array $data, $ticket_queue_id){
//        dd($data);
        try{
            DB::beginTransaction();
            $dataQueue = [
                'queue_name' => strip_tags($data['queue_name']),
                'description' => strip_tags($data['description']),
                'email_address' => $data['email_address'],
                'date_modified' => date('Y-m-d H:i:s'),
                'modified_by' => Auth::id(),
                'is_deleted' => 0
            ];

            $result = $this->ticketQueue->edit($dataQueue, $ticket_queue_id);
            $this->queueStaff->deleteStaffByQueue($ticket_queue_id);

            if (isset($data['staff_operator'])) {
//                dd($data['staff_operator']);
                foreach ($data['staff_operator'] as $staff => $staff_operator ) {
                    $dataStaff = [
                        'staff_id' =>$staff_operator,
                        'queue_id' => $ticket_queue_id,
                        'role' => 'operator'
                    ];
//                    dd($dataStaff);
                    $rs = $this->queueStaff->addStaff($dataStaff);
                }
            };
            if (isset($data['staff_processor'])) {
                foreach ($data['staff_processor'] as $staff => $staff_processor ) {
                    $dataStaff = [
                        'staff_id' =>$staff_processor,
                        'queue_id' => $ticket_queue_id,
                        'role' => 'processor'
                    ];
                    $rs = $this->queueStaff->addStaff($dataStaff);
                }
            };
            DB::commit();
            return [
                'error' => 0,
                'message'  => __('ticket::queue.info.edit_success'),
                'data' => $result,
            ];
        }catch (\Exception $e){
            DB::rollBack();
            return[
//                'ticket_queue_id' => $ticket_queue_id,
                'eeeee' => $e->getMessage(),
                'error' => 1,
                'message' => __('ticket::queue.info.edit_failed'),
            ];
        }
    }

    /**
     * Lấy thông tin chi tiết Queue
     *
     * @param int $ticket_queue_id
     * @return mixed
     */
    public function getDetai($ticket_queue_id)
    {
        return $this->ticketQueue->getDetai($ticket_queue_id);
    }

    /**
     * deleted queue
     *
     * @param int $ticket_queue_id
     * @return mixed
     */
    public  function  destroy($ticket_queue_id)
    {
        try {
            $dataQueue =[
                'is_deleted' => 1,
            ];
            $result = $this->ticketQueue->edit($dataQueue, $ticket_queue_id);

            return [
              'error' =>0,
              'message' => 'Xoá thành công',
              'data' => $result,
            ];
        } catch (\Exception $e) {
            return [
                'error' => 1,
                'massage' =>$e->getMessage(),
            ];
        }
    }

    public function getListAllStaffQueue()
    {
        $result = $this->queueStaff->getListAll();
        return $result;
    }

//
}
