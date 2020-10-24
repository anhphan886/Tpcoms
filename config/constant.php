<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

define('PAGING_ITEM_PER_PAGE', 10);
define('PAGING_ITEM_PER_PAGE_DASHBOARD', 5);
define('LOGIN_HOME_PAGE', 'admin.dashboard');

//Upload
define('TEMP_PATH', 'temp_upload');
define('USER_PATH', 'uploads/user/');
define('BLOG_CATEGORY_PATH', 'uploads/admin/blog-category/');
define('BLOG_PATH', 'uploads/admin/blog/');
define('AGENCY_PATH', 'uploads/admin/agency/');
define('CONFIG_PATH', 'uploads/admin/config/');
define('SUPPORT_PATH', 'uploads/admin/support/');
define('PRODUCT_UPLOADS_PATH', 'uploads/product/product');
define('CUSTOMER_UPLOADS_PATH', 'uploads/product/customer');
define('CONTRACT_UPLOADS_PATH', 'uploads/product/contract');
define('CONTRACT_UPLOADS', 'uploads/contract/');
define('ANNEX_UPLOADS_PATH', 'uploads/product/contract');
define('ANNEX_UPLOADS', 'uploads/contract/');

//define('BASE_URL_API', 'http://127.0.0.1:8003/');
define('BASE_URL_API', env('API_DOMAIN') . '/');
define('IMPORT_DATA_STATION', 'uploads/admin/import-data-station/');
define('ROW_IMPORT', 1000);
define('CODE_SUCCESS', '');
define('CODE_FAILED', 1);

// Minh
define('END_POINT_PAGING', 5);
define('NOTIFICATION_PAGING', 10);

define('CODE_ATTRIBUTE', 'TT%s%03d_%s');
define('CODE_PRODUCT', 'SP%s%03d_%s');
define('CODE_TEMPLATE', 'TL%s%03d_%s');
define('CODE_INVOICE', 'IN%s%03d_%s');
define('CODE_INVOICE_EXTENDS', 'INE%s%03d_%s');
define('CODE_CONTRACT', 'CT%s%03d_%s');
define('CODE_RECEIPT', 'RC%s%03d_%s');
define('CODE_CART', 'CART%s%03d_%s');
define('CODE_ORDER', 'O%s%03d_%s');
define('CODE_TIKET', 'T%s%03d_%s');
define('CODE_CUSTOMER', 'TP%s%03d_%s');
define('CODE_CUSTOMER_ACCOUNT', 'TP%s%03d%03d_%s');
define('CODE_TICKET_EMAIL_LOG', 'SC%s%03d_%s');
define('CODE_CONTRACT_ANNEX', 'CTA%s%03d_%s');


define('EMAIL_SUBJECT_ORDER_SUCCESS', 'Thông báo đăng ký dịch vụ thành công');
define('EMAIL_SUBJECT_ORDER_UPDATE', 'Thông báo đơn hàng đã được cập nhật');
define('EMAIL_SUBJECT_ORDER_APPROVE', 'Thông báo đơn hàng đã được duyệt');

define('EMAIL_SUBJECT_CREATE_CUSTOMER', 'Thông báo tài khoản khách hàng đã được tạo');

define('EMAIL_SUBJECT_EMAIL_WARNING', 'Cảnh báo ticket đã quá thời gian hỗ trợ');

if (! function_exists('subString')) {
    function subString($value, $limit = 50, $end = '...')
    {
        return \Illuminate\Support\Str::limit($value, $limit, $end);
    }
}

if (!function_exists('getValueByLang')) {
    function getValueByLang($fieldName, $locale = null)
    {
        if (!$locale) $locale = App::getLocale();
        return $fieldName . $locale;
    }
}

if (!function_exists('getCode')) {
    function getCode($type = 'CODE_INVOICE', $number, $number2 = null)
    {
        $now = Carbon::now()->format('ymd');
        $random = Str::upper(Str::random(4));
        if ($number2) return sprintf($type, $now, $number, $number2, $random);
        return sprintf($type, $now, $number, $random);
    }
}



// ORDER CONSTANT

define('ORDER_STATUS_NEW' , '1');
define('ORDER_SOURCE_PRIVATE' , 'private');
define('ORDER_SOURCE_PUBLIC' , 'public');
define('MODE_POSTPAID' , 'postpaid');
define('MODE_PAYUSE' , 'payuse');
define('MODE_TRIAL', 'trial');
define('MODE_REAL', 'real');
define('MODE_PREPAID', 'prepaid');
define('DEPLOY_SUPPORT_QUEUE', '4');
define('DEPLOY_SUPPORT_ISSUE', '30');
define('BLOCK_SERVICE_ISSUE', '47');
define('RESUME_SERVICE_SUPPORT_ISSUE', '37');
define('DEPLOY_SUPPORT_ISSUE_LEVEL', '5');
define('STATUS_TICKET_DONE', '3');
define('STATUS_TICKET_CANCEL', '5');
define('TICKET_CANCEL', 'cancel');
define('STAFF_SUPPORT', 'staff_support');
define('STAFF_DEPLOY', 'staff_deploy');
define('STAFF_CONSULT' , 'staff_consult');
define('DEFAULT_VAPP', 'demo_vapp');
define('DEPLOY_UPGRADE_SERVICE', '49');

define('VM_STATUS', [
    "-1" => "Could not be created",
    "0" => "Unresolved",
    "1" => "Resolved",
    "3" => "Suspended",
    "4" => "Powered on",
    "5" => "Waiting for user input",
    "6" => "In an unknown state",
    "7" => "In an unrecognized state",
    "8" => "Powered off",
    "9" => "In an inconsistent state"
]);

define('PUBLIC_CLOUD_TYPE', [
    '3', '4', '5', '6', '7', '8'
]);
define('PRIVATE_CLOUD_TYPE', [
    '9', '10', '11', '12', '13', '14', '15', '16', '17','161','162','163','164','165','166','176','177','178'
]);
define('PRIVATE_CLOUD_CATE_TYPE', [
    '3', '4'
]);
define('PUBLIC_CLOUD_CATE_TYPE', [
    '2'
]);

define('LIST_ATTRIBUTE', [
    'RAM' => 2,
    'CPU' => 1,
    'DISK' => 9,
    'SOCKET' => 1
]);
