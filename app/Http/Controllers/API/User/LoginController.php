<?php

namespace App\Http\Controllers\API\User;

use App\Exceptions\ValidationException;
use App\Http\Controllers\API\BaseController;
use App\Usecases\User\UserLoginUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request, UserLoginUsecase $usecase)
    {

        $code = JsonResponse::HTTP_UNAUTHORIZED;

        try {

            $input = $request->all();
            $dto = $usecase->execute($input);

            if ($dto) {
                return $this->sendResponse($dto, 'User login successfully.');
            } else {
                $error = JsonResponse::$statusTexts[$code];

                return $this->sendError($error, [], $code);
            }

        } catch (\Throwable $ex) {

            $errors = [];
            if ($ex instanceof ValidationException) {
                $errors = $ex->errors;
            }

            return $this->sendError($ex->getMessage(), $errors, $code);
        }

    }
}
