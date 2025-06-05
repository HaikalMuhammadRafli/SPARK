<?php

use App\Http\Controllers\BidangKeahlianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\MinatController;
use App\Http\Controllers\LombaController;
/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "web" middleware group. Make something great!
*/

Route::get('/', function () {
    return view('app');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
    });
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['authorize:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        // Master Data Routes
        route::prefix('master')->name('master.')->group(function () {
            Route::prefix('bidang-keahlian')->name('bidang-keahlian.')->group(function () {
                Route::get('/', [BidangKeahlianController::class, 'index'])->name('index');
                Route::get('/data', [BidangKeahlianController::class, 'data'])->name('data');
                Route::post('/list', [BidangKeahlianController::class, 'list'])->name('list');
                Route::get('/create', [BidangKeahlianController::class, 'create'])->name('create');
                Route::post('/', [BidangKeahlianController::class, 'store'])->name('store');
                Route::get('/{id}', [BidangKeahlianController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [BidangKeahlianController::class, 'edit'])->name('edit');
                Route::put('/{id}', [BidangKeahlianController::class, 'update'])->name('update');
                Route::get('/{id}/delete', [BidangKeahlianController::class, 'delete'])->name('delete');
                Route::delete('/{id}', [BidangKeahlianController::class, 'destroy'])->name('destroy');
            });

            // Route Periode 
            Route::prefix('periode')->name('periode.')->group(function () {
                Route::get('/', [PeriodeController::class, 'index'])->name('index');
                Route::get('/data', [PeriodeController::class, 'data'])->name('data');
                Route::post('/list', [PeriodeController::class, 'list'])->name('list');
                Route::get('/create', [PeriodeController::class, 'create'])->name('create');
                Route::post('/', [PeriodeController::class, 'store'])->name('store');
                Route::get('/{id}', [PeriodeController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [PeriodeController::class, 'edit'])->name('edit');
                Route::put('/{id}', [PeriodeController::class, 'update'])->name('update');
                Route::get('/{id}/delete', [PeriodeController::class, 'delete'])->name('delete');
                Route::delete('/{id}', [PeriodeController::class, 'destroy'])->name('destroy');
            });

            // Route prodi 
            Route::prefix('program-studi')->name('program-studi.')->group(function () {
                Route::get('/', [ProgramStudiController::class, 'index'])->name('index');
                Route::get('/data', [ProgramStudiController::class, 'data'])->name('data');
                Route::post('/list', [ProgramStudiController::class, 'list'])->name('list');
                Route::get('/create', [ProgramStudiController::class, 'create'])->name('create');
                Route::post('/', [ProgramStudiController::class, 'store'])->name('store');
                Route::get('/{id}', [ProgramStudiController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [ProgramStudiController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ProgramStudiController::class, 'update'])->name('update');
                Route::get('/{id}/delete', [ProgramStudiController::class, 'delete'])->name('delete');
                Route::delete('/{id}', [ProgramStudiController::class, 'destroy'])->name('destroy');
            });

            // Route minat 
            Route::prefix('minat')->name('minat.')->group(function () {
                Route::get('/', [MinatController::class, 'index'])->name('index');
                Route::get('/data', [MinatController::class, 'data'])->name('data');
                Route::post('/list', [MinatController::class, 'list'])->name('list');
                Route::get('/create', [MinatController::class, 'create'])->name('create');
                Route::post('/', [MinatController::class, 'store'])->name('store');
                Route::get('/{id}', [MinatController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [MinatController::class, 'edit'])->name('edit');
                Route::put('/{id}', [MinatController::class, 'update'])->name('update');
                Route::get('/{id}/delete', [MinatController::class, 'delete'])->name('delete');
                Route::delete('/{id}', [MinatController::class, 'destroy'])->name('destroy');
            });

            // Route data lomba 
            Route::prefix('data-lomba')->name('data-lomba.')->group(function () {
                Route::get('/', [LombaController::class, 'index'])->name('index');
                Route::get('/data', [LombaController::class, 'data'])->name('data');
                Route::post('/list', [LombaController::class, 'list'])->name('list');
                Route::get('/create', [LombaController::class, 'create'])->name('create');
                Route::post('/', [LombaController::class, 'store'])->name('store');
                Route::get('/{id}', [LombaController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [LombaController::class, 'edit'])->name('edit');
                Route::put('/{id}', [LombaController::class, 'update'])->name('update');
                Route::get('/{id}/delete', [LombaController::class, 'delete'])->name('delete');
                Route::delete('/{id}', [LombaController::class, 'destroy'])->name('destroy');
            });
        });
    });

    Route::prefix('dosen-pembimbing')->name('dosen-pembimbing.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dosenPembimbing'])->name('dashboard');
    });

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'mahasiswa'])->name('dashboard');
    });

});
