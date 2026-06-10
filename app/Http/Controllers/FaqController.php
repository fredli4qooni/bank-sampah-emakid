<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('urutan', 'asc')->get();
        return view('faq.index', compact('faqs'));
    }

    public function create()
    {
        $lastUrutan = Faq::max('urutan') ?? 0;
        $nextUrutan = $lastUrutan + 1;
        
        return view('faq.create', compact('nextUrutan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban'    => 'required|string',
            'urutan'     => 'required|integer|min:1',
            'kategori'   => 'nullable|string|max:50',
            'status'     => 'required|in:aktif,nonaktif',
        ]);

        Faq::create($request->all());

        return redirect()->route('faq.index')->with('success', 'Konten FAQ berhasil ditambahkan.');
    }

    public function edit(Faq $faq)
    {
        return view('faq.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban'    => 'required|string',
            'urutan'     => 'required|integer|min:1',
            'kategori'   => 'nullable|string|max:50',
            'status'     => 'required|in:aktif,nonaktif',
        ]);

        $faq->update($request->all());

        return redirect()->route('faq.index')->with('success', 'Konten FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('faq.index')->with('success', 'Konten FAQ berhasil dihapus secara permanen.');
    }
}