<?php

Route::group([
    'prefix' => 'admin',
    'as' => 'admin::',
    'middleware' => ['web', \WTG\Admin\Middleware\AuthAdmin::class],
    'namespace' => 'WTG\Admin\Controllers'
], function () {
    // Admin dashboard
    Route::get('/', 'DashboardController@view')->name('dashboard');

    // Admin API Routes
    Route::group(['as' => 'dashboard.', 'prefix' => 'dashboard'], function () {
        Route::get('stats', 'DashboardController@stats')->name('stats');
        Route::get('chart/{type}', 'DashboardController@chart')->name('chart');
    });

    // Admin import page
    Route::get('import', 'ImportController@view')->name('import');

    Route::group(['as' => 'import.'], function () {
        Route::get('import/success', 'ImportController@success')->name('success');

        Route::post('import/product', 'ImportController@product')->name('product');
        Route::post('import/image', 'ImportController@image')->name('image');
        Route::post('import/discount', 'ImportController@discount')->name('discount');
        Route::post('import/download', 'ImportController@download')->name('download');
    });

    Route::get('manager', 'UserManagerController@view')->name('manager');

    // Admin user manager
    Route::group(['as' => 'manager.', 'prefix' => 'manager'], function () {
        Route::get('edit/{companyId}', 'UserManagerController@edit')->name('edit');

//        Route::get('get', 'UserManagerController@get')->name('get');
//        Route::get('added', 'UserManagerController@added')->name('added');
        Route::patch('edit/{companyId}', 'UserManagerController@update')->name('update');

        Route::delete('{companyId}', 'UserManagerController@delete')->name('delete');

        Route::post('create', 'UserManagerController@create')->name('create');
        Route::post('edit/{companyId}/create-account', 'UserManagerController@createAccount')->name('create-account');
//        Route::post('update', 'UserManagerController@update')->name('update');
//        Route::post('delete', 'UserManagerController@delete')->name('delete');
    });

    // Admin carousel manager
    Route::get('carousel', 'CarouselController@view')->name('carousel');

    Route::group(['as' => 'carousel.', 'prefix' => 'carousel'], function () {
        Route::delete('delete/{id}', 'CarouselController@delete')->name('delete');

        Route::post('edit', 'CarouselController@edit')->name('edit');
        Route::post('create', 'CarouselController@create')->name('create');
    });

    // Admin export
    Route::get('export', 'ExportController@view')->name('export');

    Route::group(['as' => 'export.', 'prefix' => 'export'], function () {
        Route::post('catalog', 'ExportController@catalog')->name('catalog');
        Route::post('pricelist', 'ExportController@pricelist')->name('pricelist');
    });

    // Admin content
    Route::get('content', 'ContentController@view')->name('content');

    Route::group(['as' => 'content.', 'prefix' => 'content'], function () {
        Route::get('get', 'ContentController@content')->name('content');
        Route::get('description', 'ContentController@description')->name('description');
        Route::post('save/page', 'ContentController@savePage')->name('save_page');
        Route::post('save/description', 'ContentController@saveDescription')->name('save_description');
    });

    // Admin packs
    Route::get('packs', 'PacksController@view')->name('packs');

    Route::group(['as' => 'packs.', 'prefix' => 'packs'], function () {
        Route::get('edit/{id}', 'PacksController@edit')->name('edit');

        Route::post('add', 'PacksController@create')->name('create');
        Route::post('addProduct', 'PacksController@addProduct')->name('add');
        Route::post('remove', 'PacksController@destroy')->name('delete');
        Route::post('removeProduct', 'PacksController@removeProduct')->name('remove');
    });

    // Admin cache
    Route::get('cache', 'CacheController@view')->name('cache');

    Route::group(['as' => 'cache.', 'prefix' => 'cache'], function () {
        Route::get('reset', 'CacheController@reset')->name('reset');
    });

    // Admin e-mail
    Route::get('email', 'EmailController@view')->name('email');

    Route::group(['as' => 'email.', 'prefix' => 'email'], function () {
        Route::get('stats', 'EmailController@stats')->name('stats');
        Route::post('test', 'EmailController@test')->name('test');
    });
});