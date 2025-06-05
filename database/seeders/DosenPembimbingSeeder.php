<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenPembimbingSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_dosen_pembimbing')->insert([
            [
                'nip' => '198501012010121001',
                'nama' => 'Dr. Agus Harjoko, M.Kom',
                'user_id' => 31,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198502022011122002',
                'nama' => 'Dr. Budi Raharjo, M.T',
                'user_id' => 32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198503032012123003',
                'nama' => 'Dr. Citra Dewi, M.Kom',
                'user_id' => 33,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198504042013124004',
                'nama' => 'Dr. Dedi Setiawan, M.Sc',
                'user_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198505052014125005',
                'nama' => 'Dr. Eka Pratiwi, M.T',
                'user_id' => 35,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198506062015126006',
                'nama' => 'Dr. Farid Maulana, M.Kom',
                'user_id' => 36,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198507072016127007',
                'nama' => 'Dr. Gita Savitri, M.T',
                'user_id' => 37,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198508082017128008',
                'nama' => 'Dr. Hadi Nugroho, M.Kom',
                'user_id' => 38,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198509092018129009',
                'nama' => 'Dr. Intan Permata, M.Sc',
                'user_id' => 39,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198510102019130010',
                'nama' => 'Dr. Junaidi Akbar, M.T',
                'user_id' => 40,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198511112020131011',
                'nama' => 'Dr. Kiki Andriani, M.Kom',
                'user_id' => 41,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198512122021132012',
                'nama' => 'Dr. Luthfi Rahman, M.Sc',
                'user_id' => 42,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198601132022133013',
                'nama' => 'Dr. Maya Fitriani, M.T',
                'user_id' => 43,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198602142023134014',
                'nama' => 'Dr. Naufal Rizky, M.Kom',
                'user_id' => 44,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '198603152024135015',
                'nama' => 'Dr. Olivia Salsabila, M.T',
                'user_id' => 45,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
