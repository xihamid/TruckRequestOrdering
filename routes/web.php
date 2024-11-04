<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;







/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::post('/admin-login', [AuthController::class, 'adminLogin'])->name('admin.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/send-email', [UserController::class, 'index'])->name('send.email.index');
    Route::post('/users/send-email', [UserController::class, 'sendEmail'])->name('users.sendEmail');
    Route::get('/users/{user}/email-history', [UserController::class, 'getEmailHistory'])->name('users.emailHistory');



  
});

Route::get('clear', function () {
    $cacheClearOutput = Artisan::call('cache:clear');
    $routeClearOutput = Artisan::call('route:clear');
    $configClearOutput = Artisan::call('config:clear');
    $viewClearOutput = Artisan::call('view:clear');
    $output = Artisan::output();
    return  ('Cache cleared successfully');
}); 



Route::get('/login', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('auth.login');
})->name('login');

Route::get('/pusher', function () {

    return view('pusher');
})->name('pusher');





