<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxpayerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Accountant\DashboardController as AccountantDashboardController;
use App\Http\Controllers\Auditor\DashboardController as AuditorDashboardController;
use App\Http\Controllers\Tax\TaxController;
use App\Http\Controllers\TinController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public TIN Registration
Route::prefix('tin')->name('tin.')->group(function () {
    Route::view('/registration', 'tin.registration')->name('registration');
});


// File Tax Return Page
Route::get('/file-tax-return', function () {
    return view('file-tax-return');
})->name('file.tax.return');

// Temporary route to check and set security pin
Route::get('/check-security-pin', function () {
    $user = \App\Models\User::first();
    
    if (!$user) {
        return 'No users found';
    }
    
    // Check if security_pin is set
    if (empty($user->security_pin)) {
        // Set a default security pin if not set
        $user->security_pin = '1234'; // This is just for testing, in production, use a secure random pin
        $user->save();
        return 'Security pin was not set. Set to 1234 for testing.';
    }
    
    return 'Security pin is set to: ' . $user->security_pin;
});

// Authentication Routes
require __DIR__.'/auth.php';

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // TIN Routes
    Route::prefix('tin')->name('tin.')->group(function () {
        Route::get('/request', [\App\Http\Controllers\TinController::class, 'requestForm'])->name('request');
        Route::get('/dashboard', [\App\Http\Controllers\TinController::class, 'dashboard'])->name('dashboard');
        
        // TIN Request submission
        Route::post('/request', [\App\Http\Controllers\TinController::class, 'submitRequest'])->name('request.submit');
    });
    // Main Dashboard - Using Livewire Component
    Route::get('/dashboard', \App\Livewire\Dashboard::class)
        ->middleware('redirect_admin_from_user_dashboard')
        ->name('dashboard');

    // TIN Request Routes
    Route::prefix('tin-requests')
        ->name('tin-requests.')
        ->middleware('auth')
        ->group(function () {
            Route::get('/', [\App\Http\Controllers\TinRequestController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\TinRequestController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\TinRequestController::class, 'store'])->name('store');
            Route::get('/{tin_request}', [\App\Http\Controllers\TinRequestController::class, 'show'])
                ->name('show')
                ->middleware('can:view,tin_request');
            Route::post('/{tin_request}/approve', [\App\Http\Controllers\TinRequestController::class, 'approve'])
                ->name('approve')
                ->middleware('can:update,tin_request');
            Route::post('/{tin_request}/reject', [\App\Http\Controllers\TinRequestController::class, 'reject'])
                ->name('reject')
                ->middleware('can:update,tin_request');
            Route::get('/{tin_request}/download', [\App\Http\Controllers\TinRequestController::class, 'downloadPdf'])->name('download');
            Route::delete('/{tin_request}', [\App\Http\Controllers\TinRequestController::class, 'destroy'])
                ->name('destroy')
                ->middleware('can:delete,tin_request');
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
        
        // TIN Requests Management
        Route::resource('tin-requests', \App\Http\Controllers\Admin\TinRequestController::class)
            ->only(['index', 'show', 'destroy']);
            
        // TIN Request Actions
        Route::prefix('tin-requests/{tinRequest}')->name('tin-requests.')->group(function () {
            Route::post('approve', [\App\Http\Controllers\Admin\TinRequestController::class, 'approve'])
                ->name('approve');
                
            Route::post('reject', [\App\Http\Controllers\Admin\TinRequestController::class, 'reject'])
                ->name('reject');
                
            Route::get('certificate', [\App\Http\Controllers\Admin\TinRequestController::class, 'downloadCertificate'])
                ->name('certificate');
        });
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
