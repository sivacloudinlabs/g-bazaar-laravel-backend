<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminInsertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            'name' => 'Super Admin',
            'email' => 'admin@protal.com',
            'number' => 9585811800,
            'password' => Hash::make('admin@welcome'),
        ]);
        
        $user->assignRole([SUPER_ADMIN_ROLE]);
    }
}
