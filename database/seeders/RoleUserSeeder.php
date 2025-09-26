<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = ['Admin', 'CRM Agent', 'Doctor', 'Patient', 'Lab Manager'];
    
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Sample user for each role
        foreach ($roles as $role) {
            $user = User::create([
                'name' => $role . ' User',
                'email' => strtolower(str_replace(' ', '', $role)) . '@test.com',
                'password' => bcrypt('password')
            ]);
            $user->assignRole($role);
        }
    }
    
}
