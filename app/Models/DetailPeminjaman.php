<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjaman';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_peminjaman',
        'id_ruangan'
    ];
}