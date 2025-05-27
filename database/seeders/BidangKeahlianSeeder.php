<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BidangKeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $data[] = [
                'bidang_keahlian_nama' => 'Bidang Keahlian ' . $i,
            ];
        }

        DB::table('m_bidang_keahlian')->insert($data);
    }
}
