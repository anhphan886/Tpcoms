<?php


namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\receipt\Store;
use Modules\Product\Repositories\Customer\CustomerRepositoryInterface;
use Modules\Product\Repositories\Order\OrderRepositoryInterface;
use Modules\Product\Repositories\Receipt\ReceiptRepositoryInterface;


class ReceiptController extends Controller
{
    protected $order;
    protected $customer;
    protected $receipt;

    public function __construct(
        OrderRepositoryInterface $order,
        CustomerRepositoryInterface $customer,
        ReceiptRepositoryInterface $receipt
    ){
        $this->order = $order;
        $this->customer = $customer;
        $this->receipt = $receipt;
    }

    /**
     * Danh sách phiếu thu
     * @param Request $request
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index(Request $request)
    {
        $filter = $request->all();
        $list_receipt = $this->order->getListReceipt($filter);
        $receiptId = [];
        foreach ( $list_receipt['list_receipt'] as $item) {
            $receiptId[] = $item['receipt_id'];
        }
        $amount_receipt = $this->receipt->listAmountReceipt($receiptId);
        $amount_paid = [];
        foreach ( $amount_receipt as $item) {
            $amount_paid[$item['receipt_id']] = $item['amount'];
        }
        $optionCustomer = $this->customer->getOptionCustomer();
        $perpage = isset($filter['perpage']) ? $filter['perpage'] : PAGING_ITEM_PER_PAGE;

        return view('product::receipt.index',
            [
                'list_receipt' => $list_receipt['list_receipt'],
                'filter' => $list_receipt['filter'],
                'optionCustomer' => $optionCustomer,
                'amount_paid' => $amount_paid,
                'perpage' => $perpage,
            ]);
    }

    /**
     * Hủy phiếu thu
     * @param Request $request
     *
     * @return mixed
     */
    public function cancelReceipt(Request $request)
    {
        $id = $request->id;
        return $this->receipt->cancelReceipt($id);
    }

    /**
     * Load sang trang thanh toán.
     * @param $id
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function receipt(Request $request, $code)
    {
        $param = $request->all();

        $receipt = $this->receipt->getItemByCode($code);
        $staffOption = $this->receipt->getOptionStaff();
        $amountReceipt = $this->receipt->amountReceipt($receipt['receipt_id']);
        $amountReceipt = $receipt['amount'] + $receipt['vat'] - $amountReceipt;

        if ($receipt != null) {
            if ($receipt['status'] != 'paid' && $receipt['status'] != 'cancel') {
                return view('product::receipt.receipt',[
                    'receipt' => $receipt,
                    'staffOption' => $staffOption,
                    'amountReceipt' => $amountReceipt,
                    'param' => $param,
                ]);
            } else {
                return redirect()->route('product.receipt');
            }
        } else {
            return redirect()->route('product.receipt');
        }
    }

    /**
     * Thanh toán phiếu thu
     * @param Store $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeReceiptDetail(Store $request)
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);
        $result = $this->receipt->storeReceiptDetail($data);
        return response()->json($result);
    }
    /**
     * trang edit receipt
    */
    public function showEdit($code)
    {
        $receipt = $this->receipt->getItemByCode($code);
        if ($receipt != null) {
            $order = $this->receipt->getDetailOrder(intval($receipt['order_id']));
            $orderStatus = $this->receipt->getOptionOrderStatus();
            $staffOption = $this->receipt->getOptionStaff();
            $amountReceipt = $this->receipt->amountReceipt($receipt['receipt_id']);
            $amountReceipt = $receipt['amount'] - $amountReceipt;
            $receiptDetail = $this->receipt->getReceiptDetail($receipt['receipt_id']);
            //Danh sách thu chi tiết
            $getCustomerService = $this->receipt->getCustomerServiceByReceiptId($receipt['receipt_id']);
            return view(
                'product::receipt.edit', [
                    'receipt'            => $receipt,
                    'staffOption'        => $staffOption,
                    'amountReceipt'      => $amountReceipt,
                    'order'              => $order,
                    'orderStatus'        => $orderStatus,
                    'receiptDetail'      => $receiptDetail,
                    'getCustomerService' => $getCustomerService,
                ]
            );
        } else {
            return redirect()->route('product.receipt');
        }
    }
    /**
     * function edit receipt
    */
    public function editReceipt(Request $request){
        $param = $request->all();
        return $this->receipt->updateTimeReceipt($param, $param['receipt_id']);
    }

