<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persetujuan extends Model
{
    protected $table = 'persetujuan';
    protected $primaryKey = 'id_persetujuan';

    protected $fillable = [
        'id_peminjaman',
        'id_ruangan',
        'id_admin',
        'level_admin',
        'status',
        'waktu_persetujuan',
        'komentar'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}