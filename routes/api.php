<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AuthenticatedUserController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\TokenAuthenticationController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\ContractController;
use App\Http\Controllers\API\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', AuthenticatedUserController::class);

Route::middleware(['guest'])->post('/login', [TokenAuthenticationController::class, 'store']);
Route::middleware(['auth:sanctum'])->post('/logout', [TokenAuthenticationController::class, 'destroy']);

Route::get('/quote', QuoteController::class);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('contracts', ContractController::class);
});
