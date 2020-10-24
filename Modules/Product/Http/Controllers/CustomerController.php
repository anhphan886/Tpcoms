<?php

namespace Modules\Product\Http\Controllers;

use http\Url;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Http\Requests\customer\Store;
use Modules\Product\Http\Requests\customer\Update;
use Modules\Product\Repositories\Contract\ContractRepositoryInterface;
use Modules\Product\Repositories\Customer\CustomerRepositoryInterface;
use Modules\Product\Repositories\Order\OrderRepositoryInterface;
use Modules\Product\Repositories\Receipt\ReceiptRepositoryInterface;
use Modules\Product\Http\Requests\customerChildAccount\Update as childUpdate;
use Modules\Product\Http\Requests\customerChildAccount\Store as childStore;


class CustomerController extends Controller
{
    protected $customer;
    protected $order;
    protected $contract;
    protected $service;
    protected $request;
    protected $receipt;

    public function __construct(
        CustomerRepositoryInterface $customer,
        OrderRepositoryInterface $order,
        CustomerRepositoryInterface $contractId,
        CustomerRepositoryInterface $service,
        ReceiptRepositoryInterface $receipt,
        Request $request
    ) {
        $this->customer = $customer;
        $this->order = $order;
        $this->contract = $contractId;
        $this->service = $service;
        $this->request = $request;
        $this->receipt = $receipt;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $filter = request()->all();
        $data = $this->customer->getList($filter);
        $province = $this->order->optionProvince();
        $district = $this->order->optionDistrict();
        $status = $this->order->status();
        $createBy = $this->order->optionCreateBy();
        $perpage = isset($filter['perpage']) ? $filter['perpage'] : PAGING_ITEM_PER_PAGE;
        return view('product::customer.index',[
            'list'     => $data['list'],
            'filter'   => $data['filter'],
            'province' => $province,
            'district' => $district,
            'status'   => $status,
            'createBy' => $createBy,
            'perpage' => $perpage,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $province = $this->order->optionProvince();
        $district = $this->order->optionDistrict();
        $segment = $this->customer->segmentOption();

        return view('product::customer.add',[
            'province' => $province,
            'district' => $district,
            'segment' => $segment,
        ]);
    }

    public function store(Store $request)
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);
        $result = $this->customer->store($data);

        return response()->json($result);
    }

    public function edit($id)
    {
        $province = $this->order->optionProvince();
        $district = $this->order->optionDistrict();
        $list = $this->customer->detail($id);
        $segment = $this->customer->segmentOption();
        if($list == null){
            return redirect('error-404');
        }
        return view('product::customer.edit',
        [
            'list' => $list,
            'id' => $id,
            'province' => $province,
            'district' => $district,
            'segment' => $segment,
        ]);
    }

