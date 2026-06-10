<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('backup_logs');

        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id('id_log');
            
            $table->unsignedBigInteger('admin_id');
            
            $table->string('file_size')->nullable();
            $table->enum('status', ['Berhasil', 'Gagal']);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_logs');
    }
};