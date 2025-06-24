<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =====================================
        // 🔥 URUTAN SEEDING SANGAT PENTING!
        // =====================================

        // 1️⃣ SEEDER MASTER/UTAMA (tanpa foreign key)
        $this->call([
            UserSeeder::class,                  // m_users (15 data)
            ProgramStudiSeeder::class,          // m_program_studi (3 data)
            PeriodeSeeder::class,               // m_periode (5 data)
            MinatSeeder::class,                 // m_minat (5 data)
            BidangKeahlianSeeder::class,        // m_bidang_keahlian (5 data)
            KompetensiSeeder::class,            // m_kompetensi (5 data)
        ]);

        // 2️⃣ SEEDER YANG DEPEND PADA USER
        $this->call([
            MahasiswaSeeder::class,             // m_mahasiswa (5 data) - depends on users & prodi
            DosenPembimbingSeeder::class,       // m_dosen_pembimbing (5 data) - depends on users
            AdminSeeder::class,                 // m_admin (5 data) - depends on users
        ]);

        // 3️⃣ SEEDER LOMBA & KELOMPOK
        $this->call([
            LombaSeeder::class,                 // m_lomba (5 data) - depends on periode
            KelompokSeeder::class,              // m_kelompok (5 data) - depends on lomba
        ]);

        // 4️⃣ SEEDER PRESTASI
        $this->call([
            PrestasiSeeder::class,              // t_prestasi (5 data) - depends on kelompok
        ]);

        // 5️⃣ SEEDER RELASI MINAT (Pivot Tables)
        $this->call([
            MinatMahasiswaSeeder::class,        // t_minat_mahasiswa (10 data)
            MinatDosenPembimbingSeeder::class,  // t_minat_dosen_pembimbing (10 data)
            MinatLombaSeeder::class,            // t_minat_lomba (10 data)
        ]);

        // 6️⃣ SEEDER RELASI KEAHLIAN (Pivot Tables)
        $this->call([
            KeahlianMahasiswaSeeder::class,     // t_keahlian_mahasiswa (10 data)
            KeahlianDosenPembimbingSeeder::class,         // t_keahlian_dosen (10 data)
            KeahlianLombaSeeder::class,         // t_keahlian_lomba (10 data)
        ]);

        // 7️⃣ SEEDER RELASI KOMPETENSI (Pivot Tables)
        $this->call([
            KompetensiMahasiswaSeeder::class,   // t_kompetensi_mahasiswa (10 data)
            KompetensiDosenPembimbingSeeder::class,       // t_kompetensi_dosen (10 data)
            KompetensiLombaSeeder::class,       // t_kompetensi_lomba (10 data)
        ]);

        // 8️⃣ SEEDER PERAN & KOMPETENSI PERAN
        $this->call([
            MahasiswaPeranSeeder::class,                // t_mahasiswa_peran (10 data)
            DosenPembimbingPeranSeeder::class,          // t_dosen_pembimbing_peran (10 data)
            MahasiswaPeranKompetensiSeeder::class,      // t_mahasiswa_peran_kompetensi (18 data)
            DosenPembimbingPeranKompetensiSeeder::class, // t_dosen_pembimbing_peran_kompetensi (16 data)
        ]);

        // =====================================
        // 🎯 INFORMASI SEEDING
        // =====================================
        $this->command->info('');
        $this->command->info('🎉 DATABASE SEEDING COMPLETED SUCCESSFULLY!');
        $this->command->info('');
        $this->command->table(
            ['Table Name', 'Seeder', 'Records'],
            [
                ['m_users', 'UserSeeder', '15'],
                ['m_program_studi', 'ProgramStudiSeeder', '3'],
                ['m_periode', 'PeriodeSeeder', '5'],
                ['m_minat', 'MinatSeeder', '5'],
                ['m_bidang_keahlian', 'BidangKeahlianSeeder', '5'],
                ['m_kompetensi', 'KompetensiSeeder', '5'],
                ['m_mahasiswa', 'MahasiswaSeeder', '5'],
                ['m_dosen_pembimbing', 'DosenPembimbingSeeder', '5'],
                ['m_admin', 'AdminSeeder', '5'],
                ['m_lomba', 'LombaSeeder', '5'],
                ['m_kelompok', 'KelompokSeeder', '5'],
                ['t_prestasi', 'PrestasiSeeder', '5'],
                ['t_minat_mahasiswa', 'MinatMahasiswaSeeder', '10'],
                ['t_minat_dosen_pembimbing', 'MinatDosenPembimbingSeeder', '10'],
                ['t_minat_lomba', 'MinatLombaSeeder', '10'],
                ['t_keahlian_mahasiswa', 'KeahlianMahasiswaSeeder', '10'],
                ['t_keahlian_dosen_pembimbing', 'KeahlianDosenpembimbingSeeder', '10'],
                ['t_keahlian_lomba', 'KeahlianLombaSeeder', '10'],
                ['t_kompetensi_mahasiswa', 'KompetensiMahasiswaSeeder', '10'],
                ['t_kompetensi_dosen_pembimbing', 'KompetensiDosenPembimbingSeeder', '10'],
                ['t_kompetensi_lomba', 'KompetensiLombaSeeder', '10'],
                ['t_mahasiswa_peran', 'MahasiswaPeranSeeder', '10'],
                ['t_dosen_pembimbing_peran', 'DosenPembimbingPeranSeeder', '10'],
                ['t_mahasiswa_peran_kompetensi', 'MahasiswaPeranKompetensiSeeder', '18'],
                ['t_dosen_pembimbing_peran_kompetensi', 'DosenPembimbingPeranKompetensiSeeder', '16'],
            ]
        );
        $this->command->info('');
        $this->command->warn('📝 Total Records Seeded: ~230+ records across 24 tables');
        $this->command->info('🚀 Ready for testing and development!');
    }
}
