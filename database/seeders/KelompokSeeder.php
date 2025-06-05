<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_kelompok')->insert([
            [
                'kelompok_nama' => 'Code Warriors',
                'lomba_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'AI Innovators',
                'lomba_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'Web Designers',
                'lomba_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'Mobile Masters',
                'lomba_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'Cyber Defenders',
                'lomba_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'Data Wizards',
                'lomba_id' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'UX Pioneers',
                'lomba_id' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'Game Changers',
                'lomba_id' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'Smart Creators',
                'lomba_id' => 9,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'DevOps Ninjas',
                'lomba_id' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'Cloud Architects',
                'lomba_id' => 11,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'Open Source Squad',
                'lomba_id' => 12,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'Robo Legends',
                'lomba_id' => 13,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'Block Pitchers',
                'lomba_id' => 14,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kelompok_nama' => 'Biztech Analysts',
                'lomba_id' => 15,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
