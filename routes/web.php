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
    // Dashboard - USE THE CONTROLLER VERSION (CORRECT ONE)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/credit-user/{userId}', [AdminController::class, 'creditUser'])->name('admin.creditUser');
    
    // Bank Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    
    // Transfer Routes
    Route::prefix('transfer')->group(function () {
        Route::get('/', [TransferController::class, 'create'])->name('transfer.create');
        Route::post('/', [TransferController::class, 'store'])->name('transfer.store');
        Route::get('/success/{transaction}', [TransferController::class, 'success'])->name('transfer.success');
        Route::get('/pending/{transaction}', [TransferController::class, 'pending'])->name('transfer.pending');
        Route::post('/verify-token/{transaction}', [TransferController::class, 'verifyToken'])->name('transfer.verify-token');
        Route::post('/resend-token/{transaction}', [TransferController::class, 'resendToken'])->name('transfer.resend-token');
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
});