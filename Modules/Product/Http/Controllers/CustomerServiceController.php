<?php

namespace Modules\Product\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Models\OrderTable;
use Modules\Product\Repositories\Customer\CustomerRepositoryInterface;
use Modules\Core\Repositories\Admin\AdminRepositoryInterface;
use Modules\Product\Models\CustomerContractTable;
use Modules\Product\Models\CustomerServiceTable;
use Modules\Product\Repositories\Attribute\AttributeRepositoryInterface;
use Modules\Ticket\Repositories\Ticket\TicketRepository;
use Modules\Product\Repositories\Order\OrderRepositoryInterface;
use Modules\Vcloud\Repositories\Vcloud\VcloudRepositoryInterface;

class CustomerServiceController extends Controller
{
    protected $service;
    protected $admin;
    protected $request;
    protected $attribute;
    protected $mService;
    protected $mOrder;
    protected $orderTable;
    protected $mCusContract;
    public function __construct(
        CustomerRepositoryInterface $service,
        AdminRepositoryInterface $admin,
        CustomerServiceTable $mService,
        Request $request,
        AttributeRepositoryInterface $attribute,
        TicketRepository $ticketTable,
        OrderRepositoryInterface $mOrder,
        OrderTable $orderTable,
        CustomerContractTable $mCusContract
    ){
        $this->service = $service;
        $this->admin = $admin;
        $this->request = $request;
        $this->attribute = $attribute;
        $this->mService = $mService;
        $this->mTicket = $ticketTable;
        $this->mOrder = $mOrder;
        $this->orderTable = $orderTable;
        $this->mCusContract = $mCusContract;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $param = $this->request->all();

        $data_service = $this->service->getListAllService($param);
        $optionCustomer = $this->service->getOptionCustomer();
        $perpage = isset($param['perpage']) ? $param['perpage'] : PAGING_ITEM_PER_PAGE;
        $param['page'] = isset($param['page']) ? $param['page'] : 1;

        return view('product::service.index', [
            'list' => $data_service['data'],
            'filter' => $param,
            'optionCustomer' => $optionCustomer,
            'perpage' => $perpage,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('product::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $customer_service_id
     * @return Response
     */
    public function show($customer_service_id)
    {
        $detailAttribute = $this->attribute->getDetailAttribute($customer_service_id);
        $detail = $this->service->getDetail($customer_service_id);
        try{
            $vcloudData = null;//$this->vCloud->getDetail($customer_service_id);
        }catch(\Exception $e){
            $vcloudData = null;
        }
        return response(view('product::service.detail',[
            'detail' => $detail,
            'detailAttribute' => $detailAttribute,
            'detailVm' => $vcloudData
        ]))->header('Cache-Control', 'no-cache')
        ->header('Pragma', 'no-cache');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($customer_service_id)
    {
        $listStaff = $this->admin->getListAll();
        $detail = $this->service->getDetail($customer_service_id);

        return view('product::service.edit',[
            'detail' => $detail,
            'listStaff' => $listStaff,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request )
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);
        $result = $this->service->update($data, $data['customer_service_id']);
        return $result;

    }
    /**
     * get detail json.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function detail(Request $request)
    {
        $id = $request->input('customer_service_id');
        return $this->service->getDetail($id);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
     /**
     *
     * @param int $id
     * @return Response
     */
    public function resume(Request $request)
    {
        $id = $request->input('customer_service_id');
        $serviceDetail = $this->mService->getDetail($id);
        $ticketDetail = $this->mTicket->getDetailByCustomerId($id);
        $ticketMain = $ticketDetail[0];

        $result = $this->service->update([
            'status' => 'actived',
            'customer_service_id' => $id
        ], $id);
        $status = $this->mTicket->add(
            [
            "ticket_title"=> "[RESUME SERVICE][".$serviceDetail['product_name_vi']."]",
            "description"=> null,
            "issue_id"=> RESUME_SERVICE_SUPPORT_ISSUE,// hardcode 3	Database	NULL	2	4	60	15	15
            "issue_level"=> DEPLOY_SUPPORT_ISSUE_LEVEL,
            "crictical_level"=> 1,
            "date_issue"=> \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            "customer_service_id"=> $id,
            "customer_account_id" => $ticketMain['customer_account_id'],
            "customer_id" => $serviceDetail['customer_id'],
            "queue_process_id"=> DEPLOY_SUPPORT_QUEUE,// hardcode
            "operate_by"=> null,
            "platform"=> "web"
            ]
        );
        return $result;
    }

     /**
     *
     * @param int $id
     * @return Response
     */
    public function extendsService(Request $request)
    {
        $data = $request->all();
        $service_id = $data['customer_service_id'];
        array_filter($data);
        unset($data['_token']);
        $result = $this->service->extendsService($data, $service_id);
        return  $result;
    }

    /**
     * function stop payment
    */
    public function stopPayment(Request $request)
    {
        $data = $request->all();
        $service_id = $data['customer_service_id'];
        array_filter($data);
        unset($data['_token']);
        $result = $this->service->stopPayment($data, $service_id);
        return $result;
    }

    /**
     * get attribute json.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function getAttributeService(Request $request)
    {
        $id = $request->input('customer_service_id');
        return $this->attribute->getDetailAttribute($id);
    }

}
