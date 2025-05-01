<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHewanKurbanPhotosTable extends Migration
{
    public function up()
    {
        Schema::create('hewan_kurban_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hewan_kurban_id')
                  ->constrained('hewan_kurbans')
                  ->onDelete('cascade'); // Jika hewan kurban dihapus, fotonya juga terhapus
            $table->string('public_id'); // ID dari Cloudinary untuk keperluan delete
            $table->string('url');       // URL foto dari Cloudinary
            $table->integer('order')     // Urutan foto (0 = foto utama/thumbnail)
                  ->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hewan_kurban_photos');
    }
}