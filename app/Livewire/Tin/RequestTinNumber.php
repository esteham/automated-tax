<?php

namespace App\Livewire\Tin;

use Livewire\Component;
use App\Models\TaxProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RequestTinNumber extends Component
{
    // In RequestTinNumber.php, update the properties and rules to match the form fields
    public $nid_number;  // Changed from $nid to match the form field
    public $nid_issuing_country = 'Bangladesh';
    public $nid_issue_date;
    public $nid_expiry_date;
    public $security_pin;

    protected $rules = [
        'nid_number' => 'required|string|max:50|unique:tax_profiles,nid',  // Updated to match the form field
        'nid_issuing_country' => 'required|string|max:100',
        'nid_issue_date' => 'required|date|before_or_equal:today',
        'nid_expiry_date' => 'required|date|after:nid_issue_date',
        'security_pin' => 'required|string|size:4|regex:/^\d+$/',
    ];

    protected $validationAttributes = [
        'nid_number' => 'NID Number',  // Updated to match
        'nid_issuing_country' => 'issuing country',
        'nid_issue_date' => 'issue date',
        'nid_expiry_date' => 'expiry date',
        'security_pin' => 'security PIN',
    ];

    // Update the mount method
    public function mount()
    {
        $user = auth()->user();
        
        if (!$user) {
            return;
        }

        // Load user's existing tax profile if available
        $taxProfile = $user->taxProfile;
        if ($taxProfile) {
            $this->nid_number = $taxProfile->nid;  // Updated to match the new property name
            $this->nid_issuing_country = $taxProfile->nid_issuing_country ?? 'Bangladesh';
            $this->nid_issue_date = $taxProfile->nid_issue_date?->format('Y-m-d');
            $this->nid_expiry_date = $taxProfile->nid_expiry_date?->format('Y-m-d');
        }
    }

    // Add this method to help with debugging
    public function updated($propertyName)
    {
        \Log::info("Property updated: {$propertyName}", [
            'value' => $this->{$propertyName}
        ]);
        $this->validateOnly($propertyName);
    }

    public function submitRequest()
    {
        try {
            \Log::info('Form submission started', $this->all());
            $validatedData = $this->validate();
            
            $user = auth()->user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            DB::beginTransaction();

            // Update or create tax profile
            $taxProfile = $user->taxProfile ?: new TaxProfile();
            $taxProfile->user_id = $user->id;
            $taxProfile->nid = $this->nid_number;  // Updated to match the new property name
            $taxProfile->nid_issuing_country = $this->nid_issuing_country;
            $taxProfile->nid_issue_date = $this->nid_issue_date;
            $taxProfile->nid_expiry_date = $this->nid_expiry_date;
            $taxProfile->tin_status = 'pending';
            
            if (!$taxProfile->save()) {
                throw new \Exception('Failed to save tax profile');
            }

            DB::commit();
            
            session()->flash('message', 'Your TIN request has been submitted successfully!');
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('TIN Request Error: ' . $e->getMessage());
            $this->addError('form_error', 'An error occurred while processing your request: ' . $e->getMessage());
        }
    }
}