    /**
     * Chi tiết phiếu thu
     * @param $code
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function show($code)
    {

        $receipt = $this->receipt->getItemByCode($code);
        if ($receipt != null) {
            $order = $this->receipt->getDetailOrder(intval($receipt['order_id']));
            $orderStatus = $this->receipt->getOptionOrderStatus();
            $staffOption = $this->receipt->getOptionStaff();
            $amountReceipt = $this->receipt->amountReceipt($receipt['receipt_id']);
            $amountReceipt =( $receipt['amount'] + $receipt['vat']) - $amountReceipt;
            $receiptDetail = $this->receipt->getReceiptDetail($receipt['receipt_id']);
            //Danh sách thu chi tiết
            $getCustomerService = $this->receipt->getCustomerServiceByReceiptId($receipt['receipt_id']);
            return view(
                'product::receipt.detail', [
                'receipt'            => $receipt,
                'staffOption'        => $staffOption,
                'amountReceipt'      => $amountReceipt,
                'order'              => $order,
                'orderStatus'        => $orderStatus,
                'receiptDetail'      => $receiptDetail,
                'getCustomerService' => $getCustomerService,
            ]
            );
        } else {
            return redirect()->route('product.receipt');
        }
    }

    /////////// Debt receipt

    /**
     * Danh sách công nợ
     * @param Request $request
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function debtReceiptIndex(Request $request)
    {
        $filter = $request->all();
        $filter['debt']= 1;
        $list_receipt = $this->order->getListReceipt($filter);
        $optionCustomer = $this->customer->getOptionCustomer();
        $perpage = isset($filter['perpage']) ? $filter['perpage'] : PAGING_ITEM_PER_PAGE;

        return view('product::debt-receipt.index',
            [
                'list_receipt' => $list_receipt['list_receipt'],
                'filter' => $list_receipt['filter'],
                'optionCustomer' => $optionCustomer,
                'perpage' => $perpage,
            ]);
    }

    /**
     * Chi tiết phiếu thu debt receipt
     * @param $code
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function showDebtRecript($code)
    {
        $receipt = $this->receipt->getItemByCode($code);
        if ($receipt != null) {
            $order = $this->receipt->getDetailOrder(intval($receipt['order_id']));
            $orderStatus = $this->receipt->getOptionOrderStatus();
            $staffOption = $this->receipt->getOptionStaff();
            $amountReceipt = $this->receipt->amountReceipt($receipt['receipt_id']);
            $amountReceipt = $receipt['amount'] - $amountReceipt;
            $receiptDetail = $this->receipt->getReceiptDetail($receipt['receipt_id']);
            //Danh sách thu chi tiết
            $getCustomerService = $this->receipt->getCustomerServiceByReceiptId($receipt['receipt_id']);
            return view(
                'product::debt-receipt.detail', [
                    'receipt'            => $receipt,
                    'staffOption'        => $staffOption,
                    'amountReceipt'      => $amountReceipt,
                    'order'              => $order,
                    'orderStatus'        => $orderStatus,
                    'receiptDetail'      => $receiptDetail,
                    'getCustomerService' => $getCustomerService,
                ]
            );
        } else {
            return redirect()->route('product.debt-receipt');
        }
    }

    /**
     * Thanh toán phiếu thu debt receipt
     * @param Store $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeDebtReceiptDetail(Store $request)
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);
        $result = $this->receipt->storeReceiptDetail($data);
        return response()->json($result);
    }

    /**
     * Hủy phiếu thu debt receipt
     * @param Request $request
     *
     * @return mixed
     */
    public function cancelDebtReceipt(Request $request)
    {
        $id = $request->id;
        return $this->receipt->cancelReceipt($id);
    }

    /**
     * Load sang trang thanh toán.
     * @param $id
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function debtReceipt($code)
    {
        $receipt = $this->receipt->getItemByCode($code);
        $staffOption = $this->receipt->getOptionStaff();
        $amountReceipt = $this->receipt->amountReceipt($receipt['receipt_id']);
        $amountReceipt = $receipt['amount'] + $receipt['vat'] - $amountReceipt;

        if ($receipt != null) {
            if ($receipt['status'] != 'paid' && $receipt['status'] != 'cancel') {
                return view('product::debt-receipt.receipt',[
                    'receipt' => $receipt,
                    'staffOption' => $staffOption,
                    'amountReceipt' => $amountReceipt,
                ]);
            } else {
                return redirect()->route('product.receipt');
            }
        } else {
            return redirect()->route('product.receipt');
        }
    }

    /**
     * trang edit receipt
     */
    public function showDebtEdit($code)
    {
        $receipt = $this->receipt->getItemByCode($code);
        if ($receipt != null) {
            $order = $this->receipt->getDetailOrder(intval($receipt['order_id']));
            $orderStatus = $this->receipt->getOptionOrderStatus();
            $staffOption = $this->receipt->getOptionStaff();
            $amountReceipt = $this->receipt->amountReceipt($receipt['receipt_id']);
            $amountReceipt = $receipt['amount'] - $amountReceipt;
            $receiptDetail = $this->receipt->getReceiptDetail($receipt['receipt_id']);

            //Danh sách thu chi tiết
            $getCustomerService = $this->receipt->getCustomerServiceByReceiptId($receipt['receipt_id']);
            return view(
                'product::debt-receipt.edit', [
                    'receipt'            => $receipt,
                    'staffOption'        => $staffOption,
                    'amountReceipt'      => $amountReceipt,
                    'order'              => $order,
                    'orderStatus'        => $orderStatus,
                    'receiptDetail'      => $receiptDetail,
                    'getCustomerService' => $getCustomerService,
                ]
            );
        } else {
            return redirect()->route('product.receipt');
        }
    }
    /**
     * function edit receipt
     */
    public function editDebtReceipt(Request $request){
        $param = $request->all();
//        dd($param);
        return $this->receipt->updateTimeReceipt($param, $param['receipt_id']);
    }
}
