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
    'middleware' => ['web', 'auth', 'locale', 'permission'],
    'prefix' => 'vcloud'
], function() {
    Route::post('action', 'VcloudController@action')->name('vcloud.action');
    Route::post('detail', 'VcloudController@detail')->name('vcloud.detail');
    Route::get('remote', 'VcloudController@remote')->name('vcloud.remote');
    Route::post('create-vm', 'VcloudController@createVm')->name('vcloud.creat-vm');
    Route::post('create-org', 'VcloudController@createOrg')->name('vcloud.creat-org');
    Route::post('config-firewall', 'VcloudController@configFirewall')->name('vcloud.firewall');
});
