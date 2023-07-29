<?php

namespace Database\Seeders;

use App\Models\User;
use App\Usecases\User\UserRegisterUsecase;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(UserRegisterUsecase $usecase): void
    {

        $email = 'admin@localhost.loc';
        $input = [
            'email' => $email,
            'password' => 'p@55w0rd/*',
        ];

        // Retrieve user by name or create it if it doesn't exist...
        if (User::where('email', $email)->count() === 0) {
            $usecase->execute($input, ['ROLE_ADMIN']);
        }

    }
}
