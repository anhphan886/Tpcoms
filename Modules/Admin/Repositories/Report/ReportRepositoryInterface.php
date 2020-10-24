<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 12/25/2019
 * Time: 11:53 AM
 */

namespace Modules\Admin\Repositories\Report;


interface ReportRepositoryInterface
{
    public function getOrderByStatus(array $filters = []);

    public function getTopService(array $filters = []);

    public function receiptChart(array $filters = []);

    public function customerChart(array $filters = []);

    public function customerOption();

    public function debtChart(array $filters = []);

    public function segmentOption();

    public function customerRevenueChart(array $filters = []);

    public function productOption();

    public function serviceRevenueChart(array $filters = []);

    public function exportExcelCustomerRevenue();

    public function exportExcelServiceRevenue();

    public function aggregateRevenueChart(array $filters = []);
    public function exportExcelInvoice($choose_day);
}