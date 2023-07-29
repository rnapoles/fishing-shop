<?php

use App\Http\Controllers\API\User\LoginController;
use App\Http\Controllers\API\User\RegisterController;
use App\Http\Controllers\API\Product\ListProductsController;
use App\Http\Controllers\API\Product\CreateProductController;
use App\Http\Controllers\API\Sale\CreateSaleController;
use App\Http\Controllers\API\Sale\GenerateSaleReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);
Route::get('product/list', [ListProductsController::class, 'index']);

Route::middleware('auth:api')->group( function () {
  Route::post('sale/create', [CreateSaleController::class, 'create']);
});

Route::middleware(['auth:api','can:is_admin'])->group( function () {
  Route::post('product/create', [CreateProductController::class, 'create']);
  Route::get('sale/report', [GenerateSaleReportController::class, 'create']);
});