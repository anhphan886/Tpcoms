<?php

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/18/2019
 * Time: 9:47 AM
 */

namespace Modules\Product\Repositories\Order;

use App\Http\Controllers\TraitSendMail;
use App\Mail\Receipt;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Customer\Http\Api\CustomerServiceApi;
use Modules\Product\Http\Api\Address;
use Modules\Product\Http\Api\Order;
use Modules\Product\Models\CustomerAccountTable;
use Modules\Product\Models\CustomerContractTable;
use Modules\Product\Models\CustomerServiceDetailTable;
use Modules\Product\Models\CustomerServiceTable;
use Modules\Product\Models\CustomerTable;
use Modules\Product\Models\InvoiceTable;
use Modules\Product\Models\OrderAttributeDetailTable;
use Modules\Product\Models\OrderDetailTable;
use Modules\Product\Models\OrderTable;
use Modules\Product\Models\PortalAdminTable;
use Modules\Product\Models\ProductAttributeGroupMapTable;
use Modules\Product\Models\ProductAttributeGroupTable;
use Modules\Product\Models\ProductAttributeMapTable;
use Modules\Product\Models\ProductAttributeTable;
use Modules\Product\Models\ProductTable;
use Modules\Product\Models\ProductTemplateAttributeMapTable;
use Modules\Product\Models\ReceiptEmailLogTable;
use Modules\Product\Models\ReceiptTable;
use Modules\Product\Models\ReceiptMapTable;
use Modules\Ticket\Repositories\Ticket\TicketRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Product\Models\OrderStatusTable;
use Modules\Product\Models\InvoiceMapTable;
use Modules\Product\Models\ContractAnnexTable;


class OrderRepository implements OrderRepositoryInterface
{
    use TraitSendMail;

    protected $mAdmin;
    protected $orderApi;
    protected $address;
    protected $mOrder;
    protected $mOrderDetail;
    protected $mOrderAttributeDetail;
    protected $mCustomer;
    protected $mCustomerAccount;
    protected $mCusService;
    protected $mCusServiceDetail;
    protected $mCusContract;
    protected $mInvoice;
    protected $mReceipt;
    protected $mProduct;
    protected $mProductAttributeMap;
    protected $mProductAttribute;
    protected $mProductAttributeGroup;
    protected $mReceiptMap;
    protected $productAttributeGroupMap;
    protected $orderStatus;
    protected $invoiceMap;
    protected $mAnnex;
    protected $mTemplateMap;

    public function __construct(
        PortalAdminTable $adminTable,
        Order $orderApi,
        Address $address,
        OrderTable $orderTable,
        OrderDetailTable $orderDetailTable,
        OrderAttributeDetailTable $orderAttributeDetailTable,
        CustomerTable $customerTable,
        CustomerServiceTable $customerServiceTable,
        CustomerServiceDetailTable $customerServiceDetailTable,
        CustomerContractTable $customerContractTable,
        CustomerAccountTable $customerAccountTable,
        InvoiceTable $invoiceTable,
        ReceiptTable $receiptTable,
        TicketRepository $ticketTable,
        ProductTable $productTable,
        ProductAttributeMapTable $productAttributeMap,
        ProductAttributeGroupTable $mProductAttributeGroup,
        ProductAttributeTable $attributeTable,
        ReceiptMapTable $receiptMapTable,
        ProductAttributeGroupMapTable $productAttributeGroupMap,
        OrderStatusTable $orderStatus,
        InvoiceMapTable  $invoiceMap,
        ContractAnnexTable $annexTable,
        ProductTemplateAttributeMapTable $mTemplateMap
    ) {
        $this->mAdmin = $adminTable;
        $this->orderApi = $orderApi;
        $this->address = $address;
        $this->mOrder = $orderTable;
        $this->mOrderDetail = $orderDetailTable;
        $this->mOrderAttributeDetail = $orderAttributeDetailTable;
        $this->mCustomer = $customerTable;
        $this->mCustomerAccount = $customerAccountTable;
        $this->mCusService = $customerServiceTable;
        $this->mCusServiceDetail = $customerServiceDetailTable;
        $this->mCusContract = $customerContractTable;
        $this->mInvoice = $invoiceTable;
        $this->mReceipt = $receiptTable;
        $this->mTicket = $ticketTable;
        $this->mProduct = $productTable;
        $this->mProductAttribute = $attributeTable;
        $this->mProductAttributeMap = $productAttributeMap;
        $this->mProductAttributeGroup = $mProductAttributeGroup;
        $this->mReceiptMap = $receiptMapTable;
        $this->productAttributeGroupMap = $productAttributeGroupMap;
        $this->orderStatus = $orderStatus;
        $this->invoiceMap = $invoiceMap;
        $this->mAnnex  = $annexTable;
        $this->mTemplateMap = $mTemplateMap;
    }

    /**
     * Option tỉnh / thành
     * @param array $data
     * @return mixed
     */
    public function optionProvince(array $data = [])
    {
        $filer = [];
        if (isset($data['province_id'])) {
            $filer = ['province_id' => $data['province_id']];
        }
        return $this->address->optionProvince($filer);
    }

    /**
     * Option quận / huyện.
     * @param array $data
     * @return mixed
     */
    public function optionDistrict(array $data = [])
    {
        $filer = [];
        if (isset($data['province_id'])) {
            $filer = ['province_id' => $data['province_id']];
        }
        return $this->address->optionDistrict($filer);
    }

