<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabang';
    protected $primaryKey = 'id_cabang';

    protected $fillable = [
        'id_kampus',
        'nama_cabang',
        'alamat',
        'kontak'
    ];

    public function kampus()
    {
        return $this->belongsTo(Kampus::class, 'id_kampus');
    }

    public function fakultas()
    {
        return $this->hasMany(Fakultas::class, 'id_cabang');
    }

    public function gedung()
    {
        return $this->hasMany(Gedung::class, 'id_cabang');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id_cabang');
    }
}