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
        Schema::table('hewan_kurbans', function (Blueprint $table) {
            $table->float('umur', 8, 1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hewan_kurbans', function (Blueprint $table) {
            $table->integer('umur')->change();
        });
    }
};
