<?php

namespace App\Livewire\Tin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class NewRegistrationForm extends Component
{
    public $username;
    public $tin_number;
    public $email;
    public $country = 'Bangladesh';
    public $phone;
    public $password;
    public $password_confirmation;
    public $terms = false;

    protected $rules = [
        'username' => 'required|string|max:255|unique:users',
        'tin_number' => 'required|string|size:12|unique:tax_profiles|regex:/^\d+$/|digits:12',
        'email' => 'required|string|email|max:255|unique:users',
        'country' => 'required|string|max:100',
        'phone' => 'required|string|max:20|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'terms' => 'accepted',
    ];
    
    protected $validationAttributes = [
        'tin_number' => 'TIN number',
    ];
    
    protected $messages = [
        'tin_number.size' => 'The TIN number must be exactly 12 digits.',
        'tin_number.digits' => 'The TIN number must contain only numbers.',
        'terms.accepted' => 'You must accept the terms and conditions.',
        'password.confirmed' => 'The password confirmation does not match.',
    ];

    public function render()
    {
        return view('livewire.tin.new-registration-form');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $validatedData = $this->validate();

        try {
            // Start database transaction
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $this->username,
                'username' => $this->username,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => Hash::make($this->password),
                'status' => 'active',
            ]);

            // Create tax profile
            $user->taxProfile()->create([
                'tin_number' => $this->tin_number,
                'country' => $this->country,
                'registration_date' => now(),
                'status' => 'active',
            ]);

            // Assign default role
            $user->assignRole('taxpayer');

            // Commit transaction
            DB::commit();

            // Redirect to login page with success message
            return redirect()->route('login')
                ->with('status', 'Registration successful! Please log in with your credentials.');

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            $this->addError('registration_error', 'An error occurred during registration. Please try again.');
            \Log::error('Registration Error: ' . $e->getMessage());
        }
    }
    }
