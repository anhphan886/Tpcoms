<?php

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 12/25/2019
 * Time: 11:53 AM
 */

namespace Modules\Admin\Repositories\Report;

use Carbon\Carbon;
use Modules\Admin\Models\CustomerServiceTable;
use Modules\Admin\Models\CustomerTable;
use Modules\Admin\Models\InvoiceTable;
use Modules\Admin\Models\OrderStatusTable;
use Modules\Admin\Models\OrderTable;
use Modules\Admin\Models\ReceiptDetailTable;
use Modules\Admin\Models\ReceiptTable;
use Modules\Admin\Models\SegmentTable;
use Modules\Admin\Models\TicketTable;
use Modules\Admin\Repositories\Report\ReportRepositoryInterface;
use Modules\Product\Repositories\Receipt\ReceiptRepositoryInterface;
use Modules\Product\Models\ProductTable;
use Maatwebsite\Excel\Excel;
use App\Exports\EmailExport;

use Modules\Admin\Exports\InvoiceExport as ExportsInvoiceExport;
use Maatwebsite\Excel\Exporter;

class ReportRepository implements ReportRepositoryInterface
{
    protected $order;
    protected $customer;
    protected $customerService;
    protected $ticket;
    protected $orderStatus;
    protected $receipt;
    protected $receiptDetail;
    protected $excel;
    protected $invoice;
    protected $receiptRespo;
    protected $exporter;


    public function __construct(
        Exporter $exporter,
        OrderTable $order,
        CustomerTable $customer,
        CustomerServiceTable $customerService,
        TicketTable $ticket,
        OrderStatusTable $orderStatus,
        ReceiptTable $receipt,
        ReceiptDetailTable $receiptDetail,
        Excel $excel,
        InvoiceTable $invoice,
        ReceiptRepositoryInterface $receiptRespo
    ) {
        $this->exporter = $exporter;
        $this->order = $order;
        $this->customer = $customer;
        $this->customerService = $customerService;
        $this->ticket = $ticket;
        $this->orderStatus = $orderStatus;
        $this->receipt = $receipt;
        $this->receiptDetail = $receiptDetail;
        $this->excel = $excel;
        $this->invoice = $invoice;
        $this->receiptRespo = $receiptRespo;
    }

    /**
     * Lấy header
     *
     * @return array
     */
    public function getOrderByStatus(array $param = [])
    {
        $result = [];
        $column = [];
        $pie[] = ["Task", "Hours"];
        $orderStatus = $this->orderStatus->option();

        if (count($orderStatus) > 0) {
            $date = Carbon::now()->format('Y-m-d');

            $fromDate = $date . ' 00:00:00';
            $toDate = $date . ' 23:59:59';
            if (isset($param["choose_day"])) {
                if ($param["choose_day"] != '') {
                    $arr_filter = explode(" - ", $param["choose_day"]);
                    $startTime = Carbon::createFromFormat(
                        'd/m/Y',
                        $arr_filter[0]
                    )->format('Y-m-d');
                    $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])
                        ->format('Y-m-d');
                    $fromDate = $startTime . ' 00:00:00';
                    $toDate = $endTime . ' 23:59:59';
                }
            }
            $dateTime = [$fromDate, $toDate];

