<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ROLES;

        foreach ($data as $value) {
            Role::firstOrCreate([
                'name' => $value,
                'guard_name' => 'api',
            ]);
        }
    }
}
