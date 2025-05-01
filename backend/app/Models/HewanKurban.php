<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HewanKurban extends Model
{
    protected $fillable = [
        'jenis_sapi',
        'umur',
        'berat',
        'harga',
        'deskripsi',
        'video_url'
    ];

    // Relasi ke foto-foto
    public function photos()
    {
        return $this->hasMany(HewanKurbanPhoto::class);
    }
}
