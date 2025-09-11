<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();
        
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($user->hasRole('accountant')) {
            return redirect()->route('accountant.dashboard');
        }
        
        if ($user->hasRole('auditor')) {
            return redirect()->route('auditor.dashboard');
        }
        
        // Redirect to TIN dashboard if user has a TIN, otherwise to TIN request form
        if ($user->taxProfile?->tin_number) {
            return redirect()->route('tin.dashboard');
        }
        
        return redirect()->route('tin.request');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
