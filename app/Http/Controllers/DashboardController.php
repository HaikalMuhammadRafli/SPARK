<?php

namespace App\Http\Controllers;

use App\Models\KelompokModel;
use App\Models\MahasiswaModel;
use App\Models\LombaModel;
use App\Models\PrestasiModel;
use Illuminate\Http\Request;
use View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function admin()
    {
        return view('pages.admin.dashboard', [
            'mahasiswa_count' => MahasiswaModel::count(),
            'kelompok_count' => KelompokModel::count(),
            'lomba_count' => LombaModel::count(),
            'prestasi_count' => PrestasiModel::count(),
        ]);
    }

    public function dosenPembimbing()
    {
        return view('pages.dosen-pembimbing.dashboard');
    }

    public function mahasiswa()
    {
        $userNim = auth()->user()->mahasiswa->nim;

        return view(
            'pages.mahasiswa.dashboard',
            [
                'lomba_berlangsung_count' => LombaModel::where('lomba_status', 'Sedang Berlangsung')->count(),
                'lomba_akan_datang_count' => LombaModel::where('lomba_status', 'Akan Datang')->count(),
                'lomba_saya_count' => LombaModel::whereHas('kelompoks.mahasiswa_perans', function ($query) use ($userNim) {
                    $query->where('nim', $userNim);
                })->count(),
                'prestasi_saya_count' => PrestasiModel::whereHas('kelompok.mahasiswa_perans', function ($query) use ($userNim) {
                    $query->where('nim', $userNim);
                })->count(),
            ]
        );
    }
}
