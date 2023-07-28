<?php

namespace App\Http\Controllers\API;

use App\DTO\ResponseObject;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * success response method.
     */
    public function sendResponse(mixed $payload, string $message = ''): JsonResponse
    {

        $responseObj = new ResponseObject();
        $responseObj->message = $message;
        $responseObj->payload = $payload;

        return response()->json($responseObj, JsonResponse::HTTP_OK);
    }

    /**
     * return error response.
     */
    public function sendError(string $message, array $errors = [], int $code = JsonResponse::HTTP_BAD_REQUEST): JsonResponse
    {

        $responseObj = new ResponseObject();
        $responseObj->success = false;
        $responseObj->message = $message;
        $responseObj->errors = $errors;

        return response()->json($responseObj, $code);
    }
}
