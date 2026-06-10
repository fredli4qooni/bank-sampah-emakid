<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Transaksi::with(['nasabah', 'penimbang'])->get();
    }

    public function headings(): array
    {
        return [
            'ID Transaksi', 'Tanggal', 'No Rekening', 'Nama Nasabah', 
            'Penimbang', 'Total Nilai (Rp)', 'Status Validasi', 'Catatan Validasi'
        ];
    }

    public function map($trx): array
    {
        return [
            $trx->id_transaksi,
            $trx->created_at->format('Y-m-d H:i:s'),
            $trx->nasabah->no_rekening ?? '-',
            $trx->nasabah->nama ?? '-',
            $trx->penimbang->name ?? '-',
            $trx->total_nilai,
            $trx->status_validasi,
            $trx->catatan_validasi ?? '-',
        ];
    }
}