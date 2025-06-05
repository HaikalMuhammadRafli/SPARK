<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KompetensiSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_kompetensi')->insert([
            [
                'kompetensi_nama' => 'Python Programming',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'JavaScript Programming',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'React.js Framework',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'Laravel Framework',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'MySQL Database',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'Node.js Backend',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'Docker & Containerization',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'Git & Version Control',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'RESTful API Design',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'Android Development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'UI/UX Prototyping (Figma)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'Machine Learning with TensorFlow',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'Cybersecurity Fundamentals',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'Agile & Scrum Methodology',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kompetensi_nama' => 'Cloud Deployment (AWS/GCP)',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
