<?php

namespace App\Livewire\Tin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegistrationForm extends Component
{
    public $username;
    public $tin_number;
    public $email;
    public $country = 'Bangladesh';
    public $phone;
    public $password;
    public $password_confirmation;

    protected function rules()
    {
        return [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'tin_number' => ['required', 'string', 'max:20', 'unique:users,tin_number'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'country' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    public function render()
    {
        return view('livewire.tin.registration-form');
    }

    public function register()
    {
        $validated = $this->validate();

        $user = User::create([
            'username' => $this->username,
            'tin_number' => $this->tin_number,
            'email' => $this->email,
            'country' => $this->country,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        // Assign default role (you may want to adjust this based on your requirements)
        $user->assignRole('taxpayer');

        // Log in the user
        auth()->login($user);

        // Redirect to dashboard or home page
        return redirect()->route('dashboard');
    }
}
