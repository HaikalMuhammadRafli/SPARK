<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaPeranSeeder extends Seeder
{
    public function run()
    {
        DB::table('t_mahasiswa_peran')->insert([
            // Kelompok 1
            ['nim' => '2341760001', 'kelompok_id' => 1, 'nama_peran' => 'Ketua Tim', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760002', 'kelompok_id' => 1, 'nama_peran' => 'Developer', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 2
            ['nim' => '2341760002', 'kelompok_id' => 2, 'nama_peran' => 'Business Analyst', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760003', 'kelompok_id' => 2, 'nama_peran' => 'Marketing Lead', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 3
            ['nim' => '2341760003', 'kelompok_id' => 3, 'nama_peran' => 'AI Researcher', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760004', 'kelompok_id' => 3, 'nama_peran' => 'Data Scientist', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 4
            ['nim' => '2341760004', 'kelompok_id' => 4, 'nama_peran' => 'System Architect', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760005', 'kelompok_id' => 4, 'nama_peran' => 'UI/UX Designer', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 5
            ['nim' => '2341760005', 'kelompok_id' => 5, 'nama_peran' => 'Security Expert', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760001', 'kelompok_id' => 5, 'nama_peran' => 'Penetration Tester', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 6
            ['nim' => '2341760006', 'kelompok_id' => 6, 'nama_peran' => 'Data Analyst', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760007', 'kelompok_id' => 6, 'nama_peran' => 'Frontend Developer', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 7
            ['nim' => '2341760007', 'kelompok_id' => 7, 'nama_peran' => 'Scrum Master', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760008', 'kelompok_id' => 7, 'nama_peran' => 'Quality Assurance', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 8
            ['nim' => '2341760008', 'kelompok_id' => 8, 'nama_peran' => 'Game Designer', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760009', 'kelompok_id' => 8, 'nama_peran' => 'Unity Developer', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 9
            ['nim' => '2341760009', 'kelompok_id' => 9, 'nama_peran' => 'IoT Engineer', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760010', 'kelompok_id' => 9, 'nama_peran' => 'Firmware Programmer', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 10
            ['nim' => '2341760010', 'kelompok_id' => 10, 'nama_peran' => 'DevOps Engineer', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760011', 'kelompok_id' => 10, 'nama_peran' => 'Cloud Architect', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 11
            ['nim' => '2341760011', 'kelompok_id' => 11, 'nama_peran' => 'Solution Architect', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760012', 'kelompok_id' => 11, 'nama_peran' => 'API Specialist', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 12
            ['nim' => '2341760012', 'kelompok_id' => 12, 'nama_peran' => 'Open Source Contributor', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760013', 'kelompok_id' => 12, 'nama_peran' => 'Git Manager', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 13
            ['nim' => '2341760013', 'kelompok_id' => 13, 'nama_peran' => 'Robot Controller', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760014', 'kelompok_id' => 13, 'nama_peran' => 'Hardware Specialist', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 14
            ['nim' => '2341760014', 'kelompok_id' => 14, 'nama_peran' => 'Pitch Presenter', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760015', 'kelompok_id' => 14, 'nama_peran' => 'Blockchain Developer', 'created_at' => now(), 'updated_at' => now()],

            // Kelompok 15
            ['nim' => '2341760015', 'kelompok_id' => 15, 'nama_peran' => 'Business Analyst', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2341760006', 'kelompok_id' => 15, 'nama_peran' => 'BI Developer', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
