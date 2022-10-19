<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\RoleController;
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

Route::resource('role', RoleController::class);
Route::resource('unit', RoleController::class);
Route::resource('category', RoleController::class);
Route::resource('address', AddressController::class);
Route::resource('user_address', UserAddressController::class);