<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('created_at', 'desc')->get();
        return view('units.index', compact('units'));
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit'      => 'required|string|max:100',
            'kecamatan'      => 'required|string|max:100',
            'nama_ketua'     => 'nullable|string|max:100',
            'no_hp_ketua'    => 'nullable|string|max:15',
            'tanggal_daftar' => 'required|date',
            'status'         => 'required|in:aktif,nonaktif',
        ]);

        Unit::create($request->all());

        return redirect()->route('units.index')->with('success', 'Unit/Kelompok berhasil ditambahkan.');
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'nama_unit'      => 'required|string|max:100',
            'kecamatan'      => 'required|string|max:100',
            'nama_ketua'     => 'nullable|string|max:100',
            'no_hp_ketua'    => 'nullable|string|max:15',
            'tanggal_daftar' => 'required|date',
            'status'         => 'required|in:aktif,nonaktif',
        ]);

        $unit->update($request->all());

        return redirect()->route('units.index')->with('success', 'Data Unit/Kelompok berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        if ($unit->nasabah()->count() > 0) {
            return redirect()->route('units.index')->with('error', 'Gagal: Unit ini tidak dapat dihapus karena masih memiliki Nasabah aktif.');
        }

        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Unit/Kelompok berhasil dihapus.');
    }
}