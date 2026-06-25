<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PublicController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('status', 'aktif')->orderBy('urutan', 'asc')->get();
        return view('welcome', compact('faqs'));
    }

    public function tentangKami()
    {
        return view('public.tentang-kami');
    }

    public function program()
    {
        return view('public.program');
    }



    public function dokumentasi()
    {
        $dokumentasi = \App\Models\Dokumentasi::latest()->paginate(12);
        return view('public.dokumentasi', compact('dokumentasi'));
    }

    public function storeCalonUnit(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'jadwal_edukasi' => 'required|date',
        ]);

        \App\Models\CalonUnit::create($request->all());

        return back()->with('success', 'Pendaftaran berhasil dikirim! Tim kami akan segera menghubungi Anda melalui WhatsApp.');
    }
}