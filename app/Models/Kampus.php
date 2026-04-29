<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kampus extends Model
{
    protected $table = 'kampus';
    protected $primaryKey = 'id_kampus';

    protected $fillable = ['nama_kampus'];

    public function cabang()
    {
        return $this->hasMany(Cabang::class, 'id_kampus');
    }
}