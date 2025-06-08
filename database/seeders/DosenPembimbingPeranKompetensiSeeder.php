<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenPembimbingPeranKompetensiSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        // Mapping kompetensi per role
        $roleMap = [
            'Pembimbing Utama' => [1, 2, 3], // Leadership, Project Management, Communication
            'Co-Pembimbing' => [3, 4, 5], // Communication, Technical Skills, Problem Solving
            'Mentor Teknis' => [4, 5], // Technical Skills, Problem Solving
            'Mentor Strategis' => [1, 2] // Leadership, Project Management
        ];

        // Generate for 30 peran_id (from DosenPembimbingPeranSeeder)
        for ($peranId = 1; $peranId <= 30; $peranId++) {
            // Simulasikan peran_nama berdasarkan urutan seperti di seeder sebelumnya
            switch (true) {
                case in_array($peranId, [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23, 25, 27, 29]):
                    $role = 'Pembimbing Utama';
                    break;
                case in_array($peranId, [2, 6, 10, 12, 14, 18, 20, 22, 24, 26, 28, 30]):
                    $role = 'Co-Pembimbing';
                    break;
                case in_array($peranId, [4, 8, 16]):
                    $role = 'Mentor Teknis';
                    break;
                case in_array($peranId, [20]):
                    $role = 'Mentor Strategis';
                    break;
                default:
                    $role = 'Pembimbing Utama'; // fallback
            }

            $kompetensiIds = $roleMap[$role] ?? [1];

            foreach ($kompetensiIds as $kompetensiId) {
                $data[] = [
                    'peran_id' => $peranId,
                    'kompetensi_id' => $kompetensiId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('t_dosen_pembimbing_peran_kompetensi')->insert($data);
    }
}
