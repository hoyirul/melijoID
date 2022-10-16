<?php

use App\Http\Controllers\Operator\CategoryController;
use App\Http\Controllers\Operator\CustomerController;
use App\Http\Controllers\Operator\HomeController;
use App\Http\Controllers\Operator\OperatorController;
use App\Http\Controllers\Operator\RoleController;
use App\Http\Controllers\Operator\SellerController;
use App\Http\Controllers\Operator\UnitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function(){
    Route::prefix('operator')->group(function(){
        Route::controller(HomeController::class)->group(function(){
            Route::get('dashboard', 'index');
        });

        Route::middleware('isSuperadmin')->group(function(){
            Route::resource('role', RoleController::class);
            Route::resource('category', CategoryController::class);
            Route::resource('unit', UnitController::class);

            Route::resource('operator', OperatorController::class);
            Route::resource('customer', CustomerController::class);
            Route::resource('seller', SellerController::class);
        });
    });
});
