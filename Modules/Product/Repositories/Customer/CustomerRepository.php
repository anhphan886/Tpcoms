<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/13/2019
 * Time: 12:09 PM
 */

namespace Modules\Product\Repositories\Customer;
use Illuminate\Support\Facades\Log;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Admin\Models\SegmentTable;
use Modules\Product\Http\Api\General;
use Modules\Product\Models\ContractFileTable;
use Modules\Product\Models\CustomerTable;
use Modules\Product\Models\CustomerContractTable;
use Modules\Product\Models\CustomerServiceTable;
use Modules\Product\Models\CustomerAccountTable;
use Modules\Product\Repositories\Customer\CustomerRepositoryInterface;
use App\Http\Controllers\TraitSendMail;
use Modules\Product\Models\ProvinceTable;
use PHPUnit\Exception;
use Modules\Product\Models\ContractAnnexTable;
use Modules\Billing\Models\BillingDetailTable;
use Modules\Product\Models\CustomerVerifyTable;

class CustomerRepository implements CustomerRepositoryInterface
{
    use TraitSendMail;
    protected $customer;
    protected $contract;
    protected $service;
    protected $customerAccount;
    protected $contractFile;
    protected $general;
    protected $province;
    protected $mAnnex;
    protected  $mBillingDetail;
    protected $verify;

    public function __construct(
        CustomerTable $customer,
        CustomerContractTable $contract,
        CustomerServiceTable $service,
        CustomerAccountTable $customerAccount,
        ContractFileTable $contractFile,
        General $general,
        ProvinceTable $province,
        ContractAnnexTable $annexTable,
        BillingDetailTable $mBillingDetail,
        CustomerVerifyTable $verify
    )
    {
        $this->customer = $customer;
        $this->contract = $contract;
        $this->service = $service;
        $this->customerAccount = $customerAccount;
        $this->contractFile = $contractFile;
        $this->general = $general;
        $this->province = $province;
        $this->mAnnex  = $annexTable;
        $this->mBillingDetail  = $mBillingDetail;
        $this->verify = $verify;
    }

    public function getList(array $filters = [])
    {
        $chooseDay = '';
        $filter = $filters;
        if (!isset($filter['keyword'])) {
            $filter['keyword'] = null;
        }
        if (!isset($filter['choose_day'])) {
            $filter['choose_day'] = null;
        } else {
            $chooseDay = $filter['choose_day'];
        }
        if (!isset($filter['customer$status'])) {
            $filter['customer$status'] = null;
        }
        if (!isset($filter['customer$province_id'])) {
            $filter['customer$province_id'] = null;
        }
        if (!isset($filter['customer$district_id'])) {
            $filter['customer$district_id'] = null;
        }
        if (!isset($filter['customer$customer_type'])) {
            $filter['customer$customer_type'] = null;
        }
        if (!isset($filter['customer$created_by'])) {
            $filter['customer$created_by'] = null;
        }
        if (!isset($filter['page'])) {
            $filter['page'] = 1;
        }

        // Date time created at.
        if (isset($filters["choose_day"])) {
            $arr_filter = explode(" - ", $filters["choose_day"]);
            $startTime = Carbon::createFromFormat('d/m/Y', $arr_filter[0])->format('Y-m-d');
            $endTime = Carbon::createFromFormat('d/m/Y', $arr_filter[1])->format('Y-m-d');
            $filter['created_at']['from'] = $startTime . ' 00:00:00';
            $filter['created_at']['to'] = $endTime . ' 23:59:59';
            unset($filter["choose_day"]);
        }
        $list = $this->customer->getList($filter);
        $filter['choose_day'] = $chooseDay;
        return [
            'filter' => $filter,
            'list' => $list
        ];
    }

    public function getListContract($filters)
    {
        $list = $this->contract->getListDataTable($filters);

        return [
            'list' => $list,
        ];
    }

    public function getListService($id)
    {
        $list_service = $this->service->getListService($id);
        return [
            'list_service' => $list_service
        ];
    }

    public function getListAllService(array $filters = [])
    {
        $data = $this->service->getList($filters);
        return [
            'data' => $data,
            'filter' => $filters
        ];
    }

