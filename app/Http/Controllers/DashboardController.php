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
    public function admin()
    {
        $hariIni = Carbon::today();

        $totalNasabah = Nasabah::count();
        $totalSaldo = Nasabah::sum('saldo');
        
        $transaksiHariIni = Transaksi::whereDate('created_at', $hariIni)->count();
        
        $volumeHariIni = DetailTransaksi::whereHas('transaksi', function($q) use ($hariIni) {
            $q->whereDate('created_at', $hariIni);
        })->sum('berat');

        $transaksiTerbaru = Transaksi::with(['nasabah'])->orderBy('created_at', 'desc')->take(10)->get();
        
        $pendingValidasi = Transaksi::where('status_validasi', 'pending')->count();

        return view('dashboard.admin', compact(
            'totalNasabah', 'totalSaldo', 'transaksiHariIni', 'volumeHariIni', 'transaksiTerbaru', 'pendingValidasi'
        ));
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

    public function pengelola()
    {
        $hariIni = Carbon::today();

        $totalNasabah = Nasabah::count();
        $totalSaldo = Nasabah::sum('saldo');
        $transaksiHariIni = Transaksi::whereDate('created_at', $hariIni)->count();
        $volumeHariIni = DetailTransaksi::whereHas('transaksi', function($q) use ($hariIni) {
            $q->whereDate('created_at', $hariIni);
        })->sum('berat');

        return view('dashboard.pengelola', compact(
            'totalNasabah', 'totalSaldo', 'transaksiHariIni', 'volumeHariIni'
        ));
    }
}
