<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 12/25/2019
 * Time: 11:53 AM
 */

namespace Modules\Admin\Repositories\Notification;


interface NotificationRepositoryInterface
{
    public function addNotification();

    public function addNotificationLog();

    public function getNotificationByUser();

    public function isReadNotification($id);

    public function isReadAllNotification(array $data = []);
}