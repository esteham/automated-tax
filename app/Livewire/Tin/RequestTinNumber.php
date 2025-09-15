<?php

namespace App\Livewire\Tin;

use Livewire\Component;
use App\Models\TaxProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RequestTinNumber extends Component
{
    public $nid_number;
    public $nid_issuing_country = 'Bangladesh';
    public $nid_issue_date;
    public $nid_expiry_date;
    public $security_pin;

    protected $rules = [
        'nid_number' => 'required|string|max:50|unique:tax_profiles,nid_number',
        'nid_issuing_country' => 'required|string|max:100',
        'nid_issue_date' => 'required|date|before_or_equal:today',
        'nid_expiry_date' => 'required|date|after:nid_issue_date',
        'security_pin' => 'required|string|size:4|regex:/^\d+$/',
    ];

    protected $validationAttributes = [
        'nid_number' => 'NID number',
        'nid_issuing_country' => 'issuing country',
        'nid_issue_date' => 'issue date',
        'nid_expiry_date' => 'expiry date',
        'security_pin' => 'security PIN',
    ];

    public function mount()
    {
        $user = auth()->user();
        
        if (!$user) {
            return;
        }

        // Load user's existing tax profile if available
        $taxProfile = $user->taxProfile;
        if ($taxProfile) {
            $this->nid_number = $taxProfile->nid_number;
            $this->nid_issuing_country = $taxProfile->nid_issuing_country ?? 'Bangladesh';
            $this->nid_issue_date = $taxProfile->nid_issue_date?->format('Y-m-d');
            $this->nid_expiry_date = $taxProfile->nid_expiry_date?->format('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.tin.request-tin-number');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submitRequest()
    {
        $this->validate();
        
        // Get the authenticated user
        $user = auth()->user();
        
        // Verify user is authenticated - this should never happen as the route is protected
        if (!$user) {
            $this->addError('form_error', 'You must be logged in to submit a TIN request.');
            return;
        }
        
        // Reload the user with their security pin
        $user = \App\Models\User::find($user->id);
        
        // Check if security pin is set
        if (empty($user->security_pin)) {
            $this->addError('security_pin', 'No security PIN found. Please contact support.');
            return;
        }
        
        // Verify security pin
        if ($user->security_pin !== $this->security_pin) {
            $this->addError('security_pin', 'The security PIN is incorrect.');
            return;
        }

        try {
            DB::beginTransaction();

            // Update tax profile with NID information
            $taxProfile = Auth::user()->taxProfile;
            
            if (!$taxProfile) {
                $taxProfile = new TaxProfile();
                $taxProfile->user_id = Auth::id();
                $taxProfile->registration_date = now();
                $taxProfile->status = 'active';
            }

            $taxProfile->nid_number = $this->nid_number;
            $taxProfile->nid_issuing_country = $this->nid_issuing_country;
            $taxProfile->nid_issue_date = $this->nid_issue_date;
            $taxProfile->nid_expiry_date = $this->nid_expiry_date;
            $taxProfile->tin_status = 'pending';
            
            $taxProfile->save();

            DB::commit();

            session()->flash('message', 'Your TIN number request has been submitted successfully. You will be notified once it is approved.');
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('form_error', 'An error occurred while processing your request. Please try again.');
            \Log::error('TIN Request Error: ' . $e->getMessage());
        }
    }
}
