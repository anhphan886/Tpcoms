<?php

namespace Modules\Product\Http\Controllers;

use Modules\Product\Repositories\Customer\CustomerRepositoryInterface;
use Carbon\Carbon;
use function Composer\Autoload\includeFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\attributeGroup\Store;
use Modules\Product\Repositories\Order\OrderRepositoryInterface;
use Modules\Ticket\Http\Requests\Ticket\TicketStoreRequest;
use Modules\Ticket\Repositories\Issue\IssueRepositoryInterface;
use Modules\Ticket\Repositories\IssueGroup\IssueGroupRepositoryInterface;
use Modules\Ticket\Repositories\Ticket\TicketRepositoryInterface;
use Modules\Ticket\Repositories\TicketQueue\TicketQueueRepositoryInterface;
use Modules\Ticket\Models\TicketTable;
use Modules\Product\Repositories\Attribute\AttributeRepositoryInterface;

class OrderController extends Controller
{
    protected $order;
    protected $service;
    /**
     * @var TicketRepositoryInterface
     */
    private $ticket;

    /**
     * @var TicketQueueRepositoryInterface
     */
    private $ticketQueue;

    /**
     * @var IssueGroupRepositoryInterface
     */
    private $issueGroup;

    /**
     * @var IssueRepositoryInterface
     */
    private $issue;
    private $attribute;

    private $enumType = [
        'staff_support' => 'Staff Support',
        'staff_deploy' => 'Staff Deploy',
        'cs_support' => 'Customer Support',
    ];

    public function __construct(
        OrderRepositoryInterface $order,
        CustomerRepositoryInterface $service,
        TicketRepositoryInterface $ticket,
        TicketQueueRepositoryInterface $ticketQueue,
        IssueGroupRepositoryInterface $issueGroup,
        IssueRepositoryInterface $issue,
        TicketTable $ticketT,
        AttributeRepositoryInterface $attribute
    ) {
        $this->order = $order;
        $this->service = $service;
        $this->ticket = $ticket;
        $this->ticketQueue = $ticketQueue;
        $this->issueGroup = $issueGroup;
        $this->issue = $issue;
        $this->ticketT = $ticketT;
        $this->attribute = $attribute;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filter = request()->all();

        $data = $this->order->getList($filter);
        $province = $this->order->optionProvince();
        $district = $this->order->optionDistrict();

        $status = $this->order->status();
        $arrStatusTemp =[];
        foreach ($status as $key => $value) {
            if ($value['order_status_id'] == 3 ) {
                unset($status[$key]);
            } else {
                $arrStatusTemp[] = $value;
            }
        }

        $product = $this->order->optionProduct();
        $createBy = $this->order->optionCreateBy();
        $perpage = isset($filter['perpage']) ? $filter['perpage'] : PAGING_ITEM_PER_PAGE;
//        dd($data['filter']);
        return view(
            'product::order.index', [
            'list'     => $data['list'],
            'filter'   => $data['filter'],
            'province' => $province,
            'district' => $district,
            'status'   => $arrStatusTemp,
            'product'  => $product,
            'createBy' => $createBy,
            'perpage' => $perpage
        ]);
    }

