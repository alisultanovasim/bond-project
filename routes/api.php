<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'bonds'=>\App\Http\Controllers\BondController::class,
    'order'=>\App\Http\Controllers\BondOrderController::class
]);

Route::group(['prefix'=>'/bond'],function (){
   Route::get('/{id}/payouts/',[\App\Http\Controllers\BondActionController::class,'payouts']);
   Route::post('/{id}/order',[\App\Http\Controllers\BondActionController::class,'createOrder']);
   Route::get('/order/{id}/',[\App\Http\Controllers\BondActionController::class,'perPay']);
});

