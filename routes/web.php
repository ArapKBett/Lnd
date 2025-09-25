<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\LoanController as ClientLoan;
use App\Http\Controllers\Payment\MpesaController;
use App\Http\Controllers\Payment\CryptoController;

// Landing
Route::get('/', function () { return view('landing'); });

// Auth
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Middleware groups
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/dashboard', [ClientLoan::class, 'index'])->name('client.dashboard');
    Route::resource('client/loans', ClientLoan::class);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
    // Clients, loans routes
});

Route::middleware(['auth', 'role:staff'])->prefix('staff')->group(function () {
    // Approvals, reports
});

// Payments
Route::post('/mpesa/stk', [MpesaController::class, 'stkPush'])->name('mpesa.stk');
Route::post('/mpesa/callback', [MpesaController::class, 'callback'])->name('mpesa.callback');
Route::post('/crypto/pay', [CryptoController::class, 'createPayment'])->name('crypto.pay');
Route::post('/crypto/webhook', [CryptoController::class, 'webhook'])->name('crypto.webhook');
