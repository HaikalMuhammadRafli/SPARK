<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeahlianMahasiswaSeeder extends Seeder
{
    public function run()
    {
        DB::table('t_keahlian_mahasiswa')->insert([
            // Mahasiswa 1
            ['nim' => '2341760001', 'bidang_keahlian_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760001', 'bidang_keahlian_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 2
            ['nim' => '2341760002', 'bidang_keahlian_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760002', 'bidang_keahlian_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 3
            ['nim' => '2341760003', 'bidang_keahlian_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760003', 'bidang_keahlian_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 4
            ['nim' => '2341760004', 'bidang_keahlian_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760004', 'bidang_keahlian_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 5
            ['nim' => '2341760005', 'bidang_keahlian_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760005', 'bidang_keahlian_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 6
            ['nim' => '2341760006', 'bidang_keahlian_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760006', 'bidang_keahlian_id' => 7, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 7
            ['nim' => '2341760007', 'bidang_keahlian_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760007', 'bidang_keahlian_id' => 8, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 8
            ['nim' => '2341760008', 'bidang_keahlian_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760008', 'bidang_keahlian_id' => 9, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 9
            ['nim' => '2341760009', 'bidang_keahlian_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760009', 'bidang_keahlian_id' => 10, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 10
            ['nim' => '2341760010', 'bidang_keahlian_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760010', 'bidang_keahlian_id' => 11, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 11
            ['nim' => '2341760011', 'bidang_keahlian_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760011', 'bidang_keahlian_id' => 12, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 12
            ['nim' => '2341760012', 'bidang_keahlian_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760012', 'bidang_keahlian_id' => 13, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 13
            ['nim' => '2341760013', 'bidang_keahlian_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760013', 'bidang_keahlian_id' => 14, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 14
            ['nim' => '2341760014', 'bidang_keahlian_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760014', 'bidang_keahlian_id' => 15, 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa 15
            ['nim' => '2341760015', 'bidang_keahlian_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760015', 'bidang_keahlian_id' => 1, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
