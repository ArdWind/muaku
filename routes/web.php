<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerificationController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/auth-google-redirect', [AuthController::class, 'googleRedirect']);
Route::get('/auth-google-callback', [AuthController::class, 'googleCallback']);

Route::group(['middleware' => ['auth', 'check_role:customer']], function () {
    Route::get('/verify', [VerificationController::class, 'index']);
    Route::post('/verify', [VerificationController::class, 'store']);
    Route::get('/verify/{unique_id}', [VerificationController::class, 'show']);
    Route::put('/verify/{unique_id}', [VerificationController::class, 'update']);
});

Route::group(['middleware' => ['auth', 'check_role:customer', 'check_status']], function () {
    Route::get('/customer', fn() => view('customer'));
});
Route::group(['middleware' => ['auth', 'check_role:admin,staff']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
Route::group(['middleware' => ['auth', 'check_role:admin']], function () {
    Route::get('/user', fn() => view('halaman user'));
});
Route::get('/logout', [AuthController::class, 'logout']);