            foreach ($orderStatus as $item) {
                if ($item['order_status_id'] != 3) {
                    $color = '';
                    if ($item['order_status_id'] == 1) {
                        $color = '#08c900';
                    } elseif ($item['order_status_id'] == 2) {
                        $color = '#0e58c9';
                    } elseif ($item['order_status_id'] == 4) {
                        $color = '#00bac9';
                    } elseif ($item['order_status_id'] == 5) {
                        $color = '#FF0000';
                    }
                    $select = $this->order->getOrderByStatus(
                        $item['order_status_id'],
                        $dateTime
                    );
                    $column[] = [
                        'country' => $item[getValueByLang(
                            'order_status_name_'
                        )],
                        'visits'  => intval($select),
                        'color'   => $color
                    ];

                    $pie[] = [
                        $item[getValueByLang('order_status_name_')],
                        intval($select)
                    ];
                }
            }
        }
        if (count($column) == 0) {
            $result['chart'][] = [
                "country" => "",
                "visits"  => 0,
                'color'   => '#67B7DC'
            ];
        } else {
            $result['chart'] = $column;
        }
        $result['pie_chart_status'] = $pie;
        return $result;
    }

    /**
     * Báo cáo service
     *
     * @param array $param
     *
     * @return mixed
     */
    public function getTopService(array $param = [])
    {
        // Biểu đồ cột.
        $chart = [];
        $date = Carbon::now()->format('Y-m-d');

        $fromDate = $date . ' 00:00:00';
        $toDate = $date . ' 23:59:59';
        if (isset($param["choose_day"])) {
            if ($param["choose_day"] != '') {
                $arr_filter = explode(" - ", $param["choose_day"]);
                $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])
                    ->format('Y-m-d');
                $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])
                    ->format('Y-m-d');
                $fromDate = $startTime . ' 00:00:00';
                $toDate = $endTime . ' 23:59:59';
            }
        }
        $arrDate = [$fromDate, $toDate];

        //Truy vấn tổng tiền và số lượng sử dụng service.
        $select = $this->customerService->getTopServiceAll($arrDate);
        $count = count($select);
        if ($count > 0) {
            if ($count <= 6) {
                foreach ($select as $item) {
                    $chart[] = [
                        'country' => $item['name'],
                        'visits'  => intval($item['used']),
                        'color'   => '#67B7DC',
                    ];
                }
            } else {
                $limit = 0;
                $visits = 0;
                foreach ($select as $item) {
                    $limit++;
                    if ($limit <= 6) {
                        $chart[] = [
                            'country' => $item['name'],
                            'visits'  => intval($item['used']),
                            'color'   => '#67B7DC'
                        ];
                    } else {
                        $visits += intval($item['used']);
                    }
                }
                $chart[] = [
                    'country' => 'Khác',
                    'visits'  => $visits,
                    'color'   => '#67B7DC'
                ];
            }
        }
        if (count($chart) == 0) {
            $result['chart'][] = [
                "country" => "",
                "visits"  => 0,
                'color'   => '#67B7DC'
            ];
        } else {
            $result['chart'] = $chart;
        }

        //Tỉ lệ theo loại dịch vụ.
        $filters['date'] = $arrDate;
        $filters['type'] = 'type';
        $getByRatioType = $this->customerService->getByRatio($filters);
        $result['pie_chart_type'][] = ['Task', 'Hours'];
        if (count($getByRatioType) > 0) {
            foreach ($getByRatioType as $item) {
                $name = 'Dùng thử';
                if ($item['type'] == 'real') {
                    $name = 'Dùng thật';
                }
                $result['pie_chart_type'][] = [
                    $name,
                    intval($item['quantity'])
                ];
            }
        }

        //Tỉ lệ theo hình thức thanh toán.
        $filters['type'] = 'payment_type';
        $filters['type_real'] = 'real';
        $getByRatioPaymentType = $this->customerService->getByRatio($filters);
        unset($filters['type_real']);
        $result['pie_chart_pay'][] = ['Task', 'Hours'];
        if (count($getByRatioPaymentType) > 0) {
            foreach ($getByRatioPaymentType as $item) {
                $name = 'Trả trước';
                if ($item['payment_type'] == 'postpaid') {
                    $name = 'Trả sau';
                } elseif ($item['payment_type'] == 'payuse') {
                    $name = 'Dùng nhiêu trả nhiêu';
                }
                $result['pie_chart_pay'][] = [$name, intval($item['quantity'])];
            }
        }


        //Tỉ lệ theo status.
        $filters['type'] = 'status';
        $getByRatioStatus = $this->customerService->getByRatio($filters);
        $result['pie_chart_status'][] = ['Task', 'Hours'];
        if (count($getByRatioStatus) > 0) {
            foreach ($getByRatioStatus as $item) {
                $name = 'Chưa kích hoạt';
                if ($item['status'] == 'actived') {
                    $name = 'Đã kích hoạt';
                } elseif ($item['status'] == 'spending') {
                    $name = 'Đang sử dụng';
                } elseif ($item['status'] == 'cancel') {
                    $name = 'Đã hủy';
                }
                $result['pie_chart_status'][] = [
                    $name,
                    intval($item['quantity'])
                ];
            }
        }
        return $result;
    }

    /**
     * Báo cáo phiếu thu
     *
     * @param array $filters
     *
     * @return array
     */
    public function receiptChart(array $filters = [])
    {
        $result = [];
        $date = Carbon::now()->format('Y-m-d');
        $fromDate = $date . ' 00:00:00';
        $toDate = $date . ' 23:59:59';
        if (isset($filters["choose_day"])) {
            if ($filters["choose_day"] != '') {
                $arr_filter = explode(" - ", $filters["choose_day"]);
                $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])
                    ->format('Y-m-d');
                $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])
                    ->format('Y-m-d');
                $fromDate = $startTime . ' 00:00:00';
                $toDate = $endTime . ' 23:59:59';
            }
        }
        $arrDate = [$fromDate, $toDate];
        $filters['date'] = $arrDate;
        //Trạng thái đã thanh toán
        $filters['status'] = 'paid';
        $paid = $this->receipt->getAmountQuantity($filters);
        //Trạng thái chưa thanh toán
        $filters['status'] = 'unpaid';
        $unpaid = $this->receipt->getAmountQuantity($filters);
        //Trạng thái hoàn tiền
        $filters['status'] = 'refund';
        $refund = $this->receipt->getAmountQuantity($filters);
        //Trạng thái đã hủy
        $filters['status'] = 'cancel';
        $cancel = $this->receipt->getAmountQuantity($filters);


        //Trạng thái còn nợ. Phải tính số tiền còn nợ
        $filters['status'] = 'part-paid';
        $partPaid = $this->receipt->getAmountQuantity($filters);
        if ($partPaid[0]['quantity'] > 0) {
            //Danh sách phiếu thu status còn nợ
            $receiptPartPaid = $this->receipt->getAmountPartPaid($filters);
            //Nếu status còn nợ thì tính số tiền còn nợ.
            $moneyPaid = 0;
            if (count($receiptPartPaid) > 0) {
                $temp = [];
                foreach ($receiptPartPaid as $item) {
                    $temp[] = $item['receipt_id'];
                }
                //Tổng số tiền đã trả của các phiếu thu.
                $moneyPaid = intval($this->receiptDetail->amountReceipt($temp));
            }
            $partPaid[0]['amount'] = strval(
                intval($partPaid[0]['amount']) - $moneyPaid
            );
        }

        $arrayMerge = array_merge($paid, $unpaid, $partPaid, $refund, $cancel);
        $result['chart'] = $arrayMerge;
        //Tỉ lệ theo trạng thái
        $pieStatus[] = ['Task', 'Hours'];
        foreach ($arrayMerge as $item) {
            $pieStatus[] = [
                $item['status'], intval($item['amount'])
            ];
        }
        $result['pie_chart_status'] = $pieStatus;

        //Tỉ lệ theo hình thức thanh toán.
        $piePaymentType[] = ['Task', 'Hours'];
        $getAmountGroupByPaymentType
            = $this->receipt->getAmountGroupByPaymentType($filters);

        if (count($getAmountGroupByPaymentType) > 0) {
            foreach ($getAmountGroupByPaymentType as $item) {
                $type = $this->getPaymentType($item['payment_type']);
                $piePaymentType[] = [
                    $type, intval($item['amount'])
                ];
            }
        }
        $result['pie_chart_payment_type'] = $piePaymentType;
        return $result;
    }

    /**
     * Danh sách hình thức thanh toán.
     *
     * @param $status
     *
     * @return string
     */
    private function getPaymentType($type)
    {
        switch ($type) {
            case 'cash':
                return "Tiền mặt";
                break;
            case 'visa':
                return "Visa";
                break;
            case 'tranfer':
                return "Chuyển khoản";
                break;
            default:
                break;
        }
    }

    /**
     * Báo cáo tăng trưởng khách hàng.
     *
     * @param array $filters
     *
     * @return array
     */
    public function customerChart(array $filters = [])
    {
        $result = [];
        $date = Carbon::now()->format('Y-m-d');
        $fromDate = $date . ' 00:00:00';
        $toDate = $date . ' 23:59:59';
        $startTime = '';
        $endTime = '';
        if (isset($filters["choose_day"])) {
            if ($filters["choose_day"] != '') {
                $arr_filter = explode(" - ", $filters["choose_day"]);
                $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])
                    ->format('Y-m-d');
                $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])
                    ->format('Y-m-d');
                $fromDate = $startTime . ' 00:00:00';
                $toDate = $endTime . ' 23:59:59';
            }
        }
        $filters['date'] = [$fromDate, $toDate];
        //tỷ lệ theo loại khách hàng.
        $getCustomerByType = $this->customer->getCustomerByType($filters);
        $pieCustomerType[] = ['Task', 'Hours'];
        if (count($getCustomerByType) > 0) {
            foreach ($getCustomerByType as $item) {
                $name = 'Cá nhân';
                if ($item['customer_type'] == 'enterprise') {
                    $name = 'Doanh nghiệp';
                }
                $pieCustomerType[] = [
                    $name, $item['quantity']
                ];
            }
        }
        $result['pie_chart_customer_type'] = $pieCustomerType;

        //Tỉ lệ theo trạng thái
        $getCustomerByStatus = $this->customer->getCustomerByStatus($filters);
        $pieCustomerStatus[] = ['Task', 'Hours'];
        if (count($getCustomerByStatus) > 0) {
            foreach ($getCustomerByStatus as $item) {
                $name = 'Mới';
                if ($item['status'] == 'verified') {
                    $name = 'Đã duyệt';
                }
                $pieCustomerStatus[] = [
                    $name, $item['quantity']
                ];
            }
        }
        $result['pie_chart_customer_status'] = $pieCustomerStatus;

        //Số ngày.
        $dateDiff = ((strtotime($endTime) - strtotime($startTime)) / (60 * 60
            * 24)) + 1;
        $arrayDate[] = ["day", "TỔNG SỐ KH", "CÁ NHÂN", "DOANH NGHIỆP"];
        for ($i = 0; $i < $dateDiff; $i++) {
            $filters = [];
            //Ngày
            $day = date('Y-m-d', strtotime($startTime . "+" . $i . " days"));
            $filters['date'] = $day;
            //Tổng số khách hàng.
            $total = $this->customer->getCustomerChart($filters);
            //Cá nhân
            $filters['type'] = 'personal';
            $personal = $this->customer->getCustomerChart($filters);
            //Doanh nghiệp
            $filters['type'] = 'enterprise';
            $enterprise = $this->customer->getCustomerChart($filters);
            $dayFormatChart = date('d/m', strtotime($day));
            $arrayDate[] = [$dayFormatChart, $total, $personal, $enterprise];
        }
        $result['chart'] = $arrayDate;
        return $result;
    }

    /**
     * Option khách hàng.
     *
     * @return mixed
     */
    public function customerOption()
    {
        return $this->customer->getOption();
    }

    /**
     * Báo cáo công nợ
     *
     * @param array $filters
     *
     * @return mixed
     */
    public function debtChart(array $filters = [])
    {
        $date = Carbon::now()->format('Y-m-d');
        $fromDate = $date . ' 00:00:00';
        $toDate = $date . ' 23:59:59';
        $startTime = '';
        $endTime = '';
        if (isset($filters["choose_day"])) {
            if ($filters["choose_day"] != '') {
                $arr_filter = explode(" - ", $filters["choose_day"]);
                $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])->format('Y-m-d');
                $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])->format('Y-m-d');
                $fromDate = $startTime . ' 00:00:00';
                $toDate = $endTime . ' 23:59:59';
            }
        }
        $filters['date'] = [$fromDate, $toDate];

        $filters['array_status'] = ['part-paid', 'unpaid'];

        $receiptPartPaid = $this->receipt->getPartPaidDebtChart($filters);

        $optionCustomer = $this->customer->getOption();
        //Nếu status còn nợ thì tính số tiền còn nợ.
        $moneyPaidCustomer = [];
        if (count($receiptPartPaid) > 0) {
            foreach ($receiptPartPaid as $item) {
                $moneyPaid = $this->receiptDetail->amountReceiptOne($item['receipt_id']);
                $moneyPaidCustomer[] = [
                    'customer_id' => $item['customer_id'],
                    'money'       => intval($item['amount'] * 1.1 - intval($moneyPaid))
                ];
            }
        }

        $result['chart'] = [];
        $result['chart']['list'] = [];
        $result['chart']['value'] = [];
        //Mảng chứa id KH và số tiền khách nợ.
        $temp = [];

        foreach ($optionCustomer as $item) {
            foreach ($moneyPaidCustomer as $key => $index) {
                if (isset($temp[$item['customer_id']]) && $temp[$item['customer_id']] != 0) {
                } else {
                    $temp[$item['customer_id']] = 0;
                }

                if ($item['customer_id'] == $index['customer_id']) {
                    $temp[$item['customer_id']] += intval($index['money']);
                }
            }
        }

        arsort($temp);
        $totalMoney = 0;
        $count = 0;
        foreach ($temp as $key => $value) {
            $count++;
            //Trường hợp filter 1 khách hàng nào đó.
            if (
                isset($filters['customer_id'])
                && $filters['customer_id'] != null
            ) {
                if ($key == intval($filters['customer_id'])) {
                    $customer = $this->customer->getItem($key);
                    $result['chart']['list'][] = $customer['customer_name'];
                    $result['chart']['value'][] = $value;
                    //Tính tổng tiền
                    $totalMoney += $value;
                    break;
                }
            } else {
                //Có giới hạn số KH được hiển thị
                if (
                    isset($filters['display_customer'])
                    && $filters['display_customer'] != null
                ) {
                    if ($count <= intval($filters['display_customer'])) {
                        $customer = $this->customer->getItem($key);
                        $result['chart']['list'][] = $customer['customer_name'];
                        $result['chart']['value'][] = $value;
                        //Tính tổng tiền
                        $totalMoney += $value;
                    }
                } else {
                    $customer = $this->customer->getItem($key);
                    $result['chart']['list'][] = $customer['customer_name'];
                    $result['chart']['value'][] = $value;
                    //Tính tổng tiền
                    $totalMoney += $value;
                }
            }
        }

        $result['total_money'] = $totalMoney;
        return $result;
    }

    /**
     * Option lĩnh vực.
     *
     * @return mixed
     */
    public function segmentOption()
    {
        $segment = new SegmentTable();
        $result = $segment->getOption();
        return $result;
    }

    /**
     * Báo cáo doanh thu khách hàng.
     * @param array $filters
     *
     * @return mixed
     */
    public function customerRevenueChart(array $filters = [])
    {
        $date = Carbon::now()->format('Y-m-d');
        $fromDate = $date . ' 00:00:00';
        $toDate = $date . ' 23:59:59';
        $startTime = '';
        $endTime = '';
        if (isset($filters["choose_day"])) {
            if ($filters["choose_day"] != '') {
                $arr_filter = explode(" - ", $filters["choose_day"]);
                $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])->format('Y-m-d');
                $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])->format('Y-m-d');
                $fromDate = $startTime . ' 00:00:00';
                $toDate = $endTime . ' 23:59:59';
            }
        }
        $filters['date'] = [$fromDate, $toDate];

        $data = $this->customer->getCustomerRevenue($filters);

        if (request()->session()->has('customer_revenue_data')) {
            request()->session()->forget('customer_revenue_data');
        }
        request()->session()->put('customer_revenue_data', $data);

        $totalMoney = 0;
        $result['chart']['list'] = [];
        $result['chart']['value'] = [];
        foreach ($data as $item) {
            $result['chart']['list'][] = $item['customer_name'];
            $result['chart']['value'][] = intval($item['amount']);
            $totalMoney += $item['amount'];
        }
        $result['total_money'] = $totalMoney;

        return $result;
    }

    /**
     * Option product.
     * @return mixed
     */
    public function productOption()
    {
        $product = new ProductTable();
        $result = $product->option();
        return $result;
    }

    /**
     * Báo cáo doanh thu khách hàng.
     * @param array $filters
     *
     * @return mixed
     */
    public function serviceRevenueChart(array $filters = [])
    {
        $date = Carbon::now()->format('Y-m-d');
        $fromDate = $date . ' 00:00:00';
        $toDate = $date . ' 23:59:59';
        $startTime = '';
        $endTime = '';
        if (isset($filters["choose_day"])) {
            if ($filters["choose_day"] != '') {
                $arr_filter = explode(" - ", $filters["choose_day"]);
                $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])->format('Y-m-d');
                $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])->format('Y-m-d');
                $fromDate = $startTime . ' 00:00:00';
                $toDate = $endTime . ' 23:59:59';
            }
        }
        $filters['date'] = [$fromDate, $toDate];
        $product = new ProductTable();
        $data = $product->getServiceRevenue($filters);

        if (request()->session()->has('service_revenue_data')) {
            request()->session()->forget('service_revenue_data');
        }
        request()->session()->put('service_revenue_data', $data);
        $totalMoney = 0;
        $result['chart']['list'] = [];
        $result['chart']['value'] = [];
        foreach ($data as $item) {
            $result['chart']['list'][] = $item['product_name_vi'];
            $result['chart']['value'][] = intval($item['amount'] * 1.1);
            $totalMoney += intval($item['amount'] * 1.1);
        }

        $result['total_money'] = $totalMoney;
        return $result;
    }

    /**
     * Export báo cáo doanh thu khách hàng.
     * @param array $filters
     *
     * @return mixed
     */
    public function exportExcelCustomerRevenue()
    {
        $data = request()->session()->get('customer_revenue_data');
        $arrData = [];
        foreach ($data as $key => $item) {
            $arrData[] = [$key + 1, $item['customer_name'], number_format($item['amount'])];
        }
        $heading = [
            'STT',
            'Tên khách hàng',
            'Tổng tiền',
        ];
        return $this->excel->download(new EmailExport($heading, $arrData), 'Báo cáo doanh thu khách hàng.xlsx');
    }

    /**
     * Export báo cáo doanh thu khách hàng.
     * @param array $filters
     *
     * @return mixed
     */
    public function exportExcelServiceRevenue()
    {
        $data = request()->session()->get('service_revenue_data');

        $arrData = [];
        foreach ($data as $key => $item) {
            $arrData[] = [$key + 1, $item['product_name_vi'], number_format($item['amount'] * 1.1)];
        }
        $heading = [
            'STT',
            'Tên dịch vụ',
            'Tổng tiền',
        ];
        return $this->excel->download(new EmailExport($heading, $arrData), 'Báo cáo doanh thu dịch vụ.xlsx');
    }

    public function aggregateRevenueChart(array $filters = [])
    {
        $result = [];
        $column = [];
        $totalMoney = 0;
        $totalPaid = 0;
        $totalUnpaid = 0;
        if ($filters['year'] != null) {
            //Filter theo năm thì hiển thị 12 tháng.
            for ($i = 1; $i <= 12; $i++) {
                $day = Carbon::now()->month($i);
                //Lấy tổng tiền của tất cả hóa đơn.
                $totalQuery = $this->invoice->sumTotalMoney($i, $filters['year']);
                $total = $totalQuery['amount'] != null ? intval($totalQuery['amount']) : 0;
                //Lấy tổng số tiền đã trả trong receipt detail.
                $paidQuery = $this->receiptDetail->sumTotalMoney($i, $filters['year']);
                $paid = $paidQuery['amount'] != null ? intval($paidQuery['amount']) : 0;
                $totalMoney += $total;
                $totalPaid += $paid;
                $totalUnpaid += ($total - $paid);
                $unpaidTemp = $total - $paid;
                $column[] = [
                    'year'   => $day->format('m'),
                    'paid'   => $paid,
                    'unpaid' => $unpaidTemp < 0 ? 0 : $unpaidTemp,
                    'null'   => 0,
                    'color1' => "#5578eb",
                    'color2' => "#ffc107",
                    'color3' => "#fff",
                ];
            }
        } else {
            $arr_filter = explode(" - ", $filters["choose_day"]);
            //Từ ngày đến ngày.
            $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])->format('Y-m-d');
            $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])->format('Y-m-d');

            //Số ngày
            $diff_in_days = ((strtotime($endTime) - strtotime($startTime)) / (60 * 60 * 24)) + 1;

            $dataInvoice = $this->invoice->sumTotalMoneyByDay($startTime . ' 00:00:00', $endTime . ' 23:59:59');

            $dataReceiptDetail = $this->receiptDetail->sumTotalMoneyByDay($startTime . ' 00:00:00', $endTime . ' 23:59:59');

            //Gồm ngày và giá trị của invoice
            $tempInvoice = [];
            foreach ($dataInvoice as $k => $value) {
                $tempInvoice[$value['created_at']] = $value['amount'];
            }
            //Gồm ngày và giá trị của receipt detail.
            $tempReceiptDetail = [];
            foreach ($dataReceiptDetail as $k => $value) {
                $tempReceiptDetail[$value['receipt_date']] = $value['amount'];
            }
            if (count($dataInvoice) > 0) {
                //Giá trị của tùng ngày.
                for ($i = 0; $i < $diff_in_days; $i++) {
                    $day = date('Y-m-d', strtotime($startTime . "+" . $i . " days"));

                    $tomorrow = date('d/m', strtotime($startTime . "+" . $i . " days"));
                    $total = isset($tempInvoice[$day]) ? intval($tempInvoice[$day]) : 0;
                    $paid = isset($tempReceiptDetail[$day]) ? intval($tempReceiptDetail[$day]) : 0;
                    $totalMoney += $total;
                    $totalPaid += $paid;
                    $totalUnpaid += ($total - $paid);
                    $unpaid = $total - $paid;

                    $column[] = [
                        'year'   => $tomorrow,
                        'total'   => $total,
                        'paid'   => $paid,
                        'unpaid' => $unpaid < 0 ? 0 : $unpaid,
                        'null'   => 0,
                        'color1' => "#5578eb",
                        'color2' => "#ffc107",
                        'color3' => "#fff",
                    ];
                }
            } else {
                //Nếu không có record nào trong invoice thì giá trị là 0.
                for ($i = 0; $i < $diff_in_days; $i++) {
                    $tomorrow = date(
                        'd/m',
                        strtotime($startTime . "+" . $i . " days")
                    );
                    $column[] = [
                        'year'   => $tomorrow,
                        'paid'   => 0,
                        'unpaid' => 0,
                        'null'   => 0,
                        'color1' => "#5578eb",
                        'color2' => "#ffc107",
                        'color3' => "#fff",
                    ];
                }
            }
        }
        //Nếu không có gì cả thì hiện 0.
        if ($column == []) {
            $column[] = [
                'year'   => 0,
                'paid'   => 0,
                'unpaid' => 0,
                'null'   => 0,
            ];
        }

        $result['chart'] = $column;
        $result['totalMoney'] = $totalMoney;
        $result['totalPaid'] = $totalPaid;
        $result['totalUnpaid'] = $totalUnpaid;
        return $result;
    }
    public function exportExcelInvoice($choose_day)
    {
        $headings = [
            'Số thứ tự',
            'Số hóa đơn',
            'Ngày xuất hóa đơn',
            'Số đơn hàng',
            'Tên Khách hàng',
            'Địa chỉ liên hệ',
            'Kỳ cước',
            'Phí lắp đặt',
            'Cước tháng',
            'Thuế VAT',
            'Tổng cước phát sinh',
            'Tổng cước phải thu',
            'Cước Đã thu',
            'Cước Còn nợ',
            'Loại dịch vụ',
            'Gói dịch vụ',
            'Loại thuê bao',
            'Tình trạng thuê bao',
            'Nhân viên bán hàng',
            'Ghi chú'

        ];
        $data = $this->invoice->getDataExportInvoice($choose_day);

        $dataExport = [];

        $i = 1;
        $receiptId = [];
        foreach ($data as $c) {
            $receiptId = [];
            $c['num'] = $i++;
            if ($c['status'] =="actived"){
                $c['status'] = 'Đã kích hoạt';
            }else if ($c['status'] == 'not_actived'){
                $c['status'] = "Chưa kích hoạt";
            }else{
                $c['status'] = 'Đang sử dụng';
            }

            if ($c['payment_type'] == 'prepaid') {
                $c['payment_type'] = 'trả trước';
            } else if ($c['payment_type'] == 'postpair') {
                $c['payment_type'] = 'trả sau';
            } else {
                $c['payment_type'] = 'nhiêu tính nhiêu';
            }
            //LOẠI DỊCH VỤ VÀ GÓI DỊCH VỤ
            if ($c['parent_name'] == null) {
                $c['parent_name'] = $c['product_name_vi'];
            }
            // END LOẠI DV VÀ GÓI DV
            $receiptId[] = $c['receipt_id'];

            //TÍNH TỔNG TIỀN ĐÃ THU
            $amount_receipt = $this->receiptRespo->listAmountReceipt($receiptId);

            $amount_paid = 0;

            foreach ($amount_receipt as $item) {
                $amount_paid = $item['amount'] + 0.01 ;
            }

            $str = $c['tong_cuoc_phai_thu'];
            $str =  str_replace(',', '', $str);
            $total = (int) $str;

            if ($c['receipt_detail_id'] == null) {
                $c['tong_cuoc_da_thu'] = '0';
                $c['tong_cuoc_con_no'] = $c['tong_cuoc_phai_thu'];
            } else {
                $tmp = 0;
                $amount_paid=round($amount_paid,0);
                $c['tong_cuoc_da_thu'] = number_format($amount_paid);
                $tmp = $total - $amount_paid;
                $c['tong_cuoc_con_no'] =number_format($tmp);
            }
            //END TÍNH TỔNG TIỀN ĐÃ THU
            unset($c['receipt_id']);
            unset($c['receipt_detail_id']);
            $dataExport[] = $c;
        }

        return $this->exporter->download(new ExportsInvoiceExport($headings, $dataExport), 'Báo cáo công nợ tổng hợp.xlsx');
    }

}


