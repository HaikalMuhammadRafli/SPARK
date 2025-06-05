<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MinatDosenPembimbingSeeder extends Seeder
{
    public function run()
    {
        DB::table('t_minat_dosen_pembimbing')->insert([
            // Dosen 1
            ['nip' => '198501012010121001', 'minat_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198501012010121001', 'minat_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 2
            ['nip' => '198502022011122002', 'minat_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198502022011122002', 'minat_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 3
            ['nip' => '198503032012123003', 'minat_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198503032012123003', 'minat_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 4
            ['nip' => '198504042013124004', 'minat_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198504042013124004', 'minat_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 5
            ['nip' => '198505052014125005', 'minat_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198505052014125005', 'minat_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 6
            ['nip' => '198506062015126006', 'minat_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198506062015126006', 'minat_id' => 7, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 7
            ['nip' => '198507072016127007', 'minat_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198507072016127007', 'minat_id' => 8, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 8
            ['nip' => '198508082017128008', 'minat_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198508082017128008', 'minat_id' => 9, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 9
            ['nip' => '198509092018129009', 'minat_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198509092018129009', 'minat_id' => 10, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 10
            ['nip' => '198510102019130010', 'minat_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198510102019130010', 'minat_id' => 11, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 11
            ['nip' => '198511112020131011', 'minat_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198511112020131011', 'minat_id' => 12, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 12
            ['nip' => '198512122021132012', 'minat_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198512122021132012', 'minat_id' => 13, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 13
            ['nip' => '198601132022133013', 'minat_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198601132022133013', 'minat_id' => 14, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 14
            ['nip' => '198602142023134014', 'minat_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198602142023134014', 'minat_id' => 15, 'created_at' => now(), 'updated_at' => now()],

            // Dosen 15
            ['nip' => '198603152024135015', 'minat_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['nip' => '198603152024135015', 'minat_id' => 1, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
