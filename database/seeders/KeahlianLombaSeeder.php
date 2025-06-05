<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeahlianLombaSeeder extends Seeder
{
    public function run()
    {
        DB::table('t_keahlian_lomba')->insert([
            // Lomba 1
            ['lomba_id' => 1, 'bidang_keahlian_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 1, 'bidang_keahlian_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 2
            ['lomba_id' => 2, 'bidang_keahlian_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 2, 'bidang_keahlian_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 3
            ['lomba_id' => 3, 'bidang_keahlian_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 3, 'bidang_keahlian_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 4
            ['lomba_id' => 4, 'bidang_keahlian_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 4, 'bidang_keahlian_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 5
            ['lomba_id' => 5, 'bidang_keahlian_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 5, 'bidang_keahlian_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 6
            ['lomba_id' => 6, 'bidang_keahlian_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 6, 'bidang_keahlian_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 7
            ['lomba_id' => 7, 'bidang_keahlian_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 7, 'bidang_keahlian_id' => 7, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 8
            ['lomba_id' => 8, 'bidang_keahlian_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 8, 'bidang_keahlian_id' => 8, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 9
            ['lomba_id' => 9, 'bidang_keahlian_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 9, 'bidang_keahlian_id' => 6, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 10
            ['lomba_id' => 10, 'bidang_keahlian_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 10, 'bidang_keahlian_id' => 7, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 11
            ['lomba_id' => 11, 'bidang_keahlian_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 11, 'bidang_keahlian_id' => 9, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 12
            ['lomba_id' => 12, 'bidang_keahlian_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 12, 'bidang_keahlian_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 13
            ['lomba_id' => 13, 'bidang_keahlian_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 13, 'bidang_keahlian_id' => 14, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 14
            ['lomba_id' => 14, 'bidang_keahlian_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 14, 'bidang_keahlian_id' => 13, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 15
            ['lomba_id' => 15, 'bidang_keahlian_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 15, 'bidang_keahlian_id' => 14, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
