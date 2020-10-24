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
    'prefix' => 'ticket'
], function() {
    Route::get('/', 'TicketController@index')->name('ticket.index');
    Route::get('dashboard', 'TicketController@dashboard')->name('ticket.dashboard');
    Route::get('create', 'TicketController@create')->name('ticket.create');
    Route::get('test', 'TicketController@test')->name('ticket.test');
    Route::post('store', 'TicketController@store')->name('ticket.store');
    Route::get('show/{id}', 'TicketController@show')
        ->name('ticket.show')
        ->where('id', '[0-9]+');
    Route::get('edit/{id}', 'TicketController@edit')
        ->name('ticket.edit')
        ->where('id', '[0-9]+');
    Route::post('update', 'TicketController@update')->name('ticket.update');
    Route::post('get-info-customer', 'TicketController@getInfoCustomer')->name('ticket.get-info-customer');
    Route::post('get-list-issue', 'TicketController@getListIssue')->name('ticket.get-list-issue');
    Route::post('get-list-service-by-customer', 'TicketController@getListServiceByCustomer')->name('ticket.get-list-service-by-customer');
    Route::post('select-queue', 'TicketController@selectQueue')->name('ticket.select-queue');
    Route::post('get-staff-by-queue', 'TicketController@getListStaffByQueue')->name('ticket.get-staff-by-queue');
    Route::post('upload-img', 'TicketController@uploadImage')->name('ticket.upload-img');
    Route::post('post-comment', 'TicketController@postComment')->name('ticket.post-comment');
    Route::get('detail-ticket-date', 'TicketController@detailTicketCheckDate')->name('ticket.detail-ticket-date');

    // Issue group
    Route::group(['prefix' => 'issue-group'], function () {
        Route::get('/', 'IssueGroupController@index')->name('ticket.issue-group.index');
        Route::get('create', 'IssueGroupController@create')->name('ticket.issue-group.create');
        Route::get('add', 'IssueGroupController@add')->name('ticket.issue-group.add');
        Route::post('store', 'IssueGroupController@store')->name('ticket.issue-group.store');
        Route::get('edit/{id}', 'IssueGroupController@edit')->name('ticket.issue-group.edit');
        Route::post('update', 'IssueGroupController@update')->name('ticket.issue-group.update');
        Route::post('/destroy', 'IssueGroupController@destroy')->name('ticket.issue-group.destroy');
    });

    // Issue
    Route::group(['prefix' => 'issue'], function () {
        Route::get('/', 'IssueController@index')->name('ticket.issue.index');
        Route::get('create', 'IssueController@create')->name('ticket.issue.create');
        Route::post('store', 'IssueController@store')->name('ticket.issue.store');
        Route::get('edit/{id}', 'IssueController@edit')->name('ticket.issue.edit');
        Route::post('update', 'IssueController@update')->name('ticket.issue.update');
        Route::get('add', 'IssueController@add' )->name('ticket.issue.add');
        Route::post('/destroy', 'IssueController@destroy')->name('ticket.issue.destroy');
    });

    Route::group(['prefix' => 'queue'], function () {
        Route::get('/', 'QueueController@index')->name('ticket.queue.index');
        Route::get('create', 'QueueController@create')->name('ticket.queue.create');
        Route::post('store', 'QueueController@store')->name('ticket.queue.store');
        Route::get('edit/{id}', 'QueueController@edit')->name('ticket.queue.edit');
        Route::post('update', 'QueueController@update')->name('ticket.queue.update')->where('id', '[0-9]+');
        Route::post('destroy', 'QueueController@destroy')->name('ticket.queue.destroy');
    });

Route::get('validation', function () {
    return trans('ticket::validation');
})->name('ticket.validation');
});
