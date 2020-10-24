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

Route::group([
    'prefix' => 'product',
    'middleware' => ['web','auth', 'permission', 'locale'],
], function() {
    //PRODUCT
    Route::get('/', 'ProductController@index')->name('product.product');
    Route::get('/create', 'ProductController@create')->name('product.product.create');
    Route::post('/get-option-attribute', 'ProductController@getOptionAttribute')->name('product.product.get-option-attribute');
    Route::post('/get-option-attribute-sold-together', 'ProductController@getOptionAttributeSoldTogether')->name('product.product.get-option-attribute-sold-together');
    Route::post('/get-attribute-group-wni', 'ProductController@getAttrGroupWhereNotIn')->name('product.product.get-attribute-group-wni');
    Route::post('/get-detail-attribute', 'ProductController@getDetailAttribute')->name('product.product.get-detail-attribute');
    Route::post('/store', 'ProductController@store')->name('product.product.store');
    Route::post('/destroy', 'ProductController@destroy')->name('product.product.destroy');
    Route::get('/edit/{code}', 'ProductController@edit')->name('product.product.edit');
    Route::post('/uploads-image', 'ProductController@uploads')->name('product.product.uploads-image');
    Route::post('/update', 'ProductController@update')->name('product.product.update');
    Route::get('/show/{code}', 'ProductController@show')->name('product.product.show');
    Route::post('choose-attr', 'ProductController@chooseAttrAction')->name('product.product.choose-attr');

    //ATTRIBUTE.
    Route::group(['prefix' => 'attribute'], function () {
        Route::get('/', 'ProductAttributeController@index')->name('product.product-attribute');
        Route::get('/create', 'ProductAttributeController@create')->name('product.product-attribute.create');
        Route::post('/store', 'ProductAttributeController@store')->name('product.product-attribute.store');
        Route::post('/destroy', 'ProductAttributeController@destroy')->name('product.product-attribute.destroy');
        Route::get('/edit/{id}', 'ProductAttributeController@edit')->name('product.product-attribute.edit');
        Route::post('/update', 'ProductAttributeController@update')->name('product.product-attribute.update');
        Route::get('/show/{code}', 'ProductAttributeController@show')->name('product.product-attribute.show');
    });
    //ATTRIBUTE GROUP.
    Route::group(['prefix' => 'attribute-group'], function () {
        Route::get('/', 'ProductAttributeGroupController@index')->name('product.product-attribute-group');
        Route::get('/create', 'ProductAttributeGroupController@create')->name('product.product-attribute-group.create');
        Route::post('/store', 'ProductAttributeGroupController@store')->name('product.product-attribute-group.store');
        Route::post('/destroy', 'ProductAttributeGroupController@destroy')->name('product.product-attribute-group.destroy');
        Route::get('/edit/{id}', 'ProductAttributeGroupController@edit')->name('product.product-attribute-group.edit');
        Route::post('/update', 'ProductAttributeGroupController@update')->name('product.product-attribute-group.update');
        Route::get('/show/{id}', 'ProductAttributeGroupController@show')->name('product.product-attribute-group.show');
    });

    //PRODUCT CATEGORY.
    Route::group(
        ['prefix' => 'product-category'], function () {
        Route::get('/', 'ProductCategoryController@index')->name('product.product-category');
        Route::get('/create', 'ProductCategoryController@create')->name('product.product-category.create');
        Route::post('/store', 'ProductCategoryController@store')->name('product.product-category.store');
        Route::post('/destroy', 'ProductCategoryController@destroy')->name('product.product-category.destroy');
        Route::get('/edit/{id}', 'ProductCategoryController@edit')->name('product.product-category.edit');
        Route::post('/update', 'ProductCategoryController@update')->name('product.product-category.update');
        Route::get('/show/{id}', 'ProductCategoryController@show')->name('product.product-category.show');
    });

    //PRODUCT TEMPLATE.
    Route::group(
        ['prefix' => 'product-template'], function () {
        Route::get('/', 'ProductTemplateController@index')->name('product.product-template');
        Route::get('/create', 'ProductTemplateController@create')->name('product.product-template.create');
        Route::post('/get-option-attribute', 'ProductTemplateController@getOptionAttribute')->name('product.product-template.get-option-attribute');
        Route::post('/get-detail-attribute', 'ProductTemplateController@getDetailAttribute')->name('product.product-template.get-detail-attribute');
        Route::post('/store', 'ProductTemplateController@store')->name('product.product-template.store');
        Route::post('/get-attribute-by-product', 'ProductTemplateController@getAttributeByParent')->name('product.product-template.get-attribute-by-product');
        Route::get('/edit/{code}', 'ProductTemplateController@edit')->name('product.product-template.edit');
        Route::post('/update', 'ProductTemplateController@update')->name('product.product-template.update');
        Route::get('/show/{code}', 'ProductTemplateController@show')->name('product.product-template.show');
    });

    //ORDER
    Route::group(
        ['prefix' => 'order'], function () {
        Route::get('/', 'OrderController@index')->name('product.order');
        Route::get('/create', 'OrderController@create')->name('product.order.create');
        Route::get('/edit/{code}', 'OrderController@edit')->name('product.order.edit');
        Route::get('show/{id}', 'OrderController@detail')->name('product.order.detail');
        Route::post('/get-district', 'OrderController@getDistrict')->name('product.order.get-district');
        Route::post('/approve-order', 'OrderController@approveOrder')->name('product.order.approveOrder');
        Route::post('/approve-adjust-order', 'OrderController@approveAdjustOrder')->name('product.order.approveAdjustOrder');
        Route::post('/pay-order', 'OrderController@payOrder')->name('product.order.payOrder');
        Route::post('/load-popup-create-order', 'OrderController@loadPopupCreateOrder')->name('product.order.load-popup-create-order');
        Route::post('/load-product', 'OrderController@loadProduct')->name('product.order.load-product');
        Route::post('/add-cart', 'OrderController@addCart')->name('product.order.add-cart');
        Route::post('/delete-cart', 'OrderController@deleteCart')->name('product.order.delete-cart');
        Route::post('/load-cart', 'OrderController@loadCart')->name('product.order.load-cart');
        Route::post('/update-cart', 'OrderController@updateCart')->name('product.order.update-cart');
        Route::post('/update-month', 'OrderController@updateMonth')->name('product.order.update-month');
        Route::post('/do-order', 'OrderController@doOrder')->name('product.order.do-order');
        Route::post('/load-promotion', 'OrderController@loadPromotion')->name('product.order.load-promotion');
        Route::post('/add-promotion', 'OrderController@addPromotion')->name('product.order.add-promotion');
        Route::get('/create-adjust', 'OrderController@createOrderAdjust')->name('product.order.create-adjust');
        Route::post('/get-detail-service', 'OrderController@getDetailService')->name('product.order.get-detail-service');
        Route::post('/load-popup-create-order-adjust', 'OrderController@loadPopupCreateOrderAdjust')
            ->name('product.order.load-popup-create-order-adjust');
        Route::post('/adjust-service', 'OrderController@adjustService')->name('product.order.adjust-service');
        Route::post('/submit-create-order-adjust', 'OrderController@submitCreateOrderAdjust')->name('product.order.submit-create-order-adjust');
        Route::post('/get-package-order-adjust', 'OrderController@getPackageOrderAdjust')->name('product.order.get-package-order-adjust');
        Route::post('/get-list-service-by-customer', 'OrderController@getListServiceByCustomer')->name('product.get-list-service-by-customer');

    });

    // Contract
    Route::group(
        ['prefix' => 'contract'], function () {
        Route::get('/', 'ContractController@index')->name('product.contract');
        Route::post('/action', 'ContractController@action')->name('product.contract.action');
        Route::post('/upload', 'ContractController@upload')->name('product.contract.upload');
        Route::get('show/{code}', 'ContractController@show')->name('product.contract.show');
        Route::get('edit/{id}', 'ContractController@edit')->name('product.contract.edit');
        Route::post('/update', 'ContractController@update')->name('product.contract.update');
    });

    //customer
    Route::group(
        ['prefix' => 'customer'], function () {
        Route::get('/', 'CustomerController@index')->name('product.customer');
        Route::get('/detail/{id}', 'CustomerController@detail')->name('product.customer.detail');
        Route::get('/edit/{id}', 'CustomerController@edit')->name('product.customer.edit');
        Route::post('/edit', 'CustomerController@editPost')->name('product.customer.editPost');
        Route::get('/create', 'CustomerController@create')->name('product.customer.create');
        Route::post('/store','CustomerController@store')->name('product.customer.store');
        Route::post('/upload', 'CustomerController@upload')->name('product.customer.upload');
        Route::post('/list-order', 'CustomerController@listOrder')->name('product.customer.list-order');
        Route::post('/list-service', 'CustomerController@listService')->name('product.customer.list-service');
        Route::post('/list-contract', 'CustomerController@listContract')->name('product.customer.list-contract');
        Route::post('/list-receipt', 'CustomerController@listReceipt')->name('product.customer.list-receipt');
        Route::post('/list-childAccount', 'CustomerController@listChildAccount')->name('product.customer.list-childAccount');
        Route::post('/change-status', 'CustomerController@changeStatusMyStoreUserAction')->name('product.customer.change-status');
        Route::get('/show-childAccount/{id}', 'CustomerController@showChildAccountAcction')->name('product.customer.show-childAccount');
        Route::post('/edit-childAccount', 'CustomerController@editChildAccountAcction')->name('product.customer.edit-childAccount');
        Route::post('/show-reset-password', 'CustomerController@showResetPassword')->name('product.customer.show-reset-password');
        Route::post('/edit-reset-password', 'CustomerController@updatePassword')->name('product.customer.edit-reset-password');
        Route::get('/add-childAccount/{id}', 'CustomerController@addChildAccount')->name('product.customer.add-childAccount');
        Route::post('/create-childAccount', 'CustomerController@createChildAccount')->name('product.customer.create-childAccount');
        Route::post('/change-status-customer', 'CustomerController@changeStatusCustomer')->name('product.customer.change-status-customer');
    });

    // service
    Route::group(
        ['prefix' => 'service'], function () {
        Route::get('/', 'CustomerServiceController@index')->name('product.service');
        Route::get('show/{id}', 'CustomerServiceController@show')->name('product.service.show');
        Route::get('edit/{id}', 'CustomerServiceController@edit')->name('product.service.edit');
        Route::post('/update', 'CustomerServiceController@update')->name('product.service.update');
        Route::post('/resume', 'CustomerServiceController@resume')->name('product.service.resume');
        Route::post('/detail', 'CustomerServiceController@detail')->name('product.service.detail');
        Route::post('/extends', 'CustomerServiceController@extendsService')->name('product.service.extends');
        Route::post('/stopPayment', 'CustomerServiceController@stopPayment')->name('product.service.stopPayment');
        Route::post('/attribute', 'CustomerServiceController@getAttributeService')->name('product.service.attribute');
    });

    //invoice
    Route::group(
        ['prefix' => 'invoice'], function () {
        Route::get('/', 'InvoiceController@index')->name('product.invoice');
        Route::get('show/{id}', 'InvoiceController@show')->name('product.invoice.show');
        Route::get('extends/{id}/insert', 'InvoiceController@insertInvoiceExtend')->name('product.invoice.extendInsert');
        Route::get('extends/{id}/edit', 'InvoiceController@editInvoiceExtend')->name('product.invoice.extendEdit');
        Route::post('extends/edit', 'InvoiceController@editInvoiceExtendPost')->name('invoice.extends.edit');
        Route::post('extends/insert', 'InvoiceController@insertInvoiceExtendPost')->name('invoice.extends.insert');
        Route::post('extends/delete', 'InvoiceController@deleteInvoiceExtendPost')->name('invoice.extends.delete');
        Route::get('edit/{id}', 'InvoiceController@edit')->name('product.invoice.edit');
        Route::post('/update', 'InvoiceController@update')->name('product.invoice.update');
    });

    //receipt
    Route::group(
        ['prefix' => 'receipt'], function () {
        Route::get('/', 'ReceiptController@index')->name('product.receipt');
        Route::post('/destroy', 'ReceiptController@cancelReceipt')->name('product.receipt.cancel');
        Route::get('/payment-receipt/{code}', 'ReceiptController@receipt')->name('product.receipt.payment-receipt');
        Route::post('/payment-receipt', 'ReceiptController@storeReceiptDetail')->name('product.receipt.submit-payment-receipt');
        Route::get('/show/{code}', 'ReceiptController@show')->name('product.receipt.show');
        Route::get('/showEdit/{code}', 'ReceiptController@showEdit')->name('product.receipt.showEdit');
        Route::post('/editReceipt', 'ReceiptController@editReceipt')->name('product.receipt.editReceipt');

    });

    // debt receipt
    Route::group(
        ['prefix' => 'debt-receipt'], function () {
        Route::get('/', 'ReceiptController@debtReceiptIndex')->name('product.debt-receipt');
        Route::get('/showDR/{code}', 'ReceiptController@showDebtRecript')->name('product.debt-receipt.showDR');
        Route::post('/payment-receipt', 'ReceiptController@storeDebtReceiptDetail')->name('product.debt-receipt.submit-payment-receipt');
        Route::post('/destroy', 'ReceiptController@cancelDebtReceipt')->name('product.debt-receipt.cancel');
        Route::get('/payment-receipt/{code}', 'ReceiptController@debtReceipt')->name('product.debt-receipt.payment-receipt');
        Route::get('/showEdit/{code}', 'ReceiptController@showDebtEdit')->name('product.receipt.showEditDebtReceipt');
        Route::post('/editDebtReceipt', 'ReceiptController@editDebtReceipt')->name('product.receipt.editDebtReceipt');
    });

    //VOUCHER
    Route::group(
        ['prefix' => 'voucher'], function () {
        Route::get('/', 'VouchersController@index')->name('product.voucher');
        Route::post('change-status', 'VouchersController@changeStatusVouchers')->name('product.voucher.change-status');
        Route::get('/edit/{id}', 'VouchersController@edit')->name('product.voucher.edit');
        Route::post('/edit', 'VouchersController@editPost')->name('product.voucher.editPost');
        Route::get('/detail/{id}', 'VouchersController@detail')->name('product.voucher.detail');
        Route::get('/create', 'VouchersController@create')->name('product.voucher.create');
        Route::post('/store','VouchersController@store')->name('product.voucher.store');
        Route::post('/destroy', 'VouchersController@destroy')->name('product.voucher.destroy');
    });

    //SEGMENT
    Route::group(
        ['prefix' => 'segment'], function () {
        Route::get('/', 'SegmentController@index')->name('product.segment');
        Route::get('/create', 'SegmentController@create')->name('product.segment.create');
        Route::post('/store', 'SegmentController@store')->name('product.segment.store');
        Route::post('/destroy', 'SegmentController@destroy')->name('product.segment.destroy');
        Route::get('/edit/{id}', 'SegmentController@edit')->name('product.segment.edit');
        Route::post('/update', 'SegmentController@update')->name('product.segment.update');
        Route::get('/show/{id}', 'SegmentController@show')->name('product.segment.show');
    });

    Route::group (
        ['prefix' => 'annex'], function () {
        Route::get('/', 'AnnexController@index')->name('product.annex');
        Route::post('/upload', 'AnnexController@upload')->name('product.annex.upload');
        Route::get('show/{id}', 'AnnexController@show')->name('product.annex.show');
        Route::get('edit/{id}', 'AnnexController@edit')->name('product.annex.edit');
        Route::post('/update', 'AnnexController@update')->name('product.annex.update');
    });

    Route::get('core/validation', function () {
        return trans('product::validation');
    })->name('product.validation');
});
