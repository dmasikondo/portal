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

Route::get('transactions/add', 'TransactionController@addTransaction');
Route::get('transactions/bulk-add', 'TransactionController@bulkAddTransactions');
Route::get('transactions/last-autoidx', 'TransactionController@lastAutoIdx');

//Route::get('transactions/get-uncommitted-charge', function () {
//    $charges = \App\StudentCharge::with(["student" => function ($q) {
//        $q->select("id", "national_id");
//    }])->whereIsPosted(0)->get();
//    return $charges;
//});