<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenPembimbingPeranSeeder extends Seeder
{
    public function run()
    {
        DB::table('t_dosen_pembimbing_peran')->insert([
            // Kelompok 1
            ['nip' => '198501012010121001', 'kelompok_id' => 1, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198502022011122002', 'kelompok_id' => 1, 'peran_nama' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 2
            ['nip' => '198503032012123003', 'kelompok_id' => 2, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198504042013124004', 'kelompok_id' => 2, 'peran_nama' => 'Mentor Teknis', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 3
            ['nip' => '198505052014125005', 'kelompok_id' => 3, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198504042013124004', 'kelompok_id' => 3, 'peran_nama' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 4
            ['nip' => '198501012010121001', 'kelompok_id' => 4, 'peran_nama' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198502022011122002', 'kelompok_id' => 4, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 5
            ['nip' => '198503032012123003', 'kelompok_id' => 5, 'peran_nama' => 'Mentor Strategis', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198505052014125005', 'kelompok_id' => 5, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 6
            ['nip' => '198506062015126006', 'kelompok_id' => 6, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198507072016127007', 'kelompok_id' => 6, 'peran_nama' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 7
            ['nip' => '198508082017128008', 'kelompok_id' => 7, 'peran_nama' => 'Mentor Teknis', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198509092018129009', 'kelompok_id' => 7, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 8
            ['nip' => '198510102019130010', 'kelompok_id' => 8, 'peran_nama' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198511112020131011', 'kelompok_id' => 8, 'peran_nama' => 'Mentor Strategis', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 9
            ['nip' => '198512122021132012', 'kelompok_id' => 9, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198601132022133013', 'kelompok_id' => 9, 'peran_nama' => 'Mentor Teknis', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 10
            ['nip' => '198602142023134014', 'kelompok_id' => 10, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198603152024135015', 'kelompok_id' => 10, 'peran_nama' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 11
            ['nip' => '198501012010121001', 'kelompok_id' => 11, 'peran_nama' => 'Mentor Strategis', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198502022011122002', 'kelompok_id' => 11, 'peran_nama' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 12
            ['nip' => '198503032012123003', 'kelompok_id' => 12, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198504042013124004', 'kelompok_id' => 12, 'peran_nama' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 13
            ['nip' => '198505052014125005', 'kelompok_id' => 13, 'peran_nama' => 'Mentor Teknis', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198506062015126006', 'kelompok_id' => 13, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 14
            ['nip' => '198507072016127007', 'kelompok_id' => 14, 'peran_nama' => 'Mentor Strategis', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198508082017128008', 'kelompok_id' => 14, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 15
            ['nip' => '198509092018129009', 'kelompok_id' => 15, 'peran_nama' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198510102019130010', 'kelompok_id' => 15, 'peran_nama' => 'Mentor Teknis', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
