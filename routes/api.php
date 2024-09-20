<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('companies', CompanyController::class)->only([
       'index', 'store', 'show', 'update', 'destroy'
    ]);

    Route::resource('employees', EmployeeController::class)->only([
        'index', 'store', 'show', 'update', 'destroy'
    ]);
});
