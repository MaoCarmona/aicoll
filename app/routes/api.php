<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/companies')->group(function () {
    Route::post('/', [CompanyController::class, 'store']);
    Route::get('/{nit}', [CompanyController::class, 'show']);
    Route::get('/', [CompanyController::class, 'index']);
    Route::put('/{nit}', [CompanyController::class, 'update']);
    Route::delete('/{nit}', [CompanyController::class, 'destroy']);
});
