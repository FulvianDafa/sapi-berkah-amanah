<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hewan_kurbans', function (Blueprint $table) {
            $table->enum('jenis_hewan', ['sapi', 'kambing'])->default('sapi')->after('id');
            $table->renameColumn('jenis_sapi', 'nama');
            $table->float('umur')->nullable()->change();
            $table->integer('berat')->nullable()->change();
            $table->enum('kategori', ['prime', 'bigboss', 'sultan'])->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('hewan_kurbans', function (Blueprint $table) {
            $table->renameColumn('nama', 'jenis_sapi');
            $table->dropColumn('jenis_hewan');
            $table->float('umur')->nullable(false)->change();
            $table->integer('berat')->nullable(false)->change();
            $table->enum('kategori', ['prime', 'bigboss', 'sultan'])->nullable(false)->change();
        });
    }
};
