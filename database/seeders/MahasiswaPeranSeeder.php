<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaPeranSeeder extends Seeder
{
    public function run()
    {
        DB::table('t_mahasiswa_peran')->insert([
            // Kelompok 1
            ['nim' => '2341760001', 'kelompok_id' => 1, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760002', 'kelompok_id' => 1, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 2
            ['nim' => '2341760002', 'kelompok_id' => 2, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760003', 'kelompok_id' => 2, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 3
            ['nim' => '2341760003', 'kelompok_id' => 3, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760004', 'kelompok_id' => 3, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 4
            ['nim' => '2341760004', 'kelompok_id' => 4, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760005', 'kelompok_id' => 4, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 5
            ['nim' => '2341760005', 'kelompok_id' => 5, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760001', 'kelompok_id' => 5, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 6
            ['nim' => '2341760006', 'kelompok_id' => 6, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760007', 'kelompok_id' => 6, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 7
            ['nim' => '2341760007', 'kelompok_id' => 7, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760008', 'kelompok_id' => 7, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 8
            ['nim' => '2341760008', 'kelompok_id' => 8, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760009', 'kelompok_id' => 8, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 9
            ['nim' => '2341760009', 'kelompok_id' => 9, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760010', 'kelompok_id' => 9, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 10
            ['nim' => '2341760010', 'kelompok_id' => 10, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760011', 'kelompok_id' => 10, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 11
            ['nim' => '2341760011', 'kelompok_id' => 11, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760012', 'kelompok_id' => 11, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 12
            ['nim' => '2341760012', 'kelompok_id' => 12, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760013', 'kelompok_id' => 12, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 13
            ['nim' => '2341760013', 'kelompok_id' => 13, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760014', 'kelompok_id' => 13, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 14
            ['nim' => '2341760014', 'kelompok_id' => 14, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760015', 'kelompok_id' => 14, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 15
            ['nim' => '2341760015', 'kelompok_id' => 15, 'peran_nama' => 'Ketua', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760006', 'kelompok_id' => 15, 'peran_nama' => 'Anggota', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
