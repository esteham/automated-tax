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
        
        // Verify security PIN
        if ($user->security_pin !== $request->security_pin) {
            return back()->withErrors([
                'security_pin' => 'The security PIN is incorrect.',
            ])->withInput();
        }
        
        try {
            // Update or create tax profile
            $taxProfile = $user->taxProfile ?? new TaxProfile();
            $taxProfile->user_id = $user->id;
            $taxProfile->nid_number = $validated['nid_number'];
            $taxProfile->nid_issuing_country = $validated['nid_issuing_country'];
            $taxProfile->nid_issue_date = $validated['nid_issue_date'];
            $taxProfile->nid_expiry_date = $validated['nid_expiry_date'];
            $taxProfile->tin_status = 'pending';
            
            // Set registration date if this is a new tax profile
            if (!$taxProfile->exists) {
                $taxProfile->registration_date = now();
                $taxProfile->status = 'active';
            }
            
            $taxProfile->save();
            
            return redirect()->route('dashboard')
                ->with('message', 'Your TIN request has been submitted successfully. You will be notified once it is approved.');
                
        } catch (\Exception $e) {
            \Log::error('TIN Request Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while processing your request. Please try again.');
        }
    }
}
