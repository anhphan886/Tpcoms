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
Route::post('createvm', 'VMWareController@create')->name('vmware.create');
Route::post('createorg', 'VMWareController@createOrg')->name('vmware.create.org');

Route::get('/', function () {
//    return redirect()->route('admin');
    return redirect()->route('wiki.knowledge-base');
});
