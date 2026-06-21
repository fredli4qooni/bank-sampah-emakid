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
    private function getDashboardData(Request $request)
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

        $data['pendingValidasi'] = Transaksi::where('status_validasi', 'pending')
            ->distinct('id_user')
            ->count('id_user');

        $startDate = $request->query('start_date', Carbon::today()->subDays(6)->format('Y-m-d'));
        $endDate = $request->query('end_date', Carbon::today()->format('Y-m-d'));

        $startDateObj = Carbon::parse($startDate);
        $endDateObj = Carbon::parse($endDate);

        $dataTransaksiPeriode = Transaksi::selectRaw('DATE(created_at) as date, COUNT(*) as total_count, SUM(total_nilai) as total_value')
            ->whereBetween('created_at', [$startDateObj->startOfDay(), $endDateObj->endOfDay()])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $data['labelHari'] = [];
        $data['dataCount'] = [];
        $data['dataValue'] = [];

        for ($date = clone $startDateObj; $date->lte($endDateObj); $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $data['labelHari'][] = $date->format('d M');

            $record = $dataTransaksiPeriode->firstWhere('date', $dateString);
            $data['dataCount'][] = $record ? $record->total_count : 0;
            $data['dataValue'][] = $record ? $record->total_value : 0;
        }

        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;

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

    public function admin(Request $request)
    {
        $data = $this->getDashboardData($request);
        return view('dashboard.admin', $data);
    }

    public function pengelola(Request $request)
    {
        $data = $this->getDashboardData($request);
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