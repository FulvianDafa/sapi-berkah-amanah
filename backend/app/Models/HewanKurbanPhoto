<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HewanKurbanPhoto extends Model
{
    protected $fillable = [
        'hewan_kurban_id',
        'public_id',
        'url',
        'order'
    ];

    public function hewanKurban()
    {
        return $this->belongsTo(HewanKurban::class);
    }
}