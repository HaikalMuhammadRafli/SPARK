<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KompetensiMahasiswaSeeder extends Seeder
{
    public function run()
    {
        DB::table('t_kompetensi_mahasiswa')->insert([
            // Mahasiswa 1
            ['nim' => '2341760001', 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760001', 'kompetensi_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 2
            ['nim' => '2341760002', 'kompetensi_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760002', 'kompetensi_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 3
            ['nim' => '2341760003', 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760003', 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 4
            ['nim' => '2341760004', 'kompetensi_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760004', 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 5
            ['nim' => '2341760005', 'kompetensi_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760005', 'kompetensi_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 6
            ['nim' => '2341760006', 'kompetensi_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760006', 'kompetensi_id' => 7, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 7
            ['nim' => '2341760007', 'kompetensi_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760007', 'kompetensi_id' => 8, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 8
            ['nim' => '2341760008', 'kompetensi_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760008', 'kompetensi_id' => 9, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 9
            ['nim' => '2341760009', 'kompetensi_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760009', 'kompetensi_id' => 10, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 10
            ['nim' => '2341760010', 'kompetensi_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760010', 'kompetensi_id' => 11, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 11
            ['nim' => '2341760011', 'kompetensi_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760011', 'kompetensi_id' => 12, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 12
            ['nim' => '2341760012', 'kompetensi_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760012', 'kompetensi_id' => 13, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 13
            ['nim' => '2341760013', 'kompetensi_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760013', 'kompetensi_id' => 14, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 14
            ['nim' => '2341760014', 'kompetensi_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760014', 'kompetensi_id' => 15, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 15
            ['nim' => '2341760015', 'kompetensi_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760015', 'kompetensi_id' => 1, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
