<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MinatLombaSeeder extends Seeder
{
    public function run()
    {
        DB::table('t_minat_lomba')->insert([
            // Lomba 1
            ['lomba_id' => 1, 'minat_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 1, 'minat_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 2
            ['lomba_id' => 2, 'minat_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 2, 'minat_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 3
            ['lomba_id' => 3, 'minat_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 3, 'minat_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 4
            ['lomba_id' => 4, 'minat_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 4, 'minat_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 5
            ['lomba_id' => 5, 'minat_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 5, 'minat_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 6
            ['lomba_id' => 6, 'minat_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 6, 'minat_id' => 6, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 7
            ['lomba_id' => 7, 'minat_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 7, 'minat_id' => 7, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 8
            ['lomba_id' => 8, 'minat_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 8, 'minat_id' => 8, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 9
            ['lomba_id' => 9, 'minat_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 9, 'minat_id' => 9, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 10
            ['lomba_id' => 10, 'minat_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 10, 'minat_id' => 10, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 11
            ['lomba_id' => 11, 'minat_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 11, 'minat_id' => 11, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 12
            ['lomba_id' => 12, 'minat_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 12, 'minat_id' => 12, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 13
            ['lomba_id' => 13, 'minat_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 13, 'minat_id' => 14, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 14
            ['lomba_id' => 14, 'minat_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 14, 'minat_id' => 15, 'created_at' => now(), 'updated_at' => now()],

            // Lomba 15
            ['lomba_id' => 15, 'minat_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['lomba_id' => 15, 'minat_id' => 13, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
