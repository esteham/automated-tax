<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $roles = ['admin','accountant','taxpayer','auditor'];
        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r]);
        }

        $perms = [
            'user.manage', 'taxrule.manage', 'filing.create', 'filing.view',
            'filing.approve', 'filing.reject', 'payment.record','report.view'
        ];
        foreach ($perms as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        Role::findByName('admin')->givePermissionTo(Permission::all());
        Role::findByName('accountant')->givePermissionTo([
            'filing.view','filing.approve','payment.record','report.view'
        ]);
        Role::findByName('taxpayer')->givePermissionTo([
            'filing.create','filing.view'
        ]);
        Role::findByName('auditor')->givePermissionTo([
            'filing.view','report.view'
        ]);

    }

}
