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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('getuserbyname','ApiController@getuserbyname');
Route::post('store-user','ApiController@store_user');
Route::post('store-product-in','ApiController@store_product_in');
Route::post('store-product-out','ApiController@store_product_out');

Route::post('store-tower/{halaman}','ApiController@store_tower');