<?php

namespace App\Usecases\User;

use App\DTO\User\AuthenticatedUser;
use App\Exceptions\ValidationException;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Validator;

class UserRegisterUsecase
{
    public function execute(array $input, array $roles = ['ROLE_CLIENT']): AuthenticatedUser
    {

        $validator = Validator::make($input, [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            //'repeated_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors);
        }

        $dto = new AuthenticatedUser();

        try {
            DB::beginTransaction();

            $input['name'] = explode('@', $input['email'])[0];
            $input['password'] = Hash::make($input['password']);

            $user = User::create($input);

            //find and asign roles to admin
            foreach ($roles as $role) {
                $role = Role::where('name', $role)->first();
                if ($role) {
                    $user->roles()->attach($role);
                }
            }

            $dto->username = $user->name;
            $dto->token = $user->getAuthToken();
            $dto->roles = $user->getRoles();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();

            throw $e;
        }

        return $dto;
    }
}
