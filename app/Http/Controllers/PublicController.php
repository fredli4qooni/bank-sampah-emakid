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

    public function berita()
    {
        $apiKey = '7e4946cec08949f0bdb52083535551a5'; 
        
        $query = '"lingkungan hidup" OR "daur ulang sampah" OR "pengelolaan sampah" OR "bank sampah" OR "perubahan iklim" OR "pemanasan global" OR "sustainability"';

        try {
            $response = Http::get('https://newsapi.org/v2/everything', [
                'q' => $query,
                'language' => 'id', 
                'sortBy' => 'publishedAt', 
                'pageSize' => 6, 
                'apiKey' => $apiKey
            ]);

            $berita = $response->json()['articles'] ?? [];

            $kataTerlarang = ['politik', 'kriminal', 'pembunuhan', 'korupsi', 'pilkada'];
            
            $berita = array_filter($berita, function($item) use ($kataTerlarang) {
                $judul = strtolower($item['title'] ?? '');
                foreach ($kataTerlarang as $larang) {
                    if (str_contains($judul, $larang)) return false;
                }
                return true;
            });

        } catch (\Exception $e) {
            $berita = []; 
        }

        return view('public.berita', compact('berita'));
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