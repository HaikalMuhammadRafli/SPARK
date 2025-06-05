<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MinatSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_minat')->insert([
            [
                'minat_nama' => 'Artificial Intelligence',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'Web Development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'Mobile Development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'Data Science',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'Cyber Security',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'Cloud Computing',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'Game Development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'DevOps',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'Internet of Things (IoT)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'Augmented Reality / Virtual Reality',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'Software Testing',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'UI/UX Design',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'Robotics',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'Blockchain Technology',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'minat_nama' => 'Business Intelligence',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
