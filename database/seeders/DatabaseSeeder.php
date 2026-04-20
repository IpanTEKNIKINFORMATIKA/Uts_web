<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================================
        // Buat User Admin untuk Login
        // ==========================================
        User::create([
            'name' => 'Admin',
            'email' => 'admin@akademik.com',
            'password' => Hash::make('password'),
        ]);

        // ==========================================
        // Buat Data Jurusan
        // ==========================================
        $jurusan = [
            ['nama_jurusan' => 'Teknik Informatika', 'akreditasi' => 'A'],
            ['nama_jurusan' => 'Sistem Informasi', 'akreditasi' => 'A'],
            ['nama_jurusan' => 'Teknik Elektro', 'akreditasi' => 'B'],
            ['nama_jurusan' => 'Teknik Mesin', 'akreditasi' => 'B'],
            ['nama_jurusan' => 'Manajemen Informatika', 'akreditasi' => 'A'],
        ];

        foreach ($jurusan as $j) {
            Jurusan::create($j);
        }

        // ==========================================
        // Buat Data Mahasiswa
        // ==========================================
        $mahasiswa = [
            ['nim' => '2024001', 'nama' => 'Ahmad Fauzi', 'id_jurusan' => 1],
            ['nim' => '2024002', 'nama' => 'Budi Santoso', 'id_jurusan' => 1],
            ['nim' => '2024003', 'nama' => 'Citra Dewi', 'id_jurusan' => 2],
            ['nim' => '2024004', 'nama' => 'Diana Putri', 'id_jurusan' => 2],
            ['nim' => '2024005', 'nama' => 'Eko Prasetyo', 'id_jurusan' => 3],
            ['nim' => '2024006', 'nama' => 'Fitri Handayani', 'id_jurusan' => 3],
            ['nim' => '2024007', 'nama' => 'Galih Pratama', 'id_jurusan' => 4],
            ['nim' => '2024008', 'nama' => 'Hana Safitri', 'id_jurusan' => 4],
            ['nim' => '2024009', 'nama' => 'Irfan Hakim', 'id_jurusan' => 5],
            ['nim' => '2024010', 'nama' => 'Joko Widodo', 'id_jurusan' => 5],
            ['nim' => '2024011', 'nama' => 'Kartika Sari', 'id_jurusan' => 1],
            ['nim' => '2024012', 'nama' => 'Lukman Hakim', 'id_jurusan' => 2],
            ['nim' => '2024013', 'nama' => 'Maya Angelina', 'id_jurusan' => 1],
            ['nim' => '2024014', 'nama' => 'Nadia Khairunnisa', 'id_jurusan' => 3],
            ['nim' => '2024015', 'nama' => 'Omar Bakrie', 'id_jurusan' => 5],
        ];

        foreach ($mahasiswa as $m) {
            Mahasiswa::create($m);
        }

        // ==========================================
        // Buat Data Matakuliah
        // ==========================================
        $matakuliah = [
            ['nama_matakuliah' => 'Algoritma & Pemrograman', 'sks' => 3, 'id_jurusan' => 1],
            ['nama_matakuliah' => 'Basis Data', 'sks' => 3, 'id_jurusan' => 1],
            ['nama_matakuliah' => 'Pemrograman Web', 'sks' => 3, 'id_jurusan' => 1],
            ['nama_matakuliah' => 'Struktur Data', 'sks' => 3, 'id_jurusan' => 1],
            ['nama_matakuliah' => 'Analisis Sistem Informasi', 'sks' => 3, 'id_jurusan' => 2],
            ['nama_matakuliah' => 'Manajemen Proyek IT', 'sks' => 2, 'id_jurusan' => 2],
            ['nama_matakuliah' => 'E-Commerce', 'sks' => 3, 'id_jurusan' => 2],
            ['nama_matakuliah' => 'Rangkaian Listrik', 'sks' => 3, 'id_jurusan' => 3],
            ['nama_matakuliah' => 'Elektronika Digital', 'sks' => 3, 'id_jurusan' => 3],
            ['nama_matakuliah' => 'Mekanika Teknik', 'sks' => 3, 'id_jurusan' => 4],
            ['nama_matakuliah' => 'Termodinamika', 'sks' => 3, 'id_jurusan' => 4],
            ['nama_matakuliah' => 'Jaringan Komputer', 'sks' => 3, 'id_jurusan' => 5],
            ['nama_matakuliah' => 'Keamanan Sistem', 'sks' => 2, 'id_jurusan' => 5],
        ];

        foreach ($matakuliah as $mk) {
            Matakuliah::create($mk);
        }
    }
}
