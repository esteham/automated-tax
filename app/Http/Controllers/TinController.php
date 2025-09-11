<?php

namespace App\Http\Controllers;

use App\Models\TaxProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TinController extends Controller
{
    /**
     * Show the TIN request form
     *
     * @return \Illuminate\View\View
     */
    public function requestForm()
    {
        $user = Auth::user();
        
        // Check if user already has a TIN number
        if ($user->taxProfile && $user->taxProfile->tin_number) {
            return redirect()->route('dashboard')
                ->with('message', 'You already have a TIN number: ' . $user->taxProfile->tin_number);
        }
        
        return view('tin.request', [
            'user' => $user,
        ]);
    }
    
    /**
     * Process TIN request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitRequest(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $validated = $request->validate([
            'nid_number' => 'required|string|max:50|unique:tax_profiles,nid_number',
            'nid_issuing_country' => 'required|string|max:100',
            'nid_issue_date' => 'required|date|before_or_equal:today',
            'nid_expiry_date' => 'required|date|after:nid_issue_date',
            'security_pin' => 'required|string|size:4|regex:/^\d+$/',
        ]);

        try {
            // Generate a new TIN number (example format: TIN-BD-XXXX-XXXX-XXXX)
            $tinNumber = 'TIN-BD-' . strtoupper(Str::random(4)) . '-' . 
                         strtoupper(Str::random(4)) . '-' . 
                         strtoupper(Str::random(4));

            // Create or update tax profile
            $taxProfile = TaxProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nid_number' => $validated['nid_number'],
                    'nid_issuing_country' => $validated['nid_issuing_country'],
                    'nid_issue_date' => $validated['nid_issue_date'],
                    'nid_expiry_date' => $validated['nid_expiry_date'],
                    'tin_number' => $tinNumber,
                    'tin_status' => 'active',
                    'tin_requested_at' => now(),
                    'tin_approved_at' => now(),
                    'status' => 'active',
                ]
            );

            // Log the TIN assignment
            $taxProfile->logActivity(
                'TIN number ' . $tinNumber . ' was assigned',
                'tin',
                ['tin_number' => $tinNumber]
            );

            return redirect()->route('tin.dashboard')
                ->with('success', 'Your TIN request has been submitted successfully. Your TIN number is: ' . $tinNumber);
                
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error submitting TIN request: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'An error occurred while processing your request. Please try again.');
        }
    }
    
    /**
     * Display the TIN information dashboard
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // If user doesn't have a tax profile or TIN, redirect to request form
        if (!$user->taxProfile || !$user->taxProfile->tin_number) {
            return redirect()->route('tin.request')
                ->with('info', 'You need to request a TIN number first.');
        }
        
        // Load the tax profile with activities
        $taxProfile = $user->taxProfile()->with(['activities' => function($query) {
            $query->latest()->take(5);
        }])->first();
        
        return view('tin.dashboard', [
            'user' => $user,
            'taxProfile' => $taxProfile,
        ]);
    }
}
