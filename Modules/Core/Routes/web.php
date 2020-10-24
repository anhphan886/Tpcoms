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

Route::group(
    [
        'middleware' => ['web', 'locale'],
        'prefix' => 'admin'
        ],
    function () {
        Route::get('login', 'LoginController@index')->name('login');
        Route::post('login', 'LoginController@postLogin')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');

        Route::post('send-email-reset-password', 'ForgetPasswordController@sendEmailResetPassword')
            ->name('user.forget-password.send-email-reset-password');
        Route::post('/submit-reset-password', 'ForgetPasswordController@submitResetPassword')
            ->name('user.forget-password.submit-reset-password');
        Route::get('/forget-password-success', 'ForgetPasswordController@forgetPasswordSuccess')
            ->name('user.forget-password.forget-password-success');
        Route::get('/reset-password/{token}', 'ForgetPasswordController@resetPassword')->name('reset-password');

        Route::get('error-404', function () {
            return view('errors.error-404');
        })->name('error-404')->middleware('auth');
        Route::get('error-403', function () {
            return view('errors.error-403');
        })->name('error-403')->middleware('auth');
        Route::get('nothing', function () {
            return view('core::errors.blank');
        })->name('nothing')->middleware('auth');

        Route::get('core/validation', function () {
            return trans('core::validation');
        })->name('core.validation');

        Route::group(
            [
                'middleware' => ['web', 'auth', 'permission'],
                'prefix' => 'core',
            ],
            function () {
                // Admin Group
                Route::group(['prefix' => 'admin-group'], function () {
                    Route::get('/', 'AdminGroupController@index')->name('core.admin-group.index');
                    Route::get('create', 'AdminGroupController@create')->name('core.admin-group.create');
                    Route::post('store', 'AdminGroupController@store')->name('core.admin-group.store');
                    Route::get('show/{id}', 'AdminGroupController@show')
                        ->name('core.admin-group.show')
                        ->where('id', '[0-9]+');
                    Route::get('edit/{id}', 'AdminGroupController@edit')
                        ->name('core.admin-group.edit')
                        ->where('id', '[0-9]+');
                    Route::post('update', 'AdminGroupController@update')->name('core.admin-group.update');
                    Route::post('destroy', 'AdminGroupController@destroy')->name('core.admin-group.destroy');
                    Route::get('add-user-into-group/{group_id}', 'AdminGroupController@addUserIntoGroup')
                        ->name('core.admin-group.add-user-into-group')
                        ->where('group_id', '[0-9]+');
                    Route::post('submit-add-user-into-group', 'AdminGroupController@submitAddUserIntoGroup')
                        ->name('core.admin-group.submit-add-user-into-group');

                    Route::post('get-list-child', 'AdminGroupController@getListGroupChild')
                        ->name('core.admin-group.get-list-child');
                    Route::post('add-collection-list-child', 'AdminGroupController@addCollectionListGroupChild')
                        ->name('core.admin-group.add-collection-list-child');

                    Route::post('get-list-user', 'AdminGroupController@getListUser')
                        ->name('core.admin-group.get-list-user');
                    Route::post('add-collection-list-user', 'AdminGroupController@addCollectionListUser')
                        ->name('core.admin-group.add-collection-list-user');

                    Route::post('get-list-menu', 'AdminGroupController@getListMenu')
                        ->name('core.admin-group.get-list-menu');
                    Route::post('add-collection-list-menu', 'AdminGroupController@addCollectionListMenu')
                        ->name('core.admin-group.add-collection-list-menu');

                    Route::post('get-list-action', 'AdminGroupController@getListAction')
                        ->name('core.admin-group.get-list-action');
                    Route::post('add-collection-list-action', 'AdminGroupController@addCollectionListAction')
                        ->name('core.admin-group.add-collection-list-action');
                });

                // Admin Menu
                Route::group(['prefix' => 'admin-menu'], function () {
                    Route::get('/', 'AdminMenuController@index')->name('core.admin-menu.index');
                    Route::get('create', 'AdminMenuController@create')->name('core.admin-menu.create');
                    Route::post('store', 'AdminMenuController@store')->name('core.admin-menu.store');
                    Route::get('edit/{id}', 'AdminMenuController@edit')
                        ->name('core.admin-menu.edit')
                        ->where('id', '[0-9]+');
                    Route::post('update', 'AdminMenuController@update')->name('core.admin-menu.update');
                    Route::post('destroy', 'AdminMenuController@destroy')->name('core.admin-menu.destroy');
                    Route::post('get-list-group', 'AdminMenuController@getListGroup')
                        ->name('core.admin-menu.get-list-group');
                    Route::post('add-collection-list', 'AdminMenuController@addCollectionList')
                        ->name('core.admin-menu.add-collection-list');
                    Route::get('show/{id}', 'AdminMenuController@show')
                        ->name('core.admin-menu.show')
                        ->where('id', '[0-9]+');
                });

                // Admin Action
                Route::group(['prefix' => 'admin-action'], function () {
                    Route::get('/', 'AdminActionController@index')->name('core.admin-action.index');
                    Route::get('edit/{id}', 'AdminActionController@edit')
                        ->name('core.admin-action.edit')
                        ->where('id', '[0-9]+');
                    Route::post('update', 'AdminActionController@update')->name('core.admin-action.update');
                    Route::get('show/{id}', 'AdminActionController@show')
                        ->name('core.admin-action.show')
                        ->where('id', '[0-9]+');
                    Route::post('get-list-group', 'AdminActionController@getListGroup')
                        ->name('core.admin-action.get-list-group');
                    Route::post('add-collection-list-group', 'AdminActionController@addCollectionListGroup')
                        ->name('core.admin-action.add-collection-list-group');
                });

                // Admin Menu Category
                Route::group(['prefix' => 'admin-menu-category'], function () {
                    Route::get('/', 'AdminMenuCategoryController@index')->name('core.admin-menu-category.index');
                    Route::get('create', 'AdminMenuCategoryController@create')->name('core.admin-menu-category.create');
                    Route::post('store', 'AdminMenuCategoryController@store')->name('core.admin-menu-category.store');
                    Route::get('show/{id}', 'AdminMenuCategoryController@show')
                        ->name('core.admin-menu-category.show')
                        ->where('id', '[0-9]+');
                    Route::get('edit/{id}', 'AdminMenuCategoryController@edit')
                        ->name('core.admin-menu-category.edit')
                        ->where('id', '[0-9]+');
                    Route::post('update', 'AdminMenuCategoryController@update')
                        ->name('core.admin-menu-category.update');
                    Route::post('destroy', 'AdminMenuCategoryController@destroy')
                        ->name('core.admin-menu-category.destroy');
                });

                // User
                Route::group(['prefix' => 'user'], function () {
                    Route::get('/', 'AdminController@index')->name('core.user.index');
                    Route::get('create', 'AdminController@create')->name('core.user.create');
                    Route::post('store', 'AdminController@store')->name('core.user.store');
                    Route::get('show/{id}', 'AdminController@show')
                        ->name('core.user.show')
                        ->where('id', '[0-9]+');
                    Route::get('edit/{id}', 'AdminController@edit')
                        ->name('core.user.edit')
                        ->where('id', '[0-9]+');
                    Route::post('update', 'AdminController@update')->name('core.user.update');
                    Route::get('destroy/{id}', 'AdminController@destroy')->name('core.user.destroy');
                    Route::post('change-status', 'AdminController@changeStatusMyStoreUserAction')
                        ->name('core.user.change-status');
                    Route::post('/show-reset-password', 'AdminController@showResetPassword')
                        ->name('core.user.show-reset-password');
                    Route::post('/update-password', 'AdminController@updatePassword')
                        ->name('core.user.update-password');
                    Route::post('get-list-child', 'AdminController@getListGroupChild')
                        ->name('core.user.get-list-child');
                    Route::post('/add-collection-list-child', 'AdminController@addCollectionListGroupChild')
                        ->name('core.user.add-collection-list-child');
                });
            }
        );
        Route::get('/change-password', 'AdminController@changPassword')->name('admin.change-password');
        Route::post('/change-password', 'AdminController@submitChangPassword')->name('admin.submit-change-password');

    }
);
