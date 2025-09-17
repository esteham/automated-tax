<?php

namespace App\Livewire\Tin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\TaxProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TinRequestForm extends Component
{
    use WithFileUploads;

    public $nid;
    public $nid_front_image;
    public $nid_back_image;
    public $submitted = false;

    protected $rules = [
        'nid' => 'required|string|max:20',
        'nid_front_image' => 'required|image|max:2048', // 2MB max
        'nid_back_image' => 'required|image|max:2048',  // 2MB max
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->taxProfile = $this->user->taxProfile;
    }

    public function submitRequest()
    {
        $this->validate();

        // Store the uploaded files
        $frontImagePath = $this->nid_front_image->store('nid-images', 'public');
        $backImagePath = $this->nid_back_image->store('nid-images', 'public');

        // Update the tax profile with the NID information
        $this->taxProfile->update([
            'nid' => $this->nid,
            'nid_front_image' => $frontImagePath,
            'nid_back_image' => $backImagePath,
            'tin_status' => 'pending',
            'tin_requested_at' => now(),
        ]);

        $this->submitted = true;
        
        // Redirect back to dashboard with success message
        return redirect()->route('dashboard')
            ->with('status', 'TIN request submitted successfully! It is now under review.');
    }

    public function render()
    {
        return view('livewire.tin.request-form', [
            'taxProfile' => $this->taxProfile,
        ]);
    }
}
