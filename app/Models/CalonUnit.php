<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonUnit extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_calon';

    protected $fillable = [
        'nama_lengkap',
        'no_wa',
        'alamat_lengkap',
        'jadwal_edukasi',
        'status',
    ];
}
