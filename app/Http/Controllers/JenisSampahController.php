<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use Illuminate\Http\Request;

class JenisSampahController extends Controller
{
    public function index()
    {
        $jenisSampah = JenisSampah::orderBy('id_jenis', 'desc')->get();
        return view('jenis_sampah.index', compact('jenisSampah'));
    }

    public function create()
    {
        return view('jenis_sampah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sampah' => 'required|string|max:50',
            'harga_per_kg' => 'required|numeric|min:0',
        ]);

        JenisSampah::create([
            'nama_sampah' => $request->nama_sampah,
            'harga_per_kg' => $request->harga_per_kg,
            'status_aktif' => true,
        ]);

        return redirect()->route('jenis-sampah.index')->with('success', 'Jenis sampah berhasil ditambahkan.');
    }

    public function edit(JenisSampah $jenisSampah)
    {
        return view('jenis_sampah.edit', compact('jenisSampah'));
    }

    public function update(Request $request, JenisSampah $jenisSampah)
    {
        $request->validate([
            'nama_sampah' => 'required|string|max:50',
            'harga_per_kg' => 'required|numeric|min:0',
            'status_aktif' => 'required|boolean',
        ]);

        $jenisSampah->update([
            'nama_sampah' => $request->nama_sampah,
            'harga_per_kg' => $request->harga_per_kg,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()->route('jenis-sampah.index')->with('success', 'Data jenis sampah berhasil diperbarui.');
    }

    public function destroy(JenisSampah $jenisSampah)
    {
        $jenisSampah->update(['status_aktif' => false]);

        return redirect()->route('jenis-sampah.index')->with('success', 'Jenis sampah berhasil dinonaktifkan.');
    }
}