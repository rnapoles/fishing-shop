<?php

namespace App\Http\Controllers\API\User;

use App\Exceptions\ValidationException;
use App\Http\Controllers\API\BaseController;
use App\Usecases\User\UserRegisterUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, UserRegisterUsecase $usecase)
    {

        try {

            $input = $request->all();
            $dto = $usecase->execute($input);

            return $this->sendResponse($dto, 'User registered successfully.', JsonResponse::HTTP_CREATED);

        } catch (\Throwable $ex) {

            $errors = [];
            if ($ex instanceof ValidationException) {
                $errors = $ex->errors;
            }

            return $this->sendError($ex->getMessage(), $errors);
        }

    }
}
