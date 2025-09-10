<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Livewire components
        Livewire::component('tin.registration-form', \App\Livewire\Tin\RegistrationForm::class);
        Livewire::component('dashboard', \App\Livewire\Dashboard::class);
        Livewire::component('tin.request-form', \App\Livewire\Tin\TinRequestForm::class);
        
        // Set Livewire to use the app layout by default
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle);
        });
    }
}
