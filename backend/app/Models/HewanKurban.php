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
        'kategori',
        'deskripsi',
        'video_url',
        'video_public_id',
        'status'
    ];

    protected $casts = [
        'umur' => 'float',
    ];

    // Konstanta untuk range harga
    const KATEGORI_RANGES = [
        'prime' => ['min' => 0, 'max' => 25000000],
        'bigboss' => ['min' => 25000001, 'max' => 50000000],
        'sultan' => ['min' => 50000001, 'max' => PHP_FLOAT_MAX]
    ];

    // Method untuk otomatis set kategori berdasarkan harga
    // public function setHargaAttribute($value)
    // {
    //     $this->attributes['harga'] = $value;
    //     
    //     // Set kategori otomatis berdasarkan harga
    //     if ($value <= self::KATEGORI_RANGES['prime']['max']) {
    //         $this->attributes['kategori'] = 'prime';
    //     } elseif ($value <= self::KATEGORI_RANGES['bigboss']['max']) {
    //         $this->attributes['kategori'] = 'bigboss';
    //     } else {
    //         $this->attributes['kategori'] = 'sultan';
    //     }
    // }

    // Scope untuk filter berdasarkan kategori
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Relasi ke foto-foto
    public function photos()
    {
        return $this->hasMany(HewanKurbanPhoto::class);
    }

    // Method untuk mendapatkan label kategori yang lebih user-friendly
    public function getKategoriLabelAttribute()
    {
        $labels = [
            'prime' => 'Prime Class',
            'bigboss' => 'Big Boss Class',
            'sultan' => 'Sultan Class'
        ];

        return $labels[$this->kategori] ?? $this->kategori;
    }

    // Method untuk mendapatkan range harga kategori
    public function getKategoriRangeAttribute()
    {
        $range = self::KATEGORI_RANGES[$this->kategori];
        return [
            'min' => number_format($range['min'], 0, ',', '.'),
            'max' => $range['max'] === PHP_FLOAT_MAX ? '~' : number_format($range['max'], 0, ',', '.')
        ];
    }
}
