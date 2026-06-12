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
        Schema::table('penarikan_saldos', function (Blueprint $table) {
            $table->string('nomor_token', 50)->nullable()->after('keterangan');
            $table->string('bukti_transfer')->nullable()->after('nomor_token');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Approved')->after('bukti_transfer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penarikan_saldos', function (Blueprint $table) {
            $table->dropColumn(['nomor_token', 'bukti_transfer', 'status']);
        });
    }
};
