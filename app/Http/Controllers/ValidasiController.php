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

        $semuaTransaksi = Transaksi::with(['nasabah', 'penimbang', 'detail.jenisSampah'])
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $summary = [
            'total_berat' => $semuaTransaksi->sum(function ($t) {
                return $t->detail->sum('berat');
            }),
            'total_transaksi' => $semuaTransaksi->count(),
            'pending' => $semuaTransaksi->where('status_validasi', 'pending')->count(),
            'total_nilai' => $semuaTransaksi->sum('total_nilai'),
        ];

        // Tab 1: Flat list Pending
        $pendingTransactions = $semuaTransaksi->where('status_validasi', 'pending')->values();

        // Tab 2: Flat list Selesai
        $completedTransactions = $semuaTransaksi->whereIn('status_validasi', ['valid', 'terkoreksi'])->values();

        // Tab 3: Group by Penimbang untuk Mode Bulk
        $tabPenimbang = $semuaTransaksi->groupBy(function ($item) {
            return $item->id_user . '|' . \Carbon\Carbon::parse($item->created_at)->format('Y-m-d');
        })->map(function ($group, $key) {
            $parts = explode('|', $key);
            return $this->formatGrupData($group, [
                'id_user' => $parts[0],
                'nama_penimbang' => $group->first()->penimbang->name,
                'tanggal' => $parts[1]
            ]);
        });

        return view('validasi.index', compact('pendingTransactions', 'completedTransactions', 'tabPenimbang', 'summary', 'startDate', 'endDate'));
    }

    private function formatGrupData(\Illuminate\Support\Collection $group, array $extraData = [])
    {
        $pendingGroup = $group->where('status_validasi', 'pending');

        $statusAgregat = 'Semua Valid';
        if ($pendingGroup->count() > 0) $statusAgregat = 'Ada Pending';
        elseif ($group->where('status_validasi', 'terkoreksi')->count() > 0) $statusAgregat = 'Ada Koreksi';

        $data = [
            'total_berat' => $group->sum(function ($t) {
                return $t->detail->sum('berat');
            }),
            'total_berat_pending' => $pendingGroup->sum(function ($t) {
                return $t->detail->sum('berat');
            }),
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

        $keterangan = $request->keterangan ? ' - Ket: ' . $request->keterangan : '';
        $catatan = null;
        $newStatus = 'valid';
        
        if ($selisih > 10) {
            $catatan = "Selisih berat >10kg (Lap: {$beratLapangan}kg, Gud: {$beratGudang}kg). Perlu di evaluasi pengelola." . $keterangan;
            $newStatus = 'terkoreksi';
        } elseif ($selisih > 0) {
            $catatan = "Terkoreksi Wajar: Selisih {$selisih}kg (Lap: {$beratLapangan}kg, Gud: {$beratGudang}kg)." . $keterangan;
            $newStatus = 'terkoreksi';
        } else {
            $catatan = "Sesuai (Lap: {$beratLapangan}kg, Gud: {$beratGudang}kg)." . $keterangan;
            $newStatus = 'valid';
        }

        DB::beginTransaction();
        try {
            foreach ($transaksis as $trx) {
                $trx->update([
                    'status_validasi' => $newStatus,
                    'catatan_validasi' => $catatan
                ]);
                $trx->nasabah->increment('saldo', $trx->total_nilai);
            }
            DB::commit();
            return back()->with('success', count($transaksis) . ' transaksi berhasil divalidasi. Status: ' . $newStatus . '. ' . $catatan);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function koreksi(int $id_transaksi)
    {
        $transaksi = Transaksi::with(['nasabah', 'penimbang', 'detail.jenisSampah'])->findOrFail($id_transaksi);
        
        if ($transaksi->status_validasi !== 'pending') {
            return redirect()->route('validasi.index_koreksi')
                ->with('error', 'Akses ditolak! Transaksi #' . $id_transaksi . ' sudah ' . $transaksi->status_validasi . ' dan tidak dapat dikoreksi ulang untuk mencegah kerusakan audit.');
        }

        $jenisSampah = \App\Models\JenisSampah::all();
        return view('validasi.koreksi', compact('transaksi', 'jenisSampah'));
    }

    public function updateKoreksi(Request $request, int $id_transaksi)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id_jenis' => 'required|exists:jenis_sampah,id_jenis',
            'items.*.berat' => 'required|numeric|min:0.1',
            'catatan_koreksi' => 'required|string'
        ]);

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::with('detail')->findOrFail($id_transaksi);

            $dataSebelum = [
                'total_nilai' => $transaksi->total_nilai,
                'rincian' => $transaksi->detail->toArray()
            ];

            if (in_array($transaksi->status_validasi, ['valid', 'terkoreksi'])) {
                $transaksi->nasabah->decrement('saldo', $transaksi->total_nilai);
            }

            $transaksi->detail()->delete();

            $totalNilaiBaru = 0;
            foreach ($request->items as $item) {
                $jenis = \App\Models\JenisSampah::find($item['id_jenis']);
                $subtotal = $jenis->harga_per_kg * $item['berat'];
                $totalNilaiBaru += $subtotal;

                $transaksi->detail()->create([
                    'id_jenis' => $item['id_jenis'],
                    'berat' => $item['berat'],
                    'harga_saat_transaksi' => $jenis->harga_per_kg,
                    'subtotal' => $subtotal,
                ]);
            }

            $isChanged = false;
            // Check if the items array length is different
            if (count($dataSebelum['rincian']) != count($request->items)) {
                $isChanged = true;
            } else {
                // Check each item
                $rincianLama = array_values($dataSebelum['rincian']);
                $rincianBaru = array_values($request->items);
                for ($i = 0; $i < count($rincianLama); $i++) {
                    if ($rincianLama[$i]['id_jenis'] != $rincianBaru[$i]['id_jenis'] || $rincianLama[$i]['berat'] != $rincianBaru[$i]['berat']) {
                        $isChanged = true;
                        break;
                    }
                }
            }

            $newStatus = $isChanged ? 'terkoreksi' : 'valid';
            $catatanAdmin = $isChanged ? 'Koreksi Admin: ' . $request->catatan_koreksi : 'Divalidasi tanpa perubahan data. Catatan: ' . $request->catatan_koreksi;

            $transaksi->update([
                'total_nilai' => $totalNilaiBaru,
                'status_validasi' => $newStatus,
                'catatan_validasi' => $catatanAdmin,
            ]);

            $transaksi->nasabah->increment('saldo', $totalNilaiBaru);

            $dataSesudah = [
                'total_nilai' => $totalNilaiBaru,
                'rincian' => $request->items
            ];

            LogKoreksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_admin' => Auth::id(),
                'field_sebelum' => json_encode($dataSebelum),
                'field_sesudah' => json_encode($dataSesudah),
                'catatan_alasan' => $request->catatan_koreksi,
            ]);

            DB::commit();
            return redirect()->route('validasi.index')->with('success', 'Transaksi berhasil dikoreksi secara total dan saldo nasabah telah disesuaikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses koreksi: ' . $e->getMessage());
        }
    }

    public function show(int $id_transaksi)
    { /*...*/
    }

    public function process(Request $request, int $id_transaksi)
    {
        $request->validate([
            'total_berat_gudang' => 'required|numeric|min:0',
            'total_berat_lapangan' => 'required|numeric|min:0',
        ]);

        $transaksi = Transaksi::with('nasabah')->findOrFail($id_transaksi);

        if ($transaksi->status_validasi !== 'pending') {
            return redirect()->route('validasi.index')->with('error', 'Transaksi ini sudah pernah divalidasi sebelumnya.');
        }

        $beratGudang = $request->total_berat_gudang;
        $beratLapangan = $request->total_berat_lapangan;
        $selisih = abs($beratLapangan - $beratGudang);

        if ($selisih > 10) {
            return back()->with('error', "Validasi ditolak! Terdapat selisih sangat besar ({$selisih} kg). Silakan klik tombol 'Lanjut ke Koreksi Total' untuk merombak rincian keranjang.");
        }

        $keterangan = $request->keterangan ? ' - Ket: ' . $request->keterangan : '';
        $newStatus = 'valid';
        if ($selisih > 0) {
            $catatan = "Terkoreksi Wajar. (Lap: {$beratLapangan}kg, Gud: {$beratGudang}kg). Selisih: {$selisih}kg." . $keterangan;
            $newStatus = 'terkoreksi';
        } else {
            $catatan = "Sesuai. (Lap: {$beratLapangan}kg, Gud: {$beratGudang}kg)." . $keterangan;
        }

        DB::beginTransaction();
        try {

            $transaksi->update([
                'status_validasi' => $newStatus,
                'catatan_validasi' => $catatan
            ]);

            $transaksi->nasabah->increment('saldo', $transaksi->total_nilai);

            DB::commit();
            return redirect()->route('validasi.index')->with('success', 'Setoran berhasil divalidasi dan saldo masuk ke rekening nasabah.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses validasi: ' . $e->getMessage());
        }
    }
}
