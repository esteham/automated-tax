<?php

namespace App\Providers;

use App\Models\TaxReturn;
use App\Policies\TaxReturnPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        TaxReturn::class => TaxReturnPolicy::class,
        \App\Models\TinRequest::class => \App\Policies\TinRequestPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define tax return related permissions
        Gate::define('view_any_tax_return', function ($user) {
            return $user->hasRole(['admin', 'accountant', 'auditor']) || 
                   $user->can('view_any_tax_return');
        });

        Gate::define('view_tax_return', function ($user, $taxReturn) {
            if ($user->hasRole(['admin', 'accountant', 'auditor'])) {
                return true;
            }
            
            return $user->id === $taxReturn->taxpayer->user_id;
        });

        Gate::define('create_tax_return', function ($user) {
            return $user->hasRole('taxpayer') || 
                   $user->hasRole('admin') || 
                   $user->can('create_tax_return');
        });

        Gate::define('update_tax_return', function ($user, $taxReturn) {
            if ($user->hasRole('admin') || $user->hasRole('accountant')) {
                return true;
            }
            
            return $user->id === $taxReturn->taxpayer->user_id && 
                   $taxReturn->status === 'draft';
        });

        Gate::define('delete_tax_return', function ($user, $taxReturn) {
            if ($user->hasRole('admin')) {
                return true;
            }
            
            return $user->id === $taxReturn->taxpayer->user_id && 
                   $taxReturn->status === 'draft';
        });
    }
}
