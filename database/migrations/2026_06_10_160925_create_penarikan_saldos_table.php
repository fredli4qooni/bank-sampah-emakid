<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penarikan_saldos', function (Blueprint $table) {
            $table->id('id_penarikan');
            
            $table->unsignedBigInteger('id_nasabah');
            $table->unsignedBigInteger('id_admin');
            
            $table->decimal('nominal', 15, 2);
            $table->enum('metode', ['Tunai', 'Transfer Bank', 'E-Wallet (Dana/OVO/GoPay)', 'Token Listrik', 'Lainnya']);
            $table->text('keterangan')->nullable();
            
            $table->timestamps();

            $table->foreign('id_nasabah')->references('id_nasabah')->on('nasabah')->onDelete('cascade');
            $table->foreign('id_admin')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penarikan_saldos');
    }
};