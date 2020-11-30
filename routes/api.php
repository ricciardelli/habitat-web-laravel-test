<?php

use App\Http\Controllers\Api\BuyerController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SellerController;
use App\Http\Controllers\Api\SellerProductController;
use App\Http\Controllers\Auth\AuthController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('signup', [AuthController::class, 'signUp']);
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::get('logout', [AuthController::class, 'logout'])
        ->middleware('auth:api');
});

Route::apiResource('buyers', BuyerController::class)->only(['index', 'show'])->middleware('auth:api');
Route::apiResource('sellers', SellerController::class)->only(['index', 'show'])->middleware('auth:api');
Route::apiResource('products', ProductController::class)->only(['index', 'show'])->middleware('auth:api');

Route::post('sellers/product', [SellerController::class, 'product'])->name('sellers.product')->middleware('auth:api');
Route::post('products/{product}/buy', [ProductController::class, 'buy'])->name('sellers.product.buy')->middleware('auth:api');
