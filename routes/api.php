<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenPembimbingController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\MahasiswaController;
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

Route::middleware(['auth:sanctum', 'authorize:admin'])->group(function () {
    Route::prefix('mahasiswa')->group(function () {
        Route::post('/', [MahasiswaController::class, 'store']);
        Route::get('/', [MahasiswaController::class, 'index']);
        Route::get('/{nim}', [MahasiswaController::class, 'show']);
        Route::put('/{nim}', [MahasiswaController::class, 'update']);
        Route::delete('/{nim}', [MahasiswaController::class, 'destroy']);
    });
    Route::prefix('admin')->group(function () {
        Route::post('/', [AdminController::class, 'store']);
        Route::get('/', [AdminController::class, 'index']);
        Route::get('/{nip}', [AdminController::class, 'show']);
        Route::put('/{nip}', [AdminController::class, 'update']);
        Route::delete('/{nip}', [AdminController::class, 'destroy']);
    });
    Route::prefix('dosen-pembimbing')->group(function () {
        Route::post('/', [DosenPembimbingController::class, 'store']);
        Route::get('/', [DosenPembimbingController::class, 'index']);
        Route::get('/{nip}', [DosenPembimbingController::class, 'show']);
        Route::put('/{nip}', [DosenPembimbingController::class, 'update']);
        Route::delete('/{nip}', [DosenPembimbingController::class, 'destroy']);
    });
    Route::prefix('kompetensi')->group(function () {
        Route::post('/', [KompetensiController::class, 'store']);
        Route::get('/', [KompetensiController::class, 'index']);
        Route::get('/{id}', [KompetensiController::class, 'show']);
        Route::put('/{id}', [KompetensiController::class, 'update']);
        Route::delete('/{id}', [KompetensiController::class, 'destroy']);
    });
});
