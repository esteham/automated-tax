<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Define roles
        $roles = ['admin', 'accountant', 'taxpayer', 'auditor'];

        // Create users with roles
        foreach ($roles as $role) {
            
            $user = User::create([
                'name' => ucfirst($role) . ' User',
                'email' => $role . '@example.com',
                'phone' => '017' . rand(10000000, 99999999), // Random Bangladeshi phone number
                'password' => bcrypt($role . '123'), // Password is role_name+123
                'status' => 'active',
            ]);

            // Create tax profile for each user
            if ($user->id) {
                $user->taxProfile()->create([
                    'tin_number' => str_pad(rand(1, 999999999999), 12, '0', STR_PAD_LEFT),
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
