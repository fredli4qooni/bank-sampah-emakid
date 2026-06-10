<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('status', 'aktif')->orderBy('urutan', 'asc')->get();
        
        return view('welcome', compact('faqs'));
    }
}