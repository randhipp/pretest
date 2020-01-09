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

Route::middleware('auth:api')->post('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    
    Route::post('/balance', 'BalanceController@balance');
    
    Route::resource('/topup', 'TopUpController');
    Route::resource('/transfer', 'TransferController');
    Route::resource('/payment', 'PaymentController');
});

Route::post('/login', 'ApiLoginController@login')->name('apilogin');
Route::post('/logout', 'ApiLoginController@logout')->name('apilogout');