    /**
     * Get district by province
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getDistrict(Request $request)
    {
        $id = $request->province_id;
        $district = $this->order->optionDistrict(['province_id' => $id]);
        return $district;

    }

    public function create(Request $request){
        $request->session()->remove('order_id');

        $sessionId = uniqid();

        $sessionCart = $request->session()->get('arrCart');

        $sessionCart[$sessionId] = [];

        $request->session()->put('arrCart',$sessionCart);

        $arrResult = $this->order->create();
        $arrResult['sessionId'] = $sessionId;
        return view('product::order.create', $arrResult);
    }

    /**
     * Chi tiết đơn hàng.
     * @param $id
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function edit(Request $request, $code){
        $request->session()->remove('order_id');

        $arrResult = $this->order->edit($code);
//        dd($arrResult);
        if ($arrResult['arrOrder'] == null){
            return redirect('error-404');
        } else {
            if ($arrResult['arrOrder']['is_adjust'] == 1) {
                $arrOption = $this->order->create();
                $orderDetail = $this->order->getItemByCode($code);
                $customerService = $this->order->getCustomerService(['customer_id' => $orderDetail['customer_id']]);
//                dd($customerService);
                return view('product::order.edit-adjust',
                    [
                        'arrOption' => $arrOption,
                        'orderDetail' => $orderDetail,
                        'customerService' => $customerService,
                    ]
                );
            } else {
                $arrResult['sessionId'] = $code;
//                dd($arrResult);
                return view('product::order.edit', $arrResult);
            }
        }
    }

    /**
     * Get detail
     * @param $code
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function detail($code)
    {
        $status = $this->order->status();
        $arrStatusTemp =[];
        foreach ($status as $key => $value) {
            if ($value['order_status_id'] == 3 ) {
                unset($status[$key]);
            } else {
                $arrStatusTemp[] = $value;
            }
        }
//        dd($arrStatusTemp);
        $orderSelect = $this->order->getItemByCode($code);
        if ($orderSelect != null) {
            $order = $this->order->detail(['order_id' => $orderSelect['order_id']]);
            $arrOrderDetail = $this->order->getListOrderDetail($code);
            $arrResult = $this->order->getDetail($code);

            return view(
                'product::order.detail', [
                'status' => $arrStatusTemp,
                'order' => $order,
                'orderSelect' => $orderSelect,
                'arrOrderDetail' => $arrOrderDetail['arrOrderDetail'],
                'arrAttribute' => $arrResult['arrAttribute'],
            ]);
        } else {
            return redirect()->route('product.order');
        }
    }

    public function approveAdjustOrder(Request $request){
        $orderId = $request->input('order_id');
        $type = $request->input('type');
        $result = $this->order->approveAdjustOrder($orderId, $type);

        return \response()->json($result);
    }
    public function approveOrder(Request $request){
        $orderId = $request->input('order_id');
        $option = $request->input('option');
        $value = $request->input('value');

        $result = $this->order->approveOrder($orderId, $option, $value);

        return \response()->json($result);
    }

    public function payOrder(Request $request){
        $orderId = $request->input('order_id');
        $result = $this->order->payOrder($orderId);

        return \response()->json($result);
    }

    public function loadPopupCreateOrder(Request $request)
    {
        $id = $request->input('id');
        $orderId = session()->get('order_id');
        $sessionId = $request->input('sessionId');
        $arrCartDetail = [];
        $allAttribute = $this->order->allAttribute(0, []);

        if(isset($id)){
            if(isset($orderId)){
                $sessionCart = $request->session()->get('arrCartUpdate', []);
                $arrCart = $sessionCart[$orderId];
            }
            else{
                $sessionCart = $request->session()->get('arrCart', []);
                $arrCart = $sessionCart[$sessionId];
            }
            //Thuộc tính bán kèm.
            $arrCartDetail['arrCart'] = $arrCart[$id];

            //Thêm mảng nhóm thuộc tính bán kèm của sản phẩm.
            $getAttributeGroupBK = $this->order->getAttributeGroupBK($arrCart[$id]['product_id']);
            $arrCartDetail['key'] = $id;
            //Các thuộc tính bán kèm.
            $arrayTemp = [];
            if (!isset($arrCartDetail['arrCart']['value_sold_together'])
                && !isset($arrCartDetail['arrCart']['attribute_sold_together'])) {
                $attBK = $this->order->getListByProductId($arrCart[$id]['product_id']);
                $arrayTemp = [
                    'value_sold_together' => [],
                    'attribute_sold_together' => []
                ];
                foreach ($attBK as $k1 => $v1) {
                    if (isset($arrCartDetail['arrCart']['value'][$v1['product_attribute_id']])) {
                        if ($v1['quantity_attribute'] == 0) {
                            $arrayTemp['value_sold_together'][$v1['product_attribute_id']] =  $v1['product_attribute_id'];
                        } else {
                            $arrayTemp['attribute_sold_together'][$v1['product_attribute_id']] =  $v1['product_attribute_id'];
                        }
                    }
                }
            }

            $arrCartDetail['id'] = $id = $arrCart[$id]['product_id'];
            $arrCartDetail['arrCart']['allAttribute'] = $allAttribute;
            $arrCartDetail['arrCart'] = array_merge($arrCartDetail['arrCart'], $arrayTemp);
        }
        $arrResult = $this->order->loadPopupCreateOrder($id);
        $arrResult = $arrResult + $arrCartDetail;

        $arrResult['sessionId'] = $sessionId;

        return response()->json([
            'error' => false,
            'data' => view('product::order.popup.popup-create-order', $arrResult)->render()
        ]);
    }

    public function loadProduct(Request $request)
    {
        $id = $request->input('id');

        $arrResult = $this->order->loadProduct($id);
        return response()->json([
            'error' => false,
            'data' => view('product::order.popup.load-product', $arrResult)->render()
        ]);
    }

    public function addCart(Request $request){

        $data = $request->all();
        $sessionId = $data['sessionId'];

        $key = $request->input('key', null);
        $data['month'] = 1;
        $orderId = $request->session()->get('order_id');

        //Nhóm bán kèm.
        $arrayTemp = [
            'value_sold_together' => [],
            'attribute_sold_together' => []
        ];

        if (isset($data['value_sold_together'])) {
            if (count($data['value_sold_together']) > 0) {
                foreach ($data['value_sold_together'] as $k => $it) {
                    $arrayTemp['value_sold_together'][$k] = $it;
                }
            }
            unset($data['value_sold_together']);
        }
        if (isset($data['attribute_sold_together'])) {
            if (count($data['attribute_sold_together']) > 0) {
                foreach ($data['attribute_sold_together'] as $k => $it) {
                    $arrayTemp['attribute_sold_together'][$k] = $it;
                }
            }
            unset($data['attribute_sold_together']);
        }

        if($orderId) {
            $sessionCart = $request->session()->get('arrCartUpdate', []);
            $arrCart = $sessionCart[$orderId];
            if(isset($key)){
                if(isset($arrCart[$key])){
                    $arrCart[$key]['value'] = $data['value'];
                    $arrCart[$key]['value_sold_together'] = $arrayTemp['value_sold_together'];
                    $arrCart[$key]['attribute_sold_together'] = $arrayTemp['attribute_sold_together'];
                }
                $message = 'Cập nhật giỏ hàng thành công';
            } else {
                $arrCart = array_merge($arrCart, [array_merge($data, $arrayTemp)]);
                $message = 'Thêm vào giỏ hàng thành công';
            }
            $sessionCart[$orderId] = $arrCart;
            $request->session()->put('arrCartUpdate', $sessionCart);
            $sessionPromotion = $request->session()->get('arrPromotionUpdate', []);
            $request->session()->remove('arrPromotionUpdate', $sessionPromotion);
            //Sản phẩm đính kèm
        } else {

            $sessionCart = $request->session()->get('arrCart', []);
            $arrCart = $sessionCart[$sessionId];

            if(isset($key)){
                if(isset($arrCart[$key])){
                    $arrCart[$key] = array_merge($data, $arrayTemp);
                }
                $message = 'Cập nhật giỏ hàng thành công';
            } else {
                $arrCart = array_merge($arrCart, [array_merge($data, $arrayTemp)]);
                $message = 'Thêm vào giỏ hàng thành công';
            }

            $sessionCart[$sessionId] = $arrCart;

            $request->session()->put('arrCart', $sessionCart);
            $sessionPromotion = $request->session()->get('arrPromotion', []);
            $request->session()->remove('arrPromotion', $sessionPromotion);
        }
        return \response()->json(['error' => 0, 'message' => $message]);

    }

    public function deleteCart(Request $request){
        $key = $request->input('key');
        $sessionId = $request->input('sessionId');
        $orderId = $request->session()->get('order_id');

        if($orderId){

            // xoa cart session
            $sessionCart = $request->session()->get('arrCartUpdate', []);

            unset($sessionCart[$orderId][$key]);

            $request->session()->put('arrCartUpdate', $sessionCart);

            // check neu giam gia lon hon thi xoa luon giam gia
            $sessionPromotion = $request->session()->get('arrPromotionUpdate', []);

            $arrPromotion = $sessionPromotion[$orderId];

            if($arrPromotion) {
                $arrPromotion['sessionId'] = $orderId;
                $arrPromotion['order_id'] = $orderId;
                // update lại giảm giá
                $promotion = $this->order->addPromotion($arrPromotion);
                if($promotion['error']){
                    unset($sessionPromotion[$orderId]);
                    $request->session()->put('arrPromotionUpdate', $sessionPromotion);
                }
            }

        } else {

            $sessionCart = $request->session()->get('arrCart', []);
            unset($sessionCart[$sessionId][$key]);
            $request->session()->put('arrCart', $sessionCart);

            $sessionPromotion = $request->session()->get('arrPromotion', []);
            $arrPromotion = @$sessionPromotion[$sessionId];

            if($arrPromotion) {
                $arrPromotion['sessionId'] = $sessionId;
                // update lại giảm giá
                $promotion = $this->order->addPromotion($arrPromotion);

                if($promotion['error']){
                    unset($sessionPromotion[$sessionId]);
                    session()->put('arrPromotion', $sessionPromotion);
                }
            }
        }

        return \response()->json(['error' => 0, 'message' => 'Xóa sản phẩm thành công']);
    }

    public function loadCart(Request $request){
        try{
            $data = $request->all();
            $sessionId = $data['sessionId'];

            $arrResult = $this->order->loadCart($sessionId);

            $orderId = $request->session()->get('order_id');

            if($orderId){
                $sessionPromotion = $request->session()->get('arrPromotionUpdate', []);

                if(isset($sessionPromotion[$orderId])){
                    if (isset($sessionPromotion[$orderId])) {
                        $arrPromotion = $sessionPromotion[$orderId];

                        $arrPromotion['order_id'] = $orderId;
                        if(isset($arrPromotion)) {
                            $arrPromotion['sessionId'] = $data['sessionId'];
//                            // update lại giảm giá
                            if ($arrPromotion['voucher_type'] != 'code') {
                                $promotion = $this->order->addPromotion($arrPromotion);
                                if (isset($promotion['data'])) {
                                    $sessionPromotion[$orderId]['total'] = $promotion['data'];
                                }
//                            } else {
//                                if ($arrPromotion['total']) {
//                                    $promotion['data'] = $arrPromotion['total'];
//                                    $sessionPromotion[$orderId]['total'] = $promotion['data'];
//                                }
//                            }
                            } else {
                                $promotion = $this->order->addPromotion($arrPromotion);
                                if (isset($promotion['data'])) {

                                    $sessionPromotion[$orderId]['total'] = $promotion['data'];

                                } else {
                                    $promotion['data'] = 0;
                                    $sessionPromotion[$orderId]['total'] = $promotion['data'];
                                }
                            }
//
                            $request->session()->put('arrPromotionUpdate',$sessionPromotion);
//
                            $arrResult['arrPromotion']['total'] = $promotion['data'];
                        }
                    }
                }
            } else {

                $sessionPromotion = $request->session()->get('arrPromotion', []);
                $arrPromotion = @$sessionPromotion[$sessionId];

                if(isset($arrPromotion)) {
                    $arrPromotion['sessionId'] = $data['sessionId'];
                    // update lại giảm giá
                    if ($arrPromotion['voucher_type'] != 'code') {
                        $promotion = $this->order->addPromotion($arrPromotion);
                        $sessionPromotion[$orderId]['total'] = $promotion['data'];
//                    } else {
//                        $promotion['data'] = $arrPromotion['total'];
//                        $sessionPromotion[$orderId]['total'] = $promotion['data'];
//                    }
                    } else {
                        $promotion = $this->order->addPromotion($arrPromotion);
                        if (isset($promotion['data'])) {
                            $sessionPromotion[$orderId]['total'] = $promotion['data'];
                        } else {
                            $promotion['data'] = 0;
                            $sessionPromotion[$orderId]['total'] = $promotion['data'];
                        }
                    }

                    $request->session()->put('arrPromotion',$sessionPromotion);

                    $arrResult['arrPromotion']['total'] = $promotion['data'];
                }
            }
            $arrResult['orderId'] = $orderId;

            $html = view('product::order.load-cart', $arrResult)->render();
            return \response()->json(['error' => 0, 'data' => $html]);
        } catch (\Exception $ex){
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }

    }

    public function updateMonth(Request $request){
        $key = $request->input('key');
        $month = $request->input('month');
        $orderId = $request->session()->get('order_id');
        $sessionId = $request->input('sessionId');

        if($orderId){
            $sessionCart = $request->session()->get('arrCartUpdate', []);

            $sessionCart[$orderId][$key]['month'] = $month;

            $request->session()->put('arrCartUpdate', $sessionCart);
        } else {
            $sessionCart = $request->session()->get('arrCart', []);

            $sessionCart[$sessionId][$key]['month'] = $month;

            $request->session()->put('arrCart', $sessionCart);
        }

        return \response()->json(['error' => 0]);
    }

    public function loadPromotion(Request $request){

        $orderId = $request->session()->get('order_id');

        $sessionId = $request->input('sessionId');

        if($orderId){
            $sessionPromotion = $request->session()->get('arrPromotionUpdate', []);

            if(isset($sessionPromotion[$orderId])){
                $arrPromotion = $sessionPromotion[$orderId];
            }
        } else {
            $sessionPromotion = $request->session()->get('arrPromotion', []);
            $arrPromotion = @$sessionPromotion[$sessionId];
        }

        $arrPromotion['sessionId'] = $sessionId;

        $html = view('product::order.popup.popup-promotion', $arrPromotion)->render();

        return \response()->json(['error' => 0, 'data' => $html]);
    }

    public function addPromotion(Request $request){
        $data = $request->all();

        $data['cash_money_value'] = str_replace(',','', $data['cash_money_value']);
        $sessionId = $data['sessionId'];

        if($data['voucher_type'] == 'code'){
            if ($data['voucher_code'] == ''){
                return [
                    'error' => 1,
                    'data' => 0,
                    'message' => 'Vui lòng nhập mã khuyến mãi'
                ];
            }
        } else {
            if($data['cash_type'] == 'money' && $data['cash_money_value'] === ''){
                return [
                    'error' => 1,
                    'data' => 0,
                    'message' => 'Vui lòng nhập số tiền giảm'
                ];
            } else if($data['cash_type'] == 'percent' && $data['cash_percent_value'] === '') {
                return [
                    'error' => 1,
                    'data' => 0,
                    'message' => 'Vui lòng nhập phần trăm giảm'
                ];
            }
        }
        $sessionId = $data['sessionId'];

        $sessionCart = $request->session()->get('arrCart', []);
//        dd($sessionCart, $sessionId);
        if (count($sessionCart) > 0 ) {
            if(isset($sessionCart[$sessionId]) && count($sessionCart[$sessionId]) <= 0 ){
                return [
                    'error' => 1,
                    'data' => 0,
                    'message' => 'Giảm giá không thể áp dụng khi chưa chọn dịch vụ'
                ];
            }
            if(isset($sessionCart[$sessionId]) && count($sessionCart[$sessionId]) > 1){
                return [
                    'error' => 1,
                    'data' => 0,
                    'message' => 'Giảm giá không thể áp dụng cho nhiều dịch vụ'
                ];
            }
        }

        $arrPromotion = $data;

        $orderId = $request->session()->get('order_id');
        if($arrPromotion['voucher_type'] == 'cash' && $arrPromotion['cash_type'] == 'money')
            $arrPromotion['cash_percent_value'] = 0;
        elseif ($arrPromotion['voucher_type'] == 'cash' && $arrPromotion['cash_type'] == 'percent')
            $arrPromotion['cash_money_value'] = 0;

        $arrResult = $this->order->addPromotion($data);
        if($arrResult['error']){
            return \response()->json($arrResult);
        }

        $arrPromotion['total'] = $arrResult['data'];

        if($orderId){
            $sessionPromotion = $request->session()->get('arrPromotionUpdate');
            $sessionPromotion[$orderId] = $arrPromotion;
            $request->session()->put('arrPromotionUpdate', $sessionPromotion);
        } else {

            $sessionPromotion = $request->session()->get('arrPromotion', []);
            $sessionPromotion[$sessionId] = $arrPromotion;
            $request->session()->put('arrPromotion', $sessionPromotion);
        }
        return \response()->json(['error' => 0, 'message' => $arrResult['message']]);
    }

    public function doOrder(Request $request){
        $params = $request->all();
//        dd($params);
        if($params['source'] == 'private'){
            if(!$params['customer_id']){
                $arrResult =  [
                    'error' => 1,
                    'message' => ' Vui lòng chọn khách hàng'
                ];

                return \response()->json($arrResult);
            }
        }
        if(!$params['staff_id']){
            $arrResult =  [
                'error' => 1,
                'message' => 'Vui lòng chọn nhân viên hỗ trợ'
            ];

            return \response()->json($arrResult);
        }

        $arrResult = $this->order->doOder($params);

        return \response()->json($arrResult);
    }

    /**
     * Load sang trang tạo đơn hàng điều chỉnh
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function createOrderAdjust()
    {
        $arrOption = $this->order->create();

        return view('product::order.add-adjust',
            [
                'arrOption' => $arrOption
            ]
        );
    }

    /**
     * Lấy thông tin chi tiết của dịch vụ.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetailService(Request $request)
    {
        $customerServiceId = $request->customer_service_id;
        $detailAttribute = $this->attribute->getDetailAttribute($customerServiceId);
        $serviceDetail = $this->service->getDetail($customerServiceId);
        $result = [
            'serviceDetail' => $serviceDetail,
            'detailAttribute' => $detailAttribute,
        ];

        return response()->json($result);
    }

    /**
     * Load thuộc tính sản phẩm để điều chỉnh dịch vụ.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function loadPopupCreateOrderAdjust(Request $request)
    {
        $data = $request->all();

        $arrResult = $this->order->loadPopupCreateOrderAdjust($data);

        return response()->json([
            'error' => false,
            'data' => view('product::order.popup.adjust.popup-adjust', $arrResult)->render()
        ]);
    }

    /**
     * Điều chỉnh dịch vụ.
     * @param Request $request
     *
     * @return mixed
     */
    public function adjustService(Request $request)
    {
        $data = $request->all();
        $detailAttribute = $this->attribute->getDetailAttribute($data['customer_service_id']);
        $data['customer_service_detail'] = count($detailAttribute) > 0 ? $detailAttribute->toArray() : [];
        $arrResult = $this->order->adjustService($data);

        return $arrResult;
    }

