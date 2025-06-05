<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrestasiSeeder extends Seeder
{
    public function run()
    {
        DB::table('t_prestasi')->insert([
            [
                'prestasi_juara' => 'Juara 1',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_1.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_1.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_1.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_1.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_1.pdf',
                'prestasi_status' => 'Disetujui',
                'prestasi_catatan' => 'Prestasi luar biasa dalam kategori programming',
                'kelompok_id' => 1,
                'validated_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Juara 2',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_2.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_2.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_2.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_2.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_2.pdf',
                'prestasi_status' => 'Disetujui',
                'prestasi_catatan' => 'Inovasi AI yang sangat kreatif',
                'kelompok_id' => 2,
                'validated_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Juara 3',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_3.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_3.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_3.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_3.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_3.pdf',
                'prestasi_status' => 'Pending',
                'prestasi_catatan' => 'Sedang dalam proses verifikasi',
                'kelompok_id' => 3,
                'validated_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Harapan 1',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_4.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_4.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_4.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_4.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_4.pdf',
                'prestasi_status' => 'Disetujui',
                'prestasi_catatan' => 'Aplikasi mobile yang user-friendly',
                'kelompok_id' => 4,
                'validated_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Best Innovation',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_5.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_5.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_5.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_5.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_5.pdf',
                'prestasi_status' => 'Ditolak',
                'prestasi_catatan' => 'Dokumen tidak lengkap, perlu dilengkapi',
                'kelompok_id' => 5,
                'validated_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Juara Harapan 2',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_6.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_6.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_6.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_6.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_6.pdf',
                'prestasi_status' => 'Disetujui',
                'prestasi_catatan' => 'Dashboard analitik dengan visualisasi baik',
                'kelompok_id' => 6,
                'validated_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Best UI/UX',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_7.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_7.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_7.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_7.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_7.pdf',
                'prestasi_status' => 'Disetujui',
                'prestasi_catatan' => 'Tampilan antarmuka modern dan responsif',
                'kelompok_id' => 7,
                'validated_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Best Game Design',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_8.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_8.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_8.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_8.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_8.pdf',
                'prestasi_status' => 'Pending',
                'prestasi_catatan' => 'Menunggu validasi oleh juri utama',
                'kelompok_id' => 8,
                'validated_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Most Impactful IoT',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_9.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_9.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_9.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_9.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_9.pdf',
                'prestasi_status' => 'Disetujui',
                'prestasi_catatan' => 'Perangkat IoT yang hemat daya',
                'kelompok_id' => 9,
                'validated_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Top DevOps Team',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_10.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_10.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_10.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_10.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_10.pdf',
                'prestasi_status' => 'Disetujui',
                'prestasi_catatan' => 'Pipeline CI/CD berjalan mulus',
                'kelompok_id' => 10,
                'validated_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Cloud Innovator Award',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_11.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_11.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_11.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_11.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_11.pdf',
                'prestasi_status' => 'Pending',
                'prestasi_catatan' => 'Review arsitektur masih berlangsung',
                'kelompok_id' => 11,
                'validated_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Top Contributor OSS',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_12.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_12.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_12.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_12.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_12.pdf',
                'prestasi_status' => 'Disetujui',
                'prestasi_catatan' => 'Kontribusi open source aktif',
                'kelompok_id' => 12,
                'validated_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Juara 1 Nasional Robotik',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_13.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_13.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_13.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_13.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_13.pdf',
                'prestasi_status' => 'Disetujui',
                'prestasi_catatan' => 'Robot cerdas penyelamat bencana',
                'kelompok_id' => 13,
                'validated_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Best Blockchain Pitch',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_14.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_14.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_14.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_14.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_14.pdf',
                'prestasi_status' => 'Disetujui',
                'prestasi_catatan' => 'Pitch startup blockchain diterima investor',
                'kelompok_id' => 14,
                'validated_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'prestasi_juara' => 'Analisis Bisnis Terbaik',
                'prestasi_surat_tugas_url' => 'https://example.com/surat_tugas_15.pdf',
                'prestasi_poster_url' => 'https://example.com/poster_15.jpg',
                'prestasi_foto_juara_url' => 'https://example.com/foto_juara_15.jpg',
                'prestasi_proposal_url' => 'https://example.com/proposal_15.pdf',
                'prestasi_sertifikat_url' => 'https://example.com/sertifikat_15.pdf',
                'prestasi_status' => 'Disetujui',
                'prestasi_catatan' => 'Solusi bisnis digital yang kuat',
                'kelompok_id' => 15,
                'validated_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
