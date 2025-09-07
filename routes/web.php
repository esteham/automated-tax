<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxpayerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Accountant\DashboardController as AccountantDashboardController;
use App\Http\Controllers\Auditor\DashboardController as AuditorDashboardController;
use App\Livewire\TaxpayerCreate;
use App\Livewire\TaxpayerShow;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Main Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Taxpayer Routes
    Route::prefix('taxpayers')->group(function () {
        // KYC upload/remove
        Route::post('{taxpayer}/kyc', [DocumentController::class, 'store'])
            ->name('taxpayers.kyc.upload')
            ->middleware('permission:document.upload');

        Route::delete('{taxpayer}/kyc/{mediaId}', [DocumentController::class, 'destroy'])
            ->name('taxpayers.kyc.destroy')
            ->middleware('permission:document.delete');

        Route::get('/create', TaxpayerCreate::class)->name('taxpayers.create');
        Route::get('/{taxpayer}', TaxpayerShow::class)->name('taxpayers.show');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        // Add more admin routes here
    });

    // Accountant Routes
    Route::prefix('accountant')->name('accountant.')->middleware(['role:accountant'])->group(function () {
        Route::get('/dashboard', [AccountantDashboardController::class, 'index'])->name('dashboard');
        // Add more accountant routes here
    });

    // Auditor Routes
    Route::prefix('auditor')->name('auditor.')->middleware(['role:auditor'])->group(function () {
        Route::get('/dashboard', [AuditorDashboardController::class, 'index'])->name('dashboard');
        // Add more auditor routes here
    });
});

// Test Route for Blade Directives
Route::get('/test-blade', function () {
    return view('test-blade');
})->middleware('auth');

// Authentication Routes
require __DIR__.'/auth.php';
