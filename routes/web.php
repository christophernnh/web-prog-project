<?php

use App\Http\Controllers\AddItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

//guest access
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login')->middleware(RedirectIfAuthenticated::class);
Route::post('/', [AuthController::class, 'login'])->middleware(RedirectIfAuthenticated::class);


//auth access
Route::get('/additem', [AddItemController::class, 'showAddItemForm'])->middleware(UserMiddleware::class);
Route::post('/additem', [AddItemController::class, 'addItem'])->middleware(UserMiddleware::class);
Route::get('/dashboard', [DashboardController::class, 'show'])->middleware([UserMiddleware::class]);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware([UserMiddleware::class]);
Route::get('/user/{id}/fooditems', [DashboardController::class, 'showUserFoodItems'])->name('user.fooditems')->middleware([UserMiddleware::class]);
Route::get('/fooditem/{id}', [DashboardController::class, 'showFoodItem'])->name('fooditem.details');


//admin access
