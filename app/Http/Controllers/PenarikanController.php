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
        $nasabah = Nasabah::with('unit')->where('saldo', '>', 0)->orderBy('nama', 'asc')->get();
        return view('penarikan.create', compact('nasabah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_nasabah' => 'required|exists:nasabah,id_nasabah',
            'nominal' => 'required|numeric|min:100',
            'biaya_admin' => 'nullable|numeric|min:0',
            'metode' => 'required|in:Tunai,Transfer Bank,E-Wallet (Dana/OVO/GoPay),Token Listrik,Lainnya',
            'keterangan' => 'nullable|string|max:255',
            'nomor_token' => 'nullable|string|max:50|required_if:metode,Token Listrik',
            'bukti_transfer' => 'nullable|image|max:2048',
        ]);

        $nasabah = Nasabah::findOrFail($request->id_nasabah);

        if ($request->nominal > $nasabah->saldo) {
            return back()->withInput()->with('error', 'Gagal: Nominal penarikan (Rp ' . number_format($request->nominal, 0, ',', '.') . ') melebihi sisa saldo nasabah (Rp ' . number_format($nasabah->saldo, 0, ',', '.') . ').');
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        }

        DB::beginTransaction();
        try {
            PenarikanSaldo::create([
                'id_nasabah' => $nasabah->id_nasabah,
                'id_admin' => Auth::id(),
                'nominal' => $request->nominal,
                'biaya_admin' => $request->biaya_admin ?? 0,
                'metode' => $request->metode,
                'keterangan' => $request->keterangan,
                'nomor_token' => $request->nomor_token,
                'bukti_transfer' => $buktiPath,
                'status' => 'Approved'
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