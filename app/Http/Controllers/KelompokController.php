<?php

namespace App\Http\Controllers;

use App\Http\Requests\KelompokStoreRequest;
use App\Http\Requests\KelompokUpdateRequest;
use App\Http\Requests\SPKRequest;
use App\Models\BidangKeahlianModel;
use App\Models\DosenPembimbingModel;
use App\Models\DosenPembimbingPeranModel;
use App\Models\KelompokModel;
use App\Models\KompetensiModel;
use App\Models\LombaModel;
use App\Models\MahasiswaModel;
use App\Models\MahasiswaPeranModel;
use App\Models\MinatModel;
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

    public function data(Request $request)
    {
        $query = KelompokModel::with(['lomba', 'mahasiswa_perans.mahasiswa', 'dosen_pembimbing_peran.dosen_pembimbing']);

        // Apply filters
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

        $kelompoks = $query->get();

        return response()->json([
            'status' => true,
            'data' => $kelompoks->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'lomba_nama' => $item->lomba->lomba_nama,
                    'lomba_kategori' => $item->lomba->lomba_kategori ?? '',
                    'lomba_tingkat' => $item->lomba->lomba_tingkat ?? '',
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
        return view('kelompok.show', [
            'title' => 'Detail Kelompok',
            'breadcrumbs' => [
                ['name' => 'Kelompok', 'url' => route('admin.manajemen.kelompok.index')],
                ['name' => 'Detail'],
            ],
            'kelompok' => KelompokModel::findOrFail($id),
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
                'redirect' => route('admin.manajemen.kelompok.index'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus kelompok: ' . $e->getMessage(),
            ]);
        }
    }

    public function spk(SPKRequest $request)
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
}
