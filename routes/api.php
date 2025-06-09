<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController; // Pastikan ini mengarah ke OrderController Anda

// Rute untuk Midtrans Payment Notification (Callback)
// Rute di api.php secara default tidak memerlukan withoutMiddleware(['csrf'])
Route::post('/midtrans-notification', [OrderController::class, 'handleMidtransNotification']);
