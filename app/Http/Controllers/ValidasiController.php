<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\LogKoreksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    public function index()
    {
        $transaksiPending = Transaksi::with(['nasabah', 'penimbang'])
            ->where('status_validasi', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('validasi.index', compact('transaksiPending'));
    }

    public function show(int $id_transaksi)
    {
        $transaksi = Transaksi::with(['nasabah', 'penimbang', 'detail.jenisSampah'])->findOrFail($id_transaksi);

        if ($transaksi->status_validasi !== 'pending') {
            return redirect()->route('validasi.index')->with('error', 'Transaksi ini sudah diproses.');
        }

        return view('validasi.show', compact('transaksi'));
    }

    public function process(Request $request, int $id_transaksi)
    {
        $transaksi = Transaksi::with(['detail', 'nasabah'])->findOrFail($id_transaksi);

        if ($transaksi->status_validasi !== 'pending') {
            return redirect()->route('validasi.index')->with('error', 'Transaksi sudah diproses sebelumnya.');
        }

        DB::beginTransaction();

        try {
            $pesan = 'Transaksi berhasil diproses.';

            if ($request->action === 'validasi') {
                $transaksi->update(['status_validasi' => 'valid']);

                $transaksi->nasabah->increment('saldo', $transaksi->total_nilai);

                $pesan = 'Transaksi berhasil divalidasi. Saldo nasabah telah diperbarui.';
            } elseif ($request->action === 'koreksi') {
                $request->validate([
                    'berat_gudang' => 'required|array',
                    'catatan_alasan' => 'required|string',
                ]);

                $oldData = clone $transaksi;
                $oldData->load('detail');

                $newTotal = 0;

                foreach ($transaksi->detail as $detail) {
                    $beratGudang = $request->berat_gudang[$detail->id_detail];
                    $subtotalBaru = $beratGudang * $detail->harga_saat_transaksi;

                    $detail->update([
                        'berat' => $beratGudang,
                        'subtotal' => $subtotalBaru
                    ]);
                    $newTotal += $subtotalBaru;
                }

                $transaksi->update([
                    'status_validasi' => 'terkoreksi',
                    'total_nilai' => $newTotal
                ]);

                $newData = $transaksi->fresh('detail');

                LogKoreksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_admin' => Auth::id(),
                    'catatan_alasan' => $request->catatan_alasan,
                    'field_sebelum' => json_encode($oldData->toArray()),
                    'field_sesudah' => json_encode($newData->toArray()),
                ]);

                $transaksi->nasabah->increment('saldo', $newTotal);

                $pesan = 'Koreksi berhasil disimpan dan divalidasi. Audit log telah dicatat.';
            } else {
                throw new \Exception('Aksi tidak dikenali sistem.');
            }

            DB::commit();
            return redirect()->route('validasi.index')->with('success', $pesan);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
