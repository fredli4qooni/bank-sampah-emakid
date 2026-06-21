<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenarikanSaldo extends Model
{
    use HasFactory;

    protected $table = 'penarikan_saldos';
    protected $primaryKey = 'id_penarikan';

    protected $fillable = [
        'id_nasabah',
        'id_admin',
        'nominal',
        'biaya_admin',
        'metode',
        'keterangan',
        'nomor_token',
        'bukti_transfer',
        'status',
    ];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'id_nasabah', 'id_nasabah');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }
}