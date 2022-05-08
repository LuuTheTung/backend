<?php

use Illuminate\Http\Request;


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/customers', 'CustomerController');
Route::resource('/category', 'CategoryController');
Route::resource('/invoice', 'InvoiceController');
Route::resource('/company', 'CompanyController');
Route::get('/categoryName/{category_name}', 'CategoryController@getPrice')->name('customers.getCategorybyName');
Route::get('/invoiceByUser/{create_user}', 'InvoiceController@getListInvoice')->name('invoice.getListInvoice');
Route::get('/userByAdmin/{create_user}', 'InvoiceController@getListUser')->name('invoice.getListUser');
Route::get('/incomeStatement/{create_user}', 'InvoiceController@getTodayIncome')->name('invoice.getTodayIncome');
Route::get('/incomeStatementByMonth/{create_user}', 'InvoiceController@getCurrentMonth')->name('invoice.getCurrentMonth');
Route::get('/lastestInvoice/{create_user}', 'InvoiceController@getLastestInvoice')->name('invoice.getLastestInvoice');
//loginAPI
Route::post('/login', 'LoginController@getLogin');

