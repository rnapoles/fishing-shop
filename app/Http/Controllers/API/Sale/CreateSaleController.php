<?php

namespace App\Http\Controllers\API\Sale;

use App\Exceptions\ValidationException;
use App\Http\Controllers\API\BaseController;
use App\Usecases\Sale\CreateSaleUsecase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CreateSaleController extends BaseController
{
    /**
     * Create sale api
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, CreateSaleUsecase $usecase)
    {

        $input = $request->all();

        try {

            $input['client_id'] = Auth::id();

            $dtos = $usecase->execute($input);

            return $this->sendResponse($dtos, '', JsonResponse::HTTP_CREATED);

        } catch (\Throwable $ex) {

            $errors = [];
            if ($ex instanceof ValidationException) {
                $errors = $ex->errors;
            }

            return $this->sendError($ex->getMessage(), $errors);
        }

    }
}
