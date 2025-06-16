<?php

use App\Http\Controllers\BidangKeahlianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\MahasiswaPagesController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenPembimbingController;
use App\Http\Controllers\DosenPembimbingPeranController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\MinatController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\DospemPagesController;
use App\Http\Controllers\LaporanAnalisisPrestasiController;
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
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/mahasiswa', [ProfileController::class, 'updateMahasiswa'])->name('update.mahasiswa');
        Route::put('/staff', [ProfileController::class, 'updateStaff'])->name('update.staff');
        Route::get('/bidang-keahlian/{id}', [ProfileController::class, 'deleteBidangKeahlian'])->name('destroy.bidang-keahlian');
        Route::get('/minat/{id}', [ProfileController::class, 'deleteMinat'])->name('destroy.minat');
        Route::get('/add/bidang-keahlian', [ProfileController::class, 'addBidangKeahlianForm'])->name('add.bidang-keahlian.form');
        Route::get('/add/minat', [ProfileController::class, 'addMinatForm'])->name('add.minat.form');
        Route::post('/add/bidang-keahlian', [ProfileController::class, 'addBidangKeahlian'])->name('add.bidang-keahlian');
        Route::post('/add/minat', [ProfileController::class, 'addMinat'])->name('add.minat');
    });

    Route::middleware(['authorize:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        Route::prefix('manajemen')->name('manajemen.')->group(function () {
            // Kelompok Routes
            Route::prefix('kelompok')->name('kelompok.')->group(function () {
                Route::get('/', [KelompokController::class, 'index'])->name('index');
                Route::get('/data', [KelompokController::class, 'data'])->name('data');
                Route::get('/create', [KelompokController::class, 'create'])->name('create');
                Route::get('/spk/data', [KelompokController::class, 'spkData'])->name('spk.data');
                Route::post('/spk', [KelompokController::class, 'spk'])->name('spk');
                Route::post('/', [KelompokController::class, 'store'])->name('store');
                Route::get('/{id}', [KelompokController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [KelompokController::class, 'edit'])->name('edit');
                Route::put('/{id}', [KelompokController::class, 'update'])->name('update');
                Route::get('/{id}/delete', [KelompokController::class, 'delete'])->name('delete');
                Route::delete('/{id}', [KelompokController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('lomba')->name('lomba.')->group(function () {
                Route::get('/', [LombaController::class, 'index'])->name('index');
                Route::get('/data', [LombaController::class, 'data'])->name('data');
                //verification
                Route::get('/verification', [LombaController::class, 'verification'])->name('verification');
                Route::get('/verification/data', [LombaController::class, 'verificationData'])->name('verification.data');
                Route::get('/verification/detail/{id}', [LombaController::class, 'verificationDetail'])->name('verification.detail');
                Route::post('/verification/verify/{id}', [LombaController::class, 'verify'])->name('verification.verify');
                Route::post('/list', [LombaController::class, 'list'])->name('list');
                Route::get('/create', [LombaController::class, 'create'])->name('create');
                Route::post('/', [LombaController::class, 'store'])->name('store');
                Route::get('/{id}', [LombaController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [LombaController::class, 'edit'])->name('edit');
                Route::put('/{id}', [LombaController::class, 'update'])->name('update');
                Route::get('/{id}/delete', [LombaController::class, 'delete'])->name('delete');
                Route::delete('/{id}', [LombaController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('prestasi')->name('prestasi.')->group(function () {
                Route::get('/', [PrestasiController::class, 'index'])->name('index');
                Route::get('/data', [PrestasiController::class, 'data'])->name('data');
                Route::get('/verification', [PrestasiController::class, 'verification'])->name('verification');
                Route::get('/verification/data', [PrestasiController::class, 'verificationData'])->name('verification.data');
                Route::get('/verification/detail/{id}', [PrestasiController::class, 'verificationDetail'])->name('verification.detail');
                Route::post('/verification/verify/{id}', [PrestasiController::class, 'verify'])->name('verification.verify');
                Route::get('/create', [PrestasiController::class, 'create'])->name('create');
                Route::post('/', [PrestasiController::class, 'store'])->name('store');
                Route::get('/{id}', [PrestasiController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [PrestasiController::class, 'edit'])->name('edit');
                Route::put('/{id}', [PrestasiController::class, 'update'])->name('update');
                Route::get('/{id}/delete', [PrestasiController::class, 'delete'])->name('delete');
                Route::delete('/{id}', [PrestasiController::class, 'destroy'])->name('destroy');
            });
        });

        // Master Data Routes
        Route::prefix('master')->name('master.')->group(function () {
            Route::prefix('bidang-keahlian')->name('bidang-keahlian.')->group(function () {
                Route::get('/', [BidangKeahlianController::class, 'index'])->name('index');
                Route::get('/data', [BidangKeahlianController::class, 'data'])->name('data');
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
                Route::get('/create', [MinatController::class, 'create'])->name('create');
                Route::post('/', [MinatController::class, 'store'])->name('store');
                Route::get('/{id}', [MinatController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [MinatController::class, 'edit'])->name('edit');
                Route::put('/{id}', [MinatController::class, 'update'])->name('update');
                Route::get('/{id}/delete', [MinatController::class, 'delete'])->name('delete');
                Route::delete('/{id}', [MinatController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('kompetensi')->name('kompetensi.')->group(function () {
                Route::get('/', [KompetensiController::class, 'indexView'])->name('index');
                Route::get('/create', [KompetensiController::class, 'createView'])->name('create');
                Route::get('/{id}/edit', [KompetensiController::class, 'editView'])->name('edit');
                Route::get('/{id}/delete', [KompetensiController::class, 'deleteView'])->name('delete');
            });
        });

        route::prefix('manajemen-pengguna')->name('manajemen-pengguna.')->group(function () {
            Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
                Route::get('/', [MahasiswaController::class, 'indexView'])->name('index');
                Route::get('/create', [MahasiswaController::class, 'createView'])->name('create');
                Route::get('/{id}/edit', [MahasiswaController::class, 'editView'])->name('edit');
                Route::get('/{id}/delete', [MahasiswaController::class, 'deleteView'])->name('delete');
                Route::get('export-pdf', [MahasiswaController::class, 'exportPdf'])->name('export-pdf');
            });

            Route::prefix('admin')->name('admin.')->group(function () {
                Route::get('/', [AdminController::class, 'indexView'])->name('index');
                Route::get('/create', [AdminController::class, 'createView'])->name('create');
                Route::get('/{id}/edit', [AdminController::class, 'editView'])->name('edit');
                Route::get('/{id}/delete', [AdminController::class, 'deleteView'])->name('delete');
                Route::get('export-pdf', [AdminController::class, 'exportPdf'])->name('export-pdf');
            });

            Route::prefix('dosen-pembimbing')->name('dosen-pembimbing.')->group(function () {
                Route::get('/', [DosenPembimbingController::class, 'indexView'])->name('index');
                Route::get('/create', [DosenPembimbingController::class, 'createView'])->name('create');
                Route::get('/{id}/edit', [DosenPembimbingController::class, 'editView'])->name('edit');
                Route::get('/{id}/delete', [DosenPembimbingController::class, 'deleteView'])->name('delete');
                Route::get('export-pdf', [DosenPembimbingController::class, 'exportPdf'])->name('export-pdf');
            });
        });

        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanAnalisisPrestasiController::class, 'indexView'])->name('index');
            Route::get('/{id}/edit', [LaporanAnalisisPrestasiController::class, 'editView'])->name('edit');
            Route::put('/{id}', [LaporanAnalisisPrestasiController::class, 'update'])->name('update');
            Route::get('/{id}/delete', [LaporanAnalisisPrestasiController::class, 'deleteView'])->name('delete');
            Route::get('/export/excel', [LaporanAnalisisPrestasiController::class, 'exportExcel'])->name('export.excel');
            Route::get('/export/pdf', [LaporanAnalisisPrestasiController::class, 'exportPdf'])->name('export.pdf');
        });
    });

    Route::prefix('dosen-pembimbing')->name('dosen-pembimbing.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dosenPembimbing'])->name('dashboard');
        Route::prefix('data-lomba')->name('data-lomba.')->group(function () {
            Route::get('/', [DospemPagesController::class, 'dataLombaIndex'])->name('index');
            Route::get('/data', [DospemPagesController::class, 'dataLombaData'])->name('data');
            Route::get('/create', [DospemPagesController::class, 'dataLombaCreate'])->name('create');
            Route::post('/', [DospemPagesController::class, 'dataLombaStore'])->name('store');
            Route::get('/{id}', [DospemPagesController::class, 'dataLombaShow'])->name('show');
            Route::get('/{id}/edit', [DospemPagesController::class, 'dataLombaEdit'])->name('edit');
            Route::put('/{id}', [DospemPagesController::class, 'dataLombaUpdate'])->name('update');
            Route::get('/{id}/delete', [DospemPagesController::class, 'dataLombaDelete'])->name('delete');
            Route::delete('/{id}', [DospemPagesController::class, 'dataLombaDestroy'])->name('destroy');
        });

        Route::prefix('/kelompok-bimbingan')->name('kelompok-bimbingan.')->group(function () {
            Route::get('/', [DosenPembimbingPeranController::class, 'indexView'])->name('index');
            Route::get('/create', [DosenPembimbingPeranController::class, 'createView'])->name('create');
            Route::get('/{id}/edit', [DosenPembimbingPeranController::class, 'editView'])->name('edit');
            Route::get('/{id}/delete', [DosenPembimbingPeranController::class, 'deleteView'])->name('delete');
        });
    });

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'mahasiswa'])->name('dashboard');
        Route::prefix('kelompok')->name('kelompok.')->group(function () {
            Route::get('/', [MahasiswaPagesController::class, 'kelompokIndex'])->name('index');
            Route::get('/data', [MahasiswaPagesController::class, 'kelompokData'])->name('data');
            Route::get('/saya', [MahasiswaPagesController::class, 'kelompokSaya'])->name('saya');
            Route::get('/saya/data', [MahasiswaPagesController::class, 'kelompokSayaData'])->name('saya.data');
            Route::get('/create', [MahasiswaPagesController::class, 'kelompokCreate'])->name('create');
            Route::get('/spk/data', [MahasiswaPagesController::class, 'kelompokSpkData'])->name('spk.data');
            Route::post('/spk', [MahasiswaPagesController::class, 'kelompokSpk'])->name('spk');
            Route::post('/', [MahasiswaPagesController::class, 'kelompokStore'])->name('store');
            Route::get('/join/{id}', [MahasiswaPagesController::class, 'kelompokJoinForm'])->name('join.form');
            Route::post('/join/{id}', [MahasiswaPagesController::class, 'kelompokJoin'])->name('join');
            Route::post('/leave/{id}', [MahasiswaPagesController::class, 'kelompokLeave'])->name('leave');
            Route::get('/{id}', [MahasiswaPagesController::class, 'kelompokShow'])->name('show');
            Route::get('/{id}/edit', [MahasiswaPagesController::class, 'kelompokEdit'])->name('edit');
            Route::put('/{id}', [MahasiswaPagesController::class, 'kelompokUpdate'])->name('update');
            Route::get('/{id}/delete', [MahasiswaPagesController::class, 'kelompokDelete'])->name('delete');
            Route::delete('/{id}', [MahasiswaPagesController::class, 'kelompokDestroy'])->name('destroy');
        });
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            Route::get('/', [PrestasiController::class, 'indexView'])->name('index');
            Route::get('/json', [PrestasiController::class, 'indexMahasiswa'])->name('indexJson');
            Route::get('/data', [PrestasiController::class, 'dataMahasiswa'])->name('data');
            Route::get('/create', [PrestasiController::class, 'createMahasiswa'])->name('create');
            Route::post('/', [PrestasiController::class, 'storeMahasiswa'])->name('store');
            Route::get('/{id}', [PrestasiController::class, 'showMahasiswa'])->name('show');
            Route::get('/{id}/edit', [PrestasiController::class, 'editMahasiswa'])->name('edit');
            Route::put('/{id}', [PrestasiController::class, 'updateMahasiswa'])->name('update');
            Route::get('/{id}/delete', [PrestasiController::class, 'deleteMahasiswa'])->name('delete');
            Route::delete('/{id}', [PrestasiController::class, 'destroyMahasiswa'])->name('destroy');
        });
        Route::prefix('data-lomba')->name('data-lomba.')->group(function () {
            Route::get('/', [MahasiswaPagesController::class, 'dataLombaIndex'])->name('index');
            Route::get('/data', [MahasiswaPagesController::class, 'dataLombaData'])->name('data');
            Route::get('/create', [MahasiswaPagesController::class, 'dataLombaCreate'])->name('create');
            Route::post('/', [MahasiswaPagesController::class, 'dataLombaStore'])->name('store');
            Route::get('/{id}', [MahasiswaPagesController::class, 'dataLombaShow'])->name('show');
            Route::get('/{id}/edit', [MahasiswaPagesController::class, 'dataLombaEdit'])->name('edit');
            Route::put('/{id}', [MahasiswaPagesController::class, 'dataLombaUpdate'])->name('update');
            Route::get('/{id}/delete', [MahasiswaPagesController::class, 'dataLombaDelete'])->name('delete');
            Route::delete('/{id}', [MahasiswaPagesController::class, 'dataLombaDestroy'])->name('destroy');
        });
    });
});
