<?php

namespace App\Livewire;

use App\Models\Taxpayer;
use Livewire\Component;

class TaxpayerShow extends Component
{
    public $taxpayer;

    public function mount($id)
    {
        $this->taxpayer = Taxpayer::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.taxpayer-show');
    }
}
