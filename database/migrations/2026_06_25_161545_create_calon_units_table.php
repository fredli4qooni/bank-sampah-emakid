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
        Schema::create('calon_units', function (Blueprint $table) {
            $table->id('id_calon');
            $table->string('nama_lengkap');
            $table->string('no_wa');
            $table->text('alamat_lengkap');
            $table->date('jadwal_edukasi');
            $table->enum('status', ['pending', 'dihubungi'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_units');
    }
};
