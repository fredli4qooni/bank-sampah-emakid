<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private function getDashboardData()
    {
        $hariIni = Carbon::today();

        $data['totalNasabah'] = Nasabah::count();
        $data['totalSaldo'] = Nasabah::sum('saldo');
        $data['transaksiHariIni'] = Transaksi::whereDate('created_at', $hariIni)->count();
        $data['volumeHariIni'] = DetailTransaksi::whereHas('transaksi', function ($q) use ($hariIni) {
            $q->whereDate('created_at', $hariIni);
        })->sum('berat');

        $data['transaksiTerbaru'] = Transaksi::with(['nasabah'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $data['pendingValidasi'] = Transaksi::where('status_validasi', 'pending')->count();

        $tujuhHariLalu = Carbon::today()->subDays(6);
        $dataTransaksi7Hari = Transaksi::selectRaw('DATE(created_at) as date, COUNT(*) as total_count, SUM(total_nilai) as total_value')
            ->whereBetween('created_at', [$tujuhHariLalu, Carbon::today()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $data['labelHari'] = [];
        $data['dataCount'] = [];
        $data['dataValue'] = [];

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today()->subDays(6 - $i)->format('Y-m-d');
            $data['labelHari'][] = Carbon::parse($date)->format('d M');

            $record = $dataTransaksi7Hari->firstWhere('date', $date);
            $data['dataCount'][] = $record ? $record->total_count : 0;
            $data['dataValue'][] = $record ? $record->total_value : 0;
        }

        $komposisiSampah = DetailTransaksi::with('jenisSampah')
            ->whereHas('transaksi', function ($q) use ($hariIni) {
                $q->whereDate('created_at', $hariIni);
            })
            ->selectRaw('id_jenis, SUM(berat) as total_berat')
            ->groupBy('id_jenis')
            ->get();

        $data['labelKomposisi'] = [];
        $data['dataKomposisi'] = [];

        foreach ($komposisiSampah as $k) {
            $data['labelKomposisi'][] = $k->jenisSampah->nama_sampah;
            $data['dataKomposisi'][] = (float) $k->total_berat;
        }

        return $data;
    }

    public function admin()
    {
        $data = $this->getDashboardData();
        return view('dashboard.admin', $data);
    }

    public function pengelola()
    {
        $data = $this->getDashboardData();
        return view('dashboard.pengelola', $data);
    }

    public function penimbang()
    {
        $hariIni = Carbon::today();
        $idUser = Auth::id();

        $transaksiSayaHariIni = Transaksi::where('id_user', $idUser)
            ->whereDate('created_at', $hariIni)
            ->count();

        return view('dashboard.penimbang', compact('transaksiSayaHariIni'));
    }
}