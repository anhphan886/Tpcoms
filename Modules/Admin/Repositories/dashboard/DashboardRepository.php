<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 12/25/2019
 * Time: 11:53 AM
 */

namespace Modules\Admin\Repositories\dashboard;

use Carbon\Carbon;
use Modules\Admin\Models\CustomerServiceTable;
use Modules\Admin\Models\CustomerTable;
use Modules\Admin\Models\InvoiceTable;
use Modules\Admin\Models\OrderStatusTable;
use Modules\Admin\Models\OrderTable;
use Modules\Admin\Models\ReceiptDetailTable;
use Modules\Admin\Models\ReceiptTable;
use Modules\Admin\Models\TicketTable;

class DashboardRepository implements DashboardRepositoryInterface
{
    protected $order;
    protected $customer;
    protected $customerService;
    protected $ticket;
    protected $orderStatus;
    protected $receipt;
    protected $invoice;

    public function __construct(
        OrderTable $order,
        CustomerTable $customer,
        CustomerServiceTable $customerService,
        TicketTable $ticket,
        OrderStatusTable $orderStatus,
        ReceiptTable $receipt,
        InvoiceTable $invoice
    ) {
        $this->order = $order;
        $this->customer = $customer;
        $this->customerService = $customerService;
        $this->ticket = $ticket;
        $this->orderStatus = $orderStatus;
        $this->receipt = $receipt;
        $this->invoice = $invoice;
    }

    /**
     * Lấy header
     * @return array
     */
    public function getQuantitiesHead()
    {
        $result = [];
        $date = Carbon::now()->format('Y-m-d');
        $filters = ['date' => $date];
        //Số lượng order trong ngày
        $result['order'] = $this->order->getOrdersCount($filters);
        //Số lượng customer đăng ký trong ngày
        $result['customer'] = $this->customer->getCustomerCount($filters);
        //Số lượng dịch vụ sắp hết hạn trong 30 ngày tới.
        $dateAdd = Carbon::now()->addDays(30)->format('Y-m-d');
        $filters['expired_date'] = $dateAdd;
        $result['service'] = $this->customerService->getServiceExpired($filters);
        //Số lượng ticket hỗ trợ trong ngày
        $result['ticket'] = $this->ticket->getTicketCount($filters);
        //Số lượng receipt được tạo trong ngày
        $result['receipt'] = $this->receipt->getCount($filters);
        //Số lượng invoice cần xuất trong ngày
        $result['invoice'] = $this->invoice->getCountNeedExport($filters);

        return $result;
    }

    /**
     * Danh sách đơn hàng trong ngày.
     * @param array $filters
     *
     * @return mixed
     */
    public function listOder(array $filters = [])
    {
        $date = Carbon::now()->format('Y-m-d');
        $filters['date'] = $date;
        return $this->order->getListDataTable($filters);
    }
    /**
     * Danh sách customer trong ngày.
     * @param array $filters
     *
     * @return mixed
     */
    public function listCustomer(array $filters = [])
    {
        $date = Carbon::now()->format('Y-m-d');
        $filters['date'] = $date;
        return $this->customer->getListDataTable($filters);
    }

    public function getOrderByMonthYear(array $param = [])
    {
        $year = Carbon::now()->year;

        $column = [];

        if (isset($param['year']) !=''){
            $year =  $param['year'];
        }

        if (isset($param['month']) && $param['month'] != ''){
            /// chon thang
            $month =  $param['month'];
            $days = Carbon::createFromDate($year,$month);
            for ($i = 1; $i <= $days->daysInMonth; $i++) {
                $column[] = [
                    'month'=>$i.'/'.$month,
                    'order'=> $this->order->getOrderByDateMonth($i,$month,$year)
                ];
            }

        } else {
            /// khong chon thang
            for ($i = 1; $i <= 12; $i++) {
                $day = Carbon::now()->month($i);
                $column[] = [
                    'month'=>$day->format('m'),
                    'order'=> $this->order->getOrderByMonthYear($i,$year)
                ];
            }
        }
        return $column;
    }

    /**
     *
     * @param array $param
     */
    public function getTopService(array $param = [])
    {
        $date = Carbon::now()->format('Y-m-d');

        $fromDate = $date.' 00:00:00';
        $toDate = $date.' 23:59:59';
        if (isset($param["choose_day"])) {
            if ($param["choose_day"] != '') {
                $arr_filter = explode(" - ", $param["choose_day"]);
                $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])->format('Y-m-d');
                $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])->format('Y-m-d');
                $fromDate = $startTime.' 00:00:00';
                $toDate = $endTime.' 23:59:59';
            }
        }
        $arrDate = [$fromDate,$toDate];
        $result = $this->order->getTopService($arrDate);
        return $result;
    }

    public function getOrderByStatus(array $param = [])
    {
        $column = [];

        $orderStatus = $this->orderStatus->option();

        if (count($orderStatus) > 0) {
            $date = Carbon::now()->format('Y-m-d');

            $fromDate = $date.' 00:00:00';
            $toDate = $date.' 23:59:59';
            if (isset($param["choose_day"])) {
                if ($param["choose_day"] != '') {
                    $arr_filter = explode(" - ", $param["choose_day"]);
                    $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])->format('Y-m-d');
                    $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])->format('Y-m-d');
                    $fromDate = $startTime.' 00:00:00';
                    $toDate = $endTime.' 23:59:59';
                }
            }
            $dateTime = [$fromDate, $toDate];

            foreach ($orderStatus as $item) {
                if ($item['order_status_id'] != 3 && $item['order_status_id'] != 5) {
                    $color = '';
                    if ($item['order_status_id'] == 1) {
                        $color = '#08c900';
                    } elseif ($item['order_status_id'] == 2) {
                        $color = '#0e58c9';
                    } elseif ($item['order_status_id'] == 4) {
                        $color = '#00bac9';
                    }
                    $column[] = [
                        'status' => $item[getValueByLang('order_status_name_')],
                        'quantity' => $this->order->getOrderByStatus($item['order_status_id'], $dateTime),
                        'color'   => $color
                    ];
                }
            }
        }

        return $column;
    }

    /**
     * Danh sách đơn hàng trong ngày.
     * @param array $filters
     *
     * @return mixed
     */
    public function listServiceExpire(array $filters = [])
    {
        $date = Carbon::now()->format('Y-m-d');
        $filters['date'] = $date;
        if ($filters['type'] == 'expire_day') {
            $fromDate = $date;
            $toDate = Carbon::now()->addDays($filters['day'])->format('Y-m-d');
            $filters['date'] = [$fromDate, $toDate];
            unset($filters['day']);
        }
        $result = $this->customerService->getListDataTable($filters);
        return $result;
    }

    /**
     * Danh sách phiếu thu trong ngày.
     * @param array $filters
     *
     * @return mixed
     */
    public function listReceipt(array $filters = [])
    {
        $date = Carbon::now()->format('Y-m-d');
        $filters['date'] = $date;
        return $this->receipt->getListDataTable($filters);
    }

    /**
     * Danh sách hóa đơn cần xuất trong ngày.
     * @param array $filters
     *
     * @return mixed
     */
    public function listInvoice(array $filters = [])
    {
        $date = Carbon::now()->format('Y-m-d');
        $filters['date'] = $date;
        return $this->invoice->getListDataTable($filters);
    }

    public function listAmountReceipt(array $receiptId = [])
    {
        $receiptDetail = new ReceiptDetailTable();
        $result = $receiptDetail->listAmountReceipt($receiptId);

        return $result;
    }
}
