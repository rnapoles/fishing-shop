<?php

namespace App\Usecases\User;

use App\DTO\User\AuthenticatedUser;
use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Validator;

class UserLoginUsecase
{
    public function execute(array $input): ?AuthenticatedUser
    {

        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors);
        }

        try {

            $email = $input['email'];
            $password = $input['password'];

            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::user();
                $dto = new AuthenticatedUser();

                $dto->name = $user->name;
                $dto->token = $user->getAuthToken();
                $dto->roles = $user->getRoles();

                return $dto;
            }

        } catch (Throwable $e) {
            //todo send to custom log
        }

        return null;
    }
}
