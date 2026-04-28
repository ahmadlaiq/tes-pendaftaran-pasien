<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PasienApiController;
use App\Http\Controllers\Api\PendaftaranApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Patient Management
    Route::get('/pasien', [PasienApiController::class, 'index']);
    Route::post('/pasien', [PasienApiController::class, 'store']);
    Route::get('/pasien/{id}', [PasienApiController::class, 'show']);
    Route::put('/pasien/{id}', [PasienApiController::class, 'update']);
    Route::delete('/pasien/{id}', [PasienApiController::class, 'destroy']);

    // Registration Management
    Route::get('/pendaftaran', [PendaftaranApiController::class, 'index']);
    Route::post('/pendaftaran', [PendaftaranApiController::class, 'store']);
    Route::patch('/pendaftaran/{id}/status', [PendaftaranApiController::class, 'updateStatus']);
});
