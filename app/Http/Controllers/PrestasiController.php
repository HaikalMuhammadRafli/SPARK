<?php

namespace App\Http\Controllers;

use App\Models\PrestasiModel;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function data(Request $request)
    {
        $query = PrestasiModel::with('kelompok');

        if ($request->filled('juara') && $request->juara !== '') {
            $query->where('prestasi_juara', $request->juara);
        }

        if ($request->has('kategori') && !empty($request->kategori)) {
            $query->whereHas('lomba', function ($q) use ($request) {
                $q->where('lomba_kategori', $request->kategori);
            });
        }

        if ($request->has('tingkat') && !empty($request->tingkat)) {
            $query->whereHas('lomba', function ($q) use ($request) {
                $q->where('lomba_tingkat', $request->tingkat);
            });
        }

        $prestasis = $query->get();

        return response()->json([
            'status' => true,
            'data' => $prestasis->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'kelompok_nama' => $item->kelompok->kelompok_nama,
                    'prestasi_juara' => $item->prestasi_juara,
                    'lomba_tingkat' => $item->kelompok->lomba->lomba_tingkat,
                    'lomba_nama' => $item->kelompok->lomba->lomba_nama,
                    'lomba_kategori' => $item->kelompok->lomba->lomba_kategori,
                    'lomba_penyelenggara' => $item->kelompok->lomba->lomba_penyelenggara,
                    'nama_ketua' => $item->kelompok->mahasiswa_perans->where('peran_nama', 'Ketua')->first()->mahasiswa->mahasiswa_nama,
                    'nama_dpm' => $item->kelompok->dosen_pembimbing_peran->dosen_pembimbing->dosen_pembimbing_nama,
                    'prestasi_status' => $item->prestasi_status,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'actions' => view('components.buttons.default', [
                        'type' => 'button',
                        'title' => 'Verify',
                        'color' => 'primary',
                        'onclick' => "modalAction('{{ route('admin.manajemen.prestasi.verification.detail', $item->prestasi_id) }}')",
                    ])
                ];
            })
        ]);
    }

    public function verification()
    {
        $breadcrumbs = [
            ['name' => 'Verifikasi Prestasi', 'url' => route('admin.manajemen.prestasi.verification')],
        ];

        return view('prestasi.verification', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Verifikasi Prestasi',
            'prestasis' => PrestasiModel::whereNull('validated_at')->get(),
            'juaras' => [
                'Juara 1' => 'Juara 1',
                'Juara 2' => 'Juara 2',
                'Juara 3' => 'Juara 3',
            ],
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
            'tingkats' => [
                'Kota' => 'Kota',
                'Provinsi' => 'Provinsi',
                'Nasional' => 'Nasional',
                'Internasional' => 'Internasional',
            ],
        ]);
    }

    public function verificationData(Request $request)
    {
        $query = PrestasiModel::whereNull('validated_at')->with('kelompok');

        if ($request->filled('juara') && $request->juara !== '') {
            $query->where('prestasi_juara', $request->juara);
        }

        if ($request->has('kategori') && !empty($request->kategori)) {
            $query->whereHas('lomba', function ($q) use ($request) {
                $q->where('lomba_kategori', $request->kategori);
            });
        }

        if ($request->has('tingkat') && !empty($request->tingkat)) {
            $query->whereHas('lomba', function ($q) use ($request) {
                $q->where('lomba_tingkat', $request->tingkat);
            });
        }

        $prestasis = $query->get();

        return response()->json([
            'status' => true,
            'data' => $prestasis->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'kelompok_nama' => $item->kelompok->kelompok_nama,
                    'prestasi_juara' => $item->prestasi_juara,
                    'lomba_tingkat' => $item->kelompok->lomba->lomba_tingkat,
                    'lomba_nama' => $item->kelompok->lomba->lomba_nama,
                    'lomba_kategori' => $item->kelompok->lomba->lomba_kategori,
                    'lomba_penyelenggara' => $item->kelompok->lomba->lomba_penyelenggara,
                    'nama_ketua' => $item->kelompok->mahasiswa_perans->where('peran_nama', 'Ketua')->first()->mahasiswa->mahasiswa_nama,
                    'nama_dpm' => $item->kelompok->dosen_pembimbing_peran->dosen_pembimbing->dosen_pembimbing_nama,
                    'prestasi_status' => $item->prestasi_status,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'actions' => view('components.buttons.default', [
                        'type' => 'button',
                        'title' => 'Verify',
                        'color' => 'primary',
                        'onclick' => "modalAction('{{ route('admin.manajemen.prestasi.verification.detail', $item->prestasi_id) }}')",
                    ])
                ];
            })
        ]);
    }

    public function verificationDetail(string $id)
    {
        return view('prestasi.modals.verification-detail', [
            'prestasi' => PrestasiModel::findOrFail($id)
        ]);
    }

    public function verify(Request $request, string $id)
    {
        $prestasi = PrestasiModel::findOrFail($id);
        $prestasi->validated_at = now();
        $prestasi->save();

        return response()->json([
            'status' => true,
            'message' => 'Prestasi berhasil diverifikasi.'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