    public function getListServiceId(array $filter = [])
    {
        $list_service = $this->service->getListDataTable($filter);
        return [
            'list_service' => $list_service,
        ];
    }

    public function detail($id)
    {
        return $this->customer->detail($id);
    }

    public function getOptionCustomer()
    {
        return $this->customer->getOption();
    }

    /**
     * function get detail service
     *
     * @param int $customer_service_id
     * @return mixed
     */
    public function getDetail($customer_service_id)
    {
        return $this->service->getDetail($customer_service_id);
    }

    /**
     * function update content dịch vụ
     *
     * @param int $customer_service_id
     * @param int $data
     * @return mixed
     */
    public function update(array $data, $customer_service_id)
    {
        $result = $this->service->getDetail($customer_service_id);
        $quantity = $result['quantity'];
        $type = $result['type'];
        $payment_type = $result['payment_type'];
        $active_day = $result['actived_date'];
        $status = $result['status'];
        try {
            if (isset($data['charg_date']) && isset($data['status']) && $data['status'] == 'not_actived' ) {
                return [
                    'error' => 1,
                    'message' => __('Vui lòng thay đổi trạng thái dịch vụ'),
                    'data' => $result,
                ];
            }
            $dataService = [
                'customer_service_id' => strip_tags($data['customer_service_id']),
                'updated_by' => Auth::id(),
                'updated_at' => date('Y-m-d H:i:s'),
//                'status' => $data['status']
            ];


            if(isset($data['status']) && $data['status'] == 'actived'){
                $dataService['actived_date'] = date('Y-m-d');
                $dataService['status'] = $data['status'];
            }

            if(isset($data['status']) && $data['status'] == 'cancel'){
                $dataService['status'] ='cancel';
            }

            if (isset($data['charg_date'])) {
                $data['charg_date'] = str_replace('/', '-', $data['charg_date']);
                $data['charg_date'] = date('Y-m-d', strtotime($data['charg_date']));
                $dataService['charg_date'] = $data['charg_date'];

                if ($status == 'actived' && $dataService['charg_date'] < $active_day) {
                    return [
                        'error' => 1,
                        'message' => __('Thời gian bắt đầu tính phí phải lớn hơn hoặc bằng ngày kích hoạt'),
                        'data' => $result,
                    ];
                } elseif (isset($dataService['actived_date']) &&$dataService['charg_date'] < $dataService['actived_date']) {
                    return [
                        'error' => 1,
                        'message' => __('Thời gian bắt đầu tính phí phải lớn hơn hoặc bằng ngày hôm nay'),
                        'data' => $result,
                    ];
                } else {
                    if ($type == 'trial') {
                        $new = Carbon::parse($data['charg_date'])->addDays($quantity)->format('Y-m-d');
                        $dataService['expired_date'] = $new;
                    } elseif ($type == 'real' && $payment_type == 'prepaid') {
                        $new = Carbon::parse($data['charg_date'])->addMonths($quantity)->format('Y-m-d');
                        $dataService['expired_date'] = $new;
                    } else {
                        $dataService['expired_date'] = null;
                    }
                }
            }

            if(isset($data['service_content'])){
                $dataService['service_content'] = strip_tags($data['service_content']);
            }

            if(isset($data['staff_id'])){
                $dataService['staff_id'] = $data['staff_id'];
            }

            $result = $this->service->updateService($dataService, $customer_service_id);

            return [
                'error' => 0,
                'message' => __('ticket::issue.info.update_success'),
                'data' => $result,
            ];
        } catch (\Exception $e) {
            return [
                'aaaa' => $e->getMessage(),
                'error' => 1,
                'message' => __('ticket::issue.info.update_failed'),
                'data' => null
            ];
        }
    }


