<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_admin')->insert([
            [
                'nip' => '199001012015011001',
                'nama' => 'Fajar Suryanto',
                'user_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199002022015022002',
                'nama' => 'Gita Maharani',
                'user_id' => 17,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199003032015033003',
                'nama' => 'Hendra Kusuma',
                'user_id' => 18,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199004042015044004',
                'nama' => 'Indira Sari',
                'user_id' => 19,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199005052015055005',
                'nama' => 'Joko Widodo',
                'user_id' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199006062015066006',
                'nama' => 'Kirana Dewi',
                'user_id' => 21,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199007072015077007',
                'nama' => 'Lukman Hakim',
                'user_id' => 22,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199008082015088008',
                'nama' => 'Mega Pratiwi',
                'user_id' => 23,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199009092015099009',
                'nama' => 'Nanda Saputra',
                'user_id' => 24,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199010102015101010',
                'nama' => 'Oktaviani Putra',
                'user_id' => 25,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199011112015111011',
                'nama' => 'Putri Ayu',
                'user_id' => 26,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199012122015122012',
                'nama' => 'Qomaruddin Hadi',
                'user_id' => 27,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199101132016011013',
                'nama' => 'Rina Amelia',
                'user_id' => 28,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199102142016022014',
                'nama' => 'Satria Wibawa',
                'user_id' => 29,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '199103152016033015',
                'nama' => 'Tasya Nurhaliza',
                'user_id' => 30,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
