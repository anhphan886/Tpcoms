<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 1/16/2020
 * Time: 2:58 PM
 */

namespace Modules\Admin\Repositories\Notification;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Models\NotificationLogTable;
use Modules\Admin\Models\NotificationTable;
use Modules\Admin\Models\TicketTable;
use Modules\Ticket\Models\TiketStaffQueueTable;

class NotificationRepository implements NotificationRepositoryInterface
{
    protected $notification;
    protected $ticket;
    protected $notificationLog;
    protected $staffQueue;

    public function __construct(
        NotificationTable $notification,
        TicketTable $ticket,
        NotificationLogTable $notificationLog,
        TiketStaffQueueTable $staffQueue
    )
    {
        $this->notification = $notification;
        $this->ticket = $ticket;
        $this->notificationLog = $notificationLog;
        $this->staffQueue = $staffQueue;
    }

    /**
     * Thêm dữ liệu vào noti và noti log.
     * @return array
     */
    public function addNotification()
    {
        try {
            DB::beginTransaction();
            $lastNotification = $this->notification->getLastRecord();
            $count = 0;
            //Nếu chưa có noti
            //Thêm noti ticket
            if ($lastNotification == null) {
                $allTicket = $this->ticket->getTicket([]);
                $data = [];
                if (count($allTicket) > 0) {
                    foreach ($allTicket as $item) {
                        $data[] = [
                            'notification_category_id' => 1,
                            'object_id' => $item['ticket_id'],
                            'created_by' => Auth::id(),
                            'is_deleted' => 0,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'title' => $item['ticket_code'] . ' - ' . $item['ticket_title'],
                            'object_code' => $item['ticket_code'],
                            'object_datetime' => $item['date_created'],
                        ];
                        $count++;
                    }
                }
                $this->notification->addInsert($data);
            } else {
                //Đã có noti rồi thì lấy thời gian cuối cùng.
                $getTicket = $this->ticket->getTicket(['created_at' => $lastNotification['created_at']]);
                $data = [];
                if (count($getTicket) > 0) {
                    foreach ($getTicket as $item) {
                        $data[] = [
                            'notification_category_id' => 1,
                            'object_id' => $item['ticket_id'],
                            'created_by' => Auth::id(),
                            'is_deleted' => 0,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'title' => $item['ticket_code'] . ' - ' . $item['ticket_title'],
                            'object_code' => $item['ticket_code'],
                            'object_datetime' => $item['date_created'],
                        ];
                        $count++;
                    }
                }
                $this->notification->addInsert($data);
            }
            // Log noti
            $notificationTicket = $this->notification->getNotification(1);
            $arrTicketId = [];
            if (count($notificationTicket) > 0) {
                foreach ($notificationTicket as $item) {
                    $arrTicketId[] = $item['object_id'];
                }
            }

            $filters = [
                'array_ticket_id' => $arrTicketId,
                'array_ticket_type' => '',
            ];
            //Log người chủ trì
            $getOperateBy = $this->ticket->getTicket($filters);
            $data = [];
            $queueID = [];
            if (count($getOperateBy) > 0) {
                foreach ($getOperateBy as $item) {
                    $queueID[] = $item['queue_process_id'];
                    if ($item['notification_id'] != null && $item['operate_by'] != null) {
                        $data[] = [
                            'notification_id' => $item['notification_id'],
                            'user_id' => $item['operate_by'],
                            'date_created' => date('Y-m-d H:i:s'),
                            'is_read' => 0,
                            'is_deleted' => 0,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                    }
                }
            }
            //Log process by
            $filters['array_ticket_type'] = 'ticket_process';
            $getProcessBy = $this->ticket->getTicket($filters);
            if (count($getProcessBy) > 0) {
                foreach ($getProcessBy as $item) {
                    if ($item['notification_id'] != null && $item['operate_by'] != null) {
                        $data[] = [
                            'notification_id' => $item['notification_id'],
                            'user_id' => $item['process_by'],
                            'date_created' => date('Y-m-d H:i:s'),
                            'is_read' => 0,
                            'is_deleted' => 0,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                    }
                }
            }

            $this->notificationLog->addInsert($data);

//            $filters = [
//                'array_ticket_id' => $arrTicketId,
//                'array_ticket_type' => '',
//            ];
//            $getOperateBy = $this->ticket->getTicket($filters);
//            $data1 = [];
//            $queueID = [];
//            if (count($getOperateBy) > 0) {
//                foreach ($getOperateBy as $item) {
//                    $staffQueue = $this->staffQueue->getOperatorByID($item['queue_process_id']);
//                    foreach ($staffQueue as $k) {
//                        if ($item['notification_id'] != null && $item['operate_by'] != null) {
//                            $data1[] = [
//                                'notification_id' => $item['notification_id'],
//                                'user_id' => $k['staff_id'],
//                                'date_created' => date('Y-m-d H:i:s'),
//                                'is_read' => 0,
//                                'is_deleted' => 0,
//                                'created_at' => date('Y-m-d H:i:s'),
//                                'updated_at' => date('Y-m-d H:i:s'),
//                            ];
//                        }
//                        $this->notificationLog->addInsert($data1);
//                    }
//                }
//            }
            DB::commit();
            return [
                'count' => $count,
                'error' => false,
                'message' => 'Success!',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'count' => 0,
                'error' => true,
                'message' => __('product::validation.product.edit_fail'),
                'aaaa' => $e->getMessage(),
            ];
        }
    }

    /**
     * Thêm vào notilog
     * @return array
     */
    public function addNotificationLog()
    {
        try {
            DB::beginTransaction();


            DB::commit();
            return [
                'count' => count(0),
                'error' => false,
                'message' => 'Success!',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'count' => 0,
                'error' => true,
                'message' => __('product::validation.product.edit_fail'),
            ];
        }
    }

    /**
     * Danh sách noti theo user
     * @return mixed
     */
    public function getNotificationByUser()
    {
        $filters = [
            'user_id' => Auth::id(),
            'is_admin' => Auth::user()->is_admin,
        ];
        $getLog = $this->notificationLog->getLog($filters);
        return $getLog;
    }

    /**
     * Đọc 1 thông báo
     * @param $id
     *
     * @return array
     */
    public function isReadNotification($id)
    {
        $data = [
            'is_read' => 1,
            'date_read' => date('Y-m-d H:i:s'),
        ];
        $this->notificationLog->edit($data, $id);
        return [
            'error' => false,
            'message' => 'Success!',
        ];
    }

    /**
     * View all noti
     * @param array $data
     *
     * @return array
     */
    public function isReadAllNotification(array $data = [])
    {
        foreach ($data as $key => $value) {
            $dataField = [
                'is_read' => 1,
                'date_read' => date('Y-m-d H:i:s'),
            ];
            $this->notificationLog->edit($dataField, $value);
        }
        return [
            'error' => false,
            'message' => 'Success!',
        ];
    }
}
