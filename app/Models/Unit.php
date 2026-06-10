<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_unit';

    protected $fillable = [
        'nama_unit',
        'kecamatan',
        'nama_ketua',
        'no_hp_ketua',
        'tanggal_daftar',
        'status',
    ];

    public function nasabah()
    {
        return $this->hasMany(Nasabah::class, 'id_unit', 'id_unit');
    }
}