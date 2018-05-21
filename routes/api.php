<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group([

    'middleware' => 'jwt.auth'

], function ($router) {

    Route::post('/transactions/sales', 'TransactionController@sell');
    Route::get('/transactions/sales', 'TransactionController@sales');
    Route::get('/transactions/sales/create', 'TransactionController@salesCreate');
    Route::get('/transactions/sales/{id}', 'TransactionController@salesShow');

    Route::get('/commissions/{ids}/edit', 'CommissionController@edit')
        ->where('ids', '[0-9]+(,[0-9]+)*');

    Route::put('/commissions', 'CommissionController@update');

    Route::resource('/commissions', 'CommissionController', ['except' => ['edit', 'update']]);

    Route::get('/customers/birthdays', 'CustomerController@birthdays');
    Route::get('/employees/birthdays', 'EmployeeController@birthdays');

    Route::resources([
        '/customers' => 'CustomerController',
        '/products' => 'ProductController',
        '/employees' => 'EmployeeController',
        '/providers' => 'ProviderController',
        '/transactions' => 'TransactionController',
    ]);

    Route::get('/inventory', 'TransactionController@inventory');

});