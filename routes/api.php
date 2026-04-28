<?php

use App\Http\Controllers\Api\PasienApiController;
use App\Http\Controllers\Api\PendaftaranApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Email atau password salah'
        ], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'status' => 'success',
        'message' => 'Login berhasil',
        'data' => [
            'token' => $token,
            'user' => $user
        ]
    ]);
});

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
