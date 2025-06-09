<?php

namespace App\Http\Controllers;

use App\Http\Requests\KelompokStoreRequest;
use App\Http\Requests\KelompokUpdateRequest;
use App\Models\DosenPembimbingModel;
use App\Models\DosenPembimbingPeranModel;
use App\Models\KelompokModel;
use App\Models\KompetensiModel;
use App\Models\LombaModel;
use App\Models\MahasiswaModel;
use App\Models\MahasiswaPeranModel;
use DB;
use Exception;
use Illuminate\Http\Request;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Kelompok', 'url' => route('admin.manajemen.kelompok.index')],
        ];

        return view('kelompok.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Kelompok',
            'kelompoks' => KelompokModel::all(),
        ]);
    }

    public function data()
    {
        $kelompoks = KelompokModel::with(['lomba', 'mahasiswa_perans.mahasiswa', 'dosen_pembimbing_peran.dosen_pembimbing'])->get();

        return response()->json([
            'status' => true,
            'data' => $kelompoks->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'lomba_nama' => $item->lomba->lomba_nama,
                    'kelompok_nama' => $item->kelompok_nama,
                    'nama_ketua' => $item->mahasiswa_perans->where('peran_nama', 'Ketua')->first()->mahasiswa->mahasiswa_nama,
                    'nama_dpm' => $item->dosen_pembimbing_peran->dosen_pembimbing->dosen_pembimbing_nama,
                    'actions' => view('components.buttons.action', [
                        'route_prefix' => 'admin.manajemen.kelompok',
                        'id' => $item->kelompok_id
                    ])->render()
                ];
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kelompok.modals.create', [
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(KelompokStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();

            $kelompok = KelompokModel::create([
                'kelompok_nama' => $validated['kelompok_nama'],
                'lomba_id' => $validated['lomba_id'],
            ]);

            $dosenPembimbingPeran = DosenPembimbingPeranModel::create([
                'kelompok_id' => $kelompok->kelompok_id,
                'nip' => $validated['dosen_pembimbing'],
                'peran_nama' => $validated['peran_dpm'],
            ]);

            $dosenPembimbingPeran->kompetensis()->sync($validated['kompetensi_dpm'] ?? []);

            $mahasiswaPerans = [];
            for ($i = 0; $i < count($validated['mahasiswa']); $i++) {
                $mahasiswaPeran = MahasiswaPeranModel::create([
                    'kelompok_id' => $kelompok->kelompok_id,
                    'nim' => $validated['mahasiswa'][$i],
                    'peran_nama' => $validated['peran_mhs'][$i],
                ]);

                if (isset($validated['kompetensi_mhs'][$i])) {
                    $mahasiswaPeran->kompetensis()->sync($validated['kompetensi_mhs'][$i]);
                }

                $mahasiswaPerans[] = $mahasiswaPeran;
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Kelompok berhasil disimpan!',
                'redirect' => route('admin.manajemen.kelompok.index'),
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan kelompok: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('kelompok.detail', [
            'title' => 'Detail Kelompok',
            'breadcrumbs' => [
                ['name' => 'Kelompok', 'url' => route('admin.manajemen.kelompok.index')],
                ['name' => 'Detail'],
            ],
            'kelompok' => KelompokModel::with([
                'lomba',
                'mahasiswa_perans.mahasiswa',
                'mahasiswa_perans.kompetensis',
                'dosen_pembimbing_peran.dosen_pembimbing',
                'dosen_pembimbing_peran.kompetensis',
            ])->findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('kelompok.modals.edit', [
            'kelompok' => KelompokModel::with([
                'lomba',
                'mahasiswa_perans.mahasiswa',
                'mahasiswa_perans.kompetensis',
                'dosen_pembimbing_peran.dosen_pembimbing',
                'dosen_pembimbing_peran.kompetensis',
            ])->find($id),
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

    /**
     * Update the specified resource in storage.
     */
    public function update(KelompokUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();

            $kelompok = KelompokModel::findOrFail($id);
            $kelompok->update([
                'kelompok_nama' => $validated['kelompok_nama'],
                'lomba_id' => $validated['lomba_id'],
            ]);

            $dosenPembimbingPeran = $kelompok->dosen_pembimbing_peran;
            if ($dosenPembimbingPeran) {
                $dosenPembimbingPeran->update([
                    'nip' => $validated['dosen_pembimbing'],
                    'peran_nama' => $validated['peran_dpm'],
                ]);
            } else {
                $dosenPembimbingPeran = DosenPembimbingPeranModel::create([
                    'kelompok_id' => $kelompok->kelompok_id,
                    'nip' => $validated['dosen_pembimbing'],
                    'peran_nama' => $validated['peran_dpm'],
                ]);
            }

            $dosenPembimbingPeran->kompetensis()->sync($validated['kompetensi_dpm'] ?? []);

            foreach ($kelompok->mahasiswa_perans as $mahasiswaPeran) {
                $mahasiswaPeran->kompetensis()->detach();
            }

            $kelompok->mahasiswa_perans()->delete();

            foreach ($validated['mahasiswa'] as $index => $nim) {
                $mahasiswaPeran = MahasiswaPeranModel::create([
                    'kelompok_id' => $kelompok->kelompok_id,
                    'nim' => $nim,
                    'peran_nama' => $validated['peran_mhs'][$index],
                ]);

                if (isset($validated['kompetensi_mhs'][$index])) {
                    $mahasiswaPeran->kompetensis()->sync($validated['kompetensi_mhs'][$index]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Kelompok berhasil diperbarui!',
                'redirect' => route('admin.manajemen.kelompok.index'),
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui kelompok: ' . $e->getMessage(),
            ]);
        }
    }

    public function delete(string $id)
    {
        return view('kelompok.modals.delete', [
            'kelompok' => KelompokModel::findOrFail($id),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kelompok = KelompokModel::findOrFail($id);
            $kelompok->mahasiswa_perans()->delete();
            $kelompok->delete();

            return response()->json([
                'status' => true,
                'message' => 'Kelompok berhasil dihapus.',
                'redirect' => route('admin.manajemen.kelompok.index'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus kelompok: ' . $e->getMessage(),
            ]);
        }
    }
}
