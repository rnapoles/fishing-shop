<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $email = 'admin@localhost.loc';

        // Retrieve user by name or create it if it doesn't exist...
        // Verificar si el usuario administrador ya existe
        if (User::where('email', $email)->count() === 0) {

            $admin = User::create([
                'name' => 'admin',
                'email' => $email,
                'password' => Hash::make('p@55w0rd/*'),
            ]);

            //find and asign role to admin
            $role = Role::where('name', 'ROLE_ADMIN')->first();
            $admin->roles()->attach($role);
        }

    }
}
