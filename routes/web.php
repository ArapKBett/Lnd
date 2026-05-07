<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\LoanController as ClientLoan;
use App\Http\Controllers\Client\DashboardController as ClientDashboard;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Staff\LoanController as StaffLoan;
use App\Http\Controllers\Staff\DashboardController as StaffDashboard;
use App\Http\Controllers\Staff\ReportController as StaffReport;
use App\Http\Controllers\Payment\MpesaController;
use App\Http\Controllers\Payment\CryptoController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ClientController as AdminClient;
use App\Http\Controllers\Admin\LoanController as AdminLoan;
use App\Http\Controllers\Admin\StaffController as AdminStaff;
use App\Http\Controllers\Admin\ReportController as AdminReport;
use App\Http\Controllers\Admin\SettingsController as AdminSettings;
use App\Http\Controllers\LoanDisbursementController;

// Landing
Route::get('/', function () { return view('landing'); })->name('home');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Client Routes
Route::middleware(['auth', 'role:client'])->prefix('client')->group(function () {
    Route::get('/dashboard', [ClientDashboard::class, 'index'])->name('client.dashboard');
    Route::get('/loans', [ClientLoan::class, 'index'])->name('client.loans.index');
    Route::get('/loans/create', [ClientLoan::class, 'create'])->name('client.loans.create');
    Route::post('/loans', [ClientLoan::class, 'store'])->name('client.loans.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('client.profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('client.profile.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

    // Clients
    Route::get('/clients', [AdminClient::class, 'index'])->name('admin.clients.index');
    Route::get('/clients/{id}', [AdminClient::class, 'show'])->name('admin.clients.show');
    Route::put('/clients/{id}', [AdminClient::class, 'update'])->name('admin.clients.update');
    Route::delete('/clients/{id}', [AdminClient::class, 'destroy'])->name('admin.clients.destroy');

    // Loans
    Route::get('/loans', [AdminLoan::class, 'index'])->name('admin.loans.index');
    Route::get('/loans/{id}', [AdminLoan::class, 'show'])->name('admin.loans.show');
    Route::patch('/loans/{id}', [AdminLoan::class, 'update'])->name('admin.loans.update');

    // Disbursement
    Route::post('/loans/{loan}/disburse', [LoanDisbursementController::class, 'disburse'])->name('admin.loans.disburse');

    // Staff Management
    Route::get('/staff', [AdminStaff::class, 'index'])->name('admin.staff.index');
    Route::get('/staff/create', [AdminStaff::class, 'create'])->name('admin.staff.create');
    Route::post('/staff', [AdminStaff::class, 'store'])->name('admin.staff.store');

    // Reports
    Route::get('/reports', [AdminReport::class, 'index'])->name('admin.reports');

    // Settings
    Route::get('/settings', [AdminSettings::class, 'index'])->name('admin.settings');
    Route::put('/settings', [AdminSettings::class, 'update'])->name('admin.settings.update');

    // Security & Audit
    Route::get('/security', [AdminSettings::class, 'security'])->name('admin.security');
    Route::get('/audit', [AdminSettings::class, 'audit'])->name('admin.audit');
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->prefix('staff')->group(function () {
    Route::get('/dashboard', [StaffDashboard::class, 'index'])->name('staff.dashboard');
    Route::get('/loans', [StaffLoan::class, 'index'])->name('staff.loans.index');
    Route::post('/loans/{id}/approve', [StaffLoan::class, 'approve'])->name('staff.loans.approve');
    Route::post('/loans/{id}/reject', [StaffLoan::class, 'reject'])->name('staff.loans.reject');
    Route::get('/reports', [StaffReport::class, 'index'])->name('staff.reports.index');
});

// Payment Webhooks (no auth - called by payment providers)
Route::post('/mpesa/stk', [MpesaController::class, 'stkPush'])->name('mpesa.stk')->middleware('auth');
Route::post('/mpesa/callback', [MpesaController::class, 'callback'])->name('mpesa.callback');
Route::post('/crypto/pay', [CryptoController::class, 'createPayment'])->name('crypto.pay')->middleware('auth');
Route::post('/crypto/webhook', [CryptoController::class, 'webhook'])->name('crypto.webhook');
