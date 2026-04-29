<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_user',
        'waktu_mulai',
        'waktu_selesai',
        'tujuan',
        'surat',
        'waktu_pengajuan',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function ruangan()
    {
        return $this->belongsToMany(
            Ruangan::class,
            'detail_peminjaman',
            'id_peminjaman',
            'id_ruangan'
        );
    }

    public function persetujuan()
    {
        return $this->hasMany(Persetujuan::class, 'id_peminjaman');
    }
}