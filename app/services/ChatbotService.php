<?php

namespace App\Services;

use App\Models\Nasabah;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\JenisSampah;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChatbotService
{
    public function processMessage(string $message)
    {
        $input = strtolower(trim($message));
        $rules = config('chatbot_rules.intents');

        foreach ($rules as $intentId => $rule) {
            foreach ($rule['keywords'] as $keyword) {
                
                if (str_contains($keyword, '&')) {
                    $words = array_map('trim', explode('&', $keyword));
                    $allMatch = true;
                    
                    foreach ($words as $word) {
                        if (!str_contains($input, $word)) {
                            $allMatch = false;
                            break;
                        }
                    }
                    
                    if ($allMatch) {
                        $handler = $rule['handler'];
                        return $this->$handler($input, $keyword);
                    }
                } 
                else {
                    if (str_contains($input, $keyword)) {
                        $handler = $rule['handler'];
                        return $this->$handler($input, $keyword);
                    }
                }
            }
        }

        return "Maaf, saya belum mengerti pertanyaan itu. Ketik 'bantuan' untuk melihat daftar pertanyaan yang bisa saya jawab.";
    }
    
    private function handleTotalJenisSampah(string $input, string $keyword)
    {
        $total = JenisSampah::count();
        return "Saat ini Bank Sampah Emak.id menerima dan mengelola {$total} jenis sampah.";
    }

    private function handleKomposisiSampah(string $input, string $keyword)
    {
        $terbanyak = DetailTransaksi::with('jenisSampah')
            ->selectRaw('id_jenis, SUM(berat) as total_berat')
            ->groupBy('id_jenis')
            ->orderBy('total_berat', 'desc')
            ->first();

        if (!$terbanyak) {
            return "Belum ada data setoran sampah yang tercatat untuk menghitung komposisi.";
        }

        return "Komposisi sampah terbanyak sepanjang waktu adalah: " . strtoupper($terbanyak->jenisSampah->nama_sampah) . " dengan total volume terkumpul sebanyak " . number_format($terbanyak->total_berat, 2, ',', '.') . " kg/ltr.";
    }

    private function handleTotalSemuaTransaksi(string $input, string $keyword)
    {
        $total = Transaksi::count();
        return "Total keseluruhan transaksi di sistem sejak awal hingga saat ini adalah: " . number_format($total, 0, ',', '.') . " transaksi.";
    }

    private function handleTotalVolumeKeseluruhan(string $input, string $keyword)
    {
        $totalVolume = DetailTransaksi::sum('berat');
        
        return "Total volume keseluruhan sampah yang terkumpul di sistem hingga saat ini adalah: " . number_format($totalVolume, 2, ',', '.') . " kg/ltr.";
    }
    
    private function handleTransaksiMingguIni(string $input, string $keyword)
    {
        $tujuhHariLalu = Carbon::today()->subDays(6);
        $jumlah = Transaksi::whereBetween('created_at', [$tujuhHariLalu, Carbon::today()->endOfDay()])->count();
        $nilai = Transaksi::whereBetween('created_at', [$tujuhHariLalu, Carbon::today()->endOfDay()])->sum('total_nilai');
        
        return "Minggu ini (7 hari terakhir): {$jumlah} transaksi | Total Nilai: Rp " . number_format($nilai, 0, ',', '.');
    }

    private function handleNasabahHariIni(string $input, string $keyword)
    {
        $hariIni = Carbon::today();
        $transaksi = Transaksi::with('nasabah')->whereDate('created_at', $hariIni)->get();
        
        if ($transaksi->isEmpty()) return "Belum ada nasabah yang melakukan transaksi hari ini.";
        
        $nasabahUnik = $transaksi->unique('id_nasabah');
        
        $resp = "Hari ini ada " . $nasabahUnik->count() . " nasabah yang bertransaksi. Berikut daftarnya:\n";
        foreach($nasabahUnik as $trx) {
            $resp .= "- " . strtoupper($trx->nasabah->nama) . "\n";
        }
        return $resp;
    }

    private function handleNilaiMingguIni(string $input, string $keyword)
    {
        $tujuhHariLalu = Carbon::today()->subDays(6);
        $totalNilai = Transaksi::where('status_validasi', '!=', 'pending')
            ->whereBetween('created_at', [$tujuhHariLalu, Carbon::today()->endOfDay()])
            ->sum('total_nilai');
            
        return "Total perputaran nilai transaksi (uang terkumpul) minggu ini (7 hari terakhir): Rp " . number_format($totalNilai, 0, ',', '.');
    }

    private function handleTransaksiBulanIni(string $input, string $keyword)
    {
        $awalBulan = Carbon::now()->startOfMonth();
        $jumlah = Transaksi::whereBetween('created_at', [$awalBulan, Carbon::now()->endOfMonth()])->count();
        $nilai = Transaksi::whereBetween('created_at', [$awalBulan, Carbon::now()->endOfMonth()])->sum('total_nilai');
        
        return "Bulan ini: {$jumlah} transaksi | Total Nilai: Rp " . number_format($nilai, 0, ',', '.');
    }

    private function handleDaftarNasabah(string $input, string $keyword)
    {
        $nasabahs = Nasabah::orderBy('created_at', 'desc')->take(5)->get();
        if ($nasabahs->isEmpty()) return "Belum ada data nasabah di sistem.";
        
        $resp = "Berikut adalah 5 nasabah terbaru yang terdaftar di sistem:\n";
        foreach($nasabahs as $index => $n) {
            $resp .= ($index + 1) . ". {$n->nama} (Kec. {$n->kecamatan})\n";
        }
        $resp .= "\nUntuk melihat keseluruhan data, silakan buka menu Data Nasabah.";
        return $resp;
    }

    private function handleDaftarJenisSampah(string $input, string $keyword)
    {
        $jenis = JenisSampah::all();
        if ($jenis->isEmpty()) return "Belum ada jenis sampah yang terdaftar.";
        
        $resp = "Berikut adalah daftar jenis sampah yang diterima saat ini:\n";
        foreach($jenis as $index => $j) {
            $resp .= "- " . strtoupper($j->nama_sampah) . " (Rp " . number_format($j->harga_per_kg, 0, ',', '.') . "/{$j->satuan})\n";
        }
        return $resp;
    }

    private function handleNasabahTerbaik(string $input, string $keyword)
    {
        $terbaik = Transaksi::selectRaw('id_nasabah, count(*) as total_trx, sum(total_nilai) as total_rp')
            ->groupBy('id_nasabah')
            ->orderBy('total_trx', 'desc')
            ->with('nasabah')
            ->first();

        if (!$terbaik || !$terbaik->nasabah) return "Belum ada cukup data transaksi untuk menentukan nasabah teraktif.";

        return "Nasabah paling aktif adalah " . strtoupper($terbaik->nasabah->nama) . " dengan total {$terbaik->total_trx} transaksi senilai Rp " . number_format($terbaik->total_rp, 0, ',', '.') . ".";
    }

    private function handleTransaksiTerbesar(string $input, string $keyword)
    {
        $terbesar = Transaksi::with('nasabah')->orderBy('total_nilai', 'desc')->first();
        if (!$terbesar) return "Belum ada data transaksi yang tercatat.";

        return "Transaksi dengan nilai tertinggi sepanjang masa dilakukan oleh " . strtoupper($terbesar->nasabah->nama) . " senilai Rp " . number_format($terbesar->total_nilai, 0, ',', '.') . " pada tanggal " . $terbesar->created_at->format('d M Y') . ".";
    }

    private function handleCekSaldo(string $input, string $keyword)
    {
        $nama = trim(str_replace($keyword, '', $input));
        
        if (empty($nama) || in_array($nama, ['nasabah', 'semua', 'saya', 'orang'])) {
            return "Mohon sebutkan nama spesifik nasabahnya. Contoh: 'saldo Budi Santoso'. (Ketik 'total saldo' jika ingin melihat total keseluruhan).";
        }

        $nasabah = Nasabah::where('nama', 'like', "%{$nama}%")->get();

        if ($nasabah->count() === 0) {
            return "Nasabah dengan nama '{$nama}' tidak ditemukan di sistem.";
        }

        if ($nasabah->count() > 1) {
            $response = "Ditemukan {$nasabah->count()} nasabah dengan nama tersebut:\n";
            foreach ($nasabah as $index => $n) {
                $response .= ($index + 1) . ". {$n->nama} ({$n->no_rekening})\n";
            }
            $response .= "\nSebutkan nama lebih spesifik atau cek manual di halaman nasabah.";
            return $response;
        }

        $n = $nasabah->first();
        return "Saldo {$n->nama} ({$n->no_rekening}): Rp " . number_format($n->saldo, 0, ',', '.');
    }

    private function handleTransaksiHariIni(string $input, string $keyword)
    {
        $hariIni = Carbon::today();
        
        $jumlahTransaksi = Transaksi::whereDate('created_at', $hariIni)->count();
        $totalNilai = Transaksi::whereDate('created_at', $hariIni)->sum('total_nilai');
        
        $totalVolume = DetailTransaksi::whereHas('transaksi', function($q) use ($hariIni) {
            $q->whereDate('created_at', $hariIni);
        })->sum('berat');

        return "Hari ini: {$jumlahTransaksi} transaksi | Nilai: Rp " . number_format($totalNilai, 0, ',', '.') . " | Volume: {$totalVolume} kg/ltr";
    }

    private function handleCekPending(string $input, string $keyword)
    {
        $pending = Transaksi::where('status_validasi', 'pending')->count();
        if ($pending == 0) {
            return "Semua transaksi sudah divalidasi. Tidak ada antrean pending.";
        }
        return "Ada {$pending} transaksi pending yang belum divalidasi dan menunggu konfirmasi Anda.";
    }

    private function handleTotalNasabah(string $input, string $keyword)
    {
        $total = Nasabah::count();
        return "Total nasabah terdaftar di sistem: " . number_format($total, 0, ',', '.') . " nasabah.";
    }

    private function handleTotalSaldoKeseluruhan(string $input, string $keyword)
    {
        $totalSaldo = Nasabah::sum('saldo');
        return "Total saldo seluruh nasabah (liabilitas bank sampah) saat ini adalah: Rp " . number_format($totalSaldo, 0, ',', '.');
    }

    private function handleVolumeHariIni(string $input, string $keyword)
    {
        $hariIni = Carbon::today();
        $totalVolume = DetailTransaksi::whereHas('transaksi', function($q) use ($hariIni) {
            $q->whereDate('created_at', $hariIni);
        })->sum('berat');
        
        return "Volume total sampah masuk hari ini: {$totalVolume} kg/ltr.";
    }

    private function handleVolumeMingguIni(string $input, string $keyword)
    {
        $tujuhHariLalu = Carbon::today()->subDays(6);
        $totalVolume = DetailTransaksi::whereHas('transaksi', function($q) use ($tujuhHariLalu) {
            $q->whereBetween('created_at', [$tujuhHariLalu, Carbon::today()->endOfDay()]);
        })->sum('berat');
        
        return "Volume sampah minggu ini (7 hari terakhir): {$totalVolume} kg/ltr.";
    }

    private function handleVolumeBulanIni(string $input, string $keyword)
    {
        $awalBulan = Carbon::now()->startOfMonth();
        $totalVolume = DetailTransaksi::whereHas('transaksi', function($q) use ($awalBulan) {
            $q->whereBetween('created_at', [$awalBulan, Carbon::now()->endOfMonth()]);
        })->sum('berat');
        
        return "Volume sampah bulan berjalan: {$totalVolume} kg/ltr.";
    }

    private function handleNilaiBulanIni(string $input, string $keyword)
    {
        $awalBulan = Carbon::now()->startOfMonth();
        $totalNilai = Transaksi::where('status_validasi', '!=', 'pending')
            ->whereBetween('created_at', [$awalBulan, Carbon::now()->endOfMonth()])
            ->sum('total_nilai');
            
        return "Total perputaran nilai transaksi (valid/terkoreksi) bulan ini: Rp " . number_format($totalNilai, 0, ',', '.');
    }

    private function handleRiwayatTransaksi(string $input, string $keyword)
    {
        $nama = trim(str_replace($keyword, '', $input));
        if (empty($nama) || $nama === 'nasabah') return "Mohon sebutkan nama spesifik nasabahnya. Contoh: 'riwayat Budi'.";
        
        $nasabah = Nasabah::where('nama', 'like', "%{$nama}%")->first();
        if (!$nasabah) return "Nasabah dengan nama '{$nama}' tidak ditemukan di sistem.";

        $transaksi = Transaksi::where('id_nasabah', $nasabah->id_nasabah)
            ->orderBy('created_at', 'desc')->take(5)->get();

        if ($transaksi->isEmpty()) return "Belum ada transaksi setoran untuk {$nasabah->nama}.";

        $resp = "5 transaksi terakhir {$nasabah->nama}:\n";
        foreach($transaksi as $index => $trx) {
            $resp .= ($index + 1) . ". " . $trx->created_at->format('d M Y') . " - Rp " . number_format($trx->total_nilai, 0, ',', '.') . " (" . strtoupper($trx->status_validasi) . ")\n";
        }
        return $resp;
    }

    private function handleHargaSampah(string $input, string $keyword)
    {
        $namaSampah = trim(str_replace($keyword, '', $input));
        if (empty($namaSampah) || in_array($namaSampah, ['sampah', 'jenis'])) {
            return "Mohon sebutkan jenis sampahnya secara spesifik. Contoh: 'harga kardus' atau 'harga plastik'.";
        }

        $jenis = JenisSampah::where('nama_sampah', 'like', "%{$namaSampah}%")->first();
        if (!$jenis) return "Jenis sampah '{$namaSampah}' tidak terdaftar di sistem kami.";

        return "Harga " . strtoupper($jenis->nama_sampah) . " saat ini adalah: Rp " . number_format($jenis->harga_per_kg, 0, ',', '.') . " / {$jenis->satuan}";
    }

    private function handleNasabahKecamatan(string $input, string $keyword)
    {
        $kecamatan = trim(str_replace($keyword, '', $input));
        if (empty($kecamatan)) return "Mohon sebutkan nama kecamatannya. Contoh: 'nasabah di Kedaton'.";

        $jumlah = Nasabah::where('kecamatan', 'like', "%{$kecamatan}%")->count();
        return "Distribusi nasabah di Kec. " . ucwords($kecamatan) . " berjumlah {$jumlah} nasabah aktif.";
    }

    private function handleBantuan(string $input, string $keyword)
    {
        return "Sistem Rule-Based Assistant aktif. Saya bisa memproses kueri cepat seperti:\n" .
               "• 'saldo [nama]'\n" .
               "• 'riwayat [nama]'\n" .
               "• 'harga [jenis sampah]'\n" .
               "• 'transaksi hari ini / bulan ini'\n" .
               "• 'komposisi sampah terbanyak'\n" .
               "• 'ada berapa jenis sampah'\n" .
               "• 'total saldo semua'";
    }

    private function handleSapaan(string $input, string $keyword)
    {
        return "Halo, Admin! Chatbot Assistant siap. Data apa yang ingin Anda akses dengan cepat hari ini?";
    }
}