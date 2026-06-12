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

    public function cetakBuku(Nasabah $nasabah)
    {
        $transaksi = \App\Models\Transaksi::where('id_nasabah', $nasabah->id_nasabah)
            ->where('status_validasi', 'valid')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->created_at,
                    'jenis' => 'Setoran',
                    'keterangan' => 'Setoran Sampah (#' . $item->id_transaksi . ')',
                    'debit' => 0,
                    'kredit' => $item->total_nilai,
                ];
            });

        $penarikan = \App\Models\PenarikanSaldo::where('id_nasabah', $nasabah->id_nasabah)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->created_at,
                    'jenis' => 'Penarikan',
                    'keterangan' => 'Penarikan ' . $item->metode . ' (#' . $item->id_penarikan . ')',
                    'debit' => $item->nominal,
                    'kredit' => 0,
                ];
            });

        $mutasi = $transaksi->concat($penarikan)->sortBy('tanggal');

        $mutasiWithSaldo = [];
        $saldo = 0;
        foreach ($mutasi as $m) {
            $saldo += $m['kredit'];
            $saldo -= $m['debit'];
            $mutasiWithSaldo[] = [
                'tanggal' => $m['tanggal'],
                'jenis' => $m['jenis'],
                'keterangan' => $m['keterangan'],
                'debit' => $m['debit'],
                'kredit' => $m['kredit'],
                'saldo' => $saldo,
            ];
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('nasabah.buku_tabungan', compact('nasabah', 'mutasiWithSaldo'));
        return $pdf->stream('Buku_Tabungan_' . $nasabah->no_rekening . '.pdf');
    }
}