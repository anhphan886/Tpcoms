<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Repositories\dashboard\DashboardRepositoryInterface;

class DashboardController extends Controller
{
    protected $dashboard;

    public function __construct(
        DashboardRepositoryInterface $dashboard
    ) {
        $this->dashboard = $dashboard;
    }

    /**
     * Index
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index()
    {
        $head = $this->dashboard->getQuantitiesHead();

        return view(
            'admin::dashboard.index',
            [
                'head' => $head
            ]
        );
    }

    /**
     * Danh sách đơn hàng trong ngày
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listOder(Request $request)
    {
        $filter = $request->only('pagination.page', 'pagination.perpage', 'query.search_order');
        $oList = $this->dashboard->listOder($filter);
        $list = [
            'meta' => [
                'page' => $oList->currentPage(),
                'pages' => $oList->lastPage(),
                'total' => $oList->total(),
                'perpage' => $oList->perPage(),
                'sort' => 'asc',
                'field' => 'id'
            ],
            'data' => $oList->items()
        ];
        return response()->json($list);
    }

    /**
     * Danh sách đơn hàng trong ngày
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listCustomer(Request $request)
    {
        $filter = $request->only('pagination.page', 'pagination.perpage', 'query.search_customer');
        $oList = $this->dashboard->listCustomer($filter);
        $list = [
            'meta' => [
                'page' => $oList->currentPage(),
                'pages' => $oList->lastPage(),
                'total' => $oList->total(),
                'perpage' => $oList->perPage(),
                'sort' => 'asc',
                'field' => 'id'
            ],
            'data' => $oList->items()
        ];
        return response()->json($list);
    }

    /**
     *
     * @param Request $request
     * @param         $locale
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLocale(Request $request, $locale)
    {
        $request->session()->put('locale', $locale);

        return back();
    }

    /**
     * Đơn hàng theo tháng / năm
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderByMonthYear(Request $request){

        $param = $request->all();
        $result = $this->dashboard->getOrderByMonthYear($param);

        return response()->json($result);

    }

    /**
     * Top 10 dịch vụ bán chạy nhất
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopService(Request $request){

        $param = $request->all();
        $result = $this->dashboard->getTopService($param);

        return response()->json($result);
    }

    /**
     * Đơn hàng theo trạng thái.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderByStatus(Request $request){

        $param = $request->all();
        $result = $this->dashboard->getOrderByStatus($param);

        return response()->json($result);
    }

    /**
     * Danh sách dịch vụ hết hạn nhưng chưa hủy.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listServiceExpireNotCanceled(Request $request)
    {
        $filters = $request->only('pagination.page', 'pagination.perpage', 'query.search_expire_not_canceled');
        $filters['type'] = 'expire_not_canceled';
        $oList = $this->dashboard->listServiceExpire($filters);
        $list = [
            'meta' => [
                'page' => $oList->currentPage(),
                'pages' => $oList->lastPage(),
                'total' => $oList->total(),
                'perpage' => $oList->perPage(),
                'sort' => 'asc',
                'field' => 'id'
            ],
            'data' => $oList->items()
        ];
        return response()->json($list);
    }

    /**
     * Danh sách dịch vụ hết hạn trong ngày
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listServiceExpireToDay(Request $request)
    {
        $filters = $request->only('pagination.page', 'pagination.perpage', 'query.search_expire_to_day');
        $filters['type'] = 'expire_to_day';
        $oList = $this->dashboard->listServiceExpire($filters);
        $list = [
            'meta' => [
                'page' => $oList->currentPage(),
                'pages' => $oList->lastPage(),
                'total' => $oList->total(),
                'perpage' => $oList->perPage(),
                'sort' => 'asc',
                'field' => 'id'
            ],
            'data' => $oList->items()
        ];
        return response()->json($list);
    }

    /**
     * Danh sách dịch vụ hết hạn trong ngày
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listServiceExpireDay(Request $request)
    {
        $filters = $request->only(
            'pagination.page',
            'pagination.perpage',
            'query.search_expire_7_day',
            'query.search_expire_30_day',
            'day'
        );
        $filters['type'] = 'expire_day';
        $oList = $this->dashboard->listServiceExpire($filters);
        $list = [
            'meta' => [
                'page' => $oList->currentPage(),
                'pages' => $oList->lastPage(),
                'total' => $oList->total(),
                'perpage' => $oList->perPage(),
                'sort' => 'asc',
                'field' => 'id'
            ],
            'data' => $oList->items()
        ];
        return response()->json($list);
    }

    /**
     * Danh sách đơn hàng trong ngày
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listReceipt(Request $request)
    {
        $filter = $request->only('pagination.page', 'pagination.perpage', 'query.search_receipt');
        $oList = $this->dashboard->listReceipt($filter);

        $receiptId = [];
        foreach ($oList as $item) {
            $receiptId[] = $item['receipt_id'];
        }
        $amount_receipt = $this->dashboard->listAmountReceipt([26]);
        $amount_paid = [];
        foreach ( $amount_receipt as $item) {
            $amount_paid[$item['receipt_id']] = $item['amount'];
        }

        foreach ($oList as $item) {
            $total = $item['amount'] + $item['vat'];
            $debt = 0;
            if (isset($amount_paid[$item['receipt_id']])) {
                $debt = intval($total - $amount_paid[$item['receipt_id']]);
            } else {
                $debt = intval($total);
            }
            $item->setAttribute('debt', $debt);
        }

        $list = [
            'meta' => [
                'page' => $oList->currentPage(),
                'pages' => $oList->lastPage(),
                'total' => $oList->total(),
                'perpage' => $oList->perPage(),
                'sort' => 'asc',
                'field' => 'id'
            ],
            'data' => $oList->items()
        ];

        return response()->json($list);
    }

    /**
     * Hóa đơn cần xuất trong ngày
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listInvoice(Request $request)
    {
        $filter = $request->only('pagination.page', 'pagination.perpage', 'query.search_invoice');
        $oList = $this->dashboard->listInvoice($filter);

        $list = [
            'meta' => [
                'page' => $oList->currentPage(),
                'pages' => $oList->lastPage(),
                'total' => $oList->total(),
                'perpage' => $oList->perPage(),
                'sort' => 'asc',
                'field' => 'id'
            ],
            'data' => $oList->items()
        ];
        return response()->json($list);
    }

}
