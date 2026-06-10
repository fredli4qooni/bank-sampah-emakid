<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_faq';

    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'urutan',
        'kategori',
        'status',
    ];
}