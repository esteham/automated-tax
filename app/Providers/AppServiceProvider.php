<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
        // Share pending TIN requests count with navigation view
        View::composer('layouts.navigation', 'App\Http\View\Composers\NavigationComposer');

        // Register Livewire components
        Livewire::component('tin.registration-form', \App\Livewire\Tin\RegistrationForm::class);
        Livewire::component('dashboard', \App\Livewire\Dashboard::class);
        Livewire::component('tin.request-form', \App\Livewire\Tin\TinRequestForm::class);
        Livewire::component('tin.request-tin-number', \App\Livewire\Tin\RequestTinNumber::class);
        
        // Set Livewire to use the app layout by default
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle);
        });
    }
}
