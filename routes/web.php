<?php

use App\Http\Controllers\Operator\CategoryController;
use App\Http\Controllers\Operator\CustomerController;
use App\Http\Controllers\Operator\HomeController;
use App\Http\Controllers\Operator\OperatorController;
use App\Http\Controllers\Operator\PaymentController;
use App\Http\Controllers\Operator\ProductRecipeController;
use App\Http\Controllers\Operator\RecipeController;
use App\Http\Controllers\Operator\RoleController;
use App\Http\Controllers\Operator\SellerController;
use App\Http\Controllers\Operator\SettingController;
use App\Http\Controllers\Operator\TransactionController;
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

        Route::controller(SettingController::class)->group(function() {
            Route::get('/change_password', 'change_password');
            Route::put('/update_password', 'update_password');
            Route::get('/change_profile', 'change_profile');
            Route::put('/update_profile', 'update_profile');
        });

        Route::resource('recipe', RecipeController::class);
        Route::controller(ProductRecipeController::class)->group(function(){
            Route::get('/product_recipe/{id}/show', 'index');
            Route::post('/product_recipe', 'store');
            Route::delete('/product_recipe/{id}/{recipe_id}', 'destroy');
        });
        Route::resource('product_recipe', ProductRecipeController::class);

        Route::controller(TransactionController::class)->group(function() {
            Route::get('/transaction', 'index');
        });

        Route::controller(PaymentController::class)->group(function() {
            Route::get('/payment', 'index');
            Route::get('/payment/{status}', 'show_by_status');
            Route::put('/payment/{status}/{id}', 'update_by_id_status');
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
