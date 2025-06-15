<?php

namespace App\Exports;

use App\Models\LaporanAnalisisPrestasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanPrestasiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return LaporanAnalisisPrestasi::with('kelompok')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Prestasi',
            'Juara',
            'Surat Tugas URL',
            'Poster URL',
            'Foto Juara URL',
            'Proposal URL',
            'Sertifikat URL',
            'Status',
            'Catatan',
            'Nama Kelompok',
            'Tanggal Validasi',
            'Tanggal Dibuat',
            'Tanggal Diperbarui'
        ];
    }

    public function map($prestasi): array
    {
        return [
            $prestasi->prestasi_id,
            $prestasi->prestasi_juara,
            $prestasi->prestasi_surat_tugas_url,
            $prestasi->prestasi_poster_url,
            $prestasi->prestasi_foto_juara_url,
            $prestasi->prestasi_proposal_url,
            $prestasi->prestasi_sertifikat_url,
            $prestasi->prestasi_status,
            $prestasi->prestasi_catatan,
            $prestasi->kelompok->kelompok_nama ?? '-',
            $prestasi->validated_at ? $prestasi->validated_at->format('d/m/Y H:i:s') : '-',
            $prestasi->created_at->format('d/m/Y H:i:s'),
            $prestasi->updated_at->format('d/m/Y H:i:s')
        ];
    }
}
