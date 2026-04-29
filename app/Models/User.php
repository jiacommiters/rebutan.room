<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'id_cabang',
    'id_fakultas',
    'nim_nip',
    'role',
    'admin_level',
    'id_gedung'
])]

#[Hidden([
    'password',
    'remember_token'
])]

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * RELATION
     */

    // user -> cabang
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    // user -> fakultas
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'id_fakultas');
    }

    // user -> gedung (untuk admin gedung)
    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'id_gedung');
    }

    // user -> peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_user');
    }

    // user (admin) -> persetujuan
    public function persetujuan()
    {
        return $this->hasMany(Persetujuan::class, 'id_admin');
    }

    /**
     * ROLE HELPERS
     */

    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin' || $this->admin_level === 'super';
    }

    public function isAdminFakultas()
    {
        return $this->isAdmin() && $this->admin_level === 'fakultas';
    }

    public function isAdminGedung()
    {
        return $this->isAdmin() && $this->admin_level === 'gedung';
    }

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    /**
     * Cek apakah admin punya wewenang atas ruangan tertentu
     */
    public function canApproveRuangan(Ruangan $ruangan)
    {
        // Super admin bisa approve semua
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Admin gedung: hanya ruangan di gedung yang di-assign
        if ($this->isAdminGedung() && $this->id_gedung) {
            return $ruangan->id_gedung == $this->id_gedung;
        }

        // Admin fakultas: hanya ruangan di gedung milik fakultasnya
        if ($this->isAdminFakultas() && $this->id_fakultas) {
            $gedung = $ruangan->gedung;
            return $gedung && $gedung->id_fakultas == $this->id_fakultas;
        }

        return false;
    }

    /**
     * Tentukan level admin otomatis
     */
    public function getAdminLevelLabel()
    {
        if ($this->isSuperAdmin()) return 'super';
        if ($this->isAdminFakultas()) return 'fakultas';
        if ($this->isAdminGedung()) return 'gedung';
        return $this->admin_level ?? 'gedung';
    }

    /**
     * CAST
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}