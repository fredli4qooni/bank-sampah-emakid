<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id('id_unit');
            $table->string('nama_unit', 100);
            $table->string('kecamatan', 100); 
            $table->string('nama_ketua', 100)->nullable();
            $table->string('no_hp_ketua', 15)->nullable();
            $table->date('tanggal_daftar');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};