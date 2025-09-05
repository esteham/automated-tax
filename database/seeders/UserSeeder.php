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
                'password' => bcrypt($role . '123'), // Password is role_name+123
            ]);

            // Assign role to user
            $user->assignRole($role);
        }

        $this->command->info('Users with roles have been created successfully!');
        
    }

}
