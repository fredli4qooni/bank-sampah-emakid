<?php

namespace App\Http\Controllers;

use App\Models\PenarikanSaldo;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenarikanController extends Controller
{
    public function index()
    {
        $penarikan = PenarikanSaldo::with(['nasabah', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('penarikan.index', compact('penarikan'));
    }

    public function create()
    {
        $nasabah = Nasabah::where('saldo', '>', 0)->orderBy('nama', 'asc')->get();
        return view('penarikan.create', compact('nasabah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_nasabah' => 'required|exists:nasabah,id_nasabah',
            'nominal' => 'required|numeric|min:100',
            'metode' => 'required|in:Tunai,Transfer Bank,E-Wallet (Dana/OVO/GoPay),Token Listrik,Lainnya',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $nasabah = Nasabah::findOrFail($request->id_nasabah);

        if ($request->nominal > $nasabah->saldo) {
            return back()->withInput()->with('error', 'Gagal: Nominal penarikan (Rp ' . number_format($request->nominal, 0, ',', '.') . ') melebihi sisa saldo nasabah (Rp ' . number_format($nasabah->saldo, 0, ',', '.') . ').');
        }

        DB::beginTransaction();
        try {
            PenarikanSaldo::create([
                'id_nasabah' => $nasabah->id_nasabah,
                'id_admin' => Auth::id(),
                'nominal' => $request->nominal,
                'metode' => $request->metode,
                'keterangan' => $request->keterangan,
            ]);

            $nasabah->decrement('saldo', $request->nominal);

            DB::commit();
            return redirect()->route('penarikan.index')->with('success', 'Penarikan saldo berhasil diproses. Saldo nasabah telah dikurangi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}