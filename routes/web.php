<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerificationController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\ProductController;

// data-users
Route::get('/data-users', [DataUserController::class, 'DataUserView'])->name('data_users.index');// Tampilkan data user
Route::get('/data-users/create', [DataUserController::class, 'create'])->name('data_users.create');// Form tambah user
Route::post('/data-users', [DataUserController::class, 'store'])->name('data_users.store');// Simpan user baru
Route::get('/data-users/{user}/edit', [DataUserController::class, 'edit'])->name('data_users.edit');// Form edit user
Route::put('/data-users/{user}', [DataUserController::class, 'update'])->name('data_users.update');// Update user
Route::delete('/data-users/{user}', [DataUserController::class, 'destroy'])->name('data_users.destroy');// Hapus user

// data-products
Route::get('/data-products', [ProductController::class, 'DataProductView'])->name('data_products.index');// Tampilkan data produk
Route::get('/data-products/create', [ProductController::class, 'create'])->name('data_products.create');// Form tambah produk
Route::post('/data-products', [ProductController::class, 'store'])->name('data_products.store');// Simpan produk baru
Route::get('/data-products/{product}/edit', [ProductController::class, 'edit'])->name('data_products.edit');// Form edit produk
Route::put('/data-products/{product}', [ProductController::class, 'update'])->name('data_products.update');// Update produk
Route::delete('/data-products/{product}', [ProductController::class, 'destroy'])->name('data_products.destroy'); // Hapus produk


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
    // Route::get('/data', fn() => view('data'));
});
Route::get('/logout', [AuthController::class, 'logout']);
