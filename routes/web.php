<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaxpayerController;
use App\Http\Controllers\DocumentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth'])->group(function () {
    Route::resource('taxpayers', TaxpayerController::class);

    // KYC upload/remove
    Route::post('taxpayers/{taxpayer}/kyc', [DocumentController::class, 'store'])
        ->name('taxpayers.kyc.upload')
        ->middleware('permission:document.upload');

    Route::delete('taxpayers/{taxpayer}/kyc/{mediaId}', [DocumentController::class, 'destroy'])
        ->name('taxpayers.kyc.destroy')
        ->middleware('permission:document.delete');
});

require __DIR__.'/auth.php';