    /**
     * Tạo đơn hàng điều chỉnh
     * @param Request $request
     *
     * @return mixed
     */
    public function submitCreateOrderAdjust(Request $request)
    {
        $data = $request->all();
        $arrResult = $this->order->submitCreateOrderAdjust($data);
        return $arrResult;
    }

    /**
     * Load thông tin gói dịch vụ.
     * @param Request $request
     *
     * @return mixed
     */
    public function getPackageOrderAdjust(Request $request)
    {
        $data = $request->all();
        $orderDetail = $this->order->getItemByCode($data['order_code']);

        $detailAttribute = $this->attribute->getDetailAttribute($orderDetail['customer_service_id']);
        $data['customer_service_detail'] = count($detailAttribute) > 0 ? $detailAttribute->toArray() : [];
        $data['customer_service_id'] = $orderDetail['customer_service_id'];

        $arrResult = $this->order->getPackageOrderAdjust($data);

        return $arrResult;
    }

    public function getListServiceByCustomer(Request $request)
    {
        $data = $request->only(['customer_id']);

        $customer = $this->order->getDetailCustomer($data['customer_id']);

        $listService = $this->order->getListService([
            'customer_id' => $customer['customer_id']
        ]);

        return [
            'error' => 0,
            'message' => 'Success',
            'data' => $listService
        ];
    }
}
