<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/find', 'HomeController@getItem');
Route::get('/home', 'HomeController@pos');
Route::get('/return', 'HomeController@return');
Route::get('/posPdf/{key}', 'HomeController@printPdf');
Route::post('/posAction', 'HomeController@posAction');
Route::post('/posReturn', 'HomeController@posReturn');
Route::get('/me', 'HomeController@me');
Route::post('/me-store/{id}', 'HomeController@postStoreProfile');
Route::get('/findReturn/{key}', 'HomeController@findReturn');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth'], function () {

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    Route::group(['namespace' => 'Admin'], function () {
        Route::resource('clients', 'ClientsController', ['except' => ['show']]);
        Route::resource('roles', 'RolesController', ['except' => ['show']]);
        Route::resource('users', 'UsersController', ['except' => ['show']]);
        Route::resource('outlets', 'OutletsController', ['except' => ['show']]);
        Route::resource('categories', 'CategoryController', ['except' => ['show']]);
        Route::resource('suppliers', 'SuppliersController', ['except' => ['show']]);
        Route::resource('products', 'ProductsController', ['except' => ['show']]);
        Route::get('in/history', 'ProductsInController@history');
        Route::resource('in', 'ProductsInController', ['except' => ['show']]);
        Route::get('stocks/broken', 'StocksController@broken', ['except' => ['show']]);
        Route::resource('stocks', 'StocksController', ['except' => ['show']]);

        /* History Out */
        Route::get('out/history', 'ProductsOutController@history');
        Route::resource('out', 'ProductsOutController', ['except' => ['show']]);
        
        /* Acl */
        Route::post('modules/storeAcl', 'ModulesController@accessPost');
        Route::get('modules/access', 'ModulesController@access');
        Route::resource('modules', 'ModulesController', ['except' => ['show']]);
        
        /* Reports */
        Route::get('reports/excel-in', 'ReportsController@excelIn', ['except' => ['show']]);
        Route::get('reports/datatableIn', 'ReportsController@getDataTableItemIn', ['except' => ['show']]);
        Route::get('reports/in', 'ReportsController@itemIn', ['except' => ['show']]);

        Route::get('reports/excel-stock', 'ReportsController@excelStock', ['except' => ['show']]);
        Route::get('reports/datatableStock', 'ReportsController@getDataTableItemStock', ['except' => ['show']]);
        Route::get('reports/stock', 'ReportsController@itemStock', ['except' => ['show']]);

        Route::get('reports/excel-return', 'ReportsController@excelReturn', ['except' => ['show']]);
        Route::get('reports/datatableReturn', 'ReportsController@getDataTableReturn', ['except' => ['show']]);
        Route::get('reports/return', 'ReportsController@itemReturn', ['except' => ['show']]);

        Route::get('reports/excel-buy', 'ReportsController@excelBuy', ['except' => ['show']]);
        Route::get('reports/datatableBuy', 'ReportsController@getDataTableItemBuy', ['except' => ['show']]);
        Route::get('reports/buy', 'ReportsController@itemBuy', ['except' => ['show']]);

        Route::get('reports/excel', 'ReportsController@excel', ['except' => ['show']]);
        Route::get('reports/datatable', 'ReportsController@getDataTable', ['except' => ['show']]);
        Route::resource('reports', 'ReportsController', ['except' => ['show']]);

        /* Setting */
        Route::post('settings/post', 'SettingsController@store', ['except' => ['show']]);
        Route::resource('settings', 'SettingsController', ['except' => ['show']]);

    });
});