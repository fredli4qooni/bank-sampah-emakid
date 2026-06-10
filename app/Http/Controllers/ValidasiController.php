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
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $transaksi = Transaksi::with(['nasabah', 'penimbang', 'detail.jenisSampah'])
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $summary = [
            'total_berat' => $transaksi->sum(function($t) { return $t->detail->sum('berat'); }),
            'total_transaksi' => $transaksi->count(),
            'pending' => $transaksi->where('status_validasi', 'pending')->count(),
            'total_nilai' => $transaksi->sum('total_nilai'),
        ];

        $tabHarian = $transaksi->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d');
        })->map(function($group, $date) {
            return $this->formatGrupData($group, ['tanggal' => $date]);
        });

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

    private function formatGrupData(\Illuminate\Support\Collection $group, array $extraData = [])
    {
        $pendingGroup = $group->where('status_validasi', 'pending');
        
        $statusAgregat = 'Semua Valid';
        if ($pendingGroup->count() > 0) $statusAgregat = 'Ada Pending';
        elseif ($group->where('status_validasi', 'terkoreksi')->count() > 0) $statusAgregat = 'Ada Koreksi';

        $data = [
            'total_berat' => $group->sum(function($t) { return $t->detail->sum('berat'); }),
            'total_berat_pending' => $pendingGroup->sum(function($t) { return $t->detail->sum('berat'); }),
            'jml_transaksi' => $group->count(),
            'total_nilai' => $group->sum('total_nilai'),
            'transaksi' => $group,
            'status_agregat' => $statusAgregat,
            'id_transaksi_pending' => $pendingGroup->pluck('id_transaksi')->implode(',')
        ];

        return array_merge($extraData, $data);
    }

    public function bulkProcess(Request $request)
    {
        $request->validate([
            'ids' => 'required|string',
            'berat_gudang' => 'required|numeric|min:0',
            'total_berat_lapangan' => 'required|numeric|min:0',
        ]);
        
        $ids = explode(',', $request->ids);
        $transaksis = Transaksi::with('nasabah')
                        ->whereIn('id_transaksi', $ids)
                        ->where('status_validasi', 'pending')
                        ->get();

        if ($transaksis->isEmpty()) {
            return back()->with('error', 'Tidak ada transaksi pending untuk divalidasi.');
        }

        $beratLapangan = $request->total_berat_lapangan;
        $beratGudang = $request->berat_gudang;
        $selisih = abs($beratLapangan - $beratGudang);
        
        $catatan = null;
        if ($selisih > 10) {
            $catatan = "Selisih berat >10kg (Lap: {$beratLapangan}kg, Gud: {$beratGudang}kg). Perlu di evaluasi pengelola.";
        } else {
            $catatan = "Sesuai. Selisih aman: {$selisih}kg (Lap: {$beratLapangan}kg, Gud: {$beratGudang}kg).";
        }

        DB::beginTransaction();
        try {
            foreach($transaksis as $trx) {
                $trx->update([
                    'status_validasi' => 'valid',
                    'catatan_validasi' => $catatan
                ]);
                $trx->nasabah->increment('saldo', $trx->total_nilai);
            }
            DB::commit();
            return back()->with('success', count($transaksis) . ' transaksi berhasil divalidasi massal. ' . $catatan);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(int $id_transaksi) { /*...*/ }
    public function process(Request $request, int $id_transaksi) { /*...*/ }
}