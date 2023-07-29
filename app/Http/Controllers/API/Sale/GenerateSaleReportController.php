<?php

namespace App\Http\Controllers\API\Sale;

use App\Exceptions\ValidationException;
use App\Http\Controllers\API\BaseController;
use App\Usecases\Sale\GenerateSaleReportUsecase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GenerateSaleReportController extends BaseController
{
    /**
     * Create sale report api
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, GenerateSaleReportUsecase $usecase)
    {

        try {

            $html = $usecase->execute();

            $pdf = PDF::loadHTML($html);
            $pdf->loadHTML($html);

            return $pdf->stream();

        } catch (\Throwable $ex) {
            return $this->sendError($ex->getMessage(), []);
        }

    }
}
