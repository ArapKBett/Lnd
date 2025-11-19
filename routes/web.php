<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\LoanController as ClientLoan;
use App\Http\Controllers\Payment\MpesaController;
use App\Http\Controllers\Payment\CryptoController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Staff\DashboardController as StaffDashboard;

// Landing
Route::get('/', function () { return view('landing'); });

// Auth
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Middleware groups
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/dashboard', [ClientLoan::class, 'index'])->name('client.dashboard');
    Route::get('/client/loans/create', [ClientLoan::class, 'create'])->name('client.loans.create');
    Route::post('/client/loans', [ClientLoan::class, 'store'])->name('client.loans.store');
    Route::get('/client/loans', [ClientLoan::class, 'index'])->name('client.loans.index');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    // Clients, loans routes
});

Route::middleware(['auth', 'role:staff'])->prefix('staff')->group(function () {
    Route::get('/dashboard', [StaffDashboard::class, 'index'])->name('staff.dashboard');
    // Approvals, reports
});

// Payments
Route::post('/mpesa/stk', [MpesaController::class, 'stkPush'])->name('mpesa.stk');
Route::post('/mpesa/callback', [MpesaController::class, 'callback'])->name('mpesa.callback');
Route::post('/crypto/pay', [CryptoController::class, 'createPayment'])->name('crypto.pay');
Route::post('/crypto/webhook', [CryptoController::class, 'webhook'])->name('crypto.webhook');
