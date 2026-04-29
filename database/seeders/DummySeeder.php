<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kampus;
use App\Models\Cabang;
use App\Models\Fakultas;
use App\Models\Gedung;
use App\Models\Ruangan;
use App\Models\User;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        $kampus = Kampus::create([
            'nama_kampus' => 'Kampus Utama'
        ]);

        $cabangBandung = Cabang::create([
            'id_kampus' => $kampus->id_kampus,
            'nama_cabang' => 'Bandung',
            'alamat' => 'Jl. Raya Bandung',
            'kontak' => '0812340001'
        ]);

        $cabangJakarta = Cabang::create([
            'id_kampus' => $kampus->id_kampus,
            'nama_cabang' => 'Jakarta',
            'alamat' => 'Jl. Raya Jakarta',
            'kontak' => '0812340002'
        ]);

        $fakultasInformatika = Fakultas::create([
            'id_cabang' => $cabangBandung->id_cabang,
            'nama_fakultas' => 'Informatika'
        ]);

        $fakultasBisnis = Fakultas::create([
            'id_cabang' => $cabangJakarta->id_cabang,
            'nama_fakultas' => 'Bisnis'
        ]);

        $gedungFakultas = Gedung::create([
            'id_cabang' => $cabangBandung->id_cabang,
            'id_fakultas' => $fakultasInformatika->id_fakultas,
            'nama_gedung' => 'Gedung Informatika',
            'jumlah_lantai' => 5,
            'kategori' => 'fakultas'
        ]);

        $gedungUmum = Gedung::create([
            'id_cabang' => $cabangBandung->id_cabang,
            'id_fakultas' => null,
            'nama_gedung' => 'Gedung Serbaguna',
            'jumlah_lantai' => 3,
            'kategori' => 'umum'
        ]);

        Ruangan::create([
            'id_gedung' => $gedungFakultas->id_gedung,
            'nomor_ruangan' => 'A101',
            'nama_ruangan' => 'Ruang Kelas A101',
            'kapasitas' => 40,
            'fasilitas' => 'AC, Proyektor',
            'lantai' => 1,
            'tipe_ruangan' => 'kelas'
        ]);

        Ruangan::create([
            'id_gedung' => $gedungFakultas->id_gedung,
            'nomor_ruangan' => 'LAB201',
            'nama_ruangan' => 'Laboratorium Komputer',
            'kapasitas' => 35,
            'fasilitas' => 'PC, AC, Proyektor',
            'lantai' => 2,
            'tipe_ruangan' => 'laboratorium'
        ]);

        Ruangan::create([
            'id_gedung' => $gedungUmum->id_gedung,
            'nomor_ruangan' => 'AUD1',
            'nama_ruangan' => 'Auditorium Utama',
            'kapasitas' => 200,
            'fasilitas' => 'Sound system, panggung, AC',
            'lantai' => 1,
            'tipe_ruangan' => 'auditorium'
        ]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('123456'),
            'id_cabang' => $cabangBandung->id_cabang,
            'id_fakultas' => $fakultasInformatika->id_fakultas,
            'role' => 'super_admin',
            'admin_level' => 'super',
        ]);

        User::create([
            'name' => 'Admin Fakultas',
            'email' => 'admin.fakultas@gmail.com',
            'password' => bcrypt('123456'),
            'id_cabang' => $cabangBandung->id_cabang,
            'id_fakultas' => $fakultasInformatika->id_fakultas,
            'role' => 'admin',
            'admin_level' => 'fakultas',
        ]);

        User::create([
            'name' => 'Admin Gedung',
            'email' => 'admin.gedung@gmail.com',
            'password' => bcrypt('123456'),
            'id_cabang' => $cabangBandung->id_cabang,
            'id_fakultas' => $fakultasInformatika->id_fakultas,
            'id_gedung' => $gedungFakultas->id_gedung,
            'role' => 'admin',
            'admin_level' => 'gedung',
        ]);

        User::create([
            'name' => 'Dosen',
            'email' => 'dosen@gmail.com',
            'password' => bcrypt('123456'),
            'id_cabang' => $cabangBandung->id_cabang,
            'id_fakultas' => $fakultasInformatika->id_fakultas,
            'role' => 'dosen'
        ]);

        User::create([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('123456'),
            'id_cabang' => $cabangJakarta->id_cabang,
            'id_fakultas' => $fakultasBisnis->id_fakultas,
            'role' => 'staff'
        ]);
    }
}