    public function editPost(Update $request)
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);
        $result = $this->customer->editCustomer($data);
        return response()->json([
            'error' => true,
            'message' => $result
        ]);
    }

    public function detail( $id)
    {
        $province = $this->order->optionProvince();
        $district = $this->order->optionDistrict();
        $customer = $this->customer->detail($id);
        $list_order = $this->order->countOrder(['id' => $id]);
        $data_service = $this->service->getListServiceId(['id' => $id]);
        $data = $this->contract->getListContract(['id' => $id]);
        $list_receipt = $this->receipt->getListReceiptId(['id' => $id]);

        $param=$customer['customer_email'];
        $c_childAccount = $this->customer->getTotalChildAccount($id, $param);
        $contractFile = $this->contract->getContractFile();

        $count_order = $list_order['list_order']->count();
        $count_service = $data_service['list_service']->total();
        $count_contract = $data['list']->total();
        $count_receipt = $list_receipt->total();
        $segment = $this->customer->segmentOption();
        if ($customer != null) {
            return view('product::customer.detail',
                [
                    'customer' => $customer,
                    'list' => $data['list'],
                    'list_service' => $data_service['list_service'],
                    'list_receipt' => $list_receipt,
                    'list_order' => $list_order['list_order'],
                    'c_childAccount' => $c_childAccount,
                    'province' => $province,
                    'district' => $district,
                    'contractFile' => $contractFile,
                    'cService' => $count_service,
                    'cContract' => $count_contract,
                    'cReceipt' => $count_receipt,
                    'cOrder' => $count_order,
                    'filter' => $param,
                    'segment' => $segment,
                ]);
        } else {
         return redirect('error-404');
        }
    }
    /**
     * service by id customer
     * @param Request $request
     *
     * @return json
     */
    public function listService(Request $request)
    {
        $filter = $request->all();
        $filter['id'] = $request->customer_id;
        unset($filter['customer_id']);
        $oList = $this->service->getListServiceId($filter);
        $list = [
            'meta' => [
                'page' => $oList['list_service']->currentPage(),
                'pages' => $oList['list_service']->lastPage(),
                'total' => $oList['list_service']->total(),
                'perpage' => $oList['list_service']->perPage(),
                'sort' => 'asc',
                'field' => 'id'
            ],
            'data' => $oList['list_service']->items()
        ];
        return response()->json($list);
    }

    /**
     * contract by id customer
     * @param Request $request
     *
     * @return json
     */
    public function listContract(Request $request)
    {
        $filters = $request->all();
        $filters['id'] = $request->customer_id;
        unset($filters['customer_id']);
        $oList = $this->contract->getListContract($filters);
        $list = [
            'meta' => [
                'page' => $oList['list']->currentPage(),
                'pages' => $oList['list']->lastPage(),
                'total' => $oList['list']->total(),
                'perpage' => $oList['list']->perPage(),
                'sort' => 'asc',
                'field' => 'id'
            ],
            'data' => $oList['list']->items()
        ];
        return response()->json($list);
    }

    /**
     * order by id customer
     * @param Request $request
     *
     * @return json
     */
    public function listOrder(Request $request)
    {
        $filter = $request->all();
        $filter['id'] = $request->customer_id;
        unset($filter['customer_id']);
        $oList = $this->order->getListOrder($filter);
        $list = [
            'meta' => [
                'page' => $oList['list_order']->currentPage(),
                'pages' => $oList['list_order']->lastPage(),
                'total' => $oList['list_order']->total(),
                'perpage' => $oList['list_order']->perPage(),
                'sort' => 'asc',
                'field' => 'id'
            ],
            'data' => $oList['list_order']->items()
        ];

        return response()->json($list);
    }

    /**
     * receipt by id customer
     * @param Request $request
     *
     * @return json
     */
    public function listReceipt(Request $request)
    {
        $filter = $request->all();
        $filter['id'] = $request->customer_id;
        unset($filter['customer_id']);
        $oList = $this->receipt->getListReceiptId($filter);
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
     * child account by id customer
     * @param Request $request
     *
     * @return json
     */
    public function listChildAccount(Request $request)
    {
        $filters = $request->all();
        $oList = $this->customer->getListChildAccount($filters);
        $list = [
          'meta' =>[
              'page' => $oList->currentPage(),
              'pages' => $oList->lastPage(),
              'total' => $oList->total(),
              'perpage' => $oList->perPage(),
              'sort' => 'asc',
              'field' => 'id'
          ],
            'data' => $oList->items()
        ];

        return  response()->json($list);
    }

    /**
     * Upload file(pdf)
     * @param Request $request
     *
     * @return mixed
     */
    public function upload(Request $request)
    {
        $file = $image = $request->file('file');
        $id = intval($request->id);

        $result = $this->contract->upload($id, $file);

        return $result;
    }

    /**
     * function change Status of customer account
     */
    public function changeStatusMyStoreUserAction(Request $request)
    {

        $data=[
            'is_active' => $request->is_actived
        ];

        $this->customer->changeStatus($data, $request->id);

        return response()->json([
            'error' => false,
            'message' => __('product::customer.index.CHANGE_STATUS_SUCCESS')
        ]);
    }

    /**
     * function edit infon child account
    */
    public function editChildAccountAcction(childUpdate $request)
    {
        $data = $request->all();
        unset($data['is_active']);
        return $this->customer->updateChildAccount($data, $data['customer_account_id']);
    }

    /**
     * function show form edit child account
    */
    public function showChildAccountAcction($id)
    {
        $detail = $this->customer->getDetailChildAccount($id);
        $accountType = $this->customer->getAccountType();
        $province = $this->customer->getLisAllProvince();
        return view('product::customer.editChildAccount',[
            'detail' => $detail,
            'accountType' => $accountType,
            'province' => $province,
        ]);
    }

    /**
     * function show popup ResetPassword
    */
    public function showResetPassword(Request $request)
    {
        $data = $request->all();
        $detail = $this->customer->getDetailChildAccount($data['customer_account_id']);
        return view( 'product::customer.popup.popup-reset-password',[
            'detail' => $detail,
        ]);
    }

    /**
     * function show popup ResetPassword
     */
    public function updatePassword(Request $request)
    {
        $data =$request->all();
        $result = $this->customer->updatePassWord($data, $data['customer_account_id']);
        return $result;
    }

    /**
     * function add child account
    */
    public function addChildAccount(Request $request,$id)
    {
        $customer_id = $id;
        $accountType = $this->customer->getAccountType();
        $province = $this->customer->getLisAllProvince();
        return view('product::customer.addChildAccount',[
            'accountType' =>$accountType,
            'province' => $province,
             'customer_id' => $customer_id,
        ]);
    }


    /**
     * function store child account
    */
    public function createChildAccount(childStore $request)
    {
        $param = $request->all();
        $result = $this->customer->createAccount($param);
        return $result;
    }

    /**
     * function active/deactive cho tk khach hang
     * @param Request $request
     * @return mixed
     */
    public function changeStatusCustomer(Request $request)
    {
        $param = $request->all();
        $result =  $this->customer->changeStatusCustomer($param['email'], $param['is_active']);
        return $result;
    }

    public function newVerify()
    {
        $filter = $this->request->session()->get('newVerify');
        return view('user::account.new-verify', [
            'filter' => $filter
        ]);
    }
}
