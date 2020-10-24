<?php


namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Product\Repositories\Order\OrderRepositoryInterface;
use Modules\Product\Repositories\Invoice\InvoiceRepositoryInterface;
use Modules\Core\Repositories\Admin\AdminRepositoryInterface;
use Modules\Product\Http\Requests\invoice\invoiceUpdateRequest;
use Modules\Product\Repositories\Receipt\ReceiptRepositoryInterface;


class InvoiceController extends Controller
{
    protected $order;
    protected $invoice;
    protected  $admin;
    protected $receipt;

    public function __construct(
        OrderRepositoryInterface $order,
        InvoiceRepositoryInterface $invoice,
        AdminRepositoryInterface $admin,
        ReceiptRepositoryInterface $receipt

    ){
        $this->order = $order;
        $this->invoice = $invoice;
        $this->admin =$admin;
        $this->receipt = $receipt;
    }

    public function index(Request $request)
    {
        $filter = $request->all();
        $list_invoice = $this->order->getListInvoice($filter);
        $perpage = isset($filter['perpage']) ? $filter['perpage'] : PAGING_ITEM_PER_PAGE;

        return view('product::invoice.index',
            [
                'list_invoice' => $list_invoice['list_invoice'],
                'filter' => $list_invoice['filter'],
                'perpage' => $perpage
            ]);
    }

    /**edit-invoice-extends
     * Show the specified resource.
     * @param int $customer_service_id
     * @return Response
     */
    public function show($invoice_no)
    {
        $detailInvoice = $this->invoice->getDetail($invoice_no);
        // lich su thanh toan
        $receiptDetail = $this->receipt->getReceiptDetail($detailInvoice['receipt_id']);
        //Danh sách thu chi tiết
        $getOrderDetail = $this->receipt->getCustomerServiceByReceiptId($detailInvoice['receipt_id']);
        $listInvoiceExtends = $this->invoice->getByInvoice($detailInvoice['invoice_id']);
        return view('product::invoice.detail',[
            'detailInvoice' => $detailInvoice,
            'receiptDetail'      => $receiptDetail,
            'getOrderDetail' => $getOrderDetail,
            'listInvoiceExtends' => $listInvoiceExtends
        ]);
    }
    /**
     * Show the specified resource.
     * @param int $customer_service_id
     * @return Response
     */
    public function insertInvoiceExtend($invoice_no)
    {
        //invoice_no check if not exist -> return 404

        return view('product::invoice.edit-invoice-extends',[
            'invoice_no' => $invoice_no,
            'is_edit' => 0
        ]);
    }
    public function editInvoiceExtend($invoice_extends_code)
    {
        //invoice_no check if not exist -> return 404
        $invoiceInfo = $this->invoice->getInfoInvoiceExtends($invoice_extends_code);
        // get info
        return view('product::invoice.edit-invoice-extends',[
            'invoice' => $invoiceInfo['invoice'],
            'invoice_no' => $invoiceInfo['invoice']['invoice_no'],
            'invoiceExtend' => $invoiceInfo['invoiceExtend'],
            'is_edit' => 1
        ]);
    }
    
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($invoice_no)
    {
        $listAdmin= $this->admin->getListAll();
        $detailInvoice = $this->invoice->getDetail($invoice_no);
        return view('product::invoice.edit',[
            'detailInvoice' => $detailInvoice,
            'listAdmin' => $listAdmin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $invoice_id
     * @return Response
     */
    public function update(invoiceUpdateRequest $request )
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);
//        dd($data);
        $result = $this->invoice->updateInvoice($data, $data['invoice_id']);
        return $result;

    }
    /**
     * 
     */
    public function insertInvoiceExtendPost(Request $request){
        $data = $request->validate([
            'invoice_no' => 'required',
            'price' => 'required',
            'content' => 'nullable'
        ]);
        $invoice_no = $data['invoice_no'];
        $price = $data['price'];
        if($price == 0 || empty($price)){
            return ['error' => 1, 'message' => 'Giá phí hóa đơn phải lởn hơn 0'];
        }
        $content = $data['content'];
        return $this->invoice->insertInvoiceExtend($invoice_no, $price, $content);
    }
    public function editInvoiceExtendPost(Request $request){
        $data = $request->validate([
            'invoice_extends_code' => 'required',
            'price' => 'required',
            'content' => 'nullable'
        ]);
        $invoice_extends_code = $data['invoice_extends_code'];
        $price = $data['price'];
        $content = $data['content'];
        if($price == 0 || empty($price)){
            return ['error' => 1, 'message' => 'Giá phí hóa đơn phải lởn hơn 0'];
        }
        return $this->invoice->editInvoiceExtend($invoice_extends_code, $price, $content);
    }
    public function deleteInvoiceExtendPost(Request $request){
        $data = $request->validate([
            'invoice_extends_code' => 'required',
            'invoice_no' => 'required'
        ]);
        return $this->invoice->deleteInvoiceExtends($data['invoice_extends_code'], $data['invoice_no']);
    }
}
