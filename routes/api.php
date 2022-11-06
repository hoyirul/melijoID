<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\ProductRecomendationController;
use App\Http\Controllers\Api\PromoController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\RecipeFavouriteController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SellerController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\UserAddressController;
use App\Http\Controllers\Api\UserController;
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
Route::post('/auth/register/seller', [AuthController::class, 'register_seller']);
Route::put('/auth/fcm_token', [AuthController::class, 'fcm']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::apiResource('role', RoleController::class);
    Route::apiResource('unit', UnitController::class);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('address', AddressController::class);
    
    Route::apiResource('product', ProductController::class);
    Route::post('product/{seller_id}/search', [ProductController::class, 'search']);


    Route::apiResource('product_image', ProductImageController::class);

    Route::controller(SellerController::class)->group(function() {
        Route::get('user_seller/{ward}', 'index');
        Route::get('user_seller/{seller_id}/product', 'show_by_id');
        Route::get('transaction/{seller_id}/seller', 'count_my_product_transaction');
    });

    Route::controller(CartController::class)->group(function() {
        Route::get('cart/{customer_id}', 'index');
        Route::post('cart', 'store');
        Route::get('cart/{id}/show', 'show');
        Route::put('cart/{id}/update', 'update');
        Route::delete('cart/{id}/destroy', 'destroy');
    });

    Route::controller(TransactionController::class)->group(function() {
        Route::get('transaction/{customer_id}/customer', 'index');
        Route::put('transaction/{txid}/confirmation', 'update_status_trx');
        Route::put('transaction/{txid}/canceled', 'update_status_canceled');
        Route::post('transaction', 'store');
        Route::get('transaction/{txid}/detail', 'show');
        Route::get('user_seller/{seller_id}/transaction', 'show_by_seller');
    });

    Route::controller(PaymentController::class)->group(function() {
        Route::get('payment/{customer_id}', 'index');
        Route::post('payment', 'store');
    });

    Route::controller(RecipeController::class)->group(function() {
        Route::get('recipe', 'index');
        Route::get('recipe/{id}', 'show');
    });
    
    Route::controller(ProductRecomendationController::class)->group(function() {
        Route::get('product_recom/{id}/{seller_id}', 'show');
    });

    Route::controller(RecipeFavouriteController::class)->group(function() {
        Route::get('recipe_favourite/{customer_id}', 'index');
        Route::post('recipe_favourite', 'store');
        Route::get('recipe_favourite/{id}', 'show');
        Route::put('recipe_favourite/{id}', 'update');
        Route::delete('recipe_favourite/{id}', 'destroy');
    });

    Route::controller(PromoController::class)->group(function() {
        Route::get('promo', 'index');
        Route::get('promo/{promo_code}', 'show');
    });

    Route::controller(UserController::class)->group(function() {
        Route::get('user/{user_id}/profile', 'show_profile');
        Route::post('user/{user_id}/image', 'update_profile_image');
        Route::put('user/{user_id}/profile', 'update_profile');
        Route::get('user/{user_id}/address', 'show_address');
        Route::put('user/{user_id}/address', 'update_address');
    });
});