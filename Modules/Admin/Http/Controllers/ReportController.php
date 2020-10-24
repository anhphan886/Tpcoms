<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Exports\InvoiceExport as ExportsInvoiceExport;
use Modules\Admin\Repositories\Report\ReportRepositoryInterface;

use Modules\Admin\Exports\InvoiceExport;
use Maatwebsite\Excel\Exporter;


class ReportController extends Controller
{
    protected $report;
    private $exporter;

    public function __construct(ReportRepositoryInterface $report, Exporter $exporter)
    {
        $this->report = $report;
        $this->exporter = $exporter;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return redirect()->route(LOGIN_HOME_PAGE);
    }

    /**
     * Chuyển sang trang báo cáo hóa đơn
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function order()
    {
        return view('admin::report.order');
    }

    /**
     * Chuyển sang trang báo cáo dịch vụ
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function service()
    {
        return view('admin::report.service');
    }

    /**
     * Chuyển sang trang báo cáo phiếu thu
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function receipt()
    {
        return view('admin::report.receipt');
    }

    /**
     * Chuyển sang trang báo cáo phiếu thu
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function customer()
    {
        return view('admin::report.customer');
    }

    /**
     * Chuyển sang trang báo cáo phiếu thu
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function debt()
    {
        $customer = $this->report->customerOption();
        $segment = $this->report->segmentOption();
        return view('admin::report.debt',
            [
                'customer' => $customer,
                'segment' => $segment,
            ]);
    }


    /**
     * Lấy dữ liệu báo cáo hóa đơn
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderChart(Request $request)
    {
        $param = $request->all();
        $result = $this->report->getOrderByStatus($param);
        return response()->json($result);
    }

    /**
     * Lấy dữ liệu báo cáo dịch vụ
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function serviceChart(Request $request)
    {
        $param = $request->all();
        $result = $this->report->getTopService($param);

        return response()->json($result);
    }

    /**
     * Lấy dữ liệu báo cáo phiếu thu
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function receiptChart(Request $request)
    {
        $param = $request->all();

        $result = $this->report->receiptChart($param);
        return response()->json($result);
    }

    /**
     * Lấy dữ liệu báo cáo tăng trưởng khách hàng.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function customerChart(Request $request)
    {
        $param = $request->all();
        $result = $this->report->customerChart($param);
        return response()->json($result);
    }

    /**
     * Lấy dữ liệu báo cáo công nợ.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function debtChart(Request $request)
    {
        $param = $request->all();
        $result = $this->report->debtChart($param);

        return response()->json($result);
    }

    /**
     * Chuyển sang trang báo cáo doanh thu khách hàng.
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function customerRevenue()
    {
        $customer = $this->report->customerOption();
        $segment = $this->report->segmentOption();

        return view('admin::report.revenue.customer',
            [
                'customer' => $customer,
                'segment' => $segment
            ]);
    }

    /**
     * Lấy dữ liệu của biểu đồ doanh thu khách hàng.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function customerRevenueChart(Request $request)
    {
        $param = $request->all();
        $result = $this->report->customerRevenueChart($param);
        return response()->json($result);
    }

    /**
     * Chuyển sang trang báo cáo doanh thu theo dịch vụ.
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function serviceRevenue()
    {
        $segment = $this->report->segmentOption();
        $product = $this->report->productOption();

        return view('admin::report.revenue.service',
            [
                'segment' => $segment,
                'product' => $product,
            ]);
    }

    /**
     * Lấy dữ liệu của biểu đồ doanh thu khách hàng.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function serviceRevenueChart(Request $request)
    {
        $param = $request->all();
        $result = $this->report->serviceRevenueChart($param);
        return response()->json($result);
    }

    /**
     * Export excel doanh thu của khách hàng.
     * @return mixed
     */
    public function exportExcelCustomerRevenue()
    {
        return $this->report->exportExcelCustomerRevenue();
    }
    /**
     * Export excel doanh thu của dịch vụ.
     * @return mixed
     */
    public function exportExcelServiceRevenue()
    {
        return $this->report->exportExcelServiceRevenue();
    }

    public function aggregate()
    {
        return view('admin::report.revenue.aggregate');
    }

    /**
     * Lấy dữ liệu của biểu đồ doanh thu tổng hợp.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function aggregateRevenueChart(Request $request)
    {
        $param = $request->all();
        $result = $this->report->aggregateRevenueChart($param);
//        dd($result);
        return response()->json($result);
    }
    public function exportInvoice(Request $request){
        $choose_day = $request -> choose_day;
            return $this -> report -> exportExcelInvoice($choose_day);
    }
}