    /**
     * Option trạng thái đơn hàng
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function status(array $data = [])
    {
        return $this->orderApi->status($data);
    }

    /**
     * Option sản phẩm / dịch vụ
     * @param array $data
     *
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function optionProduct(array $data = [])
    {
        return $this->orderApi->optionProduct($data);
    }

    /**
     * Option người tạo
     * @param array $data
     *
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function optionCreateBy(array $data = [])
    {
        return $this->orderApi->optionCreateBy($data);
    }
    public function getList(array $data = [])
    {
//        dd($data);
        $filters['keyword'] = isset($data['keyword']) ? $data['keyword'] : null;
        $filters['province_id'] = isset($data['province_id']) ? $data['province_id'] : null;
        $filters['district_id'] = isset($data['district_id']) ? $data['district_id'] : null;
        $filters['created_by'] = isset($data['created_by']) ? $data['created_by'] : null;
        $filters['product_id'] = isset($data['product_id']) ? $data['product_id'] : null;
        $filters['order_status_id'] = isset($data['order_status_id']) ? $data['order_status_id'] : null;
        $filters['page'] = isset($data['page']) ? $data['page'] : 1;
        $filters['perpage'] = isset($data['perpage']) ? $data['perpage'] : PAGING_ITEM_PER_PAGE;
        $filters['user_id'] = Auth::id();
        // Date time created at.
        if (isset($data["created_at"])) {
            $arr_filter = explode(" - ", $data["created_at"]);
            $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])->format('Y-m-d');
            $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])->format('Y-m-d');
            $filters['created_at']['from'] = $startTime . ' 00:00:00';
            $filters['created_at']['to'] = $endTime . ' 23:59:59';
        }
//        dd($filters);
        $result = $this->orderApi->getList($filters);

        if (isset($result['list']['Items']) && count($result['list']['Items']) > 0) {
            $items = $result['list']['Items'];
            $pageInfo = $result['list']['PageInfo'];
            $result = new LengthAwarePaginator(
                $items,
                $pageInfo['total'],
                $pageInfo['itemPerPage'],
                $pageInfo['currentPage'],
                ['path' => url()->current()]
            );
        } else {
            $result = null;
        }
        if (isset($data["created_at"])) {
            $filters['created_at'] = $data["created_at"];
        } else {
            $filters['created_at'] = '';
        }
//        dd($filters);

        return [
            'list' => $result,
            'filter' => $filters,
        ];
    }

    public function create()
    {

        try {
            $arrCustomer = $this->mCustomer->getListAll();
            $arrProduct = $this->mProduct->getListProduct();
            $arrStaff = $this->mAdmin->getOption();

            $arrResult = [
                'arrCustomer' => $arrCustomer,
                'arrProduct' => $arrProduct,
                'arrStaff' => $arrStaff
            ];

            return $arrResult;
        } catch (\Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }
    }

    public function edit($code)
    {
        try {
            $arrCustomer = $this->mCustomer->getListAll();
            $arrOrder = $this->mOrder->getItemByCode($code);
            $arrStaff = $this->mAdmin->getOption();
            $arrStatus = $this->orderStatus->option();

            $arrOrderDetail = $this->mOrderDetail->getListItem($arrOrder['order_id']);
            $arrOrderDetailId = collect($arrOrderDetail)->pluck('order_detail_id');

            $arrOrderAttributeDetail = $this->mOrderAttributeDetail->getListItem($arrOrderDetailId);

            $arrAttribute = [];

            foreach ($arrOrderAttributeDetail as $attr) {
                $arrAttribute[$attr['order_detail_id']][] = $attr;
            }

            $arrCart = [];

            foreach ($arrOrderDetail as $key => $detail) {
                $arrCart[$key] = [
                    'order_id' => $detail['order_id'],
                    'order_detail_id' => $detail['order_detail_id'],
                    'order_type' => $detail['order_type'],
                    'order_price' => $detail['price'],
                    'month' => $detail['quantity'],
                    'product_id' => $detail['product_id']
                ];

                if (isset($arrAttribute[$detail['order_detail_id']])) {
                    foreach ($arrAttribute[$detail['order_detail_id']] as $attribute) {
                        $arrCart[$key]['value'][$attribute['product_attribute_id']] = $attribute['value'];
                    }
                }
            }

            $sessionPromotion[$arrOrder['order_id']] = [
                'voucher_type' => $arrOrder['voucher_type'],
                'voucher_code' => $arrOrder['voucher_code'],
                'cash_type' => $arrOrder['cash_type'],
                'cash_money_value' => $arrOrder['cash_money_value'],
                'cash_percent_value' => $arrOrder['cash_percent_value'],
                'total' => $arrOrder['discount'],
            ];

            session()->put('arrPromotionUpdate', $sessionPromotion);

            $arrCartUpdate[$arrOrder['order_id']] = $arrCart;

            session()->put('arrCartUpdate', $arrCartUpdate);

            session()->put('order_id', $arrOrder['order_id']);

            return [
                'arrOrder' => $arrOrder,
                'arrStaff' => $arrStaff,
                'arrCustomer' => $arrCustomer,
                'arrStatus' => $arrStatus
                //                'arrOrderDetail' => $arrOrderDetail,
                //                'arrOrderAttribute' => $arrOrderAttributeDetail,
                //                'arrProduct' => $arrProduct,
                //                'arrAttribute' => $arrAttribute,
                //                'arrCart' => $arrCart
            ];
        } catch (\Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }
    }

    public function loadPromotionCartEdit($id)
    {
        try {
            $arrOrder = $this->mOrder->getItem($id);

            return $arrOrder['discount'];
        } catch (\Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }
    }

    public function loadPopupCreateOrder($id = null)
    {

        try {
            $arrProduct = $this->mProduct->getListProduct();
            $firstProduct = current($arrProduct);
            if ($id) {
                $idFirstProduct = $id;
            } else {
                $idFirstProduct = $firstProduct['product_id'];
            }
            $arrProductTemplateMap = $this->mProductAttributeMap->getListByProductId($idFirstProduct);
            $arrAttributeGroup = $this->mProductAttributeGroup->getListOrder();

            $arrAttribute = [];
            foreach ($arrProductTemplateMap as $template) {
                $arrAttribute[$template['product_attribute_group_id']][] = $template;
            }

            //Nhóm thuộc tính bán kèm
            $arrAttributeGroupSoldTogether = $this->productAttributeGroupMap->getGroupSoldTogether($idFirstProduct);
            $arrProductAttGroupMap = $this->productAttributeGroupMap->getListByProductId($idFirstProduct);

            $arrAttributeMap = [];
            foreach ($arrProductAttGroupMap as $att) {
                $arrAttributeMap[$att['product_attribute_group_id']][] = $att;
            }
            $arrResult = [
                'arrProduct' => $arrProduct,
                'arrAttribute' => $arrAttribute,
                'arrAttributeGroup' => $arrAttributeGroup,
                'id' => $idFirstProduct,
                'arrAttributeGroupSoldTogether' => $arrAttributeGroupSoldTogether,
                'arrAttributeMap' => $arrAttributeMap,
            ];
            return $arrResult;
        } catch (\Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }
    }

    public function loadProduct($id)
    {

        try {
            $arrProductTemplateMap = $this->mProductAttributeMap->getListByProductId($id);
            $arrAttributeGroup = $this->mProductAttributeGroup->getListOrder();

            $arrAttribute = [];
            foreach ($arrProductTemplateMap as $template) {
                $arrAttribute[$template['product_attribute_group_id']][] = $template;
            }

            //Nhóm thuộc tính bán kèm
            $arrAttributeGroupSoldTogether = $this->productAttributeGroupMap->getGroupSoldTogether($id);
            $arrProductAttGroupMap = $this->productAttributeGroupMap->getListByProductId($id);

            $arrAttributeMap = [];
            foreach ($arrProductAttGroupMap as $att) {
                $arrAttributeMap[$att['product_attribute_group_id']][] = $att;
            }

            $arrResult = [
                'arrAttribute' => $arrAttribute,
                'arrAttributeGroup' => $arrAttributeGroup,
                'id' => $id,
                'arrAttributeGroupSoldTogether' => $arrAttributeGroupSoldTogether,
                'arrAttributeMap' => $arrAttributeMap,
            ];
            return $arrResult;
        } catch (\Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }
    }

    public function loadCart($sessionId)
    {

        try {
            $orderId = session()->get('order_id');

            $arrOrder = [];
            if (isset($orderId)) {
                $sessionCart = session()->get('arrCartUpdate', []);
                $arrCart = $sessionCart[$orderId];
                $arrOrder = collect($this->mOrderDetail->getListItem($orderId))->keyBy('order_detail_id')->toArray();
            } else {
                $sessionCart = session()->get('arrCart', []);
                $arrCart = $sessionCart[$sessionId];
            }

            $arrProductId = collect($arrCart)->pluck('product_id');

            $arrAttributeId = [];
            if ($arrCart) {
                foreach ($arrCart as $itemCart) {
                    foreach ($itemCart['value'] as $key => $value) {
                        $arrAttributeId[$key] = $key;
                    }
                }
            }

            $arrProduct = collect($this->mProduct->getListInProduct($arrProductId))->keyBy('product_id')->toArray();

            $arrAttribute = collect($this->mProductAttribute->getListIn($arrAttributeId))->keyBy('product_attribute_id')->toArray();
            //Nhóm thuộc tính bán kèm
            $allAttribute = $this->mProductAttribute->optionAll(0, []);
            if ($arrCart) {
                foreach ($arrCart as $kkk => $a) {
                    $temp = [];
                    if (isset($a['value_sold_together'])) {
                        foreach ($a['value_sold_together'] as $key => $value) {
                            if (intval($value) != 0) {
                                $temp[$value] = '1';
                            }
                        }
                    }
                    if (isset($a['attribute_sold_together'])) {
                        foreach ($a['attribute_sold_together'] as $key => $value) {
                            if (intval($value) != 0) {
                                $temp[$value] = '1';
                            }
                        }
                    }
                    if (count($temp) > 0) {
                        $resultTemp = [];
                        //Hợp mảng cũ và mảng mới lại với nhau
                        foreach ($arrCart[$kkk]['value'] as $t1 => $t2) {
                            $resultTemp[$t1] = $t2;
                        }
                        foreach ($temp as $t3 => $t4) {
                            $resultTemp[$t3] = $t4;
                        }
                        $arrCart[$kkk]['value'] = $resultTemp;
                    }
                }
            }

            $arrResult = [
                'arrProduct' => $arrProduct,
                'arrAttribute' => $arrAttribute,
                'arrCart' => $arrCart,
                'arrOrder' => $arrOrder,
                'allAttribute' => $allAttribute,
            ];
            return $arrResult;
        } catch (\Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }
    }

    public function doOder($data)
    {

        DB::beginTransaction();
        try {
            $arrResult = $this->loadCart($data['sessionId']);

            //            if(isset($data['order_id']) && $data['order_id'] != null && isset($data['order_status_id']) && isset($data['order_content'])) {
            //                $data = [
            //                    'order_id' => $data['order_id'],
            //                    'order_status_id' => $data['order_status_id'],
            //                    'order_content' => strip_tags($data['order_content']),
            //                ];
            //                $result = $this->mOrder->edit($data, $data['order_id']);
            //                return [
            //                    'error' => 0,
            //                    'message' => 'Cập nhật đơn hàng thành công',
            //                    'data' => $result
            //                ];
            //            }

            if (!$arrResult['arrCart']) {
                return [
                    'error' => 1,
                    'message' => 'Vui lòng thêm ít nhất 1 sản phẩm'
                ];
            }
            $idOrder = session()->get('order_id');


            if ($idOrder) {

                $arrOrder = $this->mOrder->getDetailItem($idOrder);
                $arrOrderDetail = $this->mOrderDetail->getListItem($idOrder);

                $orderCode = $arrOrder['order_code'];
                $orderDate = $arrOrder['created_at'];

                $this->mOrderDetail->deleteItem($idOrder, 'order_id');
                $arrOrderDetailId = collect($arrOrderDetail)->pluck('order_detail_id');

                $this->mOrderAttributeDetail->deleteItemArray($arrOrderDetailId, 'order_detail_id');

                $arrCustomerAccount = $this->mCustomerAccount->getAdmin($arrOrder['customer_id']);

                $sessionPromotion = session()->get('arrPromotionUpdate', []);

                $arrPromotion = $sessionPromotion[$idOrder];

                $message = 'Cập nhật đơn hàng thành công';
                $sessionUnset = $idOrder;

                $arrInsertEmail = [
                    'object_id' => $idOrder,
                    'template_type' => 'update',
                    'email_type' => 'order',
                    'email_subject' => EMAIL_SUBJECT_ORDER_UPDATE,
                    'email_to' => $arrCustomerAccount['account_email'],
                    'email_from' => env('MAIL_FROM_ADDRESS'),
                    'email_from_name' => env('MAIL_FROM_NAME'),
                ];
            } else {
                $arrCustomerAccount = $this->mCustomerAccount->getAdmin($data['customer_id']);
                $orderCode = getCode(CODE_ORDER, $this->mOrder->getNumberForCode());
                $orderDate = Carbon::now();
                $arrInsertOrder = [
                    'order_code' => $orderCode,
                    'customer_id' => $arrCustomerAccount['customer_id'],
                    'order_status_id' => 1,
                    'source' => 'private',
                    'created_by' => Auth::id(),
                    'created_at' => $orderDate,
                    'updated_at' => Carbon::now(),
                    'updated_by' => Auth::id(),
                ];
                $idOrder = $this->mOrder->insertItem($arrInsertOrder);

                $sessionPromotion = session()->get('arrPromotion', []);
                $arrPromotion = @$sessionPromotion[$data['sessionId']];
                $message = 'Tạo đơn hàng thành công';

                $sessionUnset = $data['sessionId'];

                $arrInsertEmail = [
                    'object_id' => $idOrder,
                    'template_type' => 'success',
                    'email_type' => 'order',
                    'email_subject' => EMAIL_SUBJECT_ORDER_SUCCESS,
                    'email_to' => $arrCustomerAccount['account_email'],
                    'email_from' => env('MAIL_FROM_ADDRESS'),
                    'email_from_name' => env('MAIL_FROM_NAME'),
                ];
            }

            //Mảng data gửi email
            $arrOrderDetailEmail = [];

            $total = 0;
            foreach ($arrResult['arrCart'] as $key => $cart) {
                $moneyCart = 0;
                if (isset($cart['order_id']) && @$cart['order_type'] == 'default') {
                    $arrInsertOrderDetail = [
                        'order_id' => $idOrder,
                        'order_type' => 'default',
                        'product_id' => $cart['product_id'],
                        'price' => $cart['order_price'],
                        'amount' => $cart['order_price'] * $cart['month'],
                        'quantity' => $cart['month'],
                        'type' => 'month',
                        'created_at' => Carbon::now(),
                        'created_by' => $arrCustomerAccount['customer_account_id'],
                        'updated_at' => Carbon::now(),
                        'updated_by' => Auth::id(),
                    ];

                    $idOrderDetail = $this->mOrderDetail->insertItem($arrInsertOrderDetail);
                    $package_detail = [];
                    foreach ($cart['value'] as $attributeId => $value) {
                        $arrInsertOrderAttribute = [
                            'order_detail_id' => $idOrderDetail,
                            'product_attribute_id' => $attributeId,
                            'value' => $value,
                            'price' => $arrResult['arrAttribute'][$attributeId]['price_month'],
                            'amount' => 0,
                        ];

                        $package_detail['vi'][$arrResult['arrAttribute'][$attributeId]['product_attribute_name_vi'] . ' ' . $arrResult['arrAttribute'][$attributeId]['unit_name']] = $value;
                        $package_detail['en'][$arrResult['arrAttribute'][$attributeId]['product_attribute_name_en'] . ' ' . $arrResult['arrAttribute'][$attributeId]['unit_name']] = $value;

                        $this->mOrderAttributeDetail->insertItem($arrInsertOrderAttribute);
                        $this->mOrderDetail->updateItem($idOrderDetail, 'order_detail_id', [
                            'package_vi' => json_encode($package_detail['vi']),
                            'package_en' => json_encode($package_detail['en'])
                        ]);
                        $moneyCart += $arrResult['arrAttribute'][$attributeId]['price_month'] * $value * $cart['month'];
                    }

                    //                    $moneyCart += $cart['order_price'] * $cart['month'];
                    $total += $moneyCart;
                } else {
                    $arrInsertOrderDetail = [
                        'order_id' => $idOrder,
                        'order_type' => 'custom',
                        'product_id' => $cart['product_id'],
                        'price' => 0,
                        'amount' => 0,
                        'quantity' => $cart['month'],
                        'type' => 'month',
                        'created_at' => Carbon::now(),
                        'created_by' => $arrCustomerAccount['customer_account_id'],
                        'updated_at' => Carbon::now(),
                        'updated_by' => Auth::id(),
                    ];
                    $idOrderDetail = $this->mOrderDetail->insertItem($arrInsertOrderDetail);
                    $package_detail = [];
                    $moneyAttr = 0;
                    foreach ($cart['value'] as $attributeId => $value) {
                        if (isset($arrResult['arrAttribute'][$attributeId]['price_month'])) {
                            $amount = $arrResult['arrAttribute'][$attributeId]['price_month'] * $value;
                            $arrInsertOrderAttribute = [
                                'order_detail_id' => $idOrderDetail,
                                'product_attribute_id' => $attributeId,
                                'value' => $value,
                                'price' => $arrResult['arrAttribute'][$attributeId]['price_month'],
                                'amount' => $amount,
                            ];
                            $this->mOrderAttributeDetail->insertItem($arrInsertOrderAttribute);
                            $moneyAttr += $amount;
                            $package_detail['vi'][$arrResult['arrAttribute'][$attributeId]['product_attribute_name_vi'] . ' ' . $arrResult['arrAttribute'][$attributeId]['unit_name']] = $value;
                            $package_detail['en'][$arrResult['arrAttribute'][$attributeId]['product_attribute_name_en'] . ' ' . $arrResult['arrAttribute'][$attributeId]['unit_name']] = $value;
                        }
                    }
                    //Thuộc tính bán kèm.
                    if (isset($cart['value_sold_together']) && count($cart['value_sold_together']) > 0) {
                        foreach ($cart['value_sold_together'] as $s => $t) {
                            foreach ($arrResult['allAttribute'] as $att => $all) {
                                if ($t != 0 && $t == $all['product_attribute_id']) {
                                    $amount = $all['price_month'];
                                    $arrInsertOrderAttribute = [
                                        'order_detail_id' => $idOrderDetail,
                                        'product_attribute_id' => $s,
                                        'value' => 1,
                                        'price' => $amount,
                                        'amount' => $amount,
                                    ];
                                    $this->mOrderAttributeDetail->insertItem($arrInsertOrderAttribute);
                                    $moneyAttr += $amount;
                                    $package_detail['vi'][$all['product_attribute_name_vi'] . ' ' . $all['unit_name']] = 1;
                                    $package_detail['en'][$all['product_attribute_name_en'] . ' ' . $all['unit_name']] = 1;
                                }
                            }
                        }
                    }
                    if (isset($cart['attribute_sold_together']) && $cart['attribute_sold_together'] != 0) {
                        foreach ($cart['attribute_sold_together'] as $s => $t) {
                            foreach ($arrResult['allAttribute'] as $att => $all) {
                                if ($t != 0 && $t == $all['product_attribute_id']) {
                                    $amount = $all['price_month'];
                                    $arrInsertOrderAttribute = [
                                        'order_detail_id' => $idOrderDetail,
                                        'product_attribute_id' => $t,
                                        'value' => 1,
                                        'price' => $amount,
                                        'amount' => $amount,
                                    ];
                                    $this->mOrderAttributeDetail->insertItem($arrInsertOrderAttribute);
                                    $moneyAttr += $amount;
                                    $package_detail['vi'][$all['product_attribute_name_vi'] . ' ' . $all['unit_name']] = 1;
                                    $package_detail['en'][$all['product_attribute_name_en'] . ' ' . $all['unit_name']] = 1;
                                }
                            }
                        }
                    }

                    $this->mOrderDetail->updateItem($idOrderDetail, 'order_detail_id', [
                        'price' => $moneyAttr,
                        'amount' => $moneyAttr * $cart['month'],
                        'package_vi' => json_encode($package_detail['vi']),
                        'package_en' => json_encode($package_detail['en'])
                    ]);

                    $moneyCart += $moneyAttr * $cart['month'];
                    $total += $moneyCart;
                }

                $arrOrderDetailEmail[$key] = [
                    'quantity' => $cart['month'],
                    'amount' => $moneyCart,
                    'product_name' => $arrResult['arrProduct'][$cart['product_id']]['product_name_vi'],
                    'package' => $package_detail
                ];
            }
            if (isset($data['voucher_code'])) {

                $tmp = [
                    'code' => strip_tags(strtoupper($data['voucher_code'])),
                    'required_price' => $total
                ];

                $check = $this->orderApi->getMoneyVoucher($tmp);
                if (!isset($check['money'])) {
                    return [
                        'error' => 1,
                        'message' => 'Voucher không thể sử dụng'
                    ];
                }

                $arrVouchersLog = [
                    'order_id' => $idOrder,
                    'voucher_id' => $check['voucher_id'],
                    'code' => strip_tags(strtoupper($data['voucher_code'])),
                    'value' => strip_tags($check['money']),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
                $addVoucherLog = $this->orderApi->createVoucherLog($arrVouchersLog);
            }

            $discount = @$arrPromotion['total'];

            if (isset($check['money']) && isset($arrPromotion['voucher_type']) && $arrPromotion['voucher_type'] == 'code') {
                $this->mOrder->updateItem($idOrder, 'order_id', [
                    //                    'voucher_code' => strip_tags(strtoupper($data['voucher_code'])),
                    'voucher_code' => strip_tags(strtoupper($arrPromotion['voucher_code'])),
                    'voucher_type' => 'code',
                    'cash_type' => $check['type'] == 'sale_percent' ? 'percent' : 'money',

                ]);
            } else if (isset($arrPromotion['voucher_type']) && $arrPromotion['voucher_type'] == 'cash') {
                $this->mOrder->updateItem($idOrder, 'order_id', [
                    'voucher_code' => '',
                    'voucher_type' => 'cash',
                    'cash_type' => isset($arrPromotion['cash_type']) ? $arrPromotion['cash_type'] : null,
                ]);
                $arrDeleteVoucherLog = [
                    'order_id' => $idOrder
                ];
                $this->orderApi->deleteVoucherLog($arrDeleteVoucherLog);
            }

            if ($idOrder) {
                $getDetail = $this->mOrder->getDetailItem($idOrder);
                if ($getDetail['voucher_code'] != null && $getDetail['total'] != null) {
                    $tmp = [
                        'code' => $getDetail['voucher_code'],
                        'required_price' => $total,
                        'order_id' => $idOrder
                    ];
                    $check = $this->orderApi->getMoneyVoucher($tmp);

                    if (!isset($check['money'])) {
                        $discount = 0;
                        $this->mOrder->updateItem($idOrder, 'order_id', [
                            'voucher_code' => '',
                            'voucher_type' => 'cash',
                            'cash_type' => null,
                        ]);
                        $arrDeleteVoucherLog = [
                            'order_id' => $idOrder
                        ];
                        $this->orderApi->deleteVoucherLog($arrDeleteVoucherLog);
                        //                        return [
                        //                            'error' => 1,
                        //                            'message' => 'Voucher không thể sử dụng'
                        //                        ];
                    }
                } else if ($getDetail['voucher_code'] == null && $getDetail['total'] == null) {
//                    $discount = 0;
                    $discount = @$arrPromotion['total'];
                }
            }

            $vat = (($total - $discount) / 10) > 0 ? ($total - $discount) / 10 : 0;

            $amount = ($total - $discount) + $vat > 0 ? ($total - $discount) + $vat : 0;

            $status = 1;
            $content = '';
            if (isset($data['order_status_id'])) {
                $status = $data['order_status_id'];
            }
            if (isset($data['order_content'])) {
                $content = $data['order_content'];
            }
            $this->mOrder->updateItem($idOrder, 'order_id', [
                'staff_id' => $data['staff_id'],
                'order_status_id' => $status,
                'order_content' => $content,
                'total' => $total,
                'discount' => $discount,
                'vat' => $vat,
                'amount' => $amount,
                'cash_money_value' => @$arrPromotion['cash_money_value'],
                'cash_percent_value' => @$arrPromotion['cash_percent_value'],
                'updated_by' => Auth::id(),
            ]);
            /**
             * send Email
             */

