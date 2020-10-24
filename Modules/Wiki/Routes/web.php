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
    'prefix' => 'wiki',
    'middleware' => ['web','auth' ,'locale','permission']
], function() {
    Route::group(['prefix' => 'knowledge-base'], function () {
        Route::get('/list-category-knowledge-base', 'WikiController@listCategory')->name('wiki.category');
        Route::get('/create-category-knowledge-base', 'WikiController@createCategory')->name('wiki.category.create');
        Route::post('/create-category-post', 'WikiController@createCategoryPost')->name('wiki.category.create.post');
        Route::get('/edit-category/{id}', 'WikiController@editCategory')->name('wiki.category.edit');
        Route::post('/edit-category-post', 'WikiController@editCategoryPost')->name('wiki.category.edit.post');
        Route::post('/delete-category-post', 'WikiController@deleteCategoryPost')->name('wiki.category.delete.post');

        Route::get('/list-knowledge-base', 'WikiController@listKnowledgeBase')->name('wiki.knowledge-base');
        Route::get('/create-knowledge-base', 'WikiController@createKnowledgeBase')->name('wiki.knowledge-base.create');
        Route::post('/create-knowledge-base', 'WikiController@createKnowledgeBasePost')
            ->name('wiki.knowledge-base.create.post');
        Route::get('/edit-knowledge-base/{id}', 'WikiController@editKnowledgeBase')->name('wiki.knowledge-base.edit');
        Route::post('/edit-knowledge-base', 'WikiController@editKnowledgeBasePost')
            ->name('wiki.knowledge-base.edit.post');
        Route::post('/delete-knowledge-base', 'WikiController@deleteKnowledgeBasePost')
            ->name('wiki.knowledge-base.delete.post');
        Route::post('/upload-image', 'WikiController@uploadImage')->name('wiki.upload.image');
    });
});
