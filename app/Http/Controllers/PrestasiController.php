<?php

namespace App\Http\Controllers;

use App\Models\PrestasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
