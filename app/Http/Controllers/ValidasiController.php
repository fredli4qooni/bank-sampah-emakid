<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\LogKoreksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    public function index(Request $request)
    {
        // Filter Tanggal (Default: 30 hari terakhir untuk menjaga performa)
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // Ambil semua transaksi beserta relasinya
        $transaksi = Transaksi::with(['nasabah', 'penimbang', 'detail.jenisSampah'])
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        // 1. Ringkasan Global (Summary Cards)
        $summary = [
            'total_berat' => $transaksi->sum(function($t) { return $t->detail->sum('berat'); }),
            'total_transaksi' => $transaksi->count(),
            'pending' => $transaksi->where('status_validasi', 'pending')->count(),
            'total_nilai' => $transaksi->sum('total_nilai'),
        ];

        // 2. Tab A: Agregasi Total Harian
        $tabHarian = $transaksi->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d');
        })->map(function($group, $date) {
            return $this->formatGrupData($group, ['tanggal' => $date]);
        });

        // 3. Tab B: Agregasi Per Penimbang
        $tabPenimbang = $transaksi->groupBy(function($item) {
            return $item->id_user . '|' . \Carbon\Carbon::parse($item->created_at)->format('Y-m-d');
        })->map(function($group, $key) {
            $parts = explode('|', $key);
            return $this->formatGrupData($group, [
                'id_user' => $parts[0],
                'nama_penimbang' => $group->first()->penimbang->name,
                'tanggal' => $parts[1]
            ]);
        });

        return view('validasi.index', compact('tabHarian', 'tabPenimbang', 'summary', 'startDate', 'endDate'));
    }

    // Fungsi Helper untuk merapikan data grup
    private function formatGrupData(\Illuminate\Support\Collection $group, array $extraData = [])
    {
        $statusAgregat = 'Semua Valid';
        if ($group->where('status_validasi', 'pending')->count() > 0) $statusAgregat = 'Ada Pending';
        elseif ($group->where('status_validasi', 'terkoreksi')->count() > 0) $statusAgregat = 'Ada Koreksi';

        $data = [
            'total_berat' => $group->sum(function($t) { return $t->detail->sum('berat'); }),
            'jml_transaksi' => $group->count(),
            'total_nilai' => $group->sum('total_nilai'),
            'transaksi' => $group,
            'status_agregat' => $statusAgregat,
            'id_transaksi_pending' => $group->where('status_validasi', 'pending')->pluck('id_transaksi')->implode(',')
        ];

        return array_merge($extraData, $data);
    }

    // FUNGSI BARU: Validasi Massal (Bulk Validate)
    public function bulkProcess(Request $request)
    {
        $request->validate(['ids' => 'required|string']);
        
        $ids = explode(',', $request->ids);
        $transaksis = Transaksi::with('nasabah')
                        ->whereIn('id_transaksi', $ids)
                        ->where('status_validasi', 'pending')
                        ->get();

        DB::beginTransaction();
        try {
            foreach($transaksis as $trx) {
                $trx->update(['status_validasi' => 'valid']);
                $trx->nasabah->increment('saldo', $trx->total_nilai);
            }
            DB::commit();
            return back()->with('success', count($transaksis) . ' transaksi berhasil divalidasi secara massal.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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