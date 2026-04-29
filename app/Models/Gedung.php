<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    protected $table = 'gedung';
    protected $primaryKey = 'id_gedung';

    protected $fillable = [
        'id_cabang',
        'id_fakultas',
        'kode_gedung',
        'nama_gedung',
        'jumlah_lantai',
        'kategori'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'id_fakultas');
    }

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class, 'id_gedung');
    }
}