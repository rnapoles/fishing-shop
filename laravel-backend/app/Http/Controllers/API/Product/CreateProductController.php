<?php

namespace App\Http\Controllers\API\Product;

use App\Exceptions\ValidationException;
use App\Http\Controllers\API\BaseController;
use App\Usecases\Product\CreateProductUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateProductController extends BaseController
{
    /**
     * Create product api
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, CreateProductUsecase $usecase)
    {

        try {

            $input = $request->all();
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
