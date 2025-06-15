<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\PrestasiModel;
use App\Models\MahasiswaModel;
use App\Models\KelompokModel;
use App\Models\MinatModel;
use App\Models\LombaModel;
use App\Models\KompetensiModel;
use Illuminate\Support\Facades\DB;
use App\Exports\PrestasiExport;
use App\Models\LaporanAnalisisPrestasi;
use App\Http\Requests\StoreLaporanAnalisisPrestasiRequest;
use App\Http\Requests\UpdateLaporanAnalisisPrestasiRequest;

class LaporanAnalisisPrestasiController extends Controller
{
    // Menampilkan semua laporan
    public function indexView()
    {
        // Data laporan prestasi yang sudah diambil
        $laporans = LaporanAnalisisPrestasi::with('kelompok')->get();

        // Menentukan breadcrumb (sesuaikan dengan struktur aplikasi kamu)
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard')], // breadcrumb pertama
            ['name' => 'Laporan Prestasi', 'url' => route('admin.laporan.index')], // breadcrumb kedua
        ];

        // Kalkulasi jumlah prestasi berdasarkan kategori minat
        $minatStats = MinatModel::all()->map(function ($minat) use ($laporans) {
            return [
                'minat' => $minat->minat_nama,
                'jumlah' => $laporans->where('kompetensi_id', $minat->minat_id)->count(),
            ];
        });

        // Statistik berdasarkan kategori lomba
        $lombaStats = LombaModel::all()->map(function ($lomba) use ($laporans) {
            return [
                'lomba' => $lomba->nama,
                'jumlah' => $laporans->where('lomba_id', $lomba->lomba_id)->count(),
            ];
        });

        // Mengirim data ke view
        return view('LaporanAnalisisPrestasi.index', compact('laporans', 'breadcrumbs', 'minatStats', 'lombaStats'));
    }

    // API endpoint untuk mendapatkan semua laporan
    public function index()
    {
        $laporans = LaporanAnalisisPrestasi::with(['kelompok', 'mahasiswa', 'lomba'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $laporans
        ]);
    }

    // Menyimpan laporan baru
    public function store(Request $request)
    {
        $request->validate([
            'prestasi_juara' => 'required|string|max:255',
            'prestasi_surat_tugas_url' => 'required|string',
            'prestasi_poster_url' => 'required|string',
            'prestasi_foto_juara_url' => 'required|string',
            'prestasi_proposal_url' => 'required|string',
            'prestasi_sertifikat_url' => 'required|string',
            'lomba_id' => 'required|integer',
            'nim' => 'required|string',
        ]);

        $laporan = LaporanAnalisisPrestasi::create($request->all());
        return response()->json(['status' => true, 'data' => $laporan], 201);
    }

    // Menampilkan laporan tertentu
    public function show($id)
    {
        $laporan = LaporanAnalisisPrestasi::find($id);

        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Laporan tidak ditemukan'], 404);
        }

        return response()->json(['status' => true, 'data' => $laporan]);
    }

    // Mengupdate laporan
   public function update(Request $request, $id)
{
    // Validasi status
    $request->validate([
        'prestasi_status' => 'required|in:Disetujui,Pending,Tidak Valid', // Validasi untuk status yang valid
    ]);

    // Mencari laporan berdasarkan ID
    $laporan = LaporanAnalisisPrestasi::find($id);

    if (!$laporan) {
        return response()->json(['status' => false, 'message' => 'Laporan tidak ditemukan'], 404);
    }

    // Update status prestasi
    $laporan->prestasi_status = $request->prestasi_status;
    $laporan->save(); // Simpan perubahan ke database

    return response()->json(['status' => true, 'data' => $laporan]);
}


    // Menghapus laporan
    public function destroy($id)
    {
        $laporan = LaporanAnalisisPrestasi::find($id);

        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Laporan tidak ditemukan'], 404);
        }

        $laporan->delete();
        return response()->json(['status' => true, 'message' => 'Laporan berhasil dihapus']);
    }

    // Export ke PDF
    public function exportPDF()
    {
        $laporans = LaporanAnalisisPrestasi::with(['kelompok', 'mahasiswa', 'lomba'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = PDF::loadView('LaporanAnalisisPrestasi.pdf', compact('laporans'));
        return $pdf->download('laporan-prestasi.pdf');
    }

    // Export ke Excel
    public function exportExcel()
    {
        return Excel::download(new PrestasiExport, 'laporan-prestasi.xlsx');
    }

    
}


