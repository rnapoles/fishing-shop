<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Retrieve role by name or create it if it doesn't exist...
        $role = Role::firstOrCreate([
            'name' => 'ROLE_ADMIN',
        ]);

        // Retrieve role by name or create it if it doesn't exist...
        $role = Role::firstOrCreate([
            'name' => 'ROLE_CLIENT',
        ]);

    }
}
