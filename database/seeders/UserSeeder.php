<?php

namespace Database\Seeders;

use App\Models\TaxProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get the taxpayer role
        $taxpayerRole = Role::firstOrCreate(['name' => 'taxpayer']);

        // Create test user
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'username' => 'testuser',
                'phone' => '1234567890',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );

        // Assign role to user
        $user->assignRole($taxpayerRole);

        // Create tax profile if it doesn't exist
        if (!$user->taxProfile) {
            TaxProfile::create([
                'user_id' => $user->id,
                'country' => 'BD',
                'status' => 'active',
                'taxpayer_type' => 'individual',
                'tin_status' => 'not_requested',
            ]);
        }

        // Define roles
        $roles = ['admin', 'accountant', 'taxpayer', 'auditor'];

        // Create users with roles
        foreach ($roles as $role) {
            $username = $role . '_' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            
            $user = User::create([
                'name' => ucfirst($role) . ' User',
                'username' => $username,
                'email' => $role . '@example.com',
                'phone' => '017' . rand(10000000, 99999999), // Random Bangladeshi phone number
                'password' => bcrypt($role . '123'), // Password is role_name+123
                'status' => 'active',
            ]);

            // Create tax profile for each user
            if ($user->id) {
                $user->taxProfile()->create([
                    'tin_number' => $role === 'taxpayer' ? str_pad(rand(1, 999999999999), 12, '0', STR_PAD_LEFT) : null,
                    'country' => 'Bangladesh',
                    'registration_date' => now(),
                    'status' => 'active',
                    'taxpayer_type' => $role === 'company' ? 'company' : 'individual',
                ]);
            }

            // Assign role to user
            $user->assignRole($role);
        }

        $this->command->info('Users with roles have been created successfully!');
    }
}
