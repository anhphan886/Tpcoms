<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('locale/{locale}', 'AdminController@changeLocale')->name('frontend.index.change-locale');

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'locale'],
], function() {
    Route::get('admin/validation', function () {
        return trans('admin::validation');
    })->name('admin.validation');
    Route::get('/', 'AdminController@index')->name('admin');
    Route::group(['middleware' => ['auth', 'permission']], function () {

    });

    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::post('/list-order', 'DashboardController@listOder')->name('admin.dashboard.list-order');
    Route::post('/list-customer', 'DashboardController@listCustomer')->name('admin.dashboard.list-customer');
    Route::post('/get-order-by-month-year', 'DashboardController@getOrderByMonthYear')->name('admin.dashboard.get-order-by-month-year');
    Route::post('/get-top-service', 'DashboardController@getTopService')->name('admin.dashboard.get-top-service');
    Route::post('/get-order-by-status', 'DashboardController@getOrderByStatus')->name('admin.dashboard.get-order-by-status');
    Route::post('/get-list-service-expire-not-canceled', 'DashboardController@listServiceExpireNotCanceled')->name('admin.dashboard.get-list-service-expire-not-canceled');
    Route::post('/get-list-service-expire-to-day', 'DashboardController@listServiceExpireToDay')->name('admin.dashboard.get-list-service-expire-to-day');
    Route::post('/get-list-service-expire-day', 'DashboardController@listServiceExpireDay')->name('admin.dashboard.get-list-service-expire-day');
    Route::post('/get-list-receipt', 'DashboardController@listReceipt')->name('admin.dashboard.list-receipt');
    Route::post('/get-list-invoice', 'DashboardController@listInvoice')->name('admin.dashboard.list-invoice');

    //REPORT.
    Route::group(['prefix' => 'report',], function () {
        Route::get('/order', 'ReportController@order')->name('admin.report.order');
        Route::post('/order-chart', 'ReportController@orderChart')->name('admin.report.get-order-by-status');
        Route::get('/service', 'ReportController@service')->name('admin.report.service');
        Route::post('/service-chart', 'ReportController@serviceChart')->name('admin.report.service-chart');
        Route::get('/receipt', 'ReportController@receipt')->name('admin.report.receipt');
        Route::post('/receipt-chart', 'ReportController@receiptChart')->name('admin.report.receipt-chart');
        Route::get('/customer', 'ReportController@customer')->name('admin.report.customer');
        Route::post('/customer-chart', 'ReportController@customerChart')->name('admin.report.customer-chart');
        Route::get('/debt', 'ReportController@debt')->name('admin.report.debt');
        Route::post('/debt-chart', 'ReportController@debtChart')->name('admin.report.debtChart');
        Route::get('/customer-revenue', 'ReportController@customerRevenue')->name('admin.report.customer-revenue');
        Route::post('/customer-revenue-chart', 'ReportController@customerRevenueChart')->name('admin.report.customer-revenue-chart');
        Route::get('/service-revenue', 'ReportController@serviceRevenue')->name('admin.report.service-revenue');
        Route::post('/service-revenue-chart', 'ReportController@serviceRevenueChart')->name('admin.report.service-revenue-chart');
        Route::get('/export-excel-customer-revenue', 'ReportController@exportExcelCustomerRevenue')->name('admin.report.export-excel-customer-revenue');
        Route::get('/export-excel-service-revenue', 'ReportController@exportExcelServiceRevenue')->name('admin.report.export-excel-service-revenue');
        Route::get('/aggregate', 'ReportController@aggregate')->name('admin.report.aggregate');
        Route::post('/aggregate-chart', 'ReportController@aggregateRevenueChart')->name('admin.report.aggregate-chart');
        Route::post('/export-invoice', 'ReportController@exportInvoice')->name('admin.report.expoft-excel-invoice');
    });

    //NOTIFICATION.
    Route::group(['prefix' => 'notification',], function () {
        Route::post('/get-notification-log', 'NotificationController@getNotificationByUser')->name('admin.notification.get-notification-log');
        Route::post('/is-read-notification', 'NotificationController@isReadNotification')->name('admin.notification.is-read-notification');
        Route::post('/is-read-all-notification', 'NotificationController@isReadAllNotification')->name('admin.notification.view-all');
    });

    //CONFIG.
    Route::group(['prefix' => 'config',], function () {
        Route::get('/', 'ConfigController@index')->name('admin.config');
        Route::post('/update', 'ConfigController@update')->name('admin.config.update');
    });
    Route::group(['prefix' => 'receipt-email',], function () {
        Route::get('/get-receipt-pay-expired', 'ReceiptEmailController@index')->name('admin.receipt-email.get-receipt-pay-expired');
    });
});
Route::group(['prefix' => 'trigger-notification',], function () {
    Route::post('/add-notification', 'NotificationController@addNotification')->name('admin.notification.add-notification');
    Route::post('/add-notification-log', 'NotificationController@addNotificationLog')->name('admin.notification.add-notification-log');
});
