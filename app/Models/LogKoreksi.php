<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogKoreksi extends Model
{
    use HasFactory;

    protected $table = 'log_koreksi';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_transaksi',
        'id_admin',
        'catatan_alasan',
        'field_sebelum',
        'field_sesudah',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
}
