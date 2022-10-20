<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::get('admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('get-products', [App\Http\Controllers\Admin\DashboardController::class, 'getProducts'])->name('get.products');
        Route::post('admin/dashboard/change/status/product', [App\Http\Controllers\Admin\DashboardController::class, 'changeStatus'])->name('change.product.status');
    });

    Route::middleware('user')->group(function () {
        Route::get('user/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');
        Route::get('get-categories', [App\Http\Controllers\User\DashboardController::class, 'getCategories'])->name('get.categories');
        Route::get('get-products', [App\Http\Controllers\User\DashboardController::class, 'getProducts'])->name('get.products');
        Route::get('get-category-list', [App\Http\Controllers\User\DashboardController::class, 'getCategoryList'])->name('get.category.list');
        Route::post('user/dashboard/category/add', [App\Http\Controllers\User\DashboardController::class, 'addCategory']);
        Route::post('user/dashboard/category/edit', [App\Http\Controllers\User\DashboardController::class, 'editCategory']);
        Route::post('user/dashboard/delete/category', [App\Http\Controllers\User\DashboardController::class, 'deleteCategory']);
        Route::post('user/dashboard/product/add', [App\Http\Controllers\User\DashboardController::class, 'addProduct']);
        Route::post('user/dashboard/product/edit', [App\Http\Controllers\User\DashboardController::class, 'editProduct']);
        Route::post('user/dashboard/delete/product', [App\Http\Controllers\User\DashboardController::class, 'deleteProduct']);
    });

});
