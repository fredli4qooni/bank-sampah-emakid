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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_nasabah');
            $table->unsignedBigInteger('id_user');
            $table->enum('status_validasi', ['pending', 'valid', 'terkoreksi'])->default('pending');
            $table->decimal('total_nilai', 12, 2)->default(0);
            $table->timestamps();

            $table->foreign('id_nasabah')->references('id_nasabah')->on('nasabah')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
