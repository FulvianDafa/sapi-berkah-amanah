<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hewan_kurbans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_sapi');  // Tambah jenis sapi
            $table->integer('umur');       // Tambah umur
            $table->integer('berat');      // Sudah ada
            $table->decimal('harga', 15, 2); // Sudah ada
            $table->text('deskripsi')->nullable(); // Sudah ada
            $table->string('video_url')->nullable(); // Untuk video utama
            $table->string('video_public_id')->nullable();
            $table->enum('status', ['tersedia', 'terjual'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hewan_kurbans');
    }
};
