<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangKeahlianSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_bidang_keahlian')->insert([
            [
                'bidang_keahlian_nama' => 'Machine Learning',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'Frontend Development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'Backend Development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'Database Management',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'Network Security',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'Cloud Computing',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'UI/UX Design',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'Cybersecurity',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'DevOps Engineering',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'Mobile App Development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'Data Engineering',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'Artificial Intelligence',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'Software Testing & QA',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'Blockchain Development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'bidang_keahlian_nama' => 'IT Project Management',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
