<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_periode')->insert([
            [
                'periode_nama' => 'Genap 2023/2024',
                'periode_tahun_awal' => 2023,
                'periode_tahun_akhir' => 2024,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Ganjil 2024/2025',
                'periode_tahun_awal' => 2024,
                'periode_tahun_akhir' => 2025,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Genap 2024/2025',
                'periode_tahun_awal' => 2024,
                'periode_tahun_akhir' => 2025,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Ganjil 2025/2026',
                'periode_tahun_awal' => 2025,
                'periode_tahun_akhir' => 2026,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Genap 2025/2026',
                'periode_tahun_awal' => 2025,
                'periode_tahun_akhir' => 2026,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Ganjil 2026/2027',
                'periode_tahun_awal' => 2026,
                'periode_tahun_akhir' => 2027,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Genap 2026/2027',
                'periode_tahun_awal' => 2026,
                'periode_tahun_akhir' => 2027,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Ganjil 2027/2028',
                'periode_tahun_awal' => 2027,
                'periode_tahun_akhir' => 2028,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Genap 2027/2028',
                'periode_tahun_awal' => 2027,
                'periode_tahun_akhir' => 2028,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Ganjil 2028/2029',
                'periode_tahun_awal' => 2028,
                'periode_tahun_akhir' => 2029,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Genap 2028/2029',
                'periode_tahun_awal' => 2028,
                'periode_tahun_akhir' => 2029,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Ganjil 2029/2030',
                'periode_tahun_awal' => 2029,
                'periode_tahun_akhir' => 2030,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Genap 2029/2030',
                'periode_tahun_awal' => 2029,
                'periode_tahun_akhir' => 2030,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Ganjil 2030/2031',
                'periode_tahun_awal' => 2030,
                'periode_tahun_akhir' => 2031,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'periode_nama' => 'Genap 2030/2031',
                'periode_tahun_awal' => 2030,
                'periode_tahun_akhir' => 2031,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
