<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patient Management
    Route::resource('pasien', \App\Http\Controllers\PasienController::class);

    // Registration Management
    Route::get('pendaftaran', [\App\Http\Controllers\PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('pendaftaran/export-pdf', [\App\Http\Controllers\PendaftaranController::class, 'exportPdf'])->name('pendaftaran.export-pdf');
    Route::get('pendaftaran/create', [\App\Http\Controllers\PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('pendaftaran', [\App\Http\Controllers\PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::patch('pendaftaran/{pendaftaran}/status', [\App\Http\Controllers\PendaftaranController::class, 'updateStatus'])->name('pendaftaran.update-status');
});

require __DIR__.'/auth.php';
