<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Unit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth()->format('Y-m-d');
        
        $idUnit = $request->id_unit;

        $units = Unit::where('status', 'aktif')->orderBy('nama_unit', 'asc')->get();

        $query = Transaksi::with(['nasabah.unit', 'penimbang'])
            ->whereIn('status_validasi', ['valid', 'terkoreksi'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        if ($idUnit) {
            $query->whereHas('nasabah', function ($q) use ($idUnit) {
                $q->where('id_unit', $idUnit);
            });
        }

        $transaksi = $query->orderBy('created_at', 'desc')->get();

        return view('laporan.index', compact('transaksi', 'startDate', 'endDate', 'units', 'idUnit'));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth()->format('Y-m-d');
        $idUnit = $request->id_unit;

        $query = Transaksi::with(['nasabah.unit', 'penimbang', 'detail.jenisSampah'])
            ->whereIn('status_validasi', ['valid', 'terkoreksi'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        $namaUnitFilter = 'Semua Unit';
        
        if ($idUnit) {
            $query->whereHas('nasabah', function ($q) use ($idUnit) {
                $q->where('id_unit', $idUnit);
            });
            
            $unit = Unit::find($idUnit);
            if($unit) {
                $namaUnitFilter = $unit->nama_unit;
            }
        }

        $transaksi = $query->orderBy('created_at', 'asc')->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('transaksi', 'startDate', 'endDate', 'namaUnitFilter'));
        
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Transaksi_BankSampah_'.$startDate.'_sd_'.$endDate.'.pdf');
    }
}