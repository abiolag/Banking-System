<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public Routes (accessible without login)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Google OAuth Routes
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

// Password Reset Routes
Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Manual Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Bank Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    
    // Transfer Routes
    Route::prefix('transfer')->group(function () {
        Route::get('/', [TransferController::class, 'create'])->name('transfer.create');
        Route::post('/', [TransferController::class, 'store'])->name('transfer.store');
        Route::get('/success/{transaction}', [TransferController::class, 'success'])->name('transfer.success');
        Route::get('/pending/{transaction}', [TransferController::class, 'pending'])->name('transfer.pending');
        Route::post('/validate-account', [TransferController::class, 'validateAccount'])->name('transfer.validate');
        Route::post('/exchange-rate', [TransferController::class, 'getExchangeRate'])->name('transfer.exchange-rate');
    });
    
    // Transaction Routes
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/transactions/filter', [TransactionController::class, 'filter'])->name('transactions.filter');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // TEMPORARY: Admin Routes without admin middleware
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/pending-transfers', [AdminController::class, 'pendingTransfers'])->name('admin.pending.transfers');
        Route::post('/credit-user/{userId}', [AdminController::class, 'creditUser'])->name('admin.creditUser');
        Route::post('/transfers/{transaction}/approve', [AdminController::class, 'approveTransfer'])->name('admin.transfers.approve');
        Route::post('/transfers/{transaction}/reject', [AdminController::class, 'rejectTransfer'])->name('admin.transfers.reject');
    });
});

// Debug route (remove in production)
Route::get('/debug-google', function() {
    return [
        'client_id' => config('services.google.client_id'),
        'client_secret' => !empty(config('services.google.client_secret')),
        'redirect' => config('services.google.redirect'),
        'env_client_id' => env('GOOGLE_CLIENT_ID')
    ];
});