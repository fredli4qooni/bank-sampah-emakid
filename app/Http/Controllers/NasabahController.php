<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NasabahController extends Controller
{
    public function index()
    {
        $nasabah = Nasabah::with('unit')->orderBy('id_nasabah', 'desc')->get();
        return view('nasabah.index', compact('nasabah'));
    }

    public function create()
    {
        Gate::authorize('isAdmin');
        $units = Unit::where('status', 'aktif')->orderBy('nama_unit', 'asc')->get();
        return view('nasabah.create', compact('units'));
    }

    public function store(Request $request)
    {
        Gate::authorize('isAdmin');

        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'kecamatan' => 'nullable|string|max:50',
            'id_unit' => 'required|exists:units,id_unit',
        ]);

        $lastNasabah = Nasabah::orderBy('id_nasabah', 'desc')->first();
        $nextId = $lastNasabah ? $lastNasabah->id_nasabah + 1 : 1;
        $noRekening = 'EMK-' . date('ym') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        Nasabah::create([
            'no_rekening' => $noRekening,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'no_hp' => $request->no_hp,
            'saldo' => 0.00,
            'id_unit' => $request->id_unit,
        ]);

        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil didaftarkan.');
    }

    public function edit(Nasabah $nasabah)
    {
        Gate::authorize('isAdmin');
        $units = Unit::where('status', 'aktif')->orderBy('nama_unit', 'asc')->get();
        return view('nasabah.edit', compact('nasabah', 'units'));
    }

    public function update(Request $request, Nasabah $nasabah)
    {
        Gate::authorize('isAdmin');

        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'kecamatan' => 'nullable|string|max:50',
            'id_unit' => 'required|exists:units,id_unit',
        ]);

        $nasabah->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'no_hp' => $request->no_hp,
            'id_unit' => $request->id_unit,
        ]);

        return redirect()->route('nasabah.index')->with('success', 'Data nasabah berhasil diperbarui.');
    }

    public function destroy(Nasabah $nasabah)
    {
        Gate::authorize('isAdmin');
        $nasabah->delete();

        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil dihapus.');
    }
}