    public function editCustomer(array $data = [])
    {
        try {
            DB::beginTransaction();
            $dataInsert['customer_name'] = strip_tags($data['customer_name']);
            $dataInsert['segment_id'] = strip_tags($data['segment_id']);
            $dataInsert['customer_id_num'] = strip_tags($data['customer_id_num']);
            $dataInsert['customer_phone'] = strip_tags($data['customer_phone']);
            $dataInsert['customer_phone2'] = strip_tags($data['customer_phone2']);
            $dataInsert['customer_website'] = strip_tags($data['customer_website']);
            $dataInsert['province_id'] = sprintf('%02d', $data['province_id']);
            $dataInsert['district_id'] = sprintf('%03d', $data['district_id']);
            $dataInsert['customer_address_desc'] = strip_tags($data['customer_address_desc']);
            $dataInsert['updated_at'] = date('Y-m-d H:i:s');
            $dataInsert['modified_by'] = Auth::id();
            if($data['block_service_time']){
                $dataInsert['block_service_time'] = strip_tags($data['block_service_time']);
            }else{
                $dataInsert['block_service_time'] = 0;
            }
            $idCustomer = $this->customer->edit($dataInsert, $data['id']);
            $customer = $this->customer->detail($data['id']);
            $dataInsertAccount = [
                'account_name' => strip_tags($data['customer_name']),
                'modified_by' => Carbon::now(),
            ];

            $this->customerAccount->edit($dataInsertAccount, $customer['customer_email']);

            DB::commit();
            return [
                'error' => false,
                'message' => __('product::validation.product.edit_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }
    public function filterPhone($value)
    {
        $value = trim($value);
        $value = preg_replace('/\D/', '', $value);

        return preg_replace('/^84|^(?!0)/', 0, $value);
    }

    public function store(array $data = [])
    {
        try {
            DB::beginTransaction();
            $customer_no = getCode(CODE_CUSTOMER, $this->customer->getNumberForCode());
            $getCustomerNo = explode("_", $customer_no)[0];
            $account_no = getCode(CODE_CUSTOMER_ACCOUNT, $this->customerAccount->getNumberForCode(), $this->customerAccount->getTotalAccount($getCustomerNo));
            $dataInsert['customer_name'] = strip_tags($data['customer_name']);
            $dataInsert['customer_no'] = $customer_no;
            $dataInsert['customer_id_num'] = strip_tags($data['customer_id_num']);
            $dataInsert['customer_type'] = strip_tags($data['customer_type']);
            $dataInsert['segment_id'] = strip_tags($data['segment_id']);
            $dataInsert['province_id'] = sprintf('%02d', $data['province_id']);
            $dataInsert['district_id'] = sprintf('%03d', $data['district_id']);
            $dataInsert['customer_phone'] = strip_tags($data['customer_phone']);
            $dataInsert['customer_phone2'] = strip_tags($data['customer_phone2']);
            $dataInsert['customer_email'] = strip_tags($data['customer_email']);
            $dataInsert['customer_website'] = strip_tags($data['customer_website']);
            $dataInsert['customer_address_desc'] = strip_tags($data['customer_address_desc']);
            $dataInsert['created_at'] = date('Y-m-d H:i:s');
            $dataInsert['created_by'] = Auth::id();
            $dataInsert['status'] = 'verified';

            $idCustomer = $this->customer->createAccount($dataInsert);

            $dataInsertAccount['account_name'] = strip_tags($data['customer_name']);
            $dataInsertAccount['account_code'] = $account_no;
            $dataInsertAccount['customer_id'] = $idCustomer;
            $dataInsertAccount['account_type'] = 'master';
            $dataInsertAccount['address'] = strip_tags($data['customer_address_desc']);
            $dataInsertAccount['account_id_num'] = strip_tags($data['customer_id_num']);
            $dataInsertAccount['account_phone'] = strip_tags($data['customer_phone']);
            $dataInsertAccount['account_email'] = strip_tags($data['customer_email']);
            $dataInsertAccount['account_password'] = strip_tags(Hash::make($data['account_password']));
            $dataInsertAccount['is_active'] = 1;
            $dataInsertAccount['is_admin'] = 1;

            $customerAccountID = $this->customerAccount->add($dataInsertAccount);

            $scheduler = app()->get(\Modules\Vcloud\Models\ScheduleTaskTable::class);
            $scheduler->add([
                'controller' => $scheduler->control_list['ORGANIZATION'],
                'function' => 'create',
                'params' => json_encode(['orgName' => $customer_no]),
                'created_at' => Carbon::now()
            ]);

            $verify = [
                'verify_code' => $this->getName(20),
                'verify_expire' => Carbon::now()->addHours(24)->format('Y-m-d H:i:s'),
                'customer_account_id' => $customerAccountID,
                'type' => 'register',
                'created_at' => Carbon::now(),
            ];

            $vars = [
                'verify_code' => $verify['verify_code'],
                'verify_expire' => $verify['verify_expire'],
                'customer_name' => $data['customer_name'],
                'title' => __('product::customer.index.register-account'),
                'content' => __('product::customer.index.register-account-text')

//                'email' => $data['customer_email'],
//                'password' => $data['account_password']
            ];

            $idVerify = $this->verify->createVerify($verify);

            $arrInsertEmail = [
//                'object_id' => $idCustomer,
                'object_id' => $idVerify,
                'template_type' => 'register',
                'email_type' => 'user',
                'email_subject' => EMAIL_SUBJECT_CREATE_CUSTOMER,
                'email_to' => $data['customer_email'],
                'email_from' => env('MAIL_FROM_ADDRESS'),
                'email_from_name' => env('MAIL_FROM_NAME'),
                'email_params' => $vars,
            ];
            $this->buildEmail($arrInsertEmail);

            DB::commit();
            return [
                'error' => false,
                'message' => __('product::validation.customer.add_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }



    /**
     * @param $code
     * @return mixed
     */
    public function getListServiceCode($code)
    {
        return $this->service->getListServiceCode($code);
    }

    public function getContractFile()
    {
        $select = $this->contractFile->getContractFile();
        return $select;
    }

    public function upload($id, $file)
    {
        $time = Carbon::now();
        //tên của file
        $name = str_replace('.pdf', '', $file->getClientOriginalName());
        $extension = $file->getClientOriginalExtension();
        $filename = $name . '_' . date_format($time, 'd') . date_format(
                $time, 'm'
            ) . date_format($time, 'Y') . '_' . time();
        $upload_success = $file->storeAs(
            CONTRACT_UPLOADS_PATH, $filename . '.' . $extension, 'public'
        );

        $result = $this->general->uploadGeneral(
            [
                'type'     => 'contract',
                'name'     => 'upload_file',
                'contents' => fopen($upload_success, 'r'),
                'filename' => $filename . '.' . $extension,
            ]
        );

        if (isset($result['file_name'])) {
            $dataInsert = [
                'customer_contract_id' => $id,
                'file_name'            => $result['file_name'],
                'link_file'            => CONTRACT_UPLOADS . $result['file_name'],
                'file_type'            => 'contract_customer_sign',
                'created_at'           => date('Y-m-d H:i:s'),
                'created_by'           => Auth::id()
            ];

            $this->contractFile->removeFile($id);
            $this->contractFile->add($dataInsert);
            return [
                'error'   => 0,
                'message' => '',
            ];
        } else {
            return [
                'error'   => true,
                'message' => '',
            ];
        }
    }

    public function getListChildAccount(array $filters= [])
    {
        return $this->customerAccount->getListDataTable($filters);
    }

    public function getTotalChildAccount($id, $param)
    {
       return $this->customerAccount->getTotalChildAccount($id, $param);
    }


    /**
     * function change Status of customer account
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function changeStatus(array $data, $id)
    {
        if ($data['is_active'] == 1) {
            DB::table('admin_lock_out')->where('admin_id', $id)->delete();
        }
        // TODO: Implement changeStatus() method.
        return $this->customerAccount->changeStatus($data, $id);
    }
    /**
     * function get detail info child accoount
     * @param int $customer_account_id
     * @return mixed
     */
    public function getDetailChildAccount($id)
    {
        return $this->customerAccount->getDetailChildAccount($id);
    }

    /**
     * get account type
     */
    public function getAccountType()
    {
        $type = [
//          'master' => __('user::customer.index.taikhoanchinh'),
            'accountant' => __('product::childAccount.index.accountant'),
            'techical' => __('product::childAccount.index.techical'),
        ];
        return $type;
    }

    /**
     * get list all province
     */
    public function getLisAllProvince()
    {
        return $this->province->getLisAllProvince();
    }

    /**
     * function update info child accoount
     * @param int $customer_account_id
     * @param array $data
     * @return mixed
     */
    public function updateChildAccount(array  $data, $id)
    {
       try {
           $data = [
               'account_type' => $data['account_type'],
               'address' => strip_tags($data['address']),
               'account_name' => strip_tags($data['account_name']),
               'account_phone' => strip_tags($data['account_phone']),
               'province_id' => strip_tags($data['province_id']),
               'updated_at' => Carbon::now(),
           ];
           $result = $this->customerAccount->updateChildAccount($data, $id);

           return [
               'error'   => false,
               'message' => __('product::validation.receipt.edit_Success'),
               'data' => $result
           ];
       } catch (\Exception $e) {
           return [
               'error'   => true,
               'message' => $e->getMessage(),
           ];
       }
    }

    /**
     * function update password child accoount
     * @param int $customer_account_id
     * @param array $data
     * @return mixed
     */
    public function updatePassWord(array $data, $id)
    {
        $tk = $this->customerAccount->getDetailChildAccount($id);
        $pass = isset($data['password']) ? strip_tags($data['password']) : '123456789';
        $item = ['account_password' => Hash::make(strip_tags($pass))];
        $this->customerAccount->updateChildAccount($item, $id);
        $vars = [
            'email' => $tk['account_email'],
            'password' => strip_tags($data['password']),
        ];
        $arrInsertEmail = [
            'object_id' => $tk['customer_account_id'],
            'template_type' => 'change-password-account-child',
            'email_type' => 'user',
            'email_subject' => __('product::childAccount.index.change-password'),
            'email_to' => $tk['account_email'],
            'email_from' => env('MAIL_FROM_ADDRESS'),
            'email_from_name' => env('MAIL_FROM_NAME'),
            'email_params' => $vars,
        ];
       $this->buildEmail($arrInsertEmail);

        return response()->json([
            'error' => false,
            'message' => __('core::admin.reset-password.UPDATE_SUCCESS'),
        ]);
    }
    /**
     * create tài khoản con with customer_id
     *@param array $data
     * @return mixed
     */
    public function  createAccount(array $data)
    {
       try {
           $customer_no = getCode(CODE_CUSTOMER, $this->customer->getNumberForCode());
           $getCustomerNo = explode("_", $customer_no)[0];
           $account_no = getCode(CODE_CUSTOMER_ACCOUNT, $this->customerAccount->getNumberForCode(), $this->customerAccount->getTotalAccount($getCustomerNo));
           $data = [
               'customer_id' => $data['customer_id'],
               'account_name' => strip_tags($data['account_name']),
               'account_type' => strip_tags($data['account_type']),
               'account_code' => strip_tags($account_no),
               'account_email' => strip_tags($data['email']),
               'account_password' => Hash::make(strip_tags($data['password'])),
               'account_phone' => strip_tags($data['account_phone']),
               'account_id_num' => strip_tags($data['account_id_num']),
               'address' => strip_tags($data['address']),
               'province_id' => $data['province_id'],
               'is_deleted' => 0,
               'is_active' => strip_tags($data['is_active']),
           ];

           $result = $this->customerAccount->createAccount($data);

           return [
               'error'   => false,
               'message' => __('product::validation.child_account.create_success'),
               'data' => $result
           ];

       } catch (\Exception $e) {
           return [
               'error'   => true,
               'message' => $e->getMessage(),
           ];
       }
    }

    public function segmentOption()
    {
        $segment = new SegmentTable();
        $result = $segment->getOption();
        return $result;
    }

    public function blockServiceExpired($date){
        $date = Carbon::parse($date);
        $cs = app()->get(\Modules\Product\Models\CustomerServiceTable::class);
        $serviceBlock = $cs->blockService($date);
        foreach($serviceBlock as $service){
            try{
                // update -> updateService /
                $cs->updateService([
                    'status' => 'block',
                    'blocked_at' => Carbon::now()
                ], $service['customer_service_id']);
                $mTicket = app()->get(\Modules\Ticket\Repositories\Ticket\TicketRepositoryInterface::class);
                $status = $mTicket->add(
                    [
                        "ticket_title"=> "[BLOCK SERVICE][".$service['product_id']."]",
                        "description"=> null,
                        "issue_id"=> BLOCK_SERVICE_ISSUE,// hardcode 3	Database	NULL	2	4	60	15	15
                        "issue_level"=> DEPLOY_SUPPORT_ISSUE_LEVEL,
                        "crictical_level"=> 1,
                        "date_issue"=> Carbon::now()->format('Y-m-d H:i:s'),
                        "customer_service_id"=> $service['customer_service_id'],
                        "customer_id" => $service['customer_id'],
                        "queue_process_id"=> DEPLOY_SUPPORT_QUEUE,// hardcode
                        "operate_by"=> null,
                        "platform"=> "web",
                        "type"=> STAFF_DEPLOY
                    ]
                );
                DB::commit();
            }catch(\Exception $e){
                continue;
            }
        }
    }
    public function blockServicePayment($date){
        $date = Carbon::parse($date);
        $cs = app()->get(\Modules\Product\Models\CustomerServiceTable::class);
        $serviceBlock = $cs->servicePaymentMiss($date);
        foreach($serviceBlock as $service){
            try{
                // update -> updateService /
                $cs->updateService([
                    'status' => 'block',
                    'blocked_at' => Carbon::now()
                ], $service['customer_service_id']);
                $mTicket = app()->get(\Modules\Ticket\Repositories\Ticket\TicketRepositoryInterface::class);
                $status = $mTicket->add(
                    [
                        "ticket_title"=> "[BLOCK SERVICE][".$service['customer_service_id']."][Dịch vụ quá hạn sử dụng]",
                        "description"=> null,
                        "issue_id"=> BLOCK_SERVICE_ISSUE,// hardcode 3	Database	NULL	2	4	60	15	15
                        "issue_level"=> DEPLOY_SUPPORT_ISSUE_LEVEL,
                        "crictical_level"=> 1,
                        "date_issue"=> Carbon::now()->format('Y-m-d H:i:s'),
                        "customer_service_id"=> $service['customer_service_id'],
                        "customer_id" => $service['customer_id'],
                        "queue_process_id"=> DEPLOY_SUPPORT_QUEUE,// hardcode
                        "operate_by"=> null,
                        "platform"=> "web",
                        "type"=> STAFF_DEPLOY
                    ]
                );
                DB::commit();
            }catch(\Exception $e){
                continue;
            }
        }
    }


    /**
     * function stop payment service
     * @param array $data
     * @return mixed
    */
    public function stopPayment(array  $data, $service_id)
    {
        try {
            if (isset($data['stop_payment_at'])) {
                $data['stop_payment_at'] = str_replace('/', '-', $data['stop_payment_at']);
                $data['stop_payment_at'] = date('Y-m-d', strtotime($data['stop_payment_at']));
            }

            $dataService = [
                'stop_payment' => 1,
                'stop_payment_at' =>$data['stop_payment_at'],
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::id()
            ];

            $result = $this->service->updateService($dataService, $service_id);

            return [
                'error'   => false,
                'message' => __('Tạm dừng thanh toán dịch vụ thành công'),
                'data' => $result
            ];

        } catch (\Exception $e) {
            return [
                'error'   => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * function extends service
     * @param array $data
     * @return mixed
    */
    public function extendsService(array $data, $service_id)
    {
        try {
            DB::beginTransaction();
            $customerDetail = $this->service->getDetail($service_id);
            $contract_id =$customerDetail['customer_contract_id'];
            $quantity = $customerDetail['quantity'];
            $price = $customerDetail['price'];
            $amount = $customerDetail['amount'];
            $expired_date = $customerDetail['expired_date'];

            $month = $data['month'];
            $contract_annex_no =getCode(CODE_CONTRACT_ANNEX, $this->mAnnex->getNumberForCode());
            if($customerDetail['status'] == 'spending' && $customerDetail['type'] != MODE_TRIAL) {

                //  tạo phụ lục hợp đồng cho gia hạn dịch vụ.
                $arrayAnnex = [
                    'contract_annex_no' => $contract_annex_no,
                    'customer_contract_id' => $contract_id,
                    'created_at' => Carbon::now(),
                    'created_by' => Auth::id(),
                    'updated_at' => Carbon::now(),
                    'updated_by' => Auth::id()
                ];
                $annexNew = $this->mAnnex->insertItem($arrayAnnex);

                // updated service
                $month = $data['month'];
                $newQuantity = $quantity + $month;
                $newAmount = $price * $month;
                $totalAmount = $amount + $newAmount;
                $newExpired_date = Carbon::parse($expired_date)->addMonths($month)->format('Y-m-d');

                $dataService = [
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::id(),
                    'quantity' => $newQuantity,
                    'amount' => $totalAmount,
                    'expired_date' => $newExpired_date,
                ];
//                dd($customerDetail, $dataService);
                $service = $this->service->updateService($dataService, $service_id);

                // tạo billing detail

                $dataBilling = [
                    'customer_service_id' => $service_id,
                    'billing_date' => date('Y-m-d H:i:s'),
                    'type' => 'charge',
                    'created_at' => date('Y-m-d H:i:s'),
                    'kind' => 'normal',
                    'annex_id' => $annexNew,
                    'total' => $newAmount,
                ];
                $billing = $this->mBillingDetail->insertItem($dataBilling);
            }
//            } elseif ($customerDetail['payment_type'] == MODE_POSTPAID && $customerDetail['type'] != MODE_TRIAL) {
//
//                //  tạo phụ lục hợp đồng cho gia hạn dịch vụ.
//                $arrayAnnex = [
//                    'contract_annex_no' => $contract_annex_no,
//                    'customer_contract_id' => $contract_id,
//                    'created_at' => Carbon::now(),
//                    'created_by' => Auth::id(),
//                    'updated_at' => Carbon::now(),
//                    'updated_by' => Auth::id()
//                ];
//                $annexNew = $this->mAnnex->insertItem($arrayAnnex);
//
//                // updated service
//                $month = $data['month'];
//                $newQuantity = $quantity + $month;
//                $newAmount = $price * $month;
//                $totalAmount = $amount + $newAmount;
//                $newExpired_date = Carbon::parse($expired_date)->addMonths($month)->format('Y-m-d');
//
//                $dataService = [
//                    'updated_at' => date('Y-m-d H:i:s'),
//                    'updated_by' => Auth::id(),
//                    'quantity' => $newQuantity,
//                    'amount' => $totalAmount,
//                    'expired_date' => $newExpired_date,
//                ];
//                dd($customerDetail, $dataService);
//                $service  = $this->service->updateService($dataService, $service_id);
//
//            } else {
//
//            }
            DB::commit();
            return [
                'error'   => false,
                'message' => __('Gia hạn  dịch vụ thành công'),
//                'data' => $result
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error'   => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * change status customer
     * @param $email
     * @param array $data
     * @return mixed
     */
    public function changeStatusCustomer($email, $data)
    {
        try {
            $dataActive = [
              'is_active' => $data
            ];
            $result = $this->customerAccount->edit($dataActive, $email);

            return [
                'error'   => false,
                'message'   => __('product::customer.index.CHANGE_STATUS_SUCCESS')
            ];
        } catch (\Exception $e) {
            return [
                'error'   => true,
                'message'   => __('product::customer.index.CHANGE_STATUS_FAIL')
//                'aaaa' => $e->getMessage(),
            ];
        }
    }

    function getName($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public function check($param)
    {
        return $this->verify->check($param);
    }

    public function checkAccount($param, $data)
    {
        $detailAccount = $this->customerAccount->getDetailByCusId($data['customer_account_id']);
        $scheduler = app()->get(\Modules\Vcloud\Models\ScheduleTaskTable::class);
        $scheduler->add([
            'controller' => $scheduler->control_list['ORGANIZATION'],
            'function' => 'create',
            'params' => json_encode(['orgName' => $detailAccount['customer_no']]),
            'created_at' => Carbon::now()
        ]);
        return view('user::account.check-account', [
        ]);
    }

    public function newVerify($param)
    {

    }

}
