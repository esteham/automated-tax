<?php

namespace App\Livewire;

use App\Models\Taxpayer;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class TaxpayerCreate extends Component
{
    use WithFileUploads;

    public $user_id, $tin_number, $taxpayer_type, $business_name, $business_type, $nid, $address, $bank_details, $kyc_docs = [];

    public function save()
    {
        $this->validate([
            'user_id' => 'required|exists:users,id',
            'tin_number' => 'required|string|unique:taxpayers,tin_number',
            'taxpayer_type' => 'required|in:individual,business',
            'business_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'nid' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'kyc_docs.*' => 'file|mimes:pdf,jpeg,png,jpg,webp|max:5120',
        ]);

        $taxpayer = Taxpayer::create([
            'user_id' => $this->user_id,
            'tin_number' => $this->tin_number,
            'taxpayer_type' => $this->taxpayer_type,
            'business_name' => $this->business_name,
            'business_type' => $this->business_type,
            'nid' => $this->nid,
            'address' => $this->address,
            'bank_details' => json_encode($this->bank_details),
        ]);

        foreach ($this->kyc_docs as $document) {
            $taxpayer->addMedia($document->getRealPath())->usingFileName($document->getClientOriginalName())->toMediaCollection('kyc_docs');
        }

        session()->flash('message', 'Taxpayer created successfully!');
        return redirect()->route('taxpayers.show', $taxpayer->id);

    }//end method

    public function render()
    {
        $users = User::all();
        return view('livewire.taxpayer-create', compact('users'));

    }//end method

}
