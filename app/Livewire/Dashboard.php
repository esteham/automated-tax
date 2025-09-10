<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\TaxProfile;
use App\Models\User;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    use WithPagination;
    
    public $user;
    public $taxProfile;
    
    public function mount()
    {
        $this->user = Auth::user();
        
        // Eager load the tax profile relationship
        $this->user->load('taxProfile');
        
        // If no tax profile exists, create a default one
        if (!$this->user->taxProfile) {
            $this->taxProfile = TaxProfile::create([
                'user_id' => $this->user->id,
                'country' => 'BD',
                'status' => 'inactive',
                'taxpayer_type' => 'individual',
                'tin_status' => 'not_requested'
            ]);
        } else {
            $this->taxProfile = $this->user->taxProfile;
        }
        
        // Make tax profile available to the layout
        $this->layoutData = ['taxProfile' => $this->taxProfile];
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'user' => $this->user,
            'taxProfile' => $this->taxProfile
        ])->layout('components.layouts.app', [
            'taxProfile' => $this->taxProfile
        ]);
    }

    public function getTinStatusBadgeClass($status)
    {
        return match($status) {
            'approved' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getTinStatusLabel($status)
    {
        return match($status) {
            'approved' => 'Approved',
            'pending' => 'Pending Approval',
            'rejected' => 'Rejected',
            default => 'Not Requested',
        };
    }
}
