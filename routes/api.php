<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenPembimbingController;


use App\Http\Controllers\DosenPembimbingPeranController;
use App\Http\Controllers\DosenPembimbingPeranKompetensiController;
use App\Http\Controllers\KompetensiController;

use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanAnalisisPrestasiController;
use App\Http\Controllers\PrestasiController;

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

// Student-specific prestasi routes
Route::middleware(['auth:sanctum', 'authorize:mahasiswa'])->group(function () {
    Route::prefix('prestasi')->group(function () {
        Route::get('/', [PrestasiController::class, 'indexMahasiswa']);
        Route::post('/', [PrestasiController::class, 'storeMahasiswa']);
        Route::get('/{id}', [PrestasiController::class, 'showMahasiswa']);
        Route::put('/{id}', [PrestasiController::class, 'updateMahasiswa']);
        Route::delete('/{id}', [PrestasiController::class, 'destroyMahasiswa']);
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware(['authorize:admin'])->group(function () {
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
        Route::prefix('laporan')->group(function () {
            Route::get('/', [LaporanAnalisisPrestasiController::class, 'index']);
            Route::post('/', [LaporanAnalisisPrestasiController::class, 'store']);
            Route::get('/{id}', [LaporanAnalisisPrestasiController::class, 'show']);
            Route::put('/{id}', [LaporanAnalisisPrestasiController::class, 'update']);
            Route::delete('/{id}', [LaporanAnalisisPrestasiController::class, 'destroy']);
            Route::get('/export/pdf', [LaporanAnalisisPrestasiController::class, 'exportPDF']);
            Route::get('/export/excel', [LaporanAnalisisPrestasiController::class, 'exportExcel']);
        });
    });

    Route::middleware(['authorize:dosen_pembimbing'])->group(function () {
        Route::prefix('dosen-pembimbing-peran')->group(function () {
            Route::post('/', [DosenPembimbingPeranController::class, 'store']);
            Route::get('/', [DosenPembimbingPeranController::class, 'show']);
            Route::put('/{peranId}', [DosenPembimbingPeranController::class, 'update']);
            Route::delete('/{peranId}', [DosenPembimbingPeranController::class, 'destroy']);
        });

        Route::prefix('dosen-pembimbing-peran-kompetensi')->group(function () {
            Route::get('/', [DosenPembimbingPeranKompetensiController::class, 'index']);
            Route::post('/{peranId}', [DosenPembimbingPeranKompetensiController::class, 'store']);
            Route::get('/{peranId}', [DosenPembimbingPeranKompetensiController::class, 'show']);
            Route::delete('/{peranId}', [DosenPembimbingPeranKompetensiController::class, 'destroy']);
        });
    });
});
