<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'file_size',
        'status',
        'keterangan',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}