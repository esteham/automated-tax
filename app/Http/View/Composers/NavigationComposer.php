<?php

namespace App\Http\View\Composers;

use App\Models\TinRequest;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NavigationComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $pendingTinRequestsCount = 0;
        
        if (Auth::check()) {
            $user = Auth::user();
            
            // Only calculate for admin and auditor roles
            if ($user->hasRole(['admin', 'auditor'])) {
                $pendingTinRequestsCount = TinRequest::where('status', 'pending')->count();
            }
        }
        
        $view->with('pendingTinRequestsCount', $pendingTinRequestsCount);
    }
}
