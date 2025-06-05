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
            ['nip' => '198501012010121001', 'kelompok_id' => 1, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198502022011122002', 'kelompok_id' => 1, 'nama_peran' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 2
            ['nip' => '198503032012123003', 'kelompok_id' => 2, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198504042013124004', 'kelompok_id' => 2, 'nama_peran' => 'Mentor Teknis', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 3
            ['nip' => '198505052014125005', 'kelompok_id' => 3, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198504042013124004', 'kelompok_id' => 3, 'nama_peran' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 4
            ['nip' => '198501012010121001', 'kelompok_id' => 4, 'nama_peran' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198502022011122002', 'kelompok_id' => 4, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 5
            ['nip' => '198503032012123003', 'kelompok_id' => 5, 'nama_peran' => 'Mentor Strategis', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198505052014125005', 'kelompok_id' => 5, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 6
            ['nip' => '198506062015126006', 'kelompok_id' => 6, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198507072016127007', 'kelompok_id' => 6, 'nama_peran' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 7
            ['nip' => '198508082017128008', 'kelompok_id' => 7, 'nama_peran' => 'Mentor Teknis', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198509092018129009', 'kelompok_id' => 7, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 8
            ['nip' => '198510102019130010', 'kelompok_id' => 8, 'nama_peran' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198511112020131011', 'kelompok_id' => 8, 'nama_peran' => 'Mentor Strategis', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 9
            ['nip' => '198512122021132012', 'kelompok_id' => 9, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198601132022133013', 'kelompok_id' => 9, 'nama_peran' => 'Mentor Teknis', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 10
            ['nip' => '198602142023134014', 'kelompok_id' => 10, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198603152024135015', 'kelompok_id' => 10, 'nama_peran' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 11
            ['nip' => '198501012010121001', 'kelompok_id' => 11, 'nama_peran' => 'Mentor Strategis', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198502022011122002', 'kelompok_id' => 11, 'nama_peran' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 12
            ['nip' => '198503032012123003', 'kelompok_id' => 12, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198504042013124004', 'kelompok_id' => 12, 'nama_peran' => 'Co-Pembimbing', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 13
            ['nip' => '198505052014125005', 'kelompok_id' => 13, 'nama_peran' => 'Mentor Teknis', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198506062015126006', 'kelompok_id' => 13, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 14
            ['nip' => '198507072016127007', 'kelompok_id' => 14, 'nama_peran' => 'Mentor Strategis', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198508082017128008', 'kelompok_id' => 14, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 15
            ['nip' => '198509092018129009', 'kelompok_id' => 15, 'nama_peran' => 'Pembimbing Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198510102019130010', 'kelompok_id' => 15, 'nama_peran' => 'Mentor Teknis', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
