<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Modules\Admin\Repositories\Notification\NotificationRepositoryInterface;

class NotificationController extends Controller
{
    protected $notification;

    public function __construct(NotificationRepositoryInterface $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Thêm thông báo
     * @return mixed
     */
    public function addNotification()
    {
        $result = $this->notification->addNotification();
        return $result;
    }

    /**
     * Thêm log noti
     * @return mixed
     */
    public function addNotificationLog()
    {
        $result = $this->notification->addNotificationLog();
        return $result;
    }

    /**
     * Get noti by user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotificationByUser()
    {
        $result = $this->notification->getNotificationByUser();

        return response()->json($result);
    }

    /**
     * Đọc 1 tin.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function isReadNotification(Request $request)
    {
        $id = $request->notification_log_id;
        $result = $this->notification->isReadNotification($id);
        return response()->json($result);
    }
    /**
     * Đọc 1 tin.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function isReadAllNotification(Request $request)
    {
        $id = $request->arrNoti;
        $result = $this->notification->isReadAllNotification($id);
        return response()->json($result);
    }
}
