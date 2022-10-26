<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\PromoController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SellerController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\UserAddressController;
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

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::put('/auth/fcm_token', [AuthController::class, 'fcm']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::apiResource('role', RoleController::class);
    Route::apiResource('unit', UnitController::class);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('address', AddressController::class);
    Route::apiResource('product', ProductController::class);
    Route::apiResource('product_image', ProductImageController::class);
    Route::controller(SellerController::class)->group(function() {
        Route::get('user_seller/{ward}', 'index');
        Route::get('user_seller/{id}/product', 'show_by_id');
    });

    Route::controller(CartController::class)->group(function() {
        Route::get('cart/{customer_id}', 'index');
        Route::post('cart', 'store');
        Route::get('cart/{id}', 'show');
        Route::put('cart/{id}', 'update');
        Route::delete('cart/{id}', 'destroy');
    });

    Route::controller(PromoController::class)->group(function() {
        Route::get('promo', 'index');
        Route::get('promo/{promo_code}', 'show');
    });
});