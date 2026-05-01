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
        $kampus = Kampus::create(['nama_kampus' => 'Telkom University']);

        $cabangBandung = Cabang::create([
            'id_kampus' => $kampus->id_kampus,
            'nama_cabang' => 'Bandung',
            'alamat' => 'Jl. Telekomunikasi No.1, Dayeuhkolot',
            'kontak' => '0812340001',
        ]);
        $cabangJakarta = Cabang::create([
            'id_kampus' => $kampus->id_kampus,
            'nama_cabang' => 'Jakarta',
            'alamat' => 'Jl. Daan Mogot No.11',
            'kontak' => '0812340002',
        ]);
        $cabangSurabaya = Cabang::create([
            'id_kampus' => $kampus->id_kampus,
            'nama_cabang' => 'Surabaya',
            'alamat' => 'Jl. Ketintang No.156',
            'kontak' => '0812340003',
        ]);
        $cabangPurwokerto = Cabang::create([
            'id_kampus' => $kampus->id_kampus,
            'nama_cabang' => 'Purwokerto',
            'alamat' => 'Jl. DI Panjaitan No.128',
            'kontak' => '0812340004',
        ]);

        $fakultasBandung = [];
        foreach ([
            'Fakultas Teknik Elektro (FTE)',
            'Fakultas Informatika (FIF)',
            'Fakultas Rekayasa Industri (FRI)',
            'Fakultas Ekonomi dan Bisnis (FEB)',
            'Fakultas Komunikasi dan Ilmu Sosial (FKIS)',
            'Fakultas Industri Kreatif (FIK)',
            'Fakultas Ilmu Terapan (FIT)',
        ] as $nama) {
            $f = Fakultas::create(['id_cabang' => $cabangBandung->id_cabang, 'nama_fakultas' => $nama]);
            $fakultasBandung[$nama] = $f;
        }
        foreach ([
            'Fakultas Teknik Elektro (FTE)',
            'Fakultas Rekayasa Industri (FRI)',
            'Fakultas Informatika (FIF)',
            'Fakultas Industri Kreatif (FIK)',
        ] as $nama) {
            Fakultas::create(['id_cabang' => $cabangJakarta->id_cabang, 'nama_fakultas' => $nama]);
        }
        foreach ([
            'Fakultas Teknik Elektro (FTE)',
            'Fakultas Rekayasa Industri (FRI)',
            'Fakultas Informatika (FIF)',
            'Fakultas Ekonomi dan Bisnis (FEB)',
        ] as $nama) {
            Fakultas::create(['id_cabang' => $cabangSurabaya->id_cabang, 'nama_fakultas' => $nama]);
        }
        foreach ([
            'Fakultas Teknik Elektro (FTE)',
            'Fakultas Rekayasa Industri (FRI)',
            'Fakultas Informatika (FIF)',
            'Fakultas Ilmu Terapan (FIT)',
            'Fakultas Ekonomi dan Bisnis (FEB)',
            'Fakultas Industri Kreatif (FIK)',
        ] as $nama) {
            Fakultas::create(['id_cabang' => $cabangPurwokerto->id_cabang, 'nama_fakultas' => $nama]);
        }

        $fifBandung = $fakultasBandung['Fakultas Informatika (FIF)'];

        $gedungFif = Gedung::create([
            'id_cabang' => $cabangBandung->id_cabang,
            'id_fakultas' => $fifBandung->id_fakultas,
            'kode_gedung' => 'BDG-FIF-01',
            'nama_gedung' => 'Gedung Fakultas Informatika',
            'jumlah_lantai' => 5,
            'kategori' => 'fakultas',
        ]);
        $gedungUmumBandung = Gedung::create([
            'id_cabang' => $cabangBandung->id_cabang,
            'kode_gedung' => 'BDG-UMM-01',
            'nama_gedung' => 'Gedung Kuliah Umum Bandung',
            'jumlah_lantai' => 4,
            'kategori' => 'umum',
        ]);
        $gedungUmumJakarta = Gedung::create([
            'id_cabang' => $cabangJakarta->id_cabang,
            'kode_gedung' => 'JKT-UMM-01',
            'nama_gedung' => 'Gedung Kuliah Umum Jakarta',
            'jumlah_lantai' => 3,
            'kategori' => 'umum',
        ]);
        $gedungUmumSurabaya = Gedung::create([
            'id_cabang' => $cabangSurabaya->id_cabang,
            'kode_gedung' => 'SBY-UMM-01',
            'nama_gedung' => 'Gedung Kuliah Umum Surabaya',
            'jumlah_lantai' => 3,
            'kategori' => 'umum',
        ]);
        $gedungUmumPurwokerto = Gedung::create([
            'id_cabang' => $cabangPurwokerto->id_cabang,
            'kode_gedung' => 'PWK-UMM-01',
            'nama_gedung' => 'Gedung Kuliah Umum Purwokerto',
            'jumlah_lantai' => 3,
            'kategori' => 'umum',
        ]);

        Ruangan::create([
            'id_gedung' => $gedungFif->id_gedung,
            'nomor_ruangan' => 'A101',
            'nama_ruangan' => 'Ruang Kelas A101',
            'kapasitas' => 40,
            'fasilitas' => 'AC, Proyektor',
            'lantai' => 1,
            'tipe_ruangan' => 'kelas',
        ]);
        Ruangan::create([
            'id_gedung' => $gedungFif->id_gedung,
            'nomor_ruangan' => 'LAB201',
            'nama_ruangan' => 'Laboratorium Komputer',
            'kapasitas' => 35,
            'fasilitas' => 'PC, AC, Proyektor',
            'lantai' => 2,
            'tipe_ruangan' => 'laboratorium',
        ]);
        Ruangan::create([
            'id_gedung' => $gedungUmumBandung->id_gedung,
            'nomor_ruangan' => 'AUD1',
            'nama_ruangan' => 'Auditorium Utama',
            'kapasitas' => 200,
            'fasilitas' => 'Sound system, panggung, AC',
            'lantai' => 1,
            'tipe_ruangan' => 'auditorium',
        ]);
        Ruangan::create([
            'id_gedung' => $gedungUmumJakarta->id_gedung,
            'nomor_ruangan' => 'S301',
            'nama_ruangan' => 'Ruang Seminar Jakarta',
            'kapasitas' => 80,
            'fasilitas' => 'Proyektor, Sound system, Hybrid meeting',
            'lantai' => 3,
            'tipe_ruangan' => 'seminar',
        ]);
        Ruangan::create([
            'id_gedung' => $gedungUmumSurabaya->id_gedung,
            'nomor_ruangan' => 'K201',
            'nama_ruangan' => 'Ruang Kelas Surabaya',
            'kapasitas' => 45,
            'fasilitas' => 'AC, Proyektor',
            'lantai' => 2,
            'tipe_ruangan' => 'kelas',
        ]);
        Ruangan::create([
            'id_gedung' => $gedungUmumPurwokerto->id_gedung,
            'nomor_ruangan' => 'LAB102',
            'nama_ruangan' => 'Laboratorium Purwokerto',
            'kapasitas' => 30,
            'fasilitas' => 'PC Lab, AC, Smart TV',
            'lantai' => 1,
            'tipe_ruangan' => 'laboratorium',
        ]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('123456'),
            'id_cabang' => $cabangBandung->id_cabang,
            'id_fakultas' => $fifBandung->id_fakultas,
            'role' => 'super_admin',
            'admin_level' => 'super',
        ]);
        User::create([
            'name' => 'Admin Fakultas',
            'email' => 'admin.fakultas@gmail.com',
            'password' => bcrypt('123456'),
            'id_cabang' => $cabangBandung->id_cabang,
            'id_fakultas' => $fifBandung->id_fakultas,
            'role' => 'admin',
            'admin_level' => 'fakultas',
        ]);
        User::create([
            'name' => 'Admin Gedung',
            'email' => 'admin.gedung@gmail.com',
            'password' => bcrypt('123456'),
            'id_cabang' => $cabangBandung->id_cabang,
            'id_fakultas' => $fifBandung->id_fakultas,
            'id_gedung' => $gedungFif->id_gedung,
            'role' => 'admin',
            'admin_level' => 'gedung',
        ]);
        User::create([
            'name' => 'Dosen',
            'email' => 'dosen@gmail.com',
            'password' => bcrypt('123456'),
            'id_cabang' => $cabangBandung->id_cabang,
            'id_fakultas' => $fifBandung->id_fakultas,
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('123456'),
            'id_cabang' => $cabangJakarta->id_cabang,
            'id_fakultas' => null,
            'role' => 'staff',
        ]);
    }
}