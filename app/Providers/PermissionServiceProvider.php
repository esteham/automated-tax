<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionRegistrar;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register blade directives
        $this->registerBladeExtensions();
    }

    /**
     * Register Blade extensions.
     */
    protected function registerBladeExtensions(): void
    {
        // Role directive
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });

        // Permission directive
        Blade::if('can', function ($permission) {
            return auth()->check() && auth()->user()->can($permission);
        });

        // Has any role directive
        Blade::if('hasanyrole', function ($roles) {
            return auth()->check() && auth()->user()->hasAnyRole($roles);
        });

        // Has all roles directive
        Blade::if('hasallroles', function ($roles) {
            return auth()->check() && auth()->user()->hasAllRoles($roles);
        });
    }
}
