<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MinatMahasiswaSeeder extends Seeder
{
    public function run()
    {
        DB::table('t_minat_mahasiswa')->insert([
            ['nim' => '2341760001', 'minat_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760001', 'minat_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760002', 'minat_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760002', 'minat_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760003', 'minat_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760003', 'minat_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760004', 'minat_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760004', 'minat_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760005', 'minat_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760005', 'minat_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760006', 'minat_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760006', 'minat_id' => 7, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760007', 'minat_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760007', 'minat_id' => 8, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760008', 'minat_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760008', 'minat_id' => 9, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760009', 'minat_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760009', 'minat_id' => 10, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760010', 'minat_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760010', 'minat_id' => 11, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760011', 'minat_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760011', 'minat_id' => 12, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760012', 'minat_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760012', 'minat_id' => 13, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760013', 'minat_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760013', 'minat_id' => 14, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760014', 'minat_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760014', 'minat_id' => 15, 'created_at' => now(), 'updated_at' => now()],

            ['nim' => '2341760015', 'minat_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760015', 'minat_id' => 1, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
