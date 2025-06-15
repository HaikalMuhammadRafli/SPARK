<?php

namespace App\Http\Controllers;

use App\Models\PrestasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestasi = PrestasiModel::with('kelompok')->get();
        return response()->json([
            'status' => 'success',
            'data' => $prestasi
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
        $request->validate([
            'prestasi_juara' => 'required|string|max:255',
            'prestasi_surat_tugas_url' => 'required|url|max:255',
            'prestasi_poster_url' => 'required|url|max:255',
            'prestasi_foto_juara_url' => 'required|url|max:255',
            'prestasi_proposal_url' => 'required|url|max:255',
            'prestasi_sertifikat_url' => 'required|url|max:255',
            'prestasi_status' => 'required|in:Disetujui,Ditolak,Pending',
            'prestasi_catatan' => 'nullable|string',
            'kelompok_id' => 'required|integer'
        ]);

        $prestasi = PrestasiModel::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Prestasi berhasil ditambahkan',
            'data' => $prestasi
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prestasi = PrestasiModel::with('kelompok')->find($id);

        if (!$prestasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prestasi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $prestasi
        ]);
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
        $prestasi = PrestasiModel::find($id);

        if (!$prestasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prestasi tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'prestasi_juara' => 'sometimes|required|string|max:255',
            'prestasi_surat_tugas_url' => 'sometimes|required|url|max:255',
            'prestasi_poster_url' => 'sometimes|required|url|max:255',
            'prestasi_foto_juara_url' => 'sometimes|required|url|max:255',
            'prestasi_proposal_url' => 'sometimes|required|url|max:255',
            'prestasi_sertifikat_url' => 'sometimes|required|url|max:255',
            'prestasi_status' => 'sometimes|required|in:Disetujui,Ditolak,Pending',
            'prestasi_catatan' => 'nullable|string',
            'kelompok_id' => 'sometimes|required|integer'
        ]);

        $prestasi->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Prestasi berhasil diperbarui',
            'data' => $prestasi
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prestasi = PrestasiModel::find($id);

        if (!$prestasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prestasi tidak ditemukan'
            ], 404);
        }

        $prestasi->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Prestasi berhasil dihapus'
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
        try {
            $verification_action = $request->input('verification_action');

            $rules = [];
            $messages = [];

            if ($verification_action === 'tolak') {
                $rules['prestasi_catatan'] = 'required|string|min:10';
                $messages['prestasi_catatan.required'] = 'Catatan wajib diisi saat menolak prestasi.';
                $messages['prestasi_catatan.min'] = 'Catatan minimal 10 karakter.';
            }

            $rules['verification_action'] = 'required|in:setuju,tolak';
            $messages['verification_action.required'] = 'Verification action tidak valid.';
            $messages['verification_action.in'] = 'Verification action harus setuju atau tolak.';

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $prestasi = PrestasiModel::findOrFail($id);

            if ($verification_action === 'setuju') {
                $prestasi->prestasi_status = 'Disetujui';
                $prestasi->prestasi_catatan = $request->prestasi_catatan ?: 'Prestasi disetujui';
                $message = 'Prestasi berhasil disetujui!';
                $prestasi->validated_at = now();
            } else {
                $prestasi->prestasi_status = 'Ditolak';
                $prestasi->prestasi_catatan = $request->prestasi_catatan;
                $message = 'Prestasi berhasil ditolak!';
            }

            $prestasi->save();

            return response()->json([
                'status' => true,
                'message' => $message
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan sistem. ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display a listing of the student's own achievements.
     */
    public function indexMahasiswa()
    {
        $user = Auth::user();
        $nim = $user->mahasiswa->nim ?? null;
        $prestasi = PrestasiModel::with('kelompok')
            ->whereHas('kelompok.mahasiswaPeran', function ($query) use ($nim) {
                $query->where('nim', $nim);
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $prestasi
        ]);
    }

    /**
     * Store a new achievement for the student.
     */
    public function storeMahasiswa(Request $request)
    {
        $user = Auth::user();
        $nim = $user->mahasiswa->nim ?? null;

        $request->validate([
            'prestasi_juara' => 'required|string|max:255',
            'prestasi_surat_tugas_url' => 'required|url|max:255',
            'prestasi_poster_url' => 'required|url|max:255',
            'prestasi_foto_juara_url' => 'required|url|max:255',
            'prestasi_proposal_url' => 'required|url|max:255',
            'prestasi_sertifikat_url' => 'required|url|max:255',
            'kelompok_id' => 'required|integer'
        ]);

        // Verify that the kelompok belongs to the student
        $kelompok = \App\Models\KelompokModel::whereHas('mahasiswaPeran', function ($query) use ($nim) {
            $query->where('nim', $nim);
        })->where('kelompok_id', $request->kelompok_id)->first();

        if (!$kelompok) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kelompok tidak ditemukan atau tidak dimiliki oleh mahasiswa'
            ], 403);
        }

        // Set default status as Pending
        $request->merge(['prestasi_status' => 'Pending']);

        $prestasi = PrestasiModel::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Prestasi berhasil ditambahkan',
            'data' => $prestasi
        ], 201);
    }

    /**
     * Display the specified achievement for the student.
     */
    public function showMahasiswa(string $id)
    {
        $user = Auth::user();
        $nim = $user->mahasiswa->nim ?? null;
        $prestasi = PrestasiModel::with('kelompok')
            ->whereHas('kelompok.mahasiswaPeran', function ($query) use ($nim) {
                $query->where('nim', $nim);
            })
            ->find($id);

        if (!$prestasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prestasi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $prestasi
        ]);
    }

    /**
     * Update the specified achievement for the student.
     */
    public function updateMahasiswa(Request $request, string $id)
    {
        $user = Auth::user();
        $nim = $user->mahasiswa->nim ?? null;
        $prestasi = PrestasiModel::with('kelompok')
            ->whereHas('kelompok.mahasiswaPeran', function ($query) use ($nim) {
                $query->where('nim', $nim);
            })
            ->find($id);

        if (!$prestasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prestasi tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'prestasi_juara' => 'sometimes|required|string|max:255',
            'prestasi_surat_tugas_url' => 'sometimes|required|url|max:255',
            'prestasi_poster_url' => 'sometimes|required|url|max:255',
            'prestasi_foto_juara_url' => 'sometimes|required|url|max:255',
            'prestasi_proposal_url' => 'sometimes|required|url|max:255',
            'prestasi_sertifikat_url' => 'sometimes|required|url|max:255',
            'kelompok_id' => 'sometimes|required|integer'
        ]);

        // If kelompok_id is being updated, verify ownership
        if ($request->has('kelompok_id')) {
            $kelompok = \App\Models\KelompokModel::whereHas('mahasiswaPeran', function ($query) use ($nim) {
                $query->where('nim', $nim);
            })->where('kelompok_id', $request->kelompok_id)->first();

            if (!$kelompok) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kelompok tidak ditemukan atau tidak dimiliki oleh mahasiswa'
                ], 403);
            }
        }

        // Remove status from request as students cannot change it
        $request->offsetUnset('prestasi_status');
        $request->offsetUnset('prestasi_catatan');

        $prestasi->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Prestasi berhasil diperbarui',
            'data' => $prestasi
        ]);
    }

    /**
     * Remove the specified achievement for the student.
     */
    public function destroyMahasiswa(string $id)
    {
        $user = Auth::user();
        $nim = $user->mahasiswa->nim ?? null;
        $prestasi = PrestasiModel::with('kelompok')
            ->whereHas('kelompok.mahasiswaPeran', function ($query) use ($nim) {
                $query->where('nim', $nim);
            })
            ->find($id);

        if (!$prestasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prestasi tidak ditemukan'
            ], 404);
        }

        $prestasi->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Prestasi berhasil dihapus'
        ]);
    }

    public function indexView()
    {
        $breadcrumbs = [
            ['name' => 'MahasiswaPrestasi', 'url' => route('mahasiswa.prestasi.index')],
        ];

        return view('mahasiswa-prestasi.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Mahasiswa Prestasi',
        ]);
    }

}
