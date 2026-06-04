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
        Schema::create('log_koreksi', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_admin');
            $table->text('catatan_alasan');
            $table->text('field_sebelum');
            $table->text('field_sesudah');
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');
            $table->foreign('id_admin')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_koreksi');
    }
};
