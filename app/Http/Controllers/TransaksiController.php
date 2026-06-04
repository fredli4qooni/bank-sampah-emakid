<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Nasabah;
use App\Models\JenisSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function create()
    {
        $nasabah = Nasabah::orderBy('nama', 'asc')->get();
        
        $jenisSampah = JenisSampah::where('status_aktif', true)->orderBy('nama_sampah', 'asc')->get();

        return view('transaksi.create', compact('nasabah', 'jenisSampah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_nasabah' => 'required|exists:nasabah,id_nasabah',
            'id_jenis' => 'required|array|min:1',
            'id_jenis.*' => 'required|exists:jenis_sampah,id_jenis',
            'berat' => 'required|array|min:1',
            'berat.*' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();

        try {
            $transaksi = Transaksi::create([
                'id_nasabah' => $request->id_nasabah,
                'id_user' => Auth::id(),
                'status_validasi' => 'pending',
                'total_nilai' => 0,
            ]);

            $totalTransaksi = 0;

            foreach ($request->id_jenis as $index => $id_jenis) {
                $berat = $request->berat[$index];
                
                $jenis = JenisSampah::find($id_jenis);
                $hargaSaatIni = $jenis->harga_per_kg;
                
                $subtotal = $berat * $hargaSaatIni;

                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_jenis' => $id_jenis,
                    'berat' => $berat,
                    'harga_saat_transaksi' => $hargaSaatIni,
                    'subtotal' => $subtotal,
                ]);

                $totalTransaksi += $subtotal;
            }

            $transaksi->update([
                'total_nilai' => $totalTransaksi
            ]);

            DB::commit();

            return redirect()->route('transaksi.create')->with('success', 'Transaksi berhasil disimpan dan menunggu validasi Admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}