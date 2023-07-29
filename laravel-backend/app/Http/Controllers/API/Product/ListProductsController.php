<?php

namespace App\Http\Controllers\API\Product;

use App\Exceptions\ValidationException;
use App\Http\Controllers\API\BaseController;
use App\Usecases\Product\ListProductsUsecase;
use Illuminate\Http\Request;

class ListProductsController extends BaseController
{
    /**
     * List products in stock
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ListProductsUsecase $usecase)
    {

        try {

            //$input = $request->all();
            $dtos = $usecase->execute();

            return $this->sendResponse($dtos);

        } catch (\Throwable $ex) {

            $errors = [];
            if ($ex instanceof ValidationException) {
                $errors = $ex->errors;
            }

            return $this->sendError($ex->getMessage(), $errors);
        }

    }
}
