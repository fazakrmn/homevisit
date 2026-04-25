<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PendaftaranController;

Route::get('/', [UserController::class, 'index'])->name('index');

Route::get('/dashboard', [UserController::class, 'Dashboard'])->middleware(['auth', 'verified', 'admin'])->name('dashboard');

Route::get('/home', [UserController::class, 'welcome'])->name('welcome');

    Route::get('/midtrans/finish', [PaymentController::class, 'callback'])->name('midtrans.finish');
    Route::post('/midtrans/callback', [PaymentController::class, 'notification'])->name('midtrans.callback');
    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
    // Step 1 - Input Data
    Route::get('/step1', [PendaftaranController::class, 'step1'])->name('step1');
    Route::post('/step1', [PendaftaranController::class, 'storeStep1'])->name('step1.store');

    // Step 2 - Pilih dokter
    Route::get('/step2/{id}', [PendaftaranController::class, 'step2'])->name('step2');
    Route::post('/step2/{id}', [PendaftaranController::class, 'storeStep2'])->name('step2.store');

    // Step 3 - Pembayaran
    Route::get('/step3/{id}', [PendaftaranController::class, 'step3'])->name('step3');
    Route::post('/step3/{id}', [PendaftaranController::class, 'storeStep3'])->name('step3.store');

    // Step 4 - Dokumen
    Route::get('/step4/{id}', [PendaftaranController::class, 'step4'])->name('step4');
    Route::post('/step4/{id}', [PendaftaranController::class, 'storeStep4'])->name('step4.store');

    // Sukses
    Route::get('/sukses/{id}', [PendaftaranController::class, 'sukses'])->name('sukses');

    // Admin routes
    Route::get('/', [PendaftaranController::class, 'index'])->name('index');
    Route::get('/{id}', [PendaftaranController::class, 'show'])->name('show');
});