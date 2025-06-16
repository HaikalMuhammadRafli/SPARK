<?php

namespace App\Http\Controllers;

use App\Models\KelompokModel;
// use DB;
use Illuminate\Http\Request;
use App\Models\LombaModel;
use App\Models\DosenPembimbingModel;
use App\Models\KompetensiModel;
use App\Models\MahasiswaModel;
use App\Models\DosenPembimbingPeranModel;
use App\Models\MinatModel;
use App\Models\BidangKeahlianModel;
use App\Models\MahasiswaPeranModel;
use App\Http\Requests\KelompokStoreRequest;
use App\Http\Requests\KelompokUpdateRequest;
use Exception;
use App\Models\PeriodeModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Http\Requests\SPKRequest;


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
        ])->whereHas('lomba', function ($lombaQuery) {
            $lombaQuery->whereNot('lomba_status', 'Berakhir');
        });

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

    public function kelompokSaya()
    {
        return view('pages.mahasiswa.kelompok.kelompok-saya', [
            'breadcrumbs' => [
                ['name' => 'Kelompok Saya', 'url' => route('mahasiswa.kelompok.saya')],
            ],
            'title' => 'Kelompok Saya',
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

    public function kelompokSayaData(Request $request)
    {
        $query = KelompokModel::with([
            'lomba',
            'dosen_pembimbing_peran.dosen_pembimbing.user',
            'mahasiswa_perans.mahasiswa.user'
        ])->whereHas('lomba', function ($lombaQuery) {
            $lombaQuery->whereNot('lomba_status', 'Berakhir');
        })->whereHas('mahasiswa_perans', function ($mahasiswaQuery) {
            $mahasiswaQuery->where('nim', Auth::user()->mahasiswa->nim);
        });

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
            'kelompok' => KelompokModel::findOrFail($id),
            'mahasiswa_role' => $this->getMahasiswaRoleInKelompok(KelompokModel::findOrFail($id)),
        ]);
    }

    private function getMahasiswaRoleInKelompok($kelompok)
    {
        $user = auth()->user();
        $mahasiswaInGroup = $user->mahasiswa->kelompoks->find($kelompok->kelompok_id);

        if (!$mahasiswaInGroup) {
            return 'non_member';
        }

        $peran = $user->mahasiswa->perans->where('kelompok_id', $kelompok->kelompok_id)->first();

        return $peran ? ($peran->peran_nama === 'Ketua' ? 'ketua' : 'member') : 'member';
    }

    public function kelompokCreate()
    {
        return view('pages.mahasiswa.kelompok.modals.create', [
            'lombas' => LombaModel::whereNot('lomba_status', 'Berakhir')->get(),
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
            'lokasi_preferensis' => [
                'Kota' => 'Kota',
                'Provinsi' => 'Provinsi',
                'Nasional' => 'Nasional',
                'Internasional' => 'Internasional',
            ],
            'minats' => MinatModel::all(),
            'bidang_keahlians' => BidangKeahlianModel::all(),
            'jumlah_rekomendasis' => [
                '10' => '10',
                '20' => '20',
                '30' => '30',
                '40' => '40',
                '50' => '50',
            ],
            'weight_ranks' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ],
        ]);
    }

    public function kelompokStore(KelompokStoreRequest $request)
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
                'reloadKelompokGrid' => true,
                'redirect' => route('mahasiswa.kelompok.index'),
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan kelompok: ' . $e->getMessage(),
            ]);
        }
    }

    public function kelompokJoinForm(string $id)
    {
        $kelompok = KelompokModel::findOrFail($id);

        return view('pages.mahasiswa.kelompok.modals.join', [
            'kelompok' => $kelompok,
            'kompetensis' => KompetensiModel::all(),
        ]);
    }

    public function kelompokJoin(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'kompetensi' => ['required', 'array', 'min:1'],
                'kompetensi.*' => ['required', 'integer', Rule::exists('m_kompetensi', 'kompetensi_id')],
            ]);

            $kelompok = KelompokModel::findOrFail($id);

            $mahasiswa_peran = $kelompok->mahasiswa_perans()->create([
                'nim' => Auth::user()->mahasiswa->nim,
                'peran_nama' => 'Anggota'
            ]);

            $mahasiswa_peran->kompetensis()->sync($validated['kompetensi']);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil bergabung dengan kelompok!',
                'redirect' => route('mahasiswa.kelompok.show', $id),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal bergabung dengan kelompok: ' . $e->getMessage(),
            ]);
        }
    }

    public function kelompokLeave(string $id)
    {
        try {
            $kelompok = KelompokModel::findOrFail($id);
            $mahasiswaPeran = $kelompok->mahasiswa_perans()->where('nim', Auth::user()->mahasiswa->nim)->first();

            if ($mahasiswaPeran) {
                $mahasiswaPeran->kompetensis()->detach();
                $mahasiswaPeran->delete();
            }

            return response()->json([
                'status' => true,
                'message' => 'Berhasil keluar dari kelompok!',
                'redirect' => route('mahasiswa.kelompok.show', $id),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal keluar dari kelompok: ' . $e->getMessage(),
            ]);
        }
    }

    public function kelompokEdit(string $id)
    {
        return view('pages.mahasiswa.kelompok.modals.edit', [
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
            'lokasi_preferensis' => [
                'Kota' => 'Kota',
                'Provinsi' => 'Provinsi',
                'Nasional' => 'Nasional',
                'Internasional' => 'Internasional',
            ],
            'minats' => MinatModel::all(),
            'bidang_keahlians' => BidangKeahlianModel::all(),
            'jumlah_rekomendasis' => [
                '10' => '10',
                '20' => '20',
                '30' => '30',
                '40' => '40',
                '50' => '50',
            ],
            'weight_ranks' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ],
        ]);
    }

    public function kelompokUpdate(KelompokUpdateRequest $request, string $id)
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
                'redirect' => route('mahasiswa.kelompok.index'),
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui kelompok: ' . $e->getMessage(),
            ]);
        }
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

    public function kelompokSpk(SPKRequest $request)
    {
        try {
            $validated = $request->validated();
            $entropy = $request->input('entropy');

            // Validate jumlah rekomendasi - accept the new values
            $jumlahRekomendasi = (int) $validated['jumlah_rekomendasi'];
            if (!in_array($jumlahRekomendasi, [10, 20, 30, 40, 50])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Jumlah rekomendasi harus 10, 20, 30, 40, atau 50.',
                ], 422);
            }

            $kriteria_dm = [
                'lokasi_preferensi' => $validated['lokasi_preferensi_spk'],
                'minats' => $validated['minat_spk'],
                'bidang_keahlians' => $validated['bidang_keahlian_spk'],
                'kompetensis' => $validated['kompetensi_spk'],
            ];

            // Inisialisasi data
            $data_mahasiswa = [];
            $data_skoring = [];

            // MOORA
            $data_normalisasi = [];
            $bobot = [];
            $data_optimasi = [];
            $data_preferensi = [];

            // ENTROPY
            $data_normalisasi_entropy = [];
            $data_matriks_kriteria = [];
            $data_entropy = [];
            $data_dispersi = [];
            $data_normalisasi_dispersi = [];

            // Matriks keputusan - Load mahasiswa with necessary relationships for performance
            $mahasiswas = MahasiswaModel::with([
                'minats:minat_id',
                'bidang_keahlians:bidang_keahlian_id',
                'kompetensis:kompetensi_id',
                'perans.kelompok.lomba.prestasis'
            ])->get();

            if ($mahasiswas->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data mahasiswa yang ditemukan.',
                ], 404);
            }

            // Check if available mahasiswa count is less than requested
            $totalMahasiswa = $mahasiswas->count();
            if ($totalMahasiswa < $jumlahRekomendasi) {

                // Adjust to available count but continue processing
                $jumlahRekomendasi = $totalMahasiswa;
            }

            foreach ($mahasiswas as $mahasiswa) {
                $data_mahasiswa[] = [
                    'mahasiswa' => $mahasiswa,
                    'lokasi_preferensi' => $mahasiswa->lokasi_preferensi,
                    'minats' => $mahasiswa->minats->pluck('minat_id')->toArray(),
                    'bidang_keahlians' => $mahasiswa->bidang_keahlians->pluck('bidang_keahlian_id')->toArray(),
                    'kompetensis' => $mahasiswa->kompetensis->pluck('kompetensi_id')->toArray(),
                    'jumlah_lomba' => count($mahasiswa->perans),
                    'jumlah_prestasi' => $mahasiswa->perans->sum(function ($peran) {
                        // Check if kelompok exists
                        if (!$peran->kelompok) {
                            return 0;
                        }

                        // Check if lomba exists
                        if (!$peran->kelompok->lomba) {
                            return 0;
                        }

                        // Check if prestasis collection exists
                        if (!$peran->kelompok->lomba->prestasis) {
                            return 0;
                        }

                        return $peran->kelompok->lomba->prestasis->count();
                    }),
                ];
            }

            // Skoring
            foreach ($data_mahasiswa as $data) {
                $data_skoring[] = [
                    'mahasiswa' => $data['mahasiswa'],
                    'PL' => $data['lokasi_preferensi'] == $kriteria_dm['lokasi_preferensi'] ? 1 : 0,
                    'M' => count(array_intersect($data['minats'], $kriteria_dm['minats'])),
                    'BK' => count(array_intersect($data['bidang_keahlians'], $kriteria_dm['bidang_keahlians'])),
                    'K' => count(array_intersect($data['kompetensis'], $kriteria_dm['kompetensis'])),
                    'JL' => $data['jumlah_lomba'],
                    'JP' => $data['jumlah_prestasi'],
                ];
            }

            // Normalisasi
            $akar_kuadrat = [
                'PL' => sqrt(array_sum(array_map(function ($x) {
                    return $x * $x;
                }, array_column($data_skoring, 'PL')))),
                'M' => sqrt(array_sum(array_map(function ($x) {
                    return $x * $x;
                }, array_column($data_skoring, 'M')))),
                'BK' => sqrt(array_sum(array_map(function ($x) {
                    return $x * $x;
                }, array_column($data_skoring, 'BK')))),
                'K' => sqrt(array_sum(array_map(function ($x) {
                    return $x * $x;
                }, array_column($data_skoring, 'K')))),
                'JL' => sqrt(array_sum(array_map(function ($x) {
                    return $x * $x;
                }, array_column($data_skoring, 'JL')))),
                'JP' => sqrt(array_sum(array_map(function ($x) {
                    return $x * $x;
                }, array_column($data_skoring, 'JP')))),
            ];

            foreach ($data_skoring as $data) {
                $data_normalisasi[] = [
                    'mahasiswa' => $data['mahasiswa'],
                    'PL' => $data['PL'] > 0 ? $data['PL'] / $akar_kuadrat['PL'] : 0,
                    'M' => $data['M'] > 0 ? $data['M'] / $akar_kuadrat['M'] : 0,
                    'BK' => $data['BK'] > 0 ? $data['BK'] / $akar_kuadrat['BK'] : 0,
                    'K' => $data['K'] > 0 ? $data['K'] / $akar_kuadrat['K'] : 0,
                    'JL' => $data['JL'] > 0 ? $data['JL'] / $akar_kuadrat['JL'] : 0,
                    'JP' => $data['JP'] > 0 ? $data['JP'] / $akar_kuadrat['JP'] : 0,
                ];
            }

            // Menghitung nilai optimasi (perkalian dengan bobot)
            if ($entropy) {

                // Normalisasi untuk Entropy
                $max_columns = [
                    'PL' => max(array_column($data_skoring, 'PL')),
                    'M' => max(array_column($data_skoring, 'M')),
                    'BK' => max(array_column($data_skoring, 'BK')),
                    'K' => max(array_column($data_skoring, 'K')),
                    'JL' => max(array_column($data_skoring, 'JL')),
                    'JP' => max(array_column($data_skoring, 'JP')),
                ];

                foreach ($data_skoring as $data) {
                    $data_normalisasi_entropy[] = [
                        'mahasiswa' => $data['mahasiswa'],
                        'PL' => $data['PL'] / $max_columns['PL'],
                        'M' => $data['M'] / $max_columns['M'],
                        'BK' => $data['BK'] / $max_columns['BK'],
                        'K' => $data['K'] / $max_columns['K'],
                        'JL' => $data['JL'] / $max_columns['JL'],
                        'JP' => $data['JP'] / $max_columns['JP'],
                    ];
                }

                // Menentukan nilai matriks kriteria
                $sum_all_columns = [
                    'PL' => array_sum(array_column($data_normalisasi_entropy, 'PL')),
                    'M' => array_sum(array_column($data_normalisasi_entropy, 'M')),
                    'BK' => array_sum(array_column($data_normalisasi_entropy, 'BK')),
                    'K' => array_sum(array_column($data_normalisasi_entropy, 'K')),
                    'JL' => array_sum(array_column($data_normalisasi_entropy, 'JL')),
                    'JP' => array_sum(array_column($data_normalisasi_entropy, 'JP')),
                ];

                $total_sum = array_sum($sum_all_columns);

                foreach ($data_normalisasi_entropy as $data) {
                    $data_matriks_kriteria[] = [
                        'mahasiswa' => $data['mahasiswa'],
                        'PL' => $data['PL'] / $total_sum,
                        'M' => $data['M'] / $total_sum,
                        'BK' => $data['BK'] / $total_sum,
                        'K' => $data['K'] / $total_sum,
                        'JL' => $data['JL'] / $total_sum,
                        'JP' => $data['JP'] / $total_sum,
                    ];
                }

                // Menghitung nilai entropy
                $nilai_log_m = -1 / log(count($data_mahasiswa));

                $data_log_matriks_kriteria = [];
                foreach ($data_matriks_kriteria as $data) {
                    $data_log_matriks_kriteria[] = [
                        'mahasiswa' => $data['mahasiswa'],
                        'PL' => $data['PL'] > 0 ? log($data['PL']) : 0,
                        'M' => $data['M'] > 0 ? log($data['M']) : 0,
                        'BK' => $data['BK'] > 0 ? log($data['BK']) : 0,
                        'K' => $data['K'] > 0 ? log($data['K']) : 0,
                        'JL' => $data['JL'] > 0 ? log($data['JL']) : 0,
                        'JP' => $data['JP'] > 0 ? log($data['JP']) : 0,
                    ];
                }

                $data_log_kali_matriks = [];
                foreach ($data_matriks_kriteria as $i => $data) {
                    $log_data = $data_log_matriks_kriteria[$i];
                    $data_log_kali_matriks[] = [
                        'mahasiswa' => $data['mahasiswa'],
                        'PL' => $data['PL'] * $log_data['PL'],
                        'M' => $data['M'] * $log_data['M'],
                        'BK' => $data['BK'] * $log_data['BK'],
                        'K' => $data['K'] * $log_data['K'],
                        'JL' => $data['JL'] * $log_data['JL'],
                        'JP' => $data['JP'] * $log_data['JP'],
                    ];
                }

                // Calculate sum for each column
                $data_sum_log_kali = [
                    'PL' => array_sum(array_column($data_log_kali_matriks, 'PL')),
                    'M' => array_sum(array_column($data_log_kali_matriks, 'M')),
                    'BK' => array_sum(array_column($data_log_kali_matriks, 'BK')),
                    'K' => array_sum(array_column($data_log_kali_matriks, 'K')),
                    'JL' => array_sum(array_column($data_log_kali_matriks, 'JL')),
                    'JP' => array_sum(array_column($data_log_kali_matriks, 'JP')),
                ];

                // Menghitung nilai entropy
                $data_entropy = [
                    'PL' => $nilai_log_m * $data_sum_log_kali['PL'],
                    'M' => $nilai_log_m * $data_sum_log_kali['M'],
                    'BK' => $nilai_log_m * $data_sum_log_kali['BK'],
                    'K' => $nilai_log_m * $data_sum_log_kali['K'],
                    'JL' => $nilai_log_m * $data_sum_log_kali['JL'],
                    'JP' => $nilai_log_m * $data_sum_log_kali['JP'],
                ];

                // Menghitung nilai dispersi
                $data_dispersi = [
                    'PL' => 1 - $data_entropy['PL'],
                    'M' => 1 - $data_entropy['M'],
                    'BK' => 1 - $data_entropy['BK'],
                    'K' => 1 - $data_entropy['K'],
                    'JL' => 1 - $data_entropy['JL'],
                    'JP' => 1 - $data_entropy['JP'],
                ];

                // Normalisasi nilai dispersi
                $sum_dispersi = array_sum($data_dispersi);
                $data_normalisasi_dispersi = [
                    'PL' => $data_dispersi['PL'] / $sum_dispersi,
                    'M' => $data_dispersi['M'] / $sum_dispersi,
                    'BK' => $data_dispersi['BK'] / $sum_dispersi,
                    'K' => $data_dispersi['K'] / $sum_dispersi,
                    'JL' => $data_dispersi['JL'] / $sum_dispersi,
                    'JP' => $data_dispersi['JP'] / $sum_dispersi,
                ];

                $bobot = [
                    'PL' => $data_normalisasi_dispersi['PL'],
                    'M' => $data_normalisasi_dispersi['M'],
                    'BK' => $data_normalisasi_dispersi['BK'],
                    'K' => $data_normalisasi_dispersi['K'],
                    'JL' => $data_normalisasi_dispersi['JL'],
                    'JP' => $data_normalisasi_dispersi['JP'],
                ];

            } else {
                // Get rank inputs (1 = highest priority, 6 = lowest priority)
                $ranks = [
                    'PL' => (int) $validated['bobot_lokasi_preferensi_spk'],
                    'M' => (int) $validated['bobot_minat_spk'],
                    'BK' => (int) $validated['bobot_bidang_keahlian_spk'],
                    'K' => (int) $validated['bobot_kompetensi_spk'],
                    'JL' => (int) $validated['bobot_jumlah_lomba_spk'],
                    'JP' => (int) $validated['bobot_jumlah_prestasi_spk'],
                ];

                // Convert ranks to weights (invert so 1 = highest weight)
                $weights = [];
                foreach ($ranks as $key => $rank) {
                    $weights[$key] = 7 - $rank; // 1 becomes 6, 2 becomes 5, ..., 6 becomes 1
                }

                // Calculate proportional weights that sum to 1
                $totalWeights = array_sum($weights);
                $bobot = [
                    'PL' => $weights['PL'] / $totalWeights,
                    'M' => $weights['M'] / $totalWeights,
                    'BK' => $weights['BK'] / $totalWeights,
                    'K' => $weights['K'] / $totalWeights,
                    'JL' => $weights['JL'] / $totalWeights,
                    'JP' => $weights['JP'] / $totalWeights,
                ];
            }

            foreach ($data_normalisasi as $data) {
                $data_optimasi[] = [
                    'mahasiswa' => $data['mahasiswa'],
                    'PL' => $data['PL'] * $bobot['PL'],
                    'M' => $data['M'] * $bobot['M'],
                    'BK' => $data['BK'] * $bobot['BK'],
                    'K' => $data['K'] * $bobot['K'],
                    'JL' => $data['JL'] * $bobot['JL'],
                    'JP' => $data['JP'] * $bobot['JP'],
                ];
            }

            // Menghitung nilai preferensi MOORA
            foreach ($data_optimasi as $data) {
                $data_preferensi[] = [
                    'mahasiswa' => $data['mahasiswa'],
                    'PL' => $data['PL'],
                    'M' => $data['M'],
                    'BK' => $data['BK'],
                    'K' => $data['K'],
                    'JL' => $data['JL'],
                    'JP' => $data['JP'],
                    'nilai_preferensi' => $data['PL'] + $data['M'] + $data['BK'] + $data['K'] + $data['JL'] + $data['JP'],
                ];
            }

            // Perangkingan MOORA
            usort($data_preferensi, function ($a, $b) {
                return $b['nilai_preferensi'] <=> $a['nilai_preferensi'];
            });

            // Limit results to requested number of recommendations
            $data_preferensi = array_slice($data_preferensi, 0, $jumlahRekomendasi);

            // Return only essential data for the view modal
            return response()->json([
                'status' => true,
                'message' => 'SPK berhasil dilakukan. Menampilkan ' . count($data_preferensi) . ' rekomendasi mahasiswa.',
                'data' => $data_preferensi,
                'matrices' => [
                    'bobot' => $bobot
                ]
            ]);

        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Gagal melakukan SPK: ' . $e->getMessage(),
            ]);
        }
    }

    public function dataLombaIndex()
    {
        // Auto-update status based on dates
        $this->updateLombaStatus();

        return view('pages.mahasiswa.data-lomba.index', [
            'breadcrumbs' => [
                ['name' => 'Data Lomba', 'url' => route('mahasiswa.data-lomba.index')],
            ],
            'title' => 'Data Lomba',
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
                'Akan datang' => 'Akan datang',
                'Sedang berlangsung' => 'Sedang berlangsung',
                'Berakhir' => 'Berakhir',
                'Ditolak' => 'Ditolak',
            ],
        ]);
    }

    public function dataLombaData(Request $request)
    {
        $user = Auth::user();
        $query = LombaModel::with(['periode']);

        // Apply search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('lomba_nama', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('lomba_penyelenggara', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Apply category filter
        if ($request->filled('kategori') && $request->kategori !== '') {
            $query->where('lomba_kategori', $request->kategori);
        }

        // Apply location filter
        if ($request->filled('lokasi') && $request->lokasi !== '') {
            $query->where('lomba_lokasi_preferensi', $request->lokasi);
        }

        // Apply level filter
        if ($request->filled('tingkat') && $request->tingkat !== '') {
            $query->where('lomba_tingkat', $request->tingkat);
        }

        // Apply status filter
        if ($request->filled('status') && $request->status !== '') {
            $query->where('lomba_status', $request->status);
        }

        // Apply periode aktif filter
        if ($request->filled('periode_aktif') && $request->periode_aktif == 'true') {
            $currentYear = Carbon::now()->year;
            $query->whereHas('periode', function ($periodeQuery) use ($currentYear) {
                $periodeQuery->where(function ($q) use ($currentYear) {
                    $q->where('periode_tahun_awal', '<=', $currentYear)
                        ->where('periode_tahun_akhir', '>=', $currentYear);
                });
            });
        }

        $lombas = $query->orderBy('created_at', 'desc')->get();

        // Auto-update status based on dates
        $this->updateLombaStatus();

        // Return the partial view as HTML
        $html = view('pages.mahasiswa.data-lomba.partials.lomba-grid', compact('lombas'))->render();

        return response()->json([
            'status' => true,
            'html' => $html,
            'count' => $lombas->count(),
        ]);
    }

    public function dataLombaShow(string $id)
    {
        $lomba = LombaModel::with(['periode'])->findOrFail($id);

        return view('pages.mahasiswa.data-lomba.show', [
            'breadcrumbs' => [
                ['name' => 'Data Lomba', 'url' => route('mahasiswa.data-lomba.index')],
                ['name' => 'Detail Lomba', 'url' => route('mahasiswa.data-lomba.show', $id)],
            ],
            'title' => 'Detail Lomba',
            'lomba' => $lomba
        ]);
    }

    public function dataLombaCreate()
    {
        // Ambil periode yang masih aktif berdasarkan tahun
        $currentYear = Carbon::now()->year;
        $periodes = PeriodeModel::where(function ($query) use ($currentYear) {
            $query->where('periode_tahun_awal', '<=', $currentYear)
                ->where('periode_tahun_akhir', '>=', $currentYear);
        })
            ->orderBy('periode_nama', 'asc')
            ->get();

        return view('pages.mahasiswa.data-lomba.modals.create', [
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
            'lokasi_preferensis' => [
                'Kota' => 'Kota',
                'Provinsi' => 'Provinsi',
                'Nasional' => 'Nasional',
                'Internasional' => 'Internasional',
            ],
            'periodes' => $periodes,
        ]);
    }

    public function dataLombaStore(Request $request)
    {
        // Validasi input sesuai dengan migration
        $request->validate([
            'lomba_nama' => 'required|string|max:255',
            'lomba_kategori' => 'required|string',
            'lomba_penyelenggara' => 'required|string|max:255',
            'lomba_lokasi_preferensi' => 'required|string',
            'lomba_tingkat' => 'required|string',
            'lomba_persyaratan' => 'required|string',
            'lomba_mulai_pendaftaran' => 'required|date',
            'lomba_akhir_pendaftaran' => 'required|date|after:lomba_mulai_pendaftaran',
            'lomba_link_registrasi' => 'required|url',
            'lomba_mulai_pelaksanaan' => 'required|date|after:lomba_akhir_pendaftaran',
            'lomba_selesai_pelaksanaan' => 'required|date|after:lomba_mulai_pelaksanaan',
            'lomba_ukuran_kelompok' => 'required|integer|min:1|max:10',
            'lomba_poster_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'periode_id' => 'required|exists:m_periode,periode_id',
        ], [
            'lomba_nama.required' => 'Nama lomba wajib diisi.',
            'lomba_kategori.required' => 'Kategori wajib dipilih.',
            'lomba_penyelenggara.required' => 'Penyelenggara wajib diisi.',
            'lomba_lokasi_preferensi.required' => 'Lokasi preferensi wajib dipilih.',
            'lomba_tingkat.required' => 'Tingkat wajib dipilih.',
            'lomba_persyaratan.required' => 'Persyaratan lomba wajib diisi.',
            'lomba_mulai_pendaftaran.required' => 'Tanggal mulai pendaftaran wajib diisi.',
            'lomba_akhir_pendaftaran.required' => 'Tanggal akhir pendaftaran wajib diisi.',
            'lomba_akhir_pendaftaran.after' => 'Tanggal akhir pendaftaran harus setelah tanggal mulai pendaftaran.',
            'lomba_link_registrasi.required' => 'Link registrasi wajib diisi.',
            'lomba_link_registrasi.url' => 'Format URL tidak valid.',
            'lomba_mulai_pelaksanaan.required' => 'Tanggal mulai pelaksanaan wajib diisi.',
            'lomba_mulai_pelaksanaan.after' => 'Tanggal mulai pelaksanaan harus setelah tanggal akhir pendaftaran.',
            'lomba_selesai_pelaksanaan.required' => 'Tanggal selesai pelaksanaan wajib diisi.',
            'lomba_selesai_pelaksanaan.after' => 'Tanggal selesai pelaksanaan harus setelah tanggal mulai pelaksanaan.',
            'lomba_ukuran_kelompok.required' => 'Ukuran kelompok wajib diisi.',
            'lomba_ukuran_kelompok.min' => 'Ukuran kelompok minimal 1.',
            'lomba_ukuran_kelompok.max' => 'Ukuran kelompok maksimal 10.',
            'periode_id.required' => 'Periode wajib dipilih.',
            'periode_id.exists' => 'Periode yang dipilih tidak valid.',
        ]);

        try {
            // Determine status based on dates
            // $now = Carbon::now();
            // $mulaiPendaftaran = Carbon::parse($request->lomba_mulai_pendaftaran);
            // $akhirPendaftaran = Carbon::parse($request->lomba_akhir_pendaftaran);
            // $selesaiPelaksanaan = Carbon::parse($request->lomba_selesai_pelaksanaan);

            // $status = 'Akan datang';
            // if ($now->gte($mulaiPendaftaran) && $now->lte($akhirPendaftaran)) {
            //     $status = 'Sedang berlangsung';
            // } elseif ($now->gt($selesaiPelaksanaan)) {
            //     $status = 'Berakhir';
            // }

            // Buat lomba baru
            $data = [
                'lomba_nama' => $request->lomba_nama,
                'lomba_kategori' => $request->lomba_kategori,
                'lomba_penyelenggara' => $request->lomba_penyelenggara,
                'lomba_lokasi_preferensi' => $request->lomba_lokasi_preferensi,
                'lomba_tingkat' => $request->lomba_tingkat,
                'lomba_persyaratan' => $request->lomba_persyaratan,
                'lomba_mulai_pendaftaran' => $request->lomba_mulai_pendaftaran,
                'lomba_akhir_pendaftaran' => $request->lomba_akhir_pendaftaran,
                'lomba_link_registrasi' => $request->lomba_link_registrasi,
                'lomba_mulai_pelaksanaan' => $request->lomba_mulai_pelaksanaan,
                'lomba_selesai_pelaksanaan' => $request->lomba_selesai_pelaksanaan,
                'lomba_ukuran_kelompok' => $request->lomba_ukuran_kelompok,
                'lomba_status' => 'Akan datang',
                'periode_id' => $request->periode_id,
                'created_by' => auth()->id(),
                'is_verified' => false,
            ];

            if ($request->hasFile('lomba_poster_url')) {
                $data['lomba_poster_url'] = $request->file('lomba_poster_url')
                    ->store('prestasi_posters', 'public');
            }

            LombaModel::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Lomba berhasil ditambahkan.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan lomba.',
                'msgField' => []
            ], 500);
        }
    }

    public function dataLombaEdit(string $id)
    {
        $lomba = LombaModel::with(['periode'])->findOrFail($id);

        // Ambil periode yang masih aktif berdasarkan tahun
        $currentYear = Carbon::now()->year;
        $periodes = PeriodeModel::where(function ($query) use ($currentYear) {
            $query->where('periode_tahun_awal', '<=', $currentYear)
                ->where('periode_tahun_akhir', '>=', $currentYear);
        })
            ->orderBy('periode_nama', 'asc')
            ->get();

        return view('pages.mahasiswa.data-lomba.partials.form', [
            'action' => route('mahasiswa.data-lomba.update', $lomba->lomba_id),
            'method' => 'PUT',
            'buttonText' => 'Update Lomba',
            'buttonIcon' => 'fa-solid fa-save',
            'lomba' => $lomba,
            'periodes' => $periodes,
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
            'lokasi_preferensis' => [
                'Kota' => 'Kota',
                'Provinsi' => 'Provinsi',
                'Nasional' => 'Nasional',
                'Internasional' => 'Internasional',
            ],
        ]);
    }

    public function dataLombaUpdate(Request $request, string $id)
    {
        $lomba = LombaModel::findOrFail($id);

        // Validasi input sesuai dengan migration
        $request->validate([
            'lomba_nama' => 'required|string|max:255',
            'lomba_kategori' => 'required|string',
            'lomba_penyelenggara' => 'required|string|max:255',
            'lomba_lokasi_preferensi' => 'required|string',
            'lomba_tingkat' => 'required|string',
            'lomba_persyaratan' => 'required|string',
            'lomba_mulai_pendaftaran' => 'required|date',
            'lomba_akhir_pendaftaran' => 'required|date|after:lomba_mulai_pendaftaran',
            'lomba_link_registrasi' => 'required|url',
            'lomba_mulai_pelaksanaan' => 'required|date|after:lomba_akhir_pendaftaran',
            'lomba_selesai_pelaksanaan' => 'required|date|after:lomba_mulai_pelaksanaan',
            'lomba_ukuran_kelompok' => 'required|integer|min:1|max:10',
            'periode_id' => 'required|exists:m_periode,periode_id',
        ], [
            'lomba_nama.required' => 'Nama lomba wajib diisi.',
            'lomba_kategori.required' => 'Kategori wajib dipilih.',
            'lomba_penyelenggara.required' => 'Penyelenggara wajib diisi.',
            'lomba_lokasi_preferensi.required' => 'Lokasi preferensi wajib dipilih.',
            'lomba_tingkat.required' => 'Tingkat wajib dipilih.',
            'lomba_persyaratan.required' => 'Persyaratan lomba wajib diisi.',
            'lomba_mulai_pendaftaran.required' => 'Tanggal mulai pendaftaran wajib diisi.',
            'lomba_akhir_pendaftaran.required' => 'Tanggal akhir pendaftaran wajib diisi.',
            'lomba_akhir_pendaftaran.after' => 'Tanggal akhir pendaftaran harus setelah tanggal mulai pendaftaran.',
            'lomba_link_registrasi.required' => 'Link registrasi wajib diisi.',
            'lomba_link_registrasi.url' => 'Format URL tidak valid.',
            'lomba_mulai_pelaksanaan.required' => 'Tanggal mulai pelaksanaan wajib diisi.',
            'lomba_mulai_pelaksanaan.after' => 'Tanggal mulai pelaksanaan harus setelah tanggal akhir pendaftaran.',
            'lomba_selesai_pelaksanaan.required' => 'Tanggal selesai pelaksanaan wajib diisi.',
            'lomba_selesai_pelaksanaan.after' => 'Tanggal selesai pelaksanaan harus setelah tanggal mulai pelaksanaan.',
            'lomba_ukuran_kelompok.required' => 'Ukuran kelompok wajib diisi.',
            'lomba_ukuran_kelompok.min' => 'Ukuran kelompok minimal 1.',
            'lomba_ukuran_kelompok.max' => 'Ukuran kelompok maksimal 10.',
            'periode_id.required' => 'Periode wajib dipilih.',
            'periode_id.exists' => 'Periode yang dipilih tidak valid.',
        ]);

        try {
            // Determine status based on dates
            $now = Carbon::now();
            $mulaiPendaftaran = Carbon::parse($request->lomba_mulai_pendaftaran);
            $akhirPendaftaran = Carbon::parse($request->lomba_akhir_pendaftaran);
            $selesaiPelaksanaan = Carbon::parse($request->lomba_selesai_pelaksanaan);

            $status = 'Akan datang';
            if ($now->gte($mulaiPendaftaran) && $now->lte($akhirPendaftaran)) {
                $status = 'Sedang berlangsung';
            } elseif ($now->gt($selesaiPelaksanaan)) {
                $status = 'Berakhir';
            }

            $lomba->update([
                'lomba_nama' => $request->lomba_nama,
                'lomba_kategori' => $request->lomba_kategori,
                'lomba_penyelenggara' => $request->lomba_penyelenggara,
                'lomba_lokasi_preferensi' => $request->lomba_lokasi_preferensi,
                'lomba_tingkat' => $request->lomba_tingkat,
                'lomba_persyaratan' => $request->lomba_persyaratan,
                'lomba_mulai_pendaftaran' => $request->lomba_mulai_pendaftaran,
                'lomba_akhir_pendaftaran' => $request->lomba_akhir_pendaftaran,
                'lomba_link_registrasi' => $request->lomba_link_registrasi,
                'lomba_mulai_pelaksanaan' => $request->lomba_mulai_pelaksanaan,
                'lomba_selesai_pelaksanaan' => $request->lomba_selesai_pelaksanaan,
                'lomba_ukuran_kelompok' => $request->lomba_ukuran_kelompok,
                'lomba_status' => $status,
                'periode_id' => $request->periode_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Lomba berhasil diupdate.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengupdate lomba.',
                'msgField' => []
            ], 500);
        }
    }

    public function dataLombaDelete(string $id)
    {
        $lomba = LombaModel::findOrFail($id);

        return view('pages.mahasiswa.data-lomba.modals.delete', [
            'lomba' => $lomba
        ]);
    }

    public function dataLombaDestroy(string $id)
    {
        $lomba = LombaModel::findOrFail($id);

        // Check if user can delete this lomba
        if (!$this->canEditLomba($lomba)) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus lomba ini.');
        }

        try {
            // Check if lomba has any related kelompok
            if ($lomba->kelompoks()->count() > 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Lomba tidak dapat dihapus karena sudah memiliki kelompok yang terdaftar.'
                ], 400);
            }

            $lomba->delete();

            return response()->json([
                'status' => true,
                'message' => 'Lomba berhasil dihapus.',
                'redirect' => route('mahasiswa.data-lomba.index')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus lomba: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if user can edit/delete lomba
     */
    private function canEditLomba($lomba)
    {
        $user = Auth::user();

        // Only creator can edit their own lomba
        if ($lomba->created_by === $user->user_id) {
            // Can only edit if status is still 'menunggu_verifikasi'
            return $lomba->lomba_status === 'Akan datang';
        }

        return false;
    }

    /**
     * Auto-update lomba status based on dates
     */
    private function updateLombaStatus()
    {
        $now = Carbon::now();

        // Hanya update lomba yang sudah diverifikasi
        LombaModel::where('lomba_status', 'Akan datang')
            ->where('is_verified', true) // Tambahkan kondisi ini
            ->where('lomba_mulai_pendaftaran', '<=', $now)
            ->where('lomba_akhir_pendaftaran', '>=', $now)
            ->update(['lomba_status' => 'Sedang berlangsung']);

        LombaModel::whereIn('lomba_status', ['Akan datang', 'Sedang berlangsung'])
            ->where('is_verified', true) // Tambahkan kondisi ini
            ->where('lomba_selesai_pelaksanaan', '<', $now)
            ->update(['lomba_status' => 'Berakhir']);
    }

    /**
     * Check if user can view lomba
     */
    private function canViewLomba($lomba)
    {
        $user = Auth::user();

        // Mahasiswa can only view verified lombas
        if ($lomba->lomba_status !== 'menunggu_verifikasi') {
            return true;
        }

        // Creator can view their own lomba even if not verified yet
        if ($lomba->created_by === $user->user_id) {
            return true;
        }

        return false;
    }
}
