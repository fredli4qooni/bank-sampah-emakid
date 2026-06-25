<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanValidasiController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // Query transaksi yang sudah divalidasi
        $semuaTransaksi = Transaksi::with(['penimbang', 'detail'])
            ->where('status_validasi', '!=', 'pending')
            ->whereBetween(DB::raw('DATE(updated_at)'), [$startDate, $endDate])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Kelompokkan berdasarkan id_user, DATE(updated_at), dan catatan_validasi
        $riwayatValidasi = $semuaTransaksi->groupBy(function($t) {
            return $t->id_user . '|' . $t->updated_at->format('Y-m-d H:i') . '|' . $t->catatan_validasi;
        })->map(function($group) {
            $first = $group->first();
            $catatanValidasi = $first->catatan_validasi ?? '';
            
            $lapangan = 0;
            $gudang = 0;
            $keterangan = $catatanValidasi;
            
            // Coba urai format "Lap: Xkg, Gud: Ykg"
            if (preg_match('/Lap:\s*([0-9.]+)kg,\s*Gud:\s*([0-9.]+)kg/i', $catatanValidasi, $m)) {
                $lapangan = (float)$m[1];
                $gudang = (float)$m[2];
                
                // Cari "Ket: ..."
                if (preg_match('/Ket:\s*(.*)$/i', $catatanValidasi, $k)) {
                    $keterangan = trim($k[1]);
                } else {
                    $keterangan = '-';
                }
            } else {
                // Kasus "Koreksi Admin" atau lainnya, tidak menggunakan bulk process
                $lapangan = $group->sum(function($t) { return $t->detail->sum('berat'); });
                $gudang = $lapangan; // asumsikan sama jika tidak ada data Gudang spesifik
                
                if (preg_match('/-\s*(.*)$/', $catatanValidasi, $k)) {
                    $keterangan = trim($k[1]);
                } elseif (str_starts_with($catatanValidasi, 'Koreksi Admin')) {
                    $keterangan = $catatanValidasi;
                }
            }
            
            $selisih = abs($lapangan - $gudang);

            return [
                'nama_penimbang' => $first->penimbang->name,
                'tanggal' => $first->updated_at->format('d/m/Y H:i'),
                'total_berat_lapangan' => $lapangan,
                'total_berat_gudang' => $gudang,
                'selisih' => $selisih,
                'status' => $first->status_validasi,
                'keterangan' => $keterangan,
                'transaksi_count' => $group->count(),
                'total_nilai' => $group->sum('total_nilai'),
            ];
        })->values();

        return view('laporan_validasi.index', compact('riwayatValidasi', 'startDate', 'endDate'));
    }
}
