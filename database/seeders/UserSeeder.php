<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // === Mahasiswa: user_id 1–15 ===
        $mahasiswa_nim = [
            '2341760001',
            '2341760002',
            '2341760003',
            '2341760004',
            '2341760005',
            '2341760006',
            '2341760007',
            '2341760008',
            '2341760009',
            '2341760010',
            '2341760011',
            '2341760012',
            '2341760013',
            '2341760014',
            '2341760015'
        ];

        $mahasiswa = array_map(function ($nim, $index) {
            return [
                'email' => "$nim@polinema.ac.id",
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'status_akun' => 'aktif',
                'last_login_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $mahasiswa_nim, array_keys($mahasiswa_nim));

        // === Admin: user_id 16–30 ===
        $admin_nip = [
            '199001012015011001',
            '199002022015022002',
            '199003032015033003',
            '199004042015044004',
            '199005052015055005',
            '199006062015066006',
            '199007072015077007',
            '199008082015088008',
            '199009092015099009',
            '199010102015101010',
            '199011112015111011',
            '199012122015122012',
            '199101132016011013',
            '199102142016022014',
            '199103152016033015'
        ];

        $admin = array_map(function ($nip, $index) {
            return [
                'email' => "$nip@polinema.ac.id",
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status_akun' => 'aktif',
                'last_login_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $admin_nip, array_keys($admin_nip));

        // === Dosen Pembimbing: user_id 31–45 ===
        $dosen_nip = [
            '198501012010121001',
            '198502022011122002',
            '198503032012123003',
            '198504042013124004',
            '198505052014125005',
            '198506062015126006',
            '198507072016127007',
            '198508082017128008',
            '198509092018129009',
            '198510102019130010',
            '198511112020131011',
            '198512122021132012',
            '198601132022133013',
            '198602142023134014',
            '198603152024135015'
        ];

        $dosen = array_map(function ($nip, $index) {
            return [
                'email' => "$nip@polinema.ac.id",
                'password' => Hash::make('password123'),
                'role' => 'dosen_pembimbing',
                'status_akun' => 'aktif',
                'last_login_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $dosen_nip, array_keys($dosen_nip));

        // Gabungkan dan masukkan ke dalam tabel
        DB::table('m_user')->insert(array_merge($mahasiswa, $admin, $dosen));
    }
}
