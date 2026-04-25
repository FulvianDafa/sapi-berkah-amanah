<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hewan_kurbans', function (Blueprint $table) {
            $table->enum('jenis_hewan', ['sapi', 'kambing', 'domba'])->default('sapi')->change();
        });
    }

    public function down(): void
    {
        Schema::table('hewan_kurbans', function (Blueprint $table) {
            $table->enum('jenis_hewan', ['sapi', 'kambing'])->default('sapi')->change();
        });
    }
};
