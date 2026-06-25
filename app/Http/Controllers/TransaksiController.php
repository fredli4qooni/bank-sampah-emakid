<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Nasabah;
use App\Models\JenisSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index()
    {
        $query = Transaksi::with(['nasabah.unit', 'detail.jenisSampah']);
        
        // Jika penimbang, hanya lihat setoran miliknya. Jika admin, lihat semua.
        if (Auth::user()->role === 'penimbang') {
            $query->where('id_user', Auth::id());
        }

        $transaksi = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $nasabah = Nasabah::with('unit')->orderBy('nama', 'asc')->get();
        
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

            return redirect()->route('transaksi.create')
                ->with('success', 'Transaksi berhasil disimpan dan menunggu validasi Admin.')
                ->with('last_transaction_id', $transaksi->id_transaksi)
                ->with('last_transaction_no_hp', $transaksi->nasabah->no_hp)
                ->with('last_transaction_nama', $transaksi->nasabah->nama)
                ->with('last_transaction_nilai', $transaksi->total_nilai);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(int $id_transaksi)
    {
        $transaksi = Transaksi::with(['nasabah', 'detail.jenisSampah'])->findOrFail($id_transaksi);
        
        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, int $id_transaksi)
    {
        $transaksi = Transaksi::with(['detail', 'nasabah'])->findOrFail($id_transaksi);

        $request->validate([
            'berat' => 'required|array',
            'berat.*' => 'required|numeric|min:0.01',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $totalNilaiLama = $transaksi->total_nilai;
            $totalNilaiBaru = 0;

            foreach ($request->berat as $id_detail => $beratBaru) {
                $detail = \App\Models\DetailTransaksi::findOrFail($id_detail);
                
                $hargaBaru = $request->harga[$id_detail] ?? $detail->harga_saat_transaksi;
                
                $subtotal = $beratBaru * $hargaBaru;

                $detail->update([
                    'berat' => $beratBaru,
                    'harga_saat_transaksi' => $hargaBaru,
                    'subtotal' => $subtotal
                ]);

                $totalNilaiBaru += $subtotal;
            }

            $transaksi->update([
                'total_nilai' => $totalNilaiBaru
            ]);

            if (in_array($transaksi->status_validasi, ['valid', 'terkoreksi'])) {
                $transaksi->nasabah->decrement('saldo', $totalNilaiLama);
                $transaksi->nasabah->increment('saldo', $totalNilaiBaru);
            }

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi atas nama ' . $transaksi->nasabah->nama . ' berhasil dikoreksi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function cetakStruk(int $id_transaksi)
    {
        $transaksi = Transaksi::with(['nasabah', 'penimbang', 'detail.jenisSampah'])->findOrFail($id_transaksi);
        
        // Ukuran kertas thermal 58mm (width = 58mm = ~164pt)
        $customPaper = array(0, 0, 164, 400); 

        $pdf = Pdf::loadView('transaksi.struk', compact('transaksi'))
                  ->setPaper($customPaper);

        return $pdf->stream('Struk_Setoran_' . $transaksi->id_transaksi . '.pdf');
    }

    public function destroy(int $id_transaksi)
    {
        $transaksi = Transaksi::findOrFail($id_transaksi);

        DB::beginTransaction();
        try {
            if (in_array($transaksi->status_validasi, ['valid', 'terkoreksi'])) {
                $transaksi->nasabah->decrement('saldo', $transaksi->total_nilai);
            }

            \App\Models\DetailTransaksi::where('id_transaksi', $id_transaksi)->delete();
            $transaksi->delete();
            
            DB::commit();
            return back()->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}