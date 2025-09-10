<?php

namespace App\Livewire\Tin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegistrationForm extends Component
{
    public $username;
    public $security_pin;
    public $security_pin_confirmation;
    public $email;
    public $country = 'Bangladesh';
    public $phone;
    public $password;
    public $password_confirmation;
    public $terms = false;

    protected $rules = [
        'username' => 'required|string|max:255|unique:users',
        'security_pin' => 'required|string|size:4|confirmed|regex:/^\d+$/|digits:4',
        'email' => 'required|string|email|max:255|unique:users',
        'country' => 'required|string|max:100',
        'phone' => 'required|string|max:20|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'terms' => 'accepted',
    ];
    
    protected $validationAttributes = [
        'security_pin' => 'security PIN',
    ];
    
    protected $messages = [
        'security_pin.size' => 'The security PIN must be exactly 4 digits.',
        'security_pin.digits' => 'The security PIN must contain only numbers.',
        'security_pin.confirmed' => 'The security PIN confirmation does not match.',
        'terms.accepted' => 'You must accept the terms and conditions.',
        'password.confirmed' => 'The password confirmation does not match.',
    ];

    public function render()
    {
        return view('livewire.tin.registration-form');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $this->validate();

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create the user
            $user = User::create([
                'name' => $this->username, // Using username as name for simplicity
                'username' => $this->username,
                'email' => $this->email,
                'phone' => $this->phone,
                'country' => $this->country,
                'security_pin' => $this->security_pin,
                'password' => Hash::make($this->password),
                'status' => 'active',
            ]);

            // Create tax profile
            $user->taxProfile()->create([
                'country' => $this->country,
                'status' => 'active',
                'taxpayer_type' => 'individual',
                'tin_status' => 'not_requested',
            ]);

            // Assign default role
            $user->assignRole('taxpayer');

            // Commit the transaction
            DB::commit();

            // Redirect to login with success message
            return redirect()->route('login')->with('status', 'Registration successful! Please login to continue.');

        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            $this->addError('registration', 'An error occurred during registration. Please try again.');
            \Log::error('Registration error: ' . $e->getMessage());
        }
    }
}
