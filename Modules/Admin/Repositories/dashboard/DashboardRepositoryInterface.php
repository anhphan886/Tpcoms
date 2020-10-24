<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 12/25/2019
 * Time: 11:53 AM
 */

namespace Modules\Admin\Repositories\dashboard;


interface DashboardRepositoryInterface
{
    public function getQuantitiesHead();

    public function listOder(array $filters = []);

    public function listCustomer(array $filters = []);

    public function getOrderByMonthYear(array $filters = []);

    public function getTopService(array $filters = []);

    public function getOrderByStatus(array $filters = []);

    public function listServiceExpire(array $filters = []);

    public function listReceipt(array $filters = []);

    public function listInvoice(array $filters = []);

    public function listAmountReceipt(array $filters = []);
}