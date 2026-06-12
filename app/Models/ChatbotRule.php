<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotRule extends Model
{
    protected $fillable = ['nama_aturan', 'keywords', 'jenis_aksi', 'handler_sistem', 'balasan_teks'];
}