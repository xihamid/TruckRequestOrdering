<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/client-login', [AuthController::class, 'clientLogin'])->name('client.login'); 
Route::post('/logout', [AuthController::class, 'logout'])->name('client.logout'); 




Route::middleware(['auth:sanctum', 'role:client'])->group(function () {
    Route::get('/orders', [OrderController::class, 'getOrders'])->name('client.orders');
    Route::post('/place-new-order', [OrderController::class, 'create'])->name('client.orders.store');
});


