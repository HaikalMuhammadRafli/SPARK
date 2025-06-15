<?php

namespace App\Http\Controllers;

use App\Http\Requests\LombaStoreRequest;
use App\Http\Requests\LombaUpdateRequest;
use App\Models\LombaModel;
use App\Models\PeriodeModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LombaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Lomba', 'url' => route('admin.manajemen.lomba.index')],
        ];

        return view('lomba.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Manajemen Lomba',
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
            'status_options' => [
                'Akan datang' => 'Akan datang',
                'Sedang berlangsung' => 'Sedang berlangsung',
                'Berakhir' => 'Berakhir',
                'Ditolak' => 'Ditolak',
            ],
        ]);
    }

    public function data(Request $request)
    {
        // Auto-update status based on dates
        $this->updateLombaStatus();

        $query = LombaModel::with('periode');

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

        // Return the partial view as HTML
        $html = view('lomba.partials.lomba-table', compact('lombas'))->render();

        return response()->json([
            'status' => true,
            'html' => $html,
            'count' => $lombas->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil periode yang masih aktif berdasarkan tahun
        $currentYear = Carbon::now()->year;
        $periodes = PeriodeModel::where(function ($query) use ($currentYear) {
            $query->where('periode_tahun_awal', '<=', $currentYear)
                  ->where('periode_tahun_akhir', '>=', $currentYear);
        })
        ->orderBy('periode_nama', 'asc')
        ->get();

        return view('lomba.modals.create', [
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            'lomba_mulai_pelaksanaan' => 'required|date|after_or_equal:lomba_akhir_pendaftaran',
            'lomba_selesai_pelaksanaan' => 'required|date|after:lomba_mulai_pelaksanaan',
            'lomba_ukuran_kelompok' => 'required|integer|min:1|max:20',
            'lomba_poster_url' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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
            'lomba_mulai_pelaksanaan.after_or_equal' => 'Tanggal mulai pelaksanaan harus setelah atau sama dengan tanggal akhir pendaftaran.',
            'lomba_selesai_pelaksanaan.required' => 'Tanggal selesai pelaksanaan wajib diisi.',
            'lomba_selesai_pelaksanaan.after' => 'Tanggal selesai pelaksanaan harus setelah tanggal mulai pelaksanaan.',
            'lomba_ukuran_kelompok.required' => 'Ukuran kelompok wajib diisi.',
            'lomba_ukuran_kelompok.min' => 'Ukuran kelompok minimal 1.',
            'lomba_ukuran_kelompok.max' => 'Ukuran kelompok maksimal 20.',
            'lomba_poster_url.required' => 'Poster lomba wajib diupload.',
            'lomba_poster_url.image' => 'File harus berupa gambar.',
            'lomba_poster_url.mimes' => 'Format file harus JPG, JPEG, atau PNG.',
            'lomba_poster_url.max' => 'Ukuran file maksimal 2MB.',
            'periode_id.required' => 'Periode wajib dipilih.',
            'periode_id.exists' => 'Periode yang dipilih tidak valid.',
        ]);

        try {
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
                'lomba_ukuran_kelompok' => (int) $request->lomba_ukuran_kelompok,
                'lomba_status' => $status,
                'periode_id' => $request->periode_id,
            ];

            // Upload poster ke folder prestasi_posters dengan Storage::disk('public')
            if ($request->hasFile('lomba_poster_url')) {
                $data['lomba_poster_url'] = $request->file('lomba_poster_url')
                    ->store('prestasi_posters', 'public');
            }

            LombaModel::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Data lomba berhasil ditambahkan!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan lomba: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lomba = LombaModel::with(['periode'])->findOrFail($id);

        return view('lomba.detail', [
            'title' => 'Detail Lomba',
            'breadcrumbs' => [
                ['name' => 'Lomba', 'url' => route('admin.manajemen.lomba.index')],
                ['name' => 'Detail'],
            ],
            'lomba' => $lomba,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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

        return view('lomba.modals.edit', [
            'title' => 'Edit Lomba',
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $lomba = LombaModel::findOrFail($id);

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
            'lomba_mulai_pelaksanaan' => 'required|date|after_or_equal:lomba_akhir_pendaftaran',
            'lomba_selesai_pelaksanaan' => 'required|date|after:lomba_mulai_pelaksanaan',
            'lomba_ukuran_kelompok' => 'required|integer|min:1|max:20',
            'lomba_poster_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
            'lomba_mulai_pelaksanaan.after_or_equal' => 'Tanggal mulai pelaksanaan harus setelah atau sama dengan tanggal akhir pendaftaran.',
            'lomba_selesai_pelaksanaan.required' => 'Tanggal selesai pelaksanaan wajib diisi.',
            'lomba_selesai_pelaksanaan.after' => 'Tanggal selesai pelaksanaan harus setelah tanggal mulai pelaksanaan.',
            'lomba_ukuran_kelompok.required' => 'Ukuran kelompok wajib diisi.',
            'lomba_ukuran_kelompok.min' => 'Ukuran kelompok minimal 1.',
            'lomba_ukuran_kelompok.max' => 'Ukuran kelompok maksimal 20.',
            'lomba_poster_url.image' => 'File harus berupa gambar.',
            'lomba_poster_url.mimes' => 'Format file harus JPG, JPEG, atau PNG.',
            'lomba_poster_url.max' => 'Ukuran file maksimal 2MB.',
            'periode_id.required' => 'Periode wajib dipilih.',
            'periode_id.exists' => 'Periode yang dipilih tidak valid.',
        ]);

        try {
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
                'lomba_ukuran_kelompok' => (int) $request->lomba_ukuran_kelompok,
                'lomba_status' => $status,
                'periode_id' => $request->periode_id,
            ];

            // Jika ada file poster baru, hapus yang lama lalu simpan yang baru
            if ($request->hasFile('lomba_poster_url')) {
                if ($lomba->lomba_poster_url && Storage::disk('public')->exists($lomba->lomba_poster_url)) {
                    Storage::disk('public')->delete($lomba->lomba_poster_url);
                }
                $data['lomba_poster_url'] = $request->file('lomba_poster_url')->store('prestasi_posters', 'public');
            }

            $lomba->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Data lomba berhasil diperbarui!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengupdate lomba: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function delete(string $id)
    {
        return view('lomba.modals.delete', [
            'lomba' => LombaModel::findOrFail($id),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $lomba = LombaModel::findOrFail($id);
            
            // Check if lomba has any related kelompok
            if ($lomba->kelompoks()->count() > 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Lomba tidak dapat dihapus karena sudah memiliki kelompok yang terdaftar.'
                ], 400);
            }
            
            // Delete poster file if exists
            if ($lomba->lomba_poster_url && Storage::disk('public')->exists($lomba->lomba_poster_url)) {
                Storage::disk('public')->delete($lomba->lomba_poster_url);
            }
            
            $lomba->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data lomba berhasil dihapus!',
                'redirect' => route('admin.manajemen.lomba.index')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus lomba: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle poster file upload with validation
     */
    private function handlePosterUpload($file)
    {
        // Validate file
        if (!$file->isValid()) {
            throw new Exception('File poster tidak valid!');
        }
        
        // Check file size (max 2MB)
        if ($file->getSize() > 2 * 1024 * 1024) {
            throw new Exception('Ukuran file poster maksimal 2MB!');
        }
        
        // Check file type
        $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new Exception('Format file harus JPG, JPEG, atau PNG!');
        }
        
        // Generate unique filename
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Store file
         $path = $file->storeAs('lomba/posters', $fileName, 'public');
        
        if (!$path) {
            throw new Exception('Gagal menyimpan file poster!');
        }
        
        return $path;
    }

    /**
     * Auto-update lomba status based on dates
     */
    private function updateLombaStatus()
    {
        $now = Carbon::now();

        // Update to 'Sedang berlangsung' if within registration period
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
     * Determine lomba status based on dates
     */
    private function determineStatus($startRegistration, $endRegistration, $startEvent = null, $endEvent = null)
    {
        $now = now()->format('Y-m-d');
        
        // If event has ended
        if ($endEvent && $now > $endEvent) {
            return 'Berakhir';
        }
        
        // If event is ongoing
        if ($startEvent && $now >= $startEvent) {
            return 'Sedang berlangsung';
        }
        
        // If registration period is active
        if ($now >= $startRegistration && $now <= $endRegistration) {
            return 'Akan datang';
        }
        
        // If registration has ended but event hasn't started
        if ($now > $endRegistration) {
            return 'Berakhir';
        }
        
        return 'Akan datang';
    }
}