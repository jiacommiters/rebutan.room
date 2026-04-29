<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';

    protected $fillable = [
        'id_gedung',
        'nomor_ruangan',
        'nama_ruangan',
        'kapasitas',
        'fasilitas',
        'lantai',
        'tipe_ruangan'
    ];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'id_gedung');
    }

    public function peminjaman()
    {
        return $this->belongsToMany(
            Peminjaman::class,
            'detail_peminjaman',
            'id_ruangan',
            'id_peminjaman'
        );
    }
}