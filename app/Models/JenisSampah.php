<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    use HasFactory;

    protected $table = 'jenis_sampah';
    protected $primaryKey = 'id_jenis';

    protected $fillable = [
        'nama_sampah',
        'satuan',
        'harga_per_kg',
        'status_aktif',
    ];
}
