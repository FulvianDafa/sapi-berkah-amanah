<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HewanKurban;

class HewanKurbanSeeder extends Seeder
{
    public function run()
    {  
        HewanKurban::create([
            'nama' => 'Sapi Kurban 01',
            'deskripsi' => 'Sapi besar dengan harga terjangkau.',
            'berat' => 200,
            'harga' => 15000000,
        ]);

        HewanKurban::create([
            'nama' => 'Sapi Kurban 02',
            'deskripsi' => 'Sapi kecil, ideal untuk keluarga.',
            'berat' => 180,
            'harga' => 12000000,
        ]);
    }
}
