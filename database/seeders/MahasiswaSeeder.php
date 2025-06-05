<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_mahasiswa')->insert([
            [
                'nim' => '2341760001',
                'nama' => 'Ahmad Rizki Pratama',
                'lokasi_preferensi' => 'Kota',
                'user_id' => 1,
                'program_studi_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760002',
                'nama' => 'Siti Nurhaliza',
                'lokasi_preferensi' => 'Kota',
                'user_id' => 2,
                'program_studi_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760003',
                'nama' => 'Budi Santoso',
                'lokasi_preferensi' => 'Internasional',
                'user_id' => 3,
                'program_studi_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760004',
                'nama' => 'Diana Putri',
                'lokasi_preferensi' => 'Provinsi',
                'user_id' => 4,
                'program_studi_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760005',
                'nama' => 'Eko Wahyudi',
                'lokasi_preferensi' => 'Provinsi',
                'user_id' => 5,
                'program_studi_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760006',
                'nama' => 'Fitriani Zahra',
                'lokasi_preferensi' => 'Kota',
                'user_id' => 6,
                'program_studi_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760007',
                'nama' => 'Gilang Saputra',
                'lokasi_preferensi' => 'Kota',
                'user_id' => 7,
                'program_studi_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760008',
                'nama' => 'Hana Maharani',
                'lokasi_preferensi' => 'Internasional',
                'user_id' => 8,
                'program_studi_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760009',
                'nama' => 'Iqbal Maulana',
                'lokasi_preferensi' => 'Provinsi',
                'user_id' => 9,
                'program_studi_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760010',
                'nama' => 'Jessica Anjani',
                'lokasi_preferensi' => 'Provinsi',
                'user_id' => 10,
                'program_studi_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760011',
                'nama' => 'Kurniawan Dwi',
                'lokasi_preferensi' => 'Kota',
                'user_id' => 11,
                'program_studi_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760012',
                'nama' => 'Laras Sekar',
                'lokasi_preferensi' => 'Kota',
                'user_id' => 12,
                'program_studi_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760013',
                'nama' => 'Muhammad Faisal',
                'lokasi_preferensi' => 'Internasional',
                'user_id' => 13,
                'program_studi_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760014',
                'nama' => 'Nina Lestari',
                'lokasi_preferensi' => 'Provinsi',
                'user_id' => 14,
                'program_studi_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nim' => '2341760015',
                'nama' => 'Oscar Prabowo',
                'lokasi_preferensi' => 'Provinsi',
                'user_id' => 15,
                'program_studi_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
