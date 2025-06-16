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
use Exception;
use App\Models\PeriodeModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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

        // Update to 'Sedang berlangsung' if registration period has started
        LombaModel::where('lomba_status', 'Akan datang')
            ->where('lomba_mulai_pendaftaran', '<=', $now)
            ->where('lomba_akhir_pendaftaran', '>=', $now)
            ->update(['lomba_status' => 'Sedang berlangsung']);

        // Update to 'Berakhir' if execution period has ended
        LombaModel::whereIn('lomba_status', ['Akan datang', 'Sedang berlangsung'])
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
