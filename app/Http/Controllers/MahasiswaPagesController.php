<?php

namespace App\Http\Controllers;

use App\Models\KelompokModel;
use DB;
use Illuminate\Http\Request;
use App\Models\LombaModel;
use App\Models\DosenPembimbingModel;
use App\Models\KompetensiModel;
use App\Models\MahasiswaModel;
use App\Models\DosenPembimbingPeranModel;
use Exception;

class MahasiswaPagesController extends Controller
{
    public function kelompokIndex()
    {
        return view('pages.mahasiswa.kelompok.index', [
            'breadcrumbs' => [
                ['name' => 'Kelompok', 'url' => route('mahasiswa.kelompok.index')],
            ],
            'title' => 'Kelompok',
            'kategoris' => [
                'Programming' => 'Programming',
                'Artificial Intelligence' => 'Artificial Intelligence',
                'Data Science' => 'Data Science',
                'Web Design' => 'Web Design',
                'Mobile Development' => 'Mobile Development',
                'UI/UX Design' => 'UI/UX Design',
                'Game Development' => 'Game Development',
                'Cyber Security' => 'Cyber Security',
                'Cloud Computing' => 'Cloud Computing',
                'Internet of Things' => 'Internet of Things',
                'DevOps' => 'DevOps',
                'Robotics' => 'Robotics',
                'Blockchain Technology' => 'Blockchain Technology',
                'Business Intelligence' => 'Business Intelligence',
            ],
            'lokasi_preferensis' => [
                'Kota' => 'Kota',
                'Provinsi' => 'Provinsi',
                'Nasional' => 'Nasional',
                'Internasional' => 'Internasional',
            ],
            'tingkats' => [
                'Kota' => 'Kota',
                'Provinsi' => 'Provinsi',
                'Nasional' => 'Nasional',
                'Internasional' => 'Internasional',
            ],
            'statuses' => [
                'Full' => 'Full',
                'Tidak Full' => 'Tidak Full',
            ],
        ]);
    }

    public function kelompokData(Request $request)
    {
        $query = KelompokModel::with([
            'lomba',
            'dosen_pembimbing_peran.dosen_pembimbing.user',
            'mahasiswa_perans.mahasiswa.user'
        ]);

        // Apply search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('kelompok_nama', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('lomba', function ($lombaQuery) use ($searchTerm) {
                        $lombaQuery->where('lomba_nama', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        // Apply category filter
        if ($request->filled('kategori') && $request->kategori !== '') {
            $query->whereHas('lomba', function ($lombaQuery) use ($request) {
                $lombaQuery->where('lomba_kategori', $request->kategori);
            });
        }

        // Apply location filter
        if ($request->filled('lokasi') && $request->lokasi !== '') {
            $query->whereHas('lomba', function ($lombaQuery) use ($request) {
                $lombaQuery->where('lomba_lokasi_preferensi', $request->lokasi);
            });
        }

        // Apply level filter
        if ($request->filled('tingkat') && $request->tingkat !== '') {
            $query->whereHas('lomba', function ($lombaQuery) use ($request) {
                $lombaQuery->where('lomba_tingkat', $request->tingkat);
            });
        }

        $kelompoks = $query->get();

        // Return the partial view as HTML
        $html = view('pages.mahasiswa.kelompok.partials.kelompok-grid', compact('kelompoks'))->render();

        return response()->json([
            'status' => true,
            'html' => $html,
            'count' => $kelompoks->count(),
        ]);
    }

    public function kelompokShow(string $id)
    {
        return view('pages.mahasiswa.kelompok.show', [
            'breadcrumbs' => [
                ['name' => 'Kelompok', 'url' => route('mahasiswa.kelompok.index')],
                ['name' => 'Detail Kelompok', 'url' => route('mahasiswa.kelompok.show', $id)],
            ],
            'title' => 'Detail Kelompok',
            'kelompok' => KelompokModel::findOrFail($id)
        ]);
    }

    public function kelompokEdit(string $id)
    {
        return view('pages.mahasiswa.kelompok.modals.edit', [
            'kelompok' => KelompokModel::find($id),
            'lombas' => LombaModel::all(),
            'mahasiswas' => MahasiswaModel::all(),
            'perans_mhs' => [
                'Ketua' => 'Ketua',
                'Anggota' => 'Anggota',
            ],
            'dosen_pembimbings' => DosenPembimbingModel::all(),
            'perans_dpm' => [
                'Pembimbing kegiatan mahasiswa' => 'Pembimbing kegiatan mahasiswa',
                'Pembimbing produk tingkat kota' => 'Pembimbing produk tingkat kota',
                'Pembimbing produk tingkat provinsi' => 'Pembimbing produk tingkat provinsi',
                'Pembimbing produk tingkat nasional' => 'Pembimbing produk tingkat nasional',
                'Pembimbing produk tingkat internasional' => 'Pembimbing produk tingkat internasional',
                'Pembimbing kompetisi tingkat kota' => 'Pembimbing kompetisi tingkat kota',
                'Pembimbing kompetisi tingkat provinsi' => 'Pembimbing kompetisi tingkat provinsi',
                'Pembimbing kompetisi tingkat nasional' => 'Pembimbing kompetisi tingkat nasional',
                'Pembimbing kompetisi tingkat internasional' => 'Pembimbing kompetisi tingkat internasional',
            ],
            'kompetensis' => KompetensiModel::all(),
        ]);
    }

    public function kelompokDelete(string $id)
    {
        return view('pages.mahasiswa.kelompok.modals.delete', [
            'kelompok' => KelompokModel::findOrFail($id),
        ]);
    }

    public function kelompokDestroy(string $id)
    {
        try {
            DB::beginTransaction();

            $kelompok = KelompokModel::with([
                'mahasiswa_perans.kompetensis',
                'dosen_pembimbing_peran.kompetensis'
            ])->findOrFail($id);

            foreach ($kelompok->mahasiswa_perans as $mahasiswaPeran) {
                $mahasiswaPeran->kompetensis()->detach();
                $mahasiswaPeran->delete();
            }

            $dosenPembimbingPerans = DosenPembimbingPeranModel::where('kelompok_id', $id)->get();
            foreach ($dosenPembimbingPerans as $dosenPembimbingPeran) {
                $dosenPembimbingPeran->kompetensis()->detach();
                $dosenPembimbingPeran->delete();
            }

            $kelompok->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Kelompok berhasil dihapus.',
                'redirect' => route('mahasiswa.kelompok.index'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus kelompok: ' . $e->getMessage(),
            ]);
        }
    }
}
