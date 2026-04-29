<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = 'fakultas';
    protected $primaryKey = 'id_fakultas';

    protected $fillable = ['id_cabang', 'nama_fakultas'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function gedung()
    {
        return $this->hasMany(Gedung::class, 'id_fakultas');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id_fakultas');
    }
}