            $arrInsertEmail['email_params'] = [
                'full_name' => $arrCustomerAccount['account_name'],
                'order_code' => $orderCode,
                'order_date' => $orderDate->format('Y-m-d H:i:s'),
                'order_total' => $total,
                'order_vat' => $vat,
                'order_discount' => $discount,
                'order_amount' => $amount,
                'arrCart' => $arrOrderDetailEmail
            ];

            $this->buildEmail($arrInsertEmail);

            /**
             * END
             */
            DB::commit();

            //un set session đó
            if ($idOrder) {
                $sessionCart = session()->get('arrCart');
                unset($sessionCart[$sessionUnset]);
                session()->put('arrCart', $sessionCart);

                $sessionPromotion = session()->get('arrPromotion');
                unset($sessionPromotion[$sessionUnset]);
                session()->put('arrPromotion', $sessionPromotion);
            } else {
                $sessionCart = session()->get('arrCartUpdate');
                unset($sessionCart[$sessionUnset]);
                session()->put('arrCartUpdate', $sessionCart);

                $sessionPromotion = session()->get('arrPromotionUpdate');
                unset($sessionPromotion[$sessionUnset]);
                session()->put('arrPromotionUpdate', $sessionPromotion);
            }
            return [
                'error' => 0,
                'message' => $message
            ];
        } catch (\Exception $ex) {
            DB::rollBack();
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }
    }

    public function addPromotion($data)
    {
        try {

            $arrResult = $this->loadCart($data['sessionId']);
            $arrResult['arrPromotion'] = $data;

            if ($arrResult['arrPromotion']['voucher_type'] == 'code') {
                if ($arrResult['arrPromotion']['voucher_code'] == '') {
                    return [
                        'error' => 1,
                        'data' => 0,
                        'message' => 'Vui lòng nhập mã khuyến mãi'
                    ];
                }
            }

            $total = 0;

            foreach ($arrResult['arrCart'] as $cart) {
                if (isset($cart['order_type']) && $cart['order_type'] == 'default') {
                    $money = $cart['month'] * $cart['order_price'];
                    $total += $money;
                } else {
                    foreach ($cart['value'] as $attributeId => $value) {
                        if (isset($arrResult['arrAttribute'][$attributeId]['price_month'])) {
                            $money = $arrResult['arrAttribute'][$attributeId]['price_month'] * $value * $cart['month'];
                            $total += $money;
                        }
                    }
                    //Thuộc tính bán kèm
                    if (isset($cart['value_sold_together']) && count($cart['value_sold_together']) > 0) {
                        foreach ($cart['value_sold_together'] as $k => $v) {
                            foreach ($arrResult['allAttribute'] as $att) {
                                if ($att['product_attribute_id'] == $k) {
                                    $money = intval($att['price_month']) * $cart['month'];
                                    $total += $money;
                                }
                            }
                        }
                    }
                    if (isset($cart['attribute_sold_together']) && $cart['attribute_sold_together'] != 0) {
                        foreach ($arrResult['allAttribute'] as $att) {
                            if ($att['product_attribute_id'] == $cart['attribute_sold_together']) {
                                $money = intval($att['price_month']) * $cart['month'];
                                $total += $money;
                            }
                        }
                    }
                }
            }
            $promotion = 0;

            if ($arrResult['arrPromotion']['voucher_type'] == 'cash' && $arrResult['arrPromotion']['cash_type'] == 'money')
                $promotion = $arrResult['arrPromotion']['cash_money_value'];
            elseif ($arrResult['arrPromotion']['voucher_type'] == 'cash' && $arrResult['arrPromotion']['cash_type'] == 'percent') {
                $promotion = $arrResult['arrPromotion']['cash_percent_value'] * $total / 100;
            } elseif ($arrResult['arrPromotion']['voucher_type'] == 'code') {

                if (isset($data['order_id'])) {
                    $tmp = [
                        'code' => strip_tags(strtoupper($arrResult['arrPromotion']['voucher_code'])),
                        'required_price' => $total,
                        'order_id' => $data['order_id']
                    ];
                } else {
                    $tmp = [
                        'code' => strip_tags(strtoupper($arrResult['arrPromotion']['voucher_code'])),
                        'required_price' => $total
                    ];
                }

                $getVoucherMoney = $this->getMoneyVoucher($tmp);
                if (!isset($getVoucherMoney['money'])) {
                    return [
                        'error' => 1,
                        'message' => 'Mã khuyến mãi không hợp lệ'
                    ];
                }
                $promotion = $getVoucherMoney['money'];

            }

            if ($promotion > $total) {
                return [
                    'error' => 1,
                    'message' => 'Số tiền giảm lớn hơn tiền đơn hàng'
                ];
            }

            return [
                'error' => 0,
                'data' => $promotion,
                'message' => 'Thêm giảm giá thành công'
            ];
        } catch (\Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }
    }

    public function detail(array $data = [])
    {
        return $this->orderApi->detail($data);
    }
    private function genAttributeKeyArray($arr)
    {
        $tmp = [];
        foreach ($arr as $value) {
            $id = $value['product_attribute_id'];
            $tmp['product_attribute_id_' . $id] = $value;
        }
        return $tmp;
    }
    public function approveAdjustOrder($orderId, $type)
    {
        if($type == 'cancel'){
            $this->mOrder->updateStatusItem($orderId, STATUS_TICKET_CANCEL);
            return ['error' => 0, 'message' => 'Hủy đơn hàng thành công!'];
        }
        try {
            $arrOrderDetail = $this->detail(['order_id' => $orderId]);
            $orderDetailName = $arrOrderDetail['order_detail'];
            $orderInfo = $arrOrderDetail['order_info'];
            $customerSvId = $orderInfo['customer_service_id'];
            $cusService = $this->mCusService->getDetail($customerSvId);
            $customerID = $cusService['customer_id'];
            $contract_id = $cusService['customer_contract_id'];
            $startDay = Carbon::parse($cusService['last_billing'] ?? $cusService['charg_date']);
            $endDay = Carbon::parse($cusService['stop_payment_at'] ?? Carbon::now());

            $contract_annex_no =getCode(CODE_CONTRACT_ANNEX, $this->mAnnex->getNumberForCode());

            $paymentType = $cusService['payment_type'];
            if(empty($cusService['expired_date']) && empty($cusService['charg_date'])){
                return ['error' => 1, 'message' => 'Dịch vụ cần điều chỉnh chưa có thể tính phí'];
            }
            $orderDetail = $this->mOrderDetail->getOrderDetail($orderId)[0];
            $oldPriceHours = $cusService['price'] / 30 / 24;
            $newPriceHours = $orderDetail['price'] / 30 / 24;
            $hoursLeft = Carbon::now()->diffInHours(Carbon::parse($cusService['expired_date']));
            $hoursTotal = Carbon::parse($cusService['charg_date'])->diffInHours(Carbon::parse($cusService['expired_date']));
            $billingDate = Carbon::now();
//            dd($newPrice, $oldPrice);
            if($paymentType == 'prepaid'){ // trả trước
                $total = ($newPriceHours - $oldPriceHours) * ($hoursLeft / $hoursTotal) * $hoursLeft;
                // tạo billing, receipt , invoice, invoice mapp
                $billing = app()->get(\Modules\Billing\Models\BillingTable::class);
                $newBillingId = $billing->insertItem([
                    'contract_id' => $cusService['customer_contract_id'],
                    'billing_date' => $billingDate,
                    'total' => $total,
                    'created_at' => Carbon::now()
                ]);
                $receipt_no = getCode(CODE_RECEIPT, $this->mReceipt->getNumberForCode());

//                dd($total, $total*0.1);
                $receiptId = $this->mReceipt->add([
                    'receipt_no' => $receipt_no,
                    'customer_contract_id' => $cusService['customer_contract_id'],
                    'order_id' => $orderId,
                    'amount' => $total,
                    'pay_expired' => Carbon::now()->addDays(7), // hardcode
                    'vat' => $total * 0.1,
                    'status' => 'unpaid',
                    'receipt_content' => 'Phiếu thu đơn hàng nâng cấp',
                    'is_actived' => 1,
                    'is_deleted' => 0,
                    'created_by' => 1,
                    'created_at' => Carbon::now(),
                    'modified_by' => 1,
                    'modified_at' => Carbon::now()
                ]);
                $dataInsertInvoice = [
                    'invoice_no' => getCode(CODE_INVOICE, $this->mInvoice->getNumberForCode()),
                    'net' => $total,
                    'vat' => $total * 0.1,
                    'billing_id' => $newBillingId,
                    'amount' => $total * 1.1,
                    'status' => 'new',
                    'customer_id' => $cusService['customer_id'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => 1,
                ];
                $invoiceId = $this->mInvoice->add($dataInsertInvoice);
                $dataInvoiceMap = [
                    'invoice_id' => $invoiceId,
                    'receipt_id' => $receiptId,
                    'net' => intval($dataInsertInvoice['net']),
                    'vat' => $dataInsertInvoice['vat'],
                    'amount' => $dataInsertInvoice['amount'],
                ];
                $this->invoiceMap->add($dataInvoiceMap);
            }else if($paymentType == 'postpaid'){ // trả sau
                $billingDetail = app()->get(\Modules\Billing\Models\BillingDetailTable::class);
                $billingDetail->insertItem([
                    'customer_service_id' => $customerSvId,
                    'billing_date' => $billingDate,
                    'from_date' => $startDay,
                    'to_date' => $endDay,
                    'total' => $cusService['price'],
                    'type' => 'charge',
                    'created_at' => $billingDate
                ]);
            }else if($paymentType == 'payuse'){ // trả sau
                $billingDetail = app()->get(\Modules\Billing\Models\BillingDetailTable::class);
                $billingDetail->insertItem([
                    'customer_service_id' => $customerSvId,
                    'billing_date' => $billingDate,
                    'from_date' => $startDay,
                    'to_date' => $endDay,
                    'total' => $oldPriceHours * ($startDay->diffInHours($endDay)),
                    'type' => 'charge',
                    'created_at' => $billingDate
                ]);
            }
            $this->mCusService->updateService([
                'last_billing' => $billingDate,
                'price' => $orderDetail['price'],
                'amount' => $orderDetail['price'] * $cusService['quantity']
            ], $customerSvId);

            // get customer service detail
            $csDetail = app()->get(\Modules\Product\Models\CustomerServiceDetailTable::class);
            $oldDetail = $csDetail->getDetailByCustomerService($customerSvId);
            $arrOrderDetail = $this->mOrderDetail->listOrderDetail($orderInfo['order_id']);
            $arrOrderDetailId = collect($arrOrderDetail)->pluck('order_detail_id');
            $newDetail = $this->mOrderAttributeDetail->getAttributeByDetail($arrOrderDetailId);

            // delete old attribute
            $oldTemp = $this->genAttributeKeyArray($oldDetail);
            $newTemp = $this->genAttributeKeyArray($newDetail);

            $changedKey = array_values(array_filter(array_keys($oldTemp), function ($key) use ($newTemp) {
                return !in_array($key, array_keys($newTemp));
            }));
            foreach ($changedKey as $value) {
                $attrId = $oldTemp[$value]['product_attribute_id'];
                $csDetail->deleteItemCustomer($customerSvId, $attrId);
            }
            // update + insert new attribute
            foreach ($newDetail as $value) {
                if (!$csDetail->updateItemValue([
                    'value' => $value['value'],
                    'is_deleted' => 0
                ], $customerSvId, $value['product_attribute_id'])) {
                    $csDetail->insertItem([
                        'customer_service_id' => $customerSvId,
                        'product_attribute_id' => $value['product_attribute_id'],
                        'value' => $value['value'],
                        'updated_by' => Auth::id(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }
            $csDetailList = $csDetail->getDetailByCustomerService($customerSvId);
            if(!count($csDetailList) == 0){
                // cpu, ram, disk
                $ram = 0;
                $cpu = 0;
                $disk = 0;
                $socket = 0;
                foreach($csDetailList as $csDetail){
                    if($csDetail['product_attribute_id'] == LIST_ATTRIBUTE['RAM']){
                        $ram = $csDetail['value'] * 1024;
                    }else if($csDetail['product_attribute_id'] == LIST_ATTRIBUTE['CPU']){
                        $cpu = $csDetail['value'];
                    }else if($csDetail['product_attribute_id'] == LIST_ATTRIBUTE['DISK']){
                        $disk = $csDetail['value'] * 1024;
                    }else if($csDetail['product_attribute_id'] == LIST_ATTRIBUTE['SOCKET']){
                        $socket = $csDetail['value'];
                    }
                }
                // check là public cloud hay private cloud
                // nếu là public cloud thì cập nhật vdc rồi cập nhật vms
                // nếu là private cloud thì cập nhật Vdc thôi

            }
            $this->mOrder->updateStatusItem($orderId);

            $arrayAnnex = [
                'contract_annex_no' => $contract_annex_no,
                'customer_contract_id' => $contract_id,
                'created_at' => Carbon::now(),
                'created_by' => Auth::id(),
                'updated_at' => Carbon::now(),
                'updated_by' => Auth::id()
            ];
            $annexNew = $this->mAnnex->insertItem($arrayAnnex);

        /// bẳng ticket ***********************************

//            $product_id = $orderDetail['0']['product_id'];
//            $productNode = $this->mProduct->getItem($product_id);
//            dd($productNode);

            $CustomerAccount = $this->mCustomerAccount->getAdmin($customerID);
            $status = $this->mTicket->add(
                [
                    "ticket_title" => "[SUPPORT UPGRADE][" . $orderDetailName[0]['product_name_vi'] . "]",
                    "description" => null,
                    "issue_id" => DEPLOY_UPGRADE_SERVICE, // hardcode 3	Database	NULL	2	4	60	15	15
                    "issue_level" => DEPLOY_SUPPORT_ISSUE_LEVEL,
                    "crictical_level" => 1,
                    "date_issue" => Carbon::now()->format('Y-m-d H:i:s'),
                    "customer_service_id" => $customerSvId,
                    "customer_account_id" => $CustomerAccount['customer_account_id'],
                    "customer_id" => $customerID,
                    "queue_process_id" => DEPLOY_SUPPORT_QUEUE, // hardcode
                    "operate_by" => null,
                    "platform" => "web",
                    "type" => STAFF_DEPLOY
                ]
            );
            return ['error' => 0, 'message' => 'Duyệt đơn hàng thành công!'];
        } catch (\Exception $e) {
            return [
                'error' => 1,
                'message' => 'Duyệt đơn hàng thất bại!',
                'aaaa' => $e->getMessage(),
            ];
        }
    }

    public function approveOrder($orderId, $option, $value, $confirm=false)
    {
        $type = MODE_REAL;
        if ($option == MODE_TRIAL) {
            $type = MODE_TRIAL;
            $option = MODE_PREPAID;
        }
        DB::beginTransaction();
        try {
            if ($option == TICKET_CANCEL) {
                $this->mOrder->updateStatusItem($orderId, STATUS_TICKET_CANCEL); // 7 == cancel
                DB::commit();
                return ['error' => false, 'message' => 'Hủy đơn hàng thành công'];
            }

            $this->mOrder->updateStatusItem($orderId);
            $arrOrder = $this->mOrder->getDetailItem($orderId);
            if (!isset($arrOrder)) {
                return ['error' => true, 'message' => 'Đơn hàng không tồn tại'];
            }
            $arrOrderDetail = $this->mOrderDetail->getListItem($orderId);
            $arrOrderDetailId = collect($arrOrderDetail)->pluck('order_detail_id');
            $arrOrderAttributeDetail = $this->mOrderAttributeDetail->getListItem($arrOrderDetailId);

            $arrAttribute = [];
            if ($type != MODE_TRIAL) {
                $contract_no = getCode(CODE_CONTRACT, $this->mCusContract->getNumberForCode());
                $contract_annex_no =getCode(CODE_CONTRACT_ANNEX, $this->mAnnex->getNumberForCode());
                $arrInsertContract = [
                    'contract_no' => $contract_no,
                    'customer_id' =>  $arrOrder['customer_id'],
                    'contract_date' => Carbon::now(),
                    'status' => 'new',
                    'created_at' => Carbon::now(),
                    'created_by' => Auth::id(),
                    'updated_at' => Carbon::now(),
                    'updated_by' => Auth::id()
                ];
                $contractNew = $this->mCusContract->insertItem($arrInsertContract);
            }

            foreach ($arrOrderAttributeDetail as $attr) {
                $arrAttribute[$attr['order_detail_id']][] = $attr;
            }
            $amount = 0;
            $issetValue = isset($value);
            $listService = [];
            foreach ($arrOrderDetail as $oderDetail) {
                if (!$issetValue) {
                    $value = $oderDetail['quantity'];
                }
//                dd($arrOrder , $value, $oderDetail['quantity']);
//                dd($arrOrder);
                if ($value != $oderDetail['quantity']) {
                    if ($arrOrder['cash_money_value'] > 0 || $arrOrder['cash_percent_value'] > 0 || $arrOrder['voucher_code'] != null ) {
                        DB::rollBack();
                        return [
                            'error' => true,
                            'message' => 'Đơn hàng hiện đang sử dụng voucher, Voucher này chỉ áp dụng khi số tháng của đơn hàng không đổi'
                        ];
                    }
                }

//               $expireServiceDate = $type == MODE_TRIAL ? Carbon::now()->addDay($value) : Carbon::now()->addMonth($value);
                // get product id to get service type
                $cateId = $this->mProduct->getCategoryId($oderDetail['product_id']);
                $vdcName = 'VDC_PUBLIC_CLOUD';
                if (in_array($cateId, PUBLIC_CLOUD_CATE_TYPE)) {
                    $serviceType = 'public_cloud';
                } else if (in_array($cateId, PRIVATE_CLOUD_CATE_TYPE)) {
                    $serviceType = 'private_cloud';
                } else {
                    $serviceType = 'public_cloud';
                }

//                if(isset($arrOrder['discount'])){
//                    $oderDetail['price'] = ($oderDetail['price'] * $value - intval($arrOrder['discount'])) / $value;
//                }
//                dd($oderDetail['price']);
//                dd(3397500 * $value);
//                dd($value * $oderDetail['price'],$value, $oderDetail);
                $arrInsertService = [
                    'customer_id' => $arrOrder['customer_id'],
                    'product_id' => $oderDetail['product_id'],
                    'payment_type' => $option,
//                    'quantity' => $type == MODE_TRIAL ? '7' :  $value,
                    'quantity' => $value,
                    'type' => $type,
                    'price' => $oderDetail['price'],
                    'service_content' => "",
                    'service_type' => $serviceType,
                    'amount' => $type == MODE_TRIAL ? $oderDetail['price']/30 * $value  : $value * $oderDetail['price'],
                    'customer_contract_id' => isset($contractNew) ? $contractNew : null,
                    // 'actived_date' => Carbon::now(),
                    'expired_date' => $type == MODE_TRIAL ? Carbon::now()->addDays($value) : null,
                    'staff_id' => $arrOrder['staff_id'] ?? Auth::id(),
                    'status' => 'not_actived',
                    'created_at' => Carbon::now(),
                    'created_by' => Auth::id(),
                    'updated_at' => Carbon::now(),
                    'updated_by' => Auth::id()
                ];

                // update order detail
                if ($issetValue) {
                    $tempNew = [];
                    if ($type == MODE_TRIAL) {
                        $tempNew['type'] = 'day';
                    }
                    $tempNew['quantity'] = $value;
                    $tempNew['amount'] = $arrInsertService['amount'];
                    $this->mOrderDetail->edit($tempNew, $oderDetail['order_detail_id']);
                }
                $amount += $arrInsertService['amount'];
//                $amount += $arrOrder['total'];
//                dd($arrInsertService);
                $idService  = $this->mCusService->insertItem($arrInsertService);
                $scheduler = app()->get(\Modules\Vcloud\Models\ScheduleTaskTable::class);
                if($serviceType == 'public_cloud'){
                    $this->mCusService->updateService([
                        'vdc_name' => 'VDC_PUBLIC_CLOUD'
                    ], $idService);
                    $scheduler->add([
                        'controller' => $scheduler->control_list['VCLOUD'],
                        'function' => 'createChainPublicCloudTemplate',
                        'params' => json_encode([
                            'customer_service_id' => $idService,
                        ]),
                        'created_at' => Carbon::now()
                    ]);
                }else if($serviceType == 'private_cloud'){
                    $this->mCusService->updateService([
                        'vdc_name' => 'VDC_'. $idService
                    ], $idService);
                    $scheduler->add([
                        'controller' => $scheduler->control_list['VCLOUD'],
                        'function' => 'createChainPrivateCloud',
                        'params' => json_encode([
                            'customer_service_id' => $idService,
                        ]),
                        'created_at' => Carbon::now()
                    ]);
                }
                $productNode = $this->mProduct->getItem($oderDetail['product_id']);

                $listService[] = [
                    'id_service' => $idService,
                    'name_product' => $productNode['product_name_vi']
                ];

                foreach ($arrAttribute[$oderDetail['order_detail_id']] as $item) {
                    $arrInsertServiceDetail = [
                        'customer_service_id' => $idService,
                        'product_attribute_id' => $item['product_attribute_id'],
                        'value' => $item['value'],
                        'updated_at' => Carbon::now(),
                        'updated_by' => Auth::id()
                    ];

                    $this->mCusServiceDetail->insertItem($arrInsertServiceDetail);
                }
            }
            // update order price and more
            // $arrOrder = $this->mOrder->getDetailItem($orderId);
//            dd($arrOrder);
            if ($issetValue) {
                $tempOrder = [];
                $tempOrder['total'] = $arrOrder['amount'];
                $cashDiscount = 0;
                if ($arrOrder['voucher_type'] == 'cash') {
                    if ($arrOrder['cash_type'] == 'money') {
                        $cashDiscount =  $arrOrder['cash_money_value'];
                        $tempOrder['vat'] = ($amount - $cashDiscount) * 0.1;
                    } elseif ($arrOrder['cash_type'] == 'percent') {
                        $percent = $arrOrder['cash_percent_value'];
                        $cashDiscount = $amount * $percent / 100;
                        $tempOrder['vat'] = ($amount - $cashDiscount) * 0.1;
                    } else {
                        $tempOrder['vat'] = 0.1 * $amount;
                    }
                } else {
                    $cashDiscount = $arrOrder['discount'];
                    $tempOrder['vat'] =($amount - $cashDiscount) * 0.1 ;
                }
                $tempOrder['amount'] =  ($amount - $cashDiscount) + $tempOrder['vat'];
//                dd($tempOrder['amount'], $amount, $cashDiscount, $tempOrder['vat'] );
                $tempOrder['discount'] = $cashDiscount;
                $this->mOrder->edit($tempOrder, $arrOrder['order_id']);
                DB::commit();
            }
            $newArrOrder = $this->mOrder->getDetailItem($orderId);

            $receiptId = '';
            if ($option == MODE_PREPAID && $type != MODE_TRIAL) {
                $receiptId = $this->mReceipt->add([
                    'receipt_no' => getCode(CODE_RECEIPT, $this->mReceipt->getNumberForCode()),
                    'order_id' => $orderId,
                    'amount' => $newArrOrder['amount'] / 1.1,
                    'pay_expired' => Carbon::now()->addMonths(1), // hardcode
                    'vat' => $newArrOrder['vat'],
                    'status' => 'unpaid',
                    'customer_contract_id' => isset($contractNew) ? $contractNew : null,
                    'receipt_content' => 'Phiếu thu cho đơn hàng: ' . $arrOrder['order_code'],
                    'is_actived' => 1,
                    'is_deleted' => 0,
                    'created_by' => Auth::id(),
                    'created_at' => Carbon::now(),
                    'modified_by' => Auth::id(),
                    'modified_at' => Carbon::now()
                ]);

                $dataInsertInvoice = [
                    'invoice_no' => getCode(CODE_INVOICE, $this->mInvoice->getNumberForCode()),
                    'net' => $newArrOrder['amount'] / 1.1,
                    'vat' => $newArrOrder['vat'],
                    'amount' => $newArrOrder['amount'],
                    'status' => 'new',
                    'customer_id' => $newArrOrder['customer_id'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => Auth::id(),
                ];
                $invoiceId = $this->mInvoice->add($dataInsertInvoice);
                //Lưu invoice map.
                $getReceipt = $this->mReceipt->getReceiptByOrder($orderId);
                if (count($getReceipt) > 0) {
                    foreach ($getReceipt as $item) {
                        $dataInvoiceMap = [
                            'invoice_id' => $invoiceId,
                            'receipt_id' => intval($item['receipt_id']),
                            'net' => intval($item['amount']),
                            'vat' => $item['vat'],
                            'amount' => intval($item['amount']) + intval($item['vat']),
                        ];
                        $this->invoiceMap->add($dataInvoiceMap);
                    }
                }
                //Gửi mail khi tạo hóa đơn
                $detailInvoice = $this->mInvoice->getItem($invoiceId);

                $host = request()->getSchemeAndHttpHost();
                $dataEmail = [
                    'type' => 'invoice',
                    'invoice_id' => $invoiceId,
                    'invoice_no' => $detailInvoice['invoice_no'],
                    'amount' => $detailInvoice['amount'],
                    'vat' => $detailInvoice['vat'],
                    'status' => $detailInvoice['status'],
                    'pay_expired' => null,
                    'customer_name' => $detailInvoice['customer_name'],
                    'host' => $host,
                    'subject' => 'Hóa đơn [' . $detailInvoice['invoice_no'] . ']',
                ];
                $view = view(
                    'product::mail.invoice',
                    [
                        'data' => $dataEmail,
                    ]
                )->render();
                $data2 = [
                    'obj_id' => $invoiceId,
                    'obj_code' => $detailInvoice['invoice_no'],
                    'from_address' => env('MAIL_FROM_ADDRESS'),
                    'to_address' => $detailInvoice['customer_email'],
                    'subject' => 'Hóa đơn [' . $detailInvoice['receipt_no'] . ']',
                    'body_html' => $view,
                    'date_created' => Carbon::now(),
                    'date_modified' => Carbon::now(),
                    'is_sent' => 0,
                    'obj_type' => 'invoice',
                ];

                $receiptEmailLog = new ReceiptEmailLogTable();
                $receiptEmailLog->add($data2);
//                Mail::to($detailInvoice['customer_email'])->send(new Receipt($dataEmail));
            }
            DB::commit();
            foreach ($listService as $serviceDetail) {
                // send ticket here
                // $arrOrder['customer_id']
                if ($option == MODE_PREPAID && $type != MODE_TRIAL) {
                    $this->mReceiptMap->add([
                        'receipt_id' => $receiptId,
                        'customer_service_id' => $serviceDetail['id_service'],
                        'created_by' => Auth::id()
                    ]);
                }

                // {
                //     "_token": "gSyYU2PpBi5meienzQA3QHiDm6vOKu0Rgon8TGVj",
                //     "customer_id": "55",
                //     "customer_service_id": "520",
                //     "order_code": "",
                //     "ticket_issue_group_id": "40",
                //     "issue_id": "50",
                //     "issue_level": "2",
                //     "ticket_title": "Ticket+Test",
                //     "description": "Ticket+Test",
                //     "queue_process_id": "5",
                //     "operate_by": "",
                //     "type": "staff_support"
                // }
                // {
                //     "_token": "gSyYU2PpBi5meienzQA3QHiDm6vOKu0Rgon8TGVj",
                //     "customer_id": "55",
                //     "customer_service_id": "520",
                //     "order_code": "",
                //     "ticket_issue_group_id": "40",
                //     "issue_id": "50",
                //     "issue_level": "2",
                //     "ticket_title": "Ticket+Test",
                //     "description": "Ticket+Test",
                //     "queue_process_id": "5",
                //     "operate_by": "",
                //     "type": "staff_support"
                // }

                $data = 
                    [
                        "ticket_title" => "[SUPPORT DEPLOY][" . $serviceDetail['name_product'] . "]",
                            "description" => null,
                            "issue_id" => DEPLOY_SUPPORT_ISSUE, // hardcode 3	Database	NULL	2	4	60	15	15
                            "issue_level" => DEPLOY_SUPPORT_ISSUE_LEVEL,
                            "crictical_level" => 1,
                            "date_issue" => Carbon::now()->format('Y-m-d H:i:s'),
                            "customer_service_id" => $serviceDetail['id_service'],
                            "customer_account_id" => $arrOrder['created_by'],
                            "customer_id" => $arrOrder['customer_id'],
                            "queue_process_id" => DEPLOY_SUPPORT_QUEUE, // hardcode
                            "operate_by" => null,
                            "platform" => "web",
                            "type" => STAFF_DEPLOY,
                            "operate_by"=>18 // hardcode
                    
                        // -----------------------
                    ];
                

                $status = $this->mTicket->add(
                   $data
                );
                if ($status['error'] === 1) {
                    return $status;
                }
            }
            return ['error' => false, 'message' => 'Duyệt đơn hàng thành công'];
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            DB::rollBack();
            return ['error' => true, 'message' => $ex->getMessage()];
        }
    }

    public function payOrder($orderId)
    {

        $this->mOrder->updateStatusItem($orderId, 9);

        $oUser = Auth::guard()->user();

        $arrOrder = $this->mOrder->getDetailItem($orderId);

        $arrInsertInvoice = [
            'invoice_no' => $orderId,
            'order_id' => $orderId,
            'amount' => $arrOrder['amount'],
            'invoice_date' => Carbon::now(),
            'invoice_pay_expired_date' => Carbon::now(),
            'status' => 'unpaid',
            'customer_id' => $arrOrder['customer_id'],
            'created_at' => Carbon::now(),
            'created_by' => Auth::id(),
            'updated_at' => Carbon::now(),
            'updated_by' => Auth::id()
        ];

        $this->mInvoice->insertItem($arrInsertInvoice);

        return ['error' => false, 'message' => 'Thanh toán đơn hàng thành công'];
    }

    public function getListInvoice($filters)
    {
        if (!isset($filters['invoice$invoice_no'])) {
            $filters['invoice$invoice_no'] = null;
        }
        if (!isset($filters['invoice$status'])) {
            $filters['invoice$status'] = null;
        }
        if (!isset($filters['invoice$amount'])) {
            $filters['invoice$amount'] = null;
        }
        if (!isset($filters['invoice$invoice_by'])) {
            $filters['invoice$invoice_by'] = null;
        }
        if (!isset($filters['invoice$invoice_at'])) {
            $filters['invoice$invoice_at'] = null;
        }
        if (!isset($filters['page'])) {
            $filters['page'] = 1;
        }
        $list_invoice = $this->mInvoice->getList($filters);
        return [
            'list_invoice' => $list_invoice,
            'filter' => $filters
        ];
    }

    public function getListDetailInvoice($id)
    {
        $list_invoice = $this->mInvoice->getListInvoice($id);
        return [
            'list_invoice' => $list_invoice
        ];
    }

    public function getListOrder(array $filter = [])
    {
        $list_order = $this->mOrder->getListDataTable($filter);
        return [
            'list_order' => $list_order,
        ];
    }
    public function getListReceipt($filters)
    {
        if (!isset($filters['receipt$receipt_no'])) {
            $filters['receipt$receipt_no'] = null;
        }
        if (!isset($filters['receipt$pay_expired'])) {
            $filters['receipt$pay_expired'] = null;
        }
        if (!isset($filters['receipt$status'])) {
            $filters['receipt$status'] = null;
        }
        if (!isset($filters['receipt$amount'])) {
            $filters['receipt$amount'] = null;
        }
        if (!isset($filters['receipt$receipt_content'])) {
            $filters['receipt$receipt_content'] = null;
        }
        if (!isset($filters['page'])) {
            $filters['page'] = 1;
        }
        //        if (isset($filters["choose_day"])) {
        //            $arr_filter = explode(" - ", $filters["choose_day"]);
        //            $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])->format('Y-m-d');
        //            $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])->format('Y-m-d');
        //            $filters['pay_expired']['from'] = $startTime . ' 00:00:00';
        //            $filters['pay_expired']['to'] = $endTime . ' 23:59:59';
        //        }
        $list_receipt = $this->mReceipt->getList($filters);

        return [
            'list_receipt' => $list_receipt,
            'filter' => $filters
        ];
    }

    public function getItemByCode($code)
    {
        $select = $this->mOrder->getItemByCode($code);
        return $select;
    }

    public function getListOrderDetail($code)
    {
        $arrOrderDetail = $this->mOrder->getListOrderDetail($code);
        return [
            'arrOrderDetail' => $arrOrderDetail
        ];
    }

    public function getDetail($code)
    {
        try {
            $arrOrder = $this->mOrder->detail($code);
            $arrOrderDetail = $this->mOrderDetail->listOrderDetail($arrOrder['order_id']);
            $arrOrderDetailId = collect($arrOrderDetail)->pluck('order_detail_id');
            $arrOrderDetailAttr = $this->mOrderAttributeDetail->getAttributeByDetail($arrOrderDetailId);


            $arrAttribute = [];

            foreach ($arrOrderDetailAttr as $item) {
                $arrAttribute[$item['order_detail_id']][] = $item;
            }
            return [
                'order' => $arrOrder,
                'arrOrderDetail' => $arrOrderDetail,
                'arrAttribute' => $arrAttribute,
                //                'arrOrderStatus' => $arrOrderStatus,
            ];
        } catch (\Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }
        // return $this->order->detail($id);
    }
    public function add(array $data)
    {
        return $this->mOrder->create($data);
    }
    public function getMoneyVoucher($data)
    {
        return $this->orderApi->getMoneyVoucher($data);
    }

    /**
     * Tất cả thuộc tính
     * @param $id
     * @param $arr
     *
     * @return array
     */
    public function allAttribute($id, $arr)
    {
        $allAttribute = $this->mProductAttribute->optionAll($id, $arr);
        return $allAttribute;
    }

    /**
     * Danh sách thuộc tính bán kèm theo sản phẩm.
     * @param $productId
     *
     * @return array
     */
    public function getListByProductId($productId)
    {
        return $this->productAttributeGroupMap->getListByProductId($productId);
    }

    /**
     * Danh sách nhóm thuộc tính bán kèm của sản phẩm.
     * @param $productId
     *
     * @return array
     */
    public function getAttributeGroupBK($productId)
    {
        return $this->productAttributeGroupMap->getGroupSoldTogether($productId);
    }

    public function countOrder($id)
    {
        $list_order = $this->mOrder->getAll($id);
        return [
            'list_order' => $list_order,
        ];
    }
    /**
     * Load product tạo đơn hàng điều chỉnh.
     *
     * @param null $id
     *
     * @return array
     */
    public function loadPopupCreateOrderAdjust(array $data = [])
    {
        try {
            $product = $this->mProduct->getProduct($data['product_id']);
            $productId = 0;
            if ($product['is_template'] == 0) {
                $productId = $product['product_id'];
            } else {
                $productId = $product['parent_id'];
//                $arrProductMap = $this->mTemplateMap->getListByProductId($productId);
            }
            $arrProductTemplateMap = $this->mProductAttributeMap->getListByProductId($productId);

            $arrAttributeGroup = $this->mProductAttributeGroup->getListOrder();

            $arrAttribute = [];
            foreach ($arrProductTemplateMap as $template) {
                $arrAttribute[$template['product_attribute_group_id']][] = $template;
            }

            //Nhóm thuộc tính bán kèm
            $arrAttributeGroupBK = $this->productAttributeGroupMap->getGroupSoldTogether($productId);

            $arrProductAttGroupMap = $this->productAttributeGroupMap->getListByProductId($productId);
            //Thuộc tính bán kèm
            $arrAttributeBK = [];
            foreach ($arrProductAttGroupMap as $att) {
                $arrAttributeBK[$att['product_attribute_group_id']][] = $att;
            }

            $detail_attribute = [];
            if (isset($data['detail_attribute'])) {
                foreach ($data['detail_attribute'] as $item) {
                    $val = isset($item['new_value']) ? $item['new_value'] : $item['value'];
                    $detail_attribute[$item['product_attribute_id']] = $val != "0" ? $val : 1;
                }
            }

            $arrResult = [
                'product'             => $product,
                'arrAttribute'        => $arrAttribute,
                'arrAttributeGroup'   => $arrAttributeGroup,
                'arrAttributeGroupBK' => $arrAttributeGroupBK,
                'arrAttributeBK'      => $arrAttributeBK,
                'detail_attribute'      => $detail_attribute,
            ];

            return $arrResult;
        } catch (\Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }
    }

    /**
     * Điều chỉnh dịch vụ.
     * @param array $data
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function adjustService(array $data = [])
    {
        try {
            $customerServiceDetail = [];
            $formData = [];
            //Thuộc tính cũ của dịch vụ.
            foreach ($data['customer_service_detail'] as $item) {
                $customerServiceDetail[$item['product_attribute_id']] = $item['value'];
            }

            //Thuộc tính được cập nhật
            foreach ($data['form_data'] as $item) {
                $id = preg_replace("/[^0-9]/", "", $item['name']);
                if ($id != 0) {
                    //Nếu không phải là thuộc tính bán kèm
                    $formData[$id] = $item['value'];
                } else {
                    //Nếu là thuộc tính bán kèm.
                    $formData[$item['value']] = 1;
                }
            }
            //Gói sau khi được điều chỉnh.
            $tempArrayIdAtt = [];

            foreach ($formData as $key => $value) {
                $tempArrayIdAtt[] = $key;
            }

            $attributeResult = $this->mProductAttribute->getListIn($tempArrayIdAtt);
            foreach ($attributeResult as $key => $item) {
                if (isset($formData[$item['product_attribute_id']])) {
                    $attributeResult[$key]['new_value'] = $formData[$item['product_attribute_id']];
                }
            }

            //Chỉ lấy những thuộc tính thay đổi.
            //Id
            $arrAttId = [];
            foreach ($customerServiceDetail as $key => $value) {
                foreach ($formData as $k => $v) {
                    if (!isset($customerServiceDetail[$k])) {
                        if (!in_array($k, $arrAttId)) {
                            $arrAttId[] = $k;
                        }
                    } else {
                        if ($customerServiceDetail[$k] != $v) {
                            if (!in_array($k, $arrAttId)) {
                                $arrAttId[] = $k;
                            }
                        }
                    }
                    if (!isset($formData[$key])) {
                        if (!in_array($key, $arrAttId)) {
                            $arrAttId[] = $key;
                        }
                    }
                }
            }

            $attributeNew = $this->mProductAttribute->getListIn($arrAttId);

            foreach ($attributeNew as $key => $item) {
                if (isset($formData[$item['product_attribute_id']])) {
                    $attributeNew[$key]['new_value'] = $formData[$item['product_attribute_id']];
                } else {
                    $attributeNew[$key]['new_value'] = 1;
                }
            }
            if (count($attributeNew) == 0) {
                return response()->json([
                    'error' => true,
                    'data' => ''
                ]);
            }

            $serviceDetail = $this->mCusService->getDetail($data['customer_service_id']);

            $result = [
                'customer_service_detail' => $data['customer_service_detail'],
                'attribute_new' => $attributeNew,
                'attribute_result' => $attributeResult,
                'service_detail' => $serviceDetail,
            ];
            return response()->json([
                'error' => false,
                'data' => view('product::order.include.info-service-after', $result)->render(),
                'data_service' => $result
            ]);
        } catch (\Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }
    }

    /**
     * Thêm / cập nhạt đơn hàng điều chỉnh.
     * @param array $data
     *
     * @return array
     */
    public function submitCreateOrderAdjust(array $data = [])
    {
        try {
            DB::beginTransaction();
            $customerId = 0;
            $staffId = 0;
            $order_content= '';
            $order_status_id= '';
            $customerServiceId = 0;
            foreach ($data['form_data'] as $key => $item) {
                if ($item['name'] == 'order_content') {
                    $order_content = $item['value'];
                    unset($data['form_data'][$key]);
                }
                if ($item['name'] == 'order_status_id') {
                    $order_status_id = $item['value'];
                    unset($data['form_data'][$key]);
                }

                if ($item['name'] == 'customer_id' && $item['value'] == null) {
                    return response()->json([
                        'error' => 1,
                        'message' => 'Vui lòng chọn khách hàng!',
                    ]);
                }
                if ($item['name'] == 'staff_id' && $item['value'] == null) {
                    return response()->json([
                        'error' => 2,
                        'message' => 'Vui lòng chọn nhân viên hỗ trợ!',
                    ]);
                }
                if ($item['name'] == 'customer_service_id' && $item['value'] == null) {
                    return response()->json([
                        'error' => 3,
                        'message' => 'Vui lòng chọn dịch vụ!',
                    ]);
                }
                if ($item['name'] == 'customer_id') {
                    $customerId = $item['value'];
                }
                if ($item['name'] == 'staff_id') {
                    $staffId = $item['value'];
                }
                if ($item['name'] == 'customer_service_id') {
                    $customerServiceId = $item['value'];
                }
            }
            if (!isset($data['attribute_result']) || !isset($data['service_detail'])) {
                return response()->json([
                    'error' => 4,
                    'message' => 'Dịch vụ không có thay đổi!',
                ]);
            }

            //Thêm vào order.
            $orderCode = getCode(CODE_ORDER, $this->mOrder->getNumberForCode());
            $message = 'Thêm đơn hàng điều chỉnh thành công!';

            //Nếu là chỉnh sửa đơn hàng.
            $orderDate = Carbon::now();
            if (isset($data['order_code'])) {
                $orderCode = $data['order_code'];
                $order = $this->mOrder->getItemByCode($orderCode);
                $orderDetail = $this->mOrderDetail->listOrderDetail($order['order_id']);
                $this->mOrderAttributeDetail->deleteByOrderDetail($orderDetail[0]['order_detail_id']);
                $this->mOrderDetail->removeByOrder($orderDetail[0]['order_detail_id']);
                $this->mOrder->remove($order['order_id']);
                $message = 'Cập nhật đơn hàng điều chỉnh thành công!';
                $orderDate = $order['created_at'];
            }

            $amounts = intval($data['total'] * 1.1);
            $vats = intval($data['total'] * 0.1);
            $arrInsertOrder = [
                'order_code' => $orderCode,
                'customer_id' => $customerId,
                'staff_id' => $staffId,
                'order_status_id' => $order_status_id == 6 ? 6 : 1,
                'source' => 'private',
                'created_by' => Auth::id(),
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
                'updated_by' => Auth::id(),
                'is_adjust' => 1,
                'customer_service_id' => $data['service_detail']['customer_service_id'],
                'total' => $data['total'],
                'vat' => $vats,
                'amount' => $amounts,
                'order_content' => $order_content,

            ];
            $idOrder = $this->mOrder->insertItem($arrInsertOrder);

            $arrInsertOrderDetail = [
                'order_id' => $idOrder,
                'order_type' => 'default',
                'product_id' => $data['service_detail']['product_id'],
                'price' => intval($data['total'] / $data['service_detail']['quantity']),
                'amount' => $amounts,
                'quantity' => $data['service_detail']['quantity'],
                'type' => 'month',
                'created_at' => Carbon::now(),
                'created_by' => $customerId,
                'updated_at' => Carbon::now(),
                'updated_by' => Auth::id(),
            ];

            $idOrderDetail = $this->mOrderDetail->insertItem($arrInsertOrderDetail);
            $package_detail = [];
            foreach ($data['attribute_result'] as $item) {
                $val = isset($item['new_value']) ? $item['new_value'] : $item['value'];
                $arrInsertOrderAttribute = [
                    'order_detail_id' => $idOrderDetail,
                    'product_attribute_id' => $item['product_attribute_id'],
                    'value' => $val,
                    'price' => $item['price_month'],
                    'amount' => intval($item['price_month'] * $val),
                ];
                $this->mOrderAttributeDetail->insertItem($arrInsertOrderAttribute);
                $package_detail['vi'][$item['product_attribute_name_vi'] . ' ' . $item['unit_name']] = $val;
                $package_detail['en'][$item['product_attribute_name_en'] . ' ' . $item['unit_name']] = $val;
            }

            $this->mOrderDetail->updateItem($idOrderDetail, 'order_detail_id', [
                'package_vi' => json_encode($package_detail['vi']),
                'package_en' => json_encode($package_detail['en'])
            ]);
            /**
             * send Email
             */

            $arrOrderDetailEmail[0] = [
                'quantity' => $data['service_detail']['quantity'],
                'amount' => $amounts,
                'product_name' => $data['service_detail']['product_name_vi'],
                'package' => $package_detail
            ];
            $arrInsertEmail = [
                'object_id' => $idOrder,
                'template_type' => 'success',
                'email_type' => 'order',
                'email_subject' => EMAIL_SUBJECT_ORDER_SUCCESS,
                'email_to' => $data['service_detail']['customer_email'],
                'email_from' => env('MAIL_FROM_ADDRESS'),
                'email_from_name' => env('MAIL_FROM_NAME'),
            ];
            $arrInsertEmail['email_params'] = [
                'full_name' => $data['service_detail']['customer_name'],
                'order_code' => $orderCode,
                'order_date' => $orderDate->format('Y-m-d H:i:s'),
                'order_total' => $data['total'],
                'order_vat' => $vats,
                'order_discount' => 0,
                'order_amount' => $amounts,
                'arrCart' => $arrOrderDetailEmail
            ];

            $this->buildEmail($arrInsertEmail);
            DB::commit();
            return [
                'error' => false,
                'message' => $message
            ];
        } catch (\Exception $ex) {
            DB::rollBack();
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            die;
        }
    }

    /**
     * Danh sách dịch vụ của khách hàng.
     * @param array $filters
     *
     * @return mixed|null
     * @throws \MyCore\Api\ApiException
     */
    public function getCustomerService(array $filters = [])
    {
        $customerService = new CustomerServiceApi();
        $result = $customerService->getListAll($filters);
        if (count($result) > 0) {
            return $result;
        }

        return null;
    }

    /**
     * Load package của dịch vụ.
     * @param array $data
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getPackageOrderAdjust(array $data = [])
    {
        $attributeResult = $this->mProductAttribute->getAttOfOrder($data['order_code']);
        $serviceDetail = $this->mCusService->getDetail($data['customer_service_id']);

        $arrAttId = [];
        $formData = [];
        $arrAttOld = [];

        foreach ($attributeResult as $item) {
            $formData[$item['product_attribute_id']] = $item['value'];
        }

        foreach ($data['customer_service_detail'] as $item) {
            $arrAttOld[$item['product_attribute_id']] = $item['value'];
        }



        foreach ($arrAttOld as $key => $value) {
            foreach ($formData as $k => $v) {
                if (!isset($arrAttOld[$k])) {
                    if (!in_array($k, $arrAttId)) {
                        $arrAttId[] = $k;
                    }
                } else {
                    if ($arrAttOld[$k] != $v) {
                        if (!in_array($k, $arrAttId)) {
                            $arrAttId[] = $k;
                        }
                    }
                }
                if (!isset($formData[$key])) {
                    if (!in_array($key, $arrAttId)) {
                        $arrAttId[] = $key;
                    }
                }
            }
        }

        $attributeNew = $this->mProductAttribute->getListIn($arrAttId);

        foreach ($attributeNew as $key => $item) {
            if (isset($formData[$item['product_attribute_id']])) {
                $attributeNew[$key]['new_value'] = $formData[$item['product_attribute_id']];
            } else {
                $attributeNew[$key]['new_value'] = 1;
            }
        }

        $result = [
            'customer_service_detail' => $data['customer_service_detail'],
            'attribute_new' => $attributeNew,
            'attribute_result' => $attributeResult,
            'service_detail' => $serviceDetail,
        ];

        return response()->json([
            'error' => false,
            'data' => view('product::order.include.info-service-after', $result)->render(),
            'data_service' => $result
        ]);
    }

    /**
     * Lấy danh sách sản phẩm/dịch vụ không phân trang
     *
     * @param array $filters
     * @return |null
     * @throws \MyCore\Api\ApiException
     */
    public function getListService(array $filters = [])
    {
        $result = $this->mCusService->getListAll($filters);

        if (count($result) > 0) {
            return $result;
        }

        return null;
    }

    /**
     * Lấy chi tiết khách hàng theo account
     *
     * @param int $customerId
     * @return mixed|null
     * @throws \MyCore\Api\ApiException
     */
    public function getDetailCustomer($customerId)
    {
        $result = $this->mCustomer->detail($customerId);


        return $result;

    }
}
