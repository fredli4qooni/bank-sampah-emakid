<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        $transaksi = Transaksi::with(['nasabah', 'penimbang'])
            ->whereIn('status_validasi', ['valid', 'terkoreksi'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('laporan.index', compact('transaksi', 'startDate', 'endDate'));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        $transaksi = Transaksi::with(['nasabah', 'penimbang'])
            ->whereIn('status_validasi', ['valid', 'terkoreksi'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('created_at', 'asc')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('transaksi', 'startDate', 'endDate'));
        
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Transaksi_BankSampah_'.$startDate.'_sd_'.$endDate.'.pdf');
    }
}