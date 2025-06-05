<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaPeranKompetensiSeeder extends Seeder
{
    public function run()
    {
        DB::table('t_mahasiswa_peran_kompetensi')->insert([
            // Kelompok 1
            ['peran_id' => 1, 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()], // Leadership
            ['peran_id' => 1, 'kompetensi_id' => 3, 'created_at' => now(), 'updated_at' => now()], // Communication

            ['peran_id' => 2, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()], // Technical
            ['peran_id' => 2, 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()], // Problem Solving

            // Kelompok 2
            ['peran_id' => 3, 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 3, 'kompetensi_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 4, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 3
            ['peran_id' => 5, 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 5, 'kompetensi_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 6, 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 4
            ['peran_id' => 7, 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 7, 'kompetensi_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 8, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 5
            ['peran_id' => 9, 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 9, 'kompetensi_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 10, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 10, 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 6
            ['peran_id' => 11, 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 11, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 12, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 12, 'kompetensi_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 7
            ['peran_id' => 13, 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 13, 'kompetensi_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 14, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 14, 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 8
            ['peran_id' => 15, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 15, 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 16, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 16, 'kompetensi_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 9
            ['peran_id' => 17, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 17, 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 18, 'kompetensi_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 18, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 10
            ['peran_id' => 19, 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 19, 'kompetensi_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 20, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 20, 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 11–15 (ID 21–30) → same pattern
            ['peran_id' => 21, 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 21, 'kompetensi_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 22, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 23, 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 23, 'kompetensi_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 24, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 25, 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 25, 'kompetensi_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 26, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 27, 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 27, 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 28, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            ['peran_id' => 29, 'kompetensi_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 29, 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['peran_id' => 30, 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
