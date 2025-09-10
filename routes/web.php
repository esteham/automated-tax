<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxpayerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Accountant\DashboardController as AccountantDashboardController;
use App\Http\Controllers\Auditor\DashboardController as AuditorDashboardController;
use App\Http\Controllers\Tax\TaxController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// TIN Registration
Route::view('/tin-registration', 'tin.registration')->name('tin.registration');

// Authentication Routes
require __DIR__.'/auth.php';

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Main Dashboard - Using Livewire Component
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

    // TIN Request Routes
    Route::prefix('tin')
        ->name('tin.')
        ->group(function () {
            Route::get('/request', \App\Livewire\Tin\TinRequestForm::class)->name('request');
            Route::post('/request', [\App\Livewire\Tin\TinRequestForm::class, 'submitRequest'])->name('submit-request');
        });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tax Filing Routes
    Route::prefix('tax')->name('tax.')->group(function () {
        Route::get('/dashboard', [TaxController::class, 'dashboard'])->name('dashboard');
        
        // Tax Returns
        Route::prefix('returns')->name('returns.')->group(function () {
            Route::get('/', [TaxController::class, 'index'])->name('index');
            Route::get('/new', [TaxController::class, 'create'])->name('create');
            Route::post('/', [TaxController::class, 'store'])->name('store');
            
            Route::prefix('{taxReturn}')->group(function () {
                Route::get('/', [TaxController::class, 'show'])->name('show');
                Route::get('/edit', [TaxController::class, 'edit'])->name('edit');
                Route::put('/', [TaxController::class, 'update'])->name('update');
                Route::delete('/', [TaxController::class, 'destroy'])->name('destroy');
                
                // Submission and payment
                Route::post('/submit', [TaxController::class, 'submit'])->name('submit');
                Route::post('/pay', [TaxController::class, 'initiatePayment'])->name('pay');
                Route::get('/payment/callback', [TaxController::class, 'paymentCallback'])->name('payment.callback');
                
                // Download and print
                Route::get('/download', [TaxController::class, 'download'])->name('download');
                Route::get('/print', [TaxController::class, 'print'])->name('print');
            });
            
            // Payment verification (for admin/accountant)
            Route::post('/verify-payment', [TaxController::class, 'verifyPayment'])
                ->name('verify-payment')
                ->middleware('permission:verify-payments');
        });
    });

    // Taxpayer Management Routes
    Route::prefix('taxpayers')->group(function () {
        // KYC upload/remove
        Route::post('{taxpayer}/kyc', [DocumentController::class, 'store'])
            ->name('taxpayers.kyc.upload')
            ->middleware('permission:document.upload');

        Route::delete('{taxpayer}/kyc/{mediaId}', [DocumentController::class, 'destroy'])
            ->name('taxpayers.kyc.destroy')
            ->middleware('permission:document.delete');

        Route::view('/create', 'livewire.taxpayer-create')->name('taxpayers.create');
        Route::get('/{taxpayer}', 'App\Livewire\TaxpayerShow')->name('taxpayers.show');
    });

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        // Add more admin routes here
    });

    // Accountant Routes
    Route::middleware(['role:accountant'])->prefix('accountant')->name('accountant.')->group(function () {
        Route::get('/dashboard', [AccountantDashboardController::class, 'index'])->name('dashboard');
        // Add more accountant routes here
    });

    // Auditor Routes
    Route::middleware(['role:auditor'])->prefix('auditor')->name('auditor.')->group(function () {
        Route::get('/dashboard', [AuditorDashboardController::class, 'index'])->name('dashboard');
        // Add more auditor routes here
    });
});

// Fallback Route
Route::fallback(function () {
    return view('errors.404